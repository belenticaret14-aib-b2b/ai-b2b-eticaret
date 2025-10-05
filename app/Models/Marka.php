<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marka extends Model
{
    use HasFactory;

    protected $table = 'markalar';

    protected $fillable = [
        'ad',
        'slug',
        'aciklama',
        'logo',
        'durum',
        'seo_baslik',
        'seo_aciklama',
        'meta_etiketler',
    ];

    protected $casts = [
        'durum' => 'boolean',
        'meta_etiketler' => 'array',
    ];

    // İlişkiler
    public function urunler()
    {
        return $this->hasMany(Urun::class);
    }

    // Scope'lar
    public function scopeAktif($query)
    {
        return $query->where('durum', true);
    }
}