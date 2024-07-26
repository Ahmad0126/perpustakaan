<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = 'pinjaman';

    public function member():BelongsTo{
        return $this->belongsTo(Member::class, 'id_member');
    }
    public function buku():BelongsTo{
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
