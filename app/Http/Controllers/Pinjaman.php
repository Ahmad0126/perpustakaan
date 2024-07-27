<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman as ModelsPinjaman;
use Illuminate\Http\Request;

class Pinjaman extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Pinjaman | Perpustakaan';
        $data['pinjaman'] = ModelsPinjaman::all();
        $data['member'] = Member::all();
        return view('pinjaman', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
            'id_member' => 'required|integer',
        ]);

        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();

        $pinjaman = new ModelsPinjaman();
        $pinjaman->id_buku = $buku->id;
        $pinjaman->id_member = $req->id_member;
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Meminjam Buku');
    }
    public function edit(Request $req){
        $req->validate([
            'nomor_buku' => 'required|exists:buku,nomor_buku',
        ]);
        
        $buku = Buku::where('nomor_buku', $req->nomor_buku)->get()->first();
        $pinjaman = ModelsPinjaman::where(['id' => $buku->pinjaman->first()->id, 'tanggal_kembali' => null])->get()->first();
        if($pinjaman == null){
            return redirect(route('pinjaman'))->withErrors('Buku Sedang tidak Dipinjam');
        }

        $pinjaman->tanggal_kembali = date('Y-m-d');
        $pinjaman->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Mengembalikan Buku');
    }
    public function hapus($id){
        ModelsPinjaman::destroy($id);
        return redirect(route('pinjaman'))->with('alert', 'Berhasil Menghapus Pinjaman');
    }
}
