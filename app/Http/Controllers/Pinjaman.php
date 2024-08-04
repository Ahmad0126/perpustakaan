<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Pinjaman as ModelsPinjaman;
use Illuminate\Support\Facades\DB;

class Pinjaman extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Pinjaman | Perpustakaan';
        if(Gate::allows('member')){
            $pinjaman = ModelsPinjaman::where('id_member', Auth::user()->member->id)->get()->first();
            if($pinjaman == null){ $data['buku'] = []; }else{ $data['buku'] = $pinjaman->detail; }
            $data['keranjang'] = session('buku') ?? [];
        }else{
            $data['diproses'] = ModelsPinjaman::where('status', 'diproses')->get();
            $data['buku'] = DetailPeminjaman::where('status', 'dipinjam')->get();
        }
        $data['member'] = Member::all();
        return view('pinjaman', $data);
    }
    public function detail($id){
        $data['title'] = 'Detail Pinjaman | Perpustakaan';
        $data['buku'] = ModelsPinjaman::find($id);
        return view('detail_pinjaman', $data);
    }
    public function tambah(Request $req){
        $pinjaman = ModelsPinjaman::find($req->id);
        $pinjaman->status = 'dipinjamkan';
        $pinjaman->save();
        foreach ($pinjaman->detail as $detail) {
            $detail->status = 'dipinjam';
            $detail->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
            $detail->save();
        }

        return redirect(route('pinjaman'))->with('alert', 'Buku Sudah Dipinjamkan');
    }
    public function proses(Request $req){
        $req->validate([
            'id_buku' => 'required',
        ]);
        $pinjaman = new ModelsPinjaman();
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->status = 'diproses';
        $pinjaman->id_member = Auth::user()->member->id;
        $pinjaman->save();
        foreach ($req->id_buku as $id) {
            $detail = new DetailPeminjaman();
            $detail->id_buku = $id;
            $detail->id_pinjaman = $pinjaman->id;
            $detail->status = 'menunggu_dipinjam';
            $detail->save();
        }
        session()->forget('buku');

        return redirect(route('pinjaman'))->with('alert', 'Buku Akan Segera Diproses');
    }
    public function pinjam(Request $req){
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
        if(Gate::allows('belum_pinjam', $buku->id)){
            return back()->withErrors('Buku Sudah Dipinjam');
        }
        if($buku->jumlah < 1){
            return back()->withErrors('Buku Sedang tidak Tersedia');
        }
        session()->push('buku', $buku);
        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return back()->with('alert', 'Berhasil Manambahkan Buku');
    }
    public function edit(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);
        
        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
        $pinjaman = ModelsPinjaman::where(['id_buku' => $buku->id, 'status' => 'dipinjam', 'id_member' => $req->id_member])->get()->first();
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
        $book->jumlah = $book->jumlah + 1;
        $book->save();
        session()->forget('buku.'.$k[0]);
        return back()->with('alert', 'Berhasil Dihapus Dari Antrean');
    }
}
