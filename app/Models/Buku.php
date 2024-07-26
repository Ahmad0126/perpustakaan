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
        return $this->hasMany(Pinjaman::class, 'id_buku');
    }
    public function kategori():BelongsTo{
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
