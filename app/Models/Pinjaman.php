<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = 'pinjaman';

    public function detail():HasMany{
        return $this->hasMany(DetailPeminjaman::class, 'id_pinjaman');
    }
    public function member():BelongsTo{
        return $this->belongsTo(Member::class, 'id_member');
    }
    public function jumlah_buku(){
        return count(Pinjaman::all('id'));
    }
}
