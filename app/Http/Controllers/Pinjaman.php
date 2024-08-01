<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Pinjaman as ModelsPinjaman;

class Pinjaman extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Pinjaman | Perpustakaan';
        if(Gate::allows('member')){
            $data['buku'] = ModelsPinjaman::where('id_member', Auth::user()->member->id)->get();
        }else{
            $data['pinjaman'] = ModelsPinjaman::all();
        }
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
        $pinjaman->status = 'dipinjam';
        $pinjaman->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->save();

        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return redirect(route('pinjaman'))->with('alert', 'Berhasil Meminjam Buku');
    }
    public function pinjam(Request $req){
        $req->validate([
            'id' => 'required|exists:buku,id',
        ]);
        $pinjaman = new ModelsPinjaman();
        $pinjaman->id_buku = $req->id;
        $pinjaman->id_member = Auth::user()->id;
        $pinjaman->tanggal_dipinjam = date('Y-m-d');
        $pinjaman->tanggal_kembali = date('Y-m-d', strtotime('+7 day', time()));
        $pinjaman->status = 'dipinjam';
        $pinjaman->save();

        $buku = Buku::find($req->id);
        $buku->jumlah = $buku->jumlah - 1;
        $buku->save();

        return back()->with('alert', 'Berhasil Meminjam Buku');
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
        ModelsPinjaman::destroy($id);
        return redirect(route('pinjaman'))->with('alert', 'Berhasil Menghapus Pinjaman');
    }
}
