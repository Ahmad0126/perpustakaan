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

    public function member():BelongsTo{
        return $this->belongsTo(Member::class, 'id_member');
    }
    public function buku():BelongsTo{
        return $this->belongsTo(Buku::class, 'id_buku');
    }
    public function detail():HasMany{
        return $this->hasMany(DetailPinjaman::class, 'id_pinjaman');
    }
    public function jumlah_buku($id){
        return count(DetailPinjaman::where('id_pinjaman', $id)->get());
    }
}
