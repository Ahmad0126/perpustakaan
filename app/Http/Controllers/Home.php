<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPinjaman;
use App\Models\Koleksi;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Home extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard | Perpustakaan';
        $data['buku'] = Buku::orderBy('tanggal_rilis', 'DESC')->limit(10)->get();
        if(Gate::allows('petugas')){
            $data += [
                'jml_buku'=> Buku::all()->count(),
                'jml_member' => Member::all()->count(),
                'jml_dipinjam' => DetailPinjaman::where('status', 'dipinjam')->count(),
                'jml_kembali' => DetailPinjaman::where('status', 'dikembalikan')->count(),
            ];
        }else{
            $data += [
                'jml_pinjam'=> Pinjaman::where('id_member', Auth::user()->member->id)->count(),
                'jml_koleksi' => Koleksi::where('id_user', Auth::user()->id)->count(),
                'jml_pinjam_pbulan' => Pinjaman::where('tanggal_dipinjam', '>=', date('Y-m-d', strtotime('-1 month')))->count(),
                'jml_ulasan' => Ulasan::where('id_user', Auth::user()->id)->count(),
            ];
        }
        return view('dashboard', $data);
    }
    public function login(Request $req):RedirectResponse{
        $user = $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($user)){
            $req->session()->regenerate();
            return redirect(route('base'));
        }

        return back()->withErrors([
            'username' => 'Login Failed!'
        ])->onlyInput('username');
    }
    public function logout(Request $req){
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('login');
    }
    public function daftar(){
        return view('daftar');
    }
}
