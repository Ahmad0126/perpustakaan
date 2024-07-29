<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koleksi extends Model
{
    use HasFactory;
    protected $table = 'koleksi';

    public function buku():BelongsTo{
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
