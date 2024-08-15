<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Koleksi as ModelsKoleksi;

class Koleksi extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Koleksi | Perpustakaan';
        $data['koleksi'] = ModelsKoleksi::where('id_user', Auth::user()->id)->orderBy('id', 'DESC')->paginate(20);
        return view('koleksi', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);

        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();

        $pinjaman = new ModelsKoleksi();
        $pinjaman->id_buku = $buku->id;
        $pinjaman->id_member = $req->id_member;
        $pinjaman->status = 'dipinjam';
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Meminjam Buku');
    }
    public function add(Request $req){
        $koleksi = new ModelsKoleksi();
        $koleksi->id_buku = $req->id;  
        $koleksi->id_user = Auth::user()->id;
        $koleksi->save();

        return back()->with('alert', 'Berhasil Ditambahkan Ke Koleksi');
    }
    public function hapus($id){
        ModelsKoleksi::destroy($id);
        return redirect(route('koleksi'))->with('alert', 'Berhasil Menghapus Koleksi');
    }
}
