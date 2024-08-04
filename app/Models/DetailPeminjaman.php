<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'detail_pinjaman';

    public function pinjaman():BelongsTo{
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }
    public function buku():BelongsTo{
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
