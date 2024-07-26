<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;

class User extends Controller
{
    public function index(){
        $data['title'] = 'Daftar User | Perpustakaan';
        $data['user'] = ModelsUser::all();
        return view('user', $data);
    }
}
