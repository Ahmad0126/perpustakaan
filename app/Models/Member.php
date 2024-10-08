<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';

    public function pinjaman():HasMany{
        return $this->hasMany(Pinjaman::class, 'id_member');
    }
    public function pengunjung():HasMany{
        return $this->hasMany(PengunjungMember::class, 'id_member');
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }
    public function denda():HasMany{
        return $this->hasMany(Denda::class, 'id_member');
    }
}
