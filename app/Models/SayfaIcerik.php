<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SayfaIcerik extends Model
{
    use HasFactory;

    protected $table = 'sayfa_icerikleri';

    protected $fillable = [
        'baslik',
        'slug',
        'icerik',
        'meta_baslik',
        'meta_aciklama',
        'meta_etiketler',
        'resim',
        'durum',
        'sira',
        'tip',
    ];

    protected $casts = [
        'meta_etiketler' => 'array',
        'durum' => 'boolean',
    ];

    // Scope'lar
    public function scopeAktif($query)
    {
        return $query->where('durum', true);
    }

    public function scopeTip($query, $tip)
    {
        return $query->where('tip', $tip);
    }

    public function scopeSirali($query)
    {
        return $query->orderBy('sira');
    }

    // Helper metodları
    public function getUrl()
    {
        return route('sayfa.goster', $this->slug);
    }
}