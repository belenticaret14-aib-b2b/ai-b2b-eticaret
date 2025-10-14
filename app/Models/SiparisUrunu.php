<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiparisUrunu extends Model
{
    use HasFactory;

    protected $table = 'siparis_urunleri';

    protected $fillable = [
        'siparis_id',
        'urun_id',
        'urun_adi',
        'urun_fiyati',
        'adet',
        'toplam_tutar',
    ];

    protected $casts = [
        'urun_fiyati' => 'decimal:2',
        'toplam_tutar' => 'decimal:2',
        'adet' => 'integer',
    ];

    // İlişkiler
    public function siparis()
    {
        return $this->belongsTo(Siparis::class);
    }

    public function urun()
    {
        return $this->belongsTo(Urun::class);
    }
}