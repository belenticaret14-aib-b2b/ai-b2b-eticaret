<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenkronLog extends Model
{
    use HasFactory;

    protected $table = 'senkron_loglar';

    protected $fillable = [
        'magaza_id',
        'tip',
        'durum',
        'detay',
        'baslangic_zamani',
        'bitis_zamani',
        'hata_mesaji',
    ];

    protected $casts = [
        'detay' => 'array',
        'baslangic_zamani' => 'datetime',
        'bitis_zamani' => 'datetime',
    ];

    // İlişkiler
    public function magaza()
    {
        return $this->belongsTo(Magaza::class);
    }

    // Scope'lar
    public function scopeBasarili($query)
    {
        return $query->where('durum', 'basarili');
    }

    public function scopeHatali($query)
    {
        return $query->where('durum', 'hata');
    }

    public function scopeTip($query, $tip)
    {
        return $query->where('tip', $tip);
    }
}