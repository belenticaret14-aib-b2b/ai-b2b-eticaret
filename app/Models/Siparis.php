<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    use HasFactory;

    protected $table = 'siparisler';

    protected $fillable = [
        'siparis_no',
        'kullanici_id',
        'magaza_id',
        'platform_siparis_id',
        'durum',
        'odeme_durumu',
        'kargo_durumu',
        'toplam_tutar',
        'indirim_tutari',
        'kargo_tutari',
        'vergi_tutari',
        'net_tutar',
        'odeme_yontemi',
        'kargo_firmasi',
        'kargo_takip_no',
        'fatura_bilgileri',
        'teslimat_bilgileri',
        'notlar',
        'siparis_tarihi',
        'onay_tarihi',
        'hazirlanma_tarihi',
        'kargo_tarihi',
        'teslimat_tarihi',
        'iptal_tarihi',
        'iptal_nedeni',
    ];

    protected $casts = [
        'toplam_tutar' => 'decimal:2',
        'indirim_tutari' => 'decimal:2',
        'kargo_tutari' => 'decimal:2',
        'vergi_tutari' => 'decimal:2',
        'net_tutar' => 'decimal:2',
        'fatura_bilgileri' => 'array',
        'teslimat_bilgileri' => 'array',
        'siparis_tarihi' => 'datetime',
        'onay_tarihi' => 'datetime',
        'hazirlanma_tarihi' => 'datetime',
        'kargo_tarihi' => 'datetime',
        'teslimat_tarihi' => 'datetime',
        'iptal_tarihi' => 'datetime',
    ];

    // İlişkiler
    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class);
    }

    public function magaza()
    {
        return $this->belongsTo(Magaza::class);
    }

    public function urunler()
    {
        return $this->hasMany(SiparisUrunu::class);
    }

    public function odemeler()
    {
        return $this->hasMany(SiparisOdeme::class);
    }

    public function kargoTakipler()
    {
        return $this->hasMany(KargoTakip::class);
    }

    // Scope'lar
    public function scopeYeni($query)
    {
        return $query->where('durum', 'yeni');
    }

    public function scopeOnaylanan($query)
    {
        return $query->where('durum', 'onaylandi');
    }

    public function scopeHazirlanan($query)
    {
        return $query->where('durum', 'hazirlandi');
    }

    public function scopeKargolanan($query)
    {
        return $query->where('durum', 'kargolandi');
    }

    public function scopeTeslimEdilen($query)
    {
        return $query->where('durum', 'teslim_edildi');
    }

    public function scopeIptalEdilen($query)
    {
        return $query->where('durum', 'iptal_edildi');
    }

    // Helper metodları
    public function getDurumText()
    {
        $durumlar = [
            'yeni' => 'Yeni Sipariş',
            'onaylandi' => 'Onaylandı',
            'hazirlandi' => 'Hazırlandı',
            'kargolandi' => 'Kargoya Verildi',
            'teslim_edildi' => 'Teslim Edildi',
            'iptal_edildi' => 'İptal Edildi',
        ];

        return $durumlar[$this->durum] ?? $this->durum;
    }

    public function getOdemeDurumuText()
    {
        $durumlar = [
            'bekliyor' => 'Ödeme Bekliyor',
            'odendi' => 'Ödendi',
            'iade_edildi' => 'İade Edildi',
            'iptal_edildi' => 'İptal Edildi',
        ];

        return $durumlar[$this->odeme_durumu] ?? $this->odeme_durumu;
    }

    public function canCancel()
    {
        return in_array($this->durum, ['yeni', 'onaylandi']);
    }

    public function canPrepare()
    {
        return $this->durum === 'onaylandi';
    }

    public function canShip()
    {
        return $this->durum === 'hazirlandi';
    }
}