<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Pengembalian extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Pengembalian | Perpustakaan';
        if(Gate::allows('member')){
            $data['keranjang'] = session('buku') ?? [];
        }else{
            $data['diproses'] = Pinjaman::where('status', 'diproses')->get();
        }
        $data['member'] = Member::all();
        return view('pengembalian', $data);
    }
    public function detail($id){
        $data['title'] = 'Detail Pengembalian | Perpustakaan';
        $data['buku'] = Pinjaman::find($id);
        return view('detail_pinjaman', $data);
    }
    public function tambah(Request $req){
        $pengembalian = Pinjaman::find($req->id);
        $pengembalian->status = 'dikembalikan';
        $pengembalian->save();
        foreach ($pengembalian->detail as $detail) {
            $detail->status = 'dikembalikan';
            $detail->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
            $detail->save();
        }

        return redirect(route('pengembalian'))->with('alert', 'Buku Sudah Dikembalikan');
    }
    public function proses(Request $req){
        $req->validate([
            'id_buku' => 'required',
        ]);
        $pinjaman = Pinjaman::where(['id_member' => Auth::user()->member->id, 'status' => 'dipinjam']);
        $pinjaman->status = 'dikembalikan';
        $pinjaman->save();
        foreach ($req->id_buku as $id) {
            $detail = new DetailPeminjaman();
            $detail->id_buku = $id;
            $detail->id_pinjaman = $pinjaman->id;
            $detail->status = 'menunggu_dipinjam';
            $detail->save();
        }
        session()->forget('buku');

        return redirect(route('pengembalian'))->with('alert', 'Buku Akan Segera Diproses');
    }
    public function kembalikan(Request $req){
        if($req->nomor_buku != null){
            $req->validate([
                'nomor_buku' => 'required|exists:buku,nomor_buku',
                'id_member' => 'required|integer',
            ]);
            $b = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
            $buku = $b->id;
        }else{
            $req->validate([
                'id' => 'required|exists:buku,id',
            ]);
            $buku = $req->id;
        }
        $buku = Buku::find($buku);
        if(!Gate::allows('belum_pinjam', $buku->id)){
            return back()->withErrors('Buku Sudah Dikembalikan');
        }
        session()->push('buku', $buku);
        $buku->jumlah = $buku->jumlah + 1;
        $buku->save();

        return back()->with('alert', 'Berhasil Manambahkan Buku');
    }
    public function edit(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);
        
        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
        $pinjaman = Pinjaman::where(['id_buku' => $buku->id, 'status' => 'dipinjam', 'id_member' => $req->id_member])->get()->first();
        if($pinjaman == null){
            return redirect(route('pinjaman'))->withErrors('Buku Sedang tidak Dipinjam');
        }

        $pinjaman->status = 'dikembalikan';
        $pinjaman->save();

        $buku->jumlah = $buku->jumlah + 1;
        $buku->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Mengembalikan Buku');
    }
    public function hapus($id){
        DetailPeminjaman::destroy($id);
        return redirect(route('pinjaman'))->with('alert', 'Berhasil Menghapus Pinjaman');
    }
    public function batal_keranjang($id){
        $buku = session('buku');
        $book = [];
        $k = 0;
        foreach($buku as $b){
            if($id == $b->id){
                $book = $b;
                $k = array_keys($buku, $b);
            }
        }
        $book->jumlah = $book->jumlah - 1;
        $book->save();
        session()->forget('buku.'.$k[0]);
        return back()->with('alert', 'Berhasil Dihapus Dari Antrean');
    }
}
