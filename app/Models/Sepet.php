<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sepet extends Model
{
    use HasFactory;

    protected $table = 'sepetler';

    protected $fillable = [
        'kullanici_id',
        'urun_id',
        'adet',
    ];

    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id');
    }
}
