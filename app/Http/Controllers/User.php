<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    public function index(){
        $data['title'] = 'Daftar User | Perpustakaan';
        $data['user'] = ModelsUser::all();
        return view('user', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'username' => 'required|max:25|unique:user,username',
            'password' => 'required',
            'nama' => 'required|max:60',
            'level' => 'required',
        ]);

        $user = new ModelsUser();
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->nama = $req->nama;
        $user->level = $req->level;
        $user->save();

        return redirect(route('user'))->with('alert', 'Berhasil Menambahkan User');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required|max:60',
            'level' => 'required',
        ]);

        $user = ModelsUser::find($req->id);
        $user->nama = $req->nama;
        $user->level = $req->level;
        $user->save();

        return redirect(route('user'))->with('alert', 'Berhasil Mengedit User');
    }
}
