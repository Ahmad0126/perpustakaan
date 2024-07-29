<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Home extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard | Perpustakaan';
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
