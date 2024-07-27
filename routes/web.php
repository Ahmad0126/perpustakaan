<?php

use App\Http\Controllers\Home;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function(){
    Route::get('/login', function(){ return view('login'); });
    Route::post('/login', [Home::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function(){
    Route::get('/', [Home::class, 'index'])->name('base');
    Route::get('/logout', [Home::class, 'logout'])->name('logout');
    Route::get('/user', [User::class, 'index'])->name('user');
    Route::post('/user/tambah', [User::class, 'tambah'])->name('user_tambah');
    Route::post('/user/edit', [User::class, 'edit'])->name('user_edit');
});
