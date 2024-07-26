<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard | Perpustakaan';
        return view('dashboard', $data);
    }
}
