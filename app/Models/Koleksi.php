<?php

namespace App\Models;

use App\Http\Controllers\User;
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
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }
}
