<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunResim extends Model
{
    use HasFactory;

    protected $table = 'urun_resimleri';

    protected $fillable = [
        'urun_id',
        'resim_yolu',
        'alt_text',
        'ana_resim',
        'sira',
    ];

    protected $casts = [
        'ana_resim' => 'boolean',
    ];

    // İlişkiler
    public function urun()
    {
        return $this->belongsTo(Urun::class);
    }

    // Scope'lar
    public function scopeAnaResim($query)
    {
        return $query->where('ana_resim', true);
    }

    public function scopeSirali($query)
    {
        return $query->orderBy('sira');
    }

    // Helper metodları
    public function getFullUrl()
    {
        if (str_starts_with($this->resim_yolu, 'http')) {
            return $this->resim_yolu;
        }
        
        return asset('storage/' . $this->resim_yolu);
    }
}