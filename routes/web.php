<?php

use App\Http\Controllers\Buku;
use App\Http\Controllers\Home;
use App\Http\Controllers\User;
use App\Http\Controllers\Member;
use App\Http\Controllers\Ulasan;
use App\Http\Controllers\Koleksi;
use App\Http\Controllers\Kategori;
use App\Http\Controllers\Pinjaman;
use App\Http\Controllers\Transaksi;
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
    Route::get('/daftar', [Home::class, 'daftar'])->name('daftar');
    Route::post('/register', [Member::class, 'tambah'])->name('register');
});

Route::middleware('auth')->group(function(){
    Route::get('/', [Home::class, 'index'])->name('base');
    Route::get('/logout', [Home::class, 'logout'])->name('logout');

    Route::middleware('can:admin')->group(function(){
        Route::get('/user', [User::class, 'index'])->name('user');
        Route::post('/user/tambah', [User::class, 'tambah'])->name('user_tambah');
        Route::post('/user/edit', [User::class, 'edit'])->name('user_edit');
        Route::get('/user/hapus/{id}', [User::class, 'hapus'])->name('user_hapus');
    });
    
    Route::middleware('can:petugas')->group(function(){
        Route::post('/buku/tambah', [Buku::class, 'tambah'])->name('buku_tambah');
        Route::post('/buku/edit', [Buku::class, 'edit'])->name('buku_edit');
        Route::get('/buku/hapus/{id}', [Buku::class, 'hapus'])->name('buku_hapus');
        
        Route::post('/kategori/tambah', [Kategori::class, 'tambah'])->name('kategori_tambah');
        Route::post('/kategori/edit', [Kategori::class, 'edit'])->name('kategori_edit');
        Route::get('/kategori/hapus/{id}', [Kategori::class, 'hapus'])->name('kategori_hapus');

        Route::get('/member', [Member::class, 'index'])->name('member');
        Route::post('/member/tambah', [Member::class, 'tambah'])->name('member_tambah');
        Route::post('/member/edit', [Member::class, 'edit'])->name('member_edit');
        Route::get('/member/hapus/{id}', [Member::class, 'hapus'])->name('member_hapus');
        
        Route::get('/buku/laporan', [Buku::class, 'laporan'])->name('buku_laporan');
        Route::get('/pinjaman/laporan', [Pinjaman::class, 'laporan'])->name('pinjaman_laporan');
        Route::get('/transaksi/laporan', [Transaksi::class, 'laporan'])->name('transaksi_laporan');
    });

    Route::middleware('can:member')->group(function(){
        Route::post('/buku/pinjam', [Pinjaman::class, 'pinjam'])->name('buku_pinjam');
    });

    Route::get('/kategori', [Kategori::class, 'index'])->name('kategori');
    
    Route::get('/ulasan', [Ulasan::class, 'index'])->name('ulasan');
    Route::post('/ulasan/ulas', [Ulasan::class, 'ulas'])->name('ulas');

    Route::get('/koleksi', [Koleksi::class, 'index'])->name('koleksi');
    Route::post('/koleksi/add', [Koleksi::class, 'add'])->name('koleksi_add');
    Route::get('/koleksi/hapus/{id}', [Koleksi::class, 'hapus'])->name('koleksi_hapus');
    
    Route::get('/buku', [Buku::class, 'index'])->name('buku');
    Route::get('/buku/detail/{nomor}', [Buku::class, 'detail'])->name('buku_detail');
    Route::get('/buku/filter', [Buku::class, 'filter'])->name('buku_filter');
    
    Route::get('/pinjaman', [Pinjaman::class, 'index'])->name('pinjaman');
    Route::post('/pinjaman/tambah', [Pinjaman::class, 'tambah'])->name('pinjaman_tambah');
    Route::post('/pinjaman/edit', [Pinjaman::class, 'edit'])->name('pinjaman_edit');
    Route::get('/pinjaman/hapus/{id}', [Pinjaman::class, 'hapus'])->name('pinjaman_hapus');
    Route::get('/pinjaman/filter', [Pinjaman::class, 'filter'])->name('pinjaman_filter');
    Route::get('/pinjaman/kembalikan', [Pinjaman::class, 'kembalikan'])->name('pinjaman_kembalikan');

    Route::get('/transaksi', [Transaksi::class, 'index'])->name('transaksi');
    Route::get('/transaksi/tambah', [Transaksi::class, 'tambah'])->name('transaksi_tambah');
    Route::post('/transaksi/masukkan', [Transaksi::class, 'masukkan'])->name('transaksi_masukkan');
    Route::post('/transaksi/proses', [Transaksi::class, 'proses'])->name('transaksi_proses');
    Route::post('/transaksi/kembalikan', [Transaksi::class, 'kembalikan'])->name('transaksi_kembalikan');
    Route::get('/transaksi/detail/{id}', [Transaksi::class, 'detail'])->name('transaksi_detail');
    Route::get('/keranjang/hapus/{id}', [Transaksi::class, 'batal_keranjang'])->name('keranjang_hapus');
    Route::get('/transaksi/filter', [Transaksi::class, 'filter'])->name('transaksi_filter');
});
