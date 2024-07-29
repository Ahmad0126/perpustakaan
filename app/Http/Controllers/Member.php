<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member as ModelsMember;

class Member extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Member | Perpustakaan';
        $data['member'] = ModelsMember::all();
        return view('member', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'nama' => 'required|max:60',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|max:200'
        ]);

        $user = new User();
        $user->username = $req->email;
        $user->password = Hash::make($req->password);
        $user->nama = $req->nama;
        $user->level = 'Member';
        $user->save();

        $member = new ModelsMember();
        $member->nama = $req->nama;
        $member->tanggal_lahir = $req->tanggal_lahir;
        $member->alamat = $req->alamat;
        $member->pendidikan = $req->pendidikan;
        $member->pekerjaan = $req->pekerjaan;
        $member->id_user = $user->id;
        $member->nomor_member = fake('id_ID')->randomNumber(7, true);
        $member->save();

        return redirect(route('member'))->with('alert', 'Berhasil Menambahkan Member');
    }
    public function edit(Request $req){
        $req->validate([
            'nama' => 'required|max:60',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|max:200'
        ]);

        $member = ModelsMember::find($req->id);
        $member->nama = $req->nama;
        $member->tanggal_lahir = $req->tanggal_lahir;
        $member->alamat = $req->alamat;
        $member->pendidikan = $req->pendidikan;
        $member->pekerjaan = $req->pekerjaan;
        $member->save();

        return redirect(route('member'))->with('alert', 'Berhasil Mengedit Member');
    }
    public function hapus($id){
        ModelsMember::destroy($id);
        return redirect(route('member'))->with('alert', 'Berhasil Menghapus Member');
    }
}
