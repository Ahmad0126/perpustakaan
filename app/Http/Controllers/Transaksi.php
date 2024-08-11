<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Models\DetailPinjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Transaksi extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Transaksi Pinjaman | Perpustakaan';
        if(Gate::allows('member')){
            $data['transaksi'] = Pinjaman::where('id_member', Auth::user()->member->id)->orderBy('tanggal_dipinjam', 'DESC')->paginate(20);
        }else{
            $data['transaksi'] = Pinjaman::orderBy('tanggal_dipinjam', 'DESC')->paginate(20);
        }
        return view('transaksi', $data);
        
    }
    public function detail($id){
        $data['title'] = 'Detail Pinjaman | Perpustakaan';
        $data['buku'] = Pinjaman::find($id);
        return view('transaksi_detail', $data);
    }
    public function tambah(){
        $data['title'] = 'Tambahkan Pinjaman | Perpustakaan';
        $data['buku'] = session('buku') ?? [];
        if(Gate::allows('petugas')){
            $data['member'] = Member::all();
        }
        return view('transaksi_tambah', $data);
    }
    public function masukkan(Request $req){
        if($req->nomor_buku != null){
            $req->validate([
                'nomor_buku' => 'required|exists:buku,nomor_buku',
            ]);
            $b = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
            $buku = $b->id;
        }else{
            $req->validate([
                'id' => 'required|exists:buku,id',
            ]);
            $buku = $req->id;
            if(Gate::allows('member')){
                if(!Gate::allows('belum_pinjam', $req->id)){
                    return back()->withErrors('Buku Sudah Dipinjam');
                }
            }
        }
        $buku = Buku::find($buku);
        if($buku->jumlah < 1){
            return back()->withErrors('Buku Sedang tidak Tersedia');
        }
        session()->push('buku', $buku);
        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return back()->with('alert', 'Berhasil Manambahkan Buku');
    }
    public function proses(Request $req){
        $req->validate([
            'id_buku' => 'required',
            'id_member' => 'required|exists:member,id',
        ]);
        foreach ($req->id_buku as $id){
            $detail = DetailPinjaman::where('id_buku', $id)->get();
            foreach ($detail as $d) {
                if($d->status == 'dipinjam' && $d->pinjaman->member->id == $req->id_member){
                    return back()->withErrors('Buku "'.$d->buku->judul.'" sudah dipinjam');
                }
            }
        }
        $pinjaman = new Pinjaman();
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->status = 'diproses';
        $pinjaman->id_member = $req->id_member;
        $pinjaman->save();
        foreach ($req->id_buku as $id) {
            $detail = new DetailPinjaman();
            $detail->id_buku = $id;
            $detail->id_pinjaman = $pinjaman->id;
            $detail->tanggal_kembali = date('Y-m-d', strtotime('+1 week'));
            $detail->status = 'dipinjam';
            $detail->save();
        }
        session()->forget('buku');

        return redirect(route('transaksi'))->with('alert', 'Berhasil Meminjam Buku');
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
    public function kembalikan(Request $req){
        $req->validate([
            'id' => 'required|exists:pinjaman,id'
        ]);
        $pinjaman = Pinjaman::find($req->id);
        foreach ($pinjaman->detail as $detail) {
            $detail->status = 'dikembalikan';
            $detail->save();
        }
        return back()->with('alert', 'Berhasil Mengembalikan Buku');
    }
}
