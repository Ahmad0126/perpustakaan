<?php

namespace App\Http\Controllers;

use App\Models\Ulasan as ModelsUlasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ulasan extends Controller
{
    public function index(){
        $data['ulasan'] = User::find(Auth::user()->id)->ulasan;
        $data['title'] = "Ulasan Anda | Perpustakaan";
    }
    public function ulas(Request $req){
        $req->validate([
            'rating' => 'required|max:5',
            'ulasan' => 'required|max:255',
        ]);

        $ulasan = new ModelsUlasan();
        $ulasan->id_buku = $req->id_buku;
        $ulasan->id_user = Auth::user()->id;
        $ulasan->rating = $req->rating;
        $ulasan->ulasan = $req->ulasan;
        $ulasan->save();

        return back()->with('alert', 'Berhasil Memberi Ulasan');
    }
}
