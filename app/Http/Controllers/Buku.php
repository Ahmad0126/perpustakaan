<?php

namespace App\Http\Controllers;

use App\Models\Buku as ModelsBuku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class Buku extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Buku | Perpustakaan';
        $data['buku'] = ModelsBuku::paginate(20);
        $data['kategori'] = Kategori::all();
        return view('buku', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'judul' => 'required|max:128|unique:buku,judul',
            'penulis' => 'required|max:60',
            'penerbit' => 'required|max:60',
            'id_kategori' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal_rilis' => 'required|date',
        ]);

        $kategori = Kategori::find($req->id_kategori);
        $k = count($kategori->buku) + 1;

        $buku = new ModelsBuku();
        $buku->penulis = $req->penulis;
        $buku->judul = $req->judul;
        $buku->penerbit = $req->penerbit;
        $buku->id_kategori = $req->id_kategori;
        $buku->jumlah = $req->jumlah;
        $buku->tanggal_rilis = $req->tanggal_rilis;
        $buku->nomor_buku = $kategori->nomor_rak.'-'.fake()->randomNumber(4, true);
        $buku->save();

        return redirect(route('buku'))->with('alert', 'Berhasil Menambahkan Buku');
    }
    public function detail($nomor){
        $data['buku'] = ModelsBuku::where('nomor_buku', $nomor)->get()->first();
        $data['title'] = 'Detail Buku | Perpustakaan';
        return view('datail_buku', $data);
    }
    public function edit(Request $req){
        $req->validate([
            'judul' => 'required|max:128|unique:buku,judul,'.$req->id.',id',
            'penulis' => 'required|max:60',
            'penerbit' => 'required|max:60',
            'id_kategori' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal_rilis' => 'required|date',
        ]);

        $kategori = Kategori::find($req->id_kategori);
        $k = count($kategori->buku) + 1;

        $buku = ModelsBuku::find($req->id);
        $buku->penulis = $req->penulis;
        $buku->judul = $req->judul;
        $buku->penerbit = $req->penerbit;
        $buku->id_kategori = $req->id_kategori;
        $buku->jumlah = $req->jumlah;
        $buku->tanggal_rilis = $req->tanggal_rilis;
        $buku->nomor_buku = $kategori->nomor_rak.'-'.str_pad($k, 4, 0, STR_PAD_LEFT);
        $buku->save();

        return redirect(route('buku'))->with('alert', 'Berhasil Mengedit Buku');
    }
    public function hapus($id){
        ModelsBuku::destroy($id);
        return redirect(route('buku'))->with('alert', 'Berhasil Menghapus Buku');
    }
}
