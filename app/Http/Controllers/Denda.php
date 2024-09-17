<?php

namespace App\Http\Controllers;

use App\Models\Denda as ModelsDenda;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Denda extends Controller
{
    public function index(){
        $data['title'] = 'Daftar Denda | Perpustakaan';
        if(Gate::allows('petugas')){
            $data['denda'] = ModelsDenda::orderBy('id', 'DESC')->paginate(20);
            $data['member'] = Member::all();
        }else{
            $data['denda'] = ModelsDenda::where(['id_member' => Auth::user()->member->id])->orderBy('id', 'DESC')->paginate(20);
        }
        return view('denda', $data);
    }
    public function tambah(Request $req){
        $req->validate([
            'id_member' => 'required|exists:member,id',
            'nominal' => 'required|integer',
        ]);

        $denda = new ModelsDenda();
        $denda->id_member = $req->id_member;
        $denda->nominal = $req->nominal;
        $denda->tanggal = date('Y-m-d');
        $denda->status = 'belum dibayar';
        $denda->kode_verifikasi = fake()->regexify('[A-Z]{5}[0-9]{3}');
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Menambahkan Denda');
    }
    public function edit(Request $req){
        $req->validate([
            'id' => 'required|exists:denda,id',
            'nominal' => 'required|integer',
        ]);

        $denda = ModelsDenda::find($req->id);
        $denda->nominal = $req->nominal;
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Mengedit Denda');
    }
    public function hapus($id){
        ModelsDenda::destroy($id);
        return redirect(route('denda'))->with('alert', 'Berhasil Menghapus Denda');
    }
    public function bayar(Request $req){
        $req->validate([
            'id' => 'required|exists:denda,id',
            'kode_verifikasi' => 'required',
        ]);

        $denda = ModelsDenda::find($req->id);
        if($denda->kode_verifikasi != $req->kode_verifikasi){
            return redirect(route('denda'))->withErrors('Kode Verifikasi tidak valid');
        }

        $denda->tanggal_dibayar = date('Y-m-d');
        $denda->status = 'dibayar';
        $denda->save();

        return redirect(route('denda'))->with('alert', 'Berhasil Membayar Denda');
    }
}
