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
        'adet',
        'birim_fiyat',
        'toplam_fiyat',
        'indirim_tutari',
        'platform_urun_id',
        'urun_adi',
        'urun_sku',
        'urun_barkod',
    ];

    protected $casts = [
        'birim_fiyat' => 'decimal:2',
        'toplam_fiyat' => 'decimal:2',
        'indirim_tutari' => 'decimal:2',
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