<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magaza extends Model
{
    use SoftDeletes;

    protected $table = 'magazalar';
    
    protected $fillable = [
        'ad',
        'platform',
        'platform_kodu',
        'api_anahtari',
        'api_gizli_anahtari',
        'api_url',
        'magaza_id',
        'komisyon_orani',
        'auto_senkron',
        'aktif',
        'test_mode',
        'aciklama',
        'api_base_url',
        'entegrasyon_turu',
        'durum',
        'senkron_durum',
        'son_senkron',
        'son_senkron_tarihi',
        'son_baglanti_testi',
        'ayarlar',
        'webhook_url',
        'webhook_secret',
    ];

    protected $casts = [
        'durum' => 'boolean',
        'aktif' => 'boolean',
        'auto_senkron' => 'boolean',
        'test_mode' => 'boolean',
        'komisyon_orani' => 'decimal:2',
        'son_senkron' => 'datetime',
        'son_senkron_tarihi' => 'datetime',
        'son_baglanti_testi' => 'datetime',
        'ayarlar' => 'array',
    ];

    // İlişkiler
    public function urunler()
    {
        return $this->belongsToMany(Urun::class, 'magaza_urun')
                    ->withPivot(['platform_urun_id', 'platform_sku', 'senkron_durum', 'fiyat', 'stok'])
                    ->withTimestamps();
    }

    public function siparisler()
    {
        return $this->hasMany(Siparis::class);
    }

    public function senkronLoglar()
    {
        return $this->hasMany(SenkronLog::class);
    }

    // Scope'lar
    public function scopeAktif($query)
    {
        return $query->where('durum', true);
    }

    public function scopePlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    // Helper metodları
    public function getPlatformConfig()
    {
        return config("eticaret.platformlar.{$this->platform}", []);
    }

    public function getApiCredentials()
    {
        return [
            'api_key' => $this->api_anahtari,
            'api_secret' => $this->api_gizli_anahtar,
            'base_url' => $this->api_base_url ?? $this->getPlatformConfig()['base_url'] ?? null,
        ];
    }

    public function isApiConfigured()
    {
        return !empty($this->api_anahtari) && !empty($this->api_gizli_anahtar);
    }

    public function getLastSyncStatus()
    {
        return $this->senkronLoglar()
                    ->latest()
                    ->first()?->durum ?? 'henuz_senkron_edilmedi';
    }

    public function canSync()
    {
        return $this->durum && $this->isApiConfigured();
    }
}
