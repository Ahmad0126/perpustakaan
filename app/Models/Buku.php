<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';

    public function pinjaman():HasMany{
        return $this->hasMany(DetailPeminjaman::class, 'id_buku');
    }
    public function ulasan():HasMany{
        return $this->hasMany(Ulasan::class, 'id_buku');
    }
    public function koleksi():HasMany{
        return $this->hasMany(Koleksi::class, 'id_buku');
    }
    public function kategori():BelongsTo{
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function dipinjam($id){
        $buku = DetailPeminjaman::where(['status' => 'dipinjam', 'id_buku' => $id])->get();
        return count($buku);
    }
}
