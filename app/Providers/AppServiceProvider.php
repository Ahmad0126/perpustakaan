<?php

namespace App\Providers;

use App\Models\Koleksi;
use App\Models\Pinjaman;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function(User $user){
            return $user->level === 'Admin';
        });
        Gate::define('member', function(User $user){
            return $user->level === 'Member';
        });
        Gate::define('petugas', function(User $user){
            return $user->level === 'Admin' || $user->level === 'Petugas';
        });
        Gate::define('belum_ulas', function(User $user, $id_buku){
            $buku = Ulasan::where(['id_user' => $user->id, 'id_buku' => $id_buku])->get();
            return count($buku) == 0;
        });
        Gate::define('belum_simpan', function(User $user, $id_buku){
            $buku = Koleksi::where(['id_user' => $user->id, 'id_buku' => $id_buku])->get();
            return count($buku) == 0;
        });
        Gate::define('belum_pinjam', function(User $user, $id_buku){
            $buku = Pinjaman::where(['id_member' => $user->member->id, 'id_buku' => $id_buku])->get();
            return count($buku) == 0;
        });
    }
}
