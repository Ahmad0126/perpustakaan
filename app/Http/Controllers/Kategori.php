<?php

namespace App\Http\Controllers;

use App\Models\Kategori as ModelsKategori;
use Illuminate\Http\Request;

class Kategori extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Kategori | Perpustakaan';
        $data['kategori'] = ModelsKategori::orderBy('id', 'DESC')->paginate(20);
        return view('kategori', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required|max:60|unique:kategori,nama',
            'nomor_rak' => 'required|unique:kategori,nomor_rak',
        ]);

        $kategori = new ModelsKategori();
        $kategori->nama = $req->nama;
        $kategori->nomor_rak = $req->nomor_rak;
        $kategori->save();

        return redirect(route('kategori'))->with('alert', 'Berhasil Menambahkan Kategori');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required|max:60|unique:kategori,nama,'.$req->id.',id',
            'nomor_rak' => 'required|unique:kategori,nomor_rak,'.$req->id.',id',
        ]);

        $kategori = ModelsKategori::find($req->id);
        $kategori->nama = $req->nama;
        $kategori->nomor_rak = $req->nomor_rak;
        $kategori->save();

        return redirect(route('kategori'))->with('alert', 'Berhasil Mengedit Kategori');
    }
    public function hapus($id){
        ModelsKategori::destroy($id);
        return redirect(route('kategori'))->with('alert', 'Berhasil Menghapus Kategori');
    }
}
