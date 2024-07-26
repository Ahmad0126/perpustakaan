<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengunjungMember extends Model
{
    use HasFactory;
    protected $table = 'pengunjung_member';

    public function member():BelongsTo{
        return $this->belongsTo(Member::class, 'id_member');
    }
}
