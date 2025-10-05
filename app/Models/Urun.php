<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'urunler';

    protected $fillable = [
        'ad',
        'slug',
        'sku',
        'aciklama',
        'fiyat',
        'bayi_fiyat',
        'stok',
        'minimum_stok',
        'barkod',
        'gorsel',
        'kategori_id',
        'marka_id',
        'durum',
        'aktif',
        'agirlik',
        'boyutlar',
        'seo_baslik',
        'seo_aciklama',
        'meta_title',
        'meta_description',
        'meta_etiketler',
    ];

    protected $casts = [
        'fiyat' => 'decimal:2',
        'bayi_fiyat' => 'decimal:2',
        'agirlik' => 'decimal:2',
        'boyutlar' => 'array',
        'meta_etiketler' => 'array',
        'durum' => 'boolean',
        'aktif' => 'boolean',
    ];

    // İlişkiler
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function marka()
    {
        return $this->belongsTo(Marka::class);
    }

    public function magazalar()
    {
        return $this->belongsToMany(Magaza::class, 'magaza_urun')
                    ->withPivot(['platform_urun_id', 'platform_sku', 'senkron_durum'])
                    ->withTimestamps();
    }

    public function sepetItems()
    {
        return $this->hasMany(Sepet::class);
    }

    public function siparisUrunleri()
    {
        return $this->hasMany(SiparisUrunu::class);
    }

    public function resimler()
    {
        return $this->hasMany(UrunResim::class);
    }

    public function ozellikler()
    {
        return $this->hasMany(UrunOzellik::class);
    }

    public function bayiFiyatlari()
    {
        return $this->hasMany(BayiFiyat::class);
    }

    // Scope'lar
    public function scopeAktif($query)
    {
        return $query->where('durum', true);
    }

    public function scopeStokta($query)
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeKritikStok($query)
    {
        return $query->whereColumn('stok', '<=', 'minimum_stok');
    }

    public function scopeArama($query, $arama)
    {
        return $query->where(function($q) use ($arama) {
            $q->where('ad', 'like', "%{$arama}%")
              ->orWhere('aciklama', 'like', "%{$arama}%")
              ->orWhere('barkod', $arama)
              ->orWhere('sku', $arama);
        });
    }

    // Helper metodları
    public function getBayiFiyati($bayiId = null)
    {
        if ($bayiId) {
            $ozelFiyat = $this->bayiFiyatlari()
                              ->where('bayi_id', $bayiId)
                              ->where('baslangic_tarihi', '<=', now())
                              ->where(function($q) {
                                  $q->whereNull('bitis_tarihi')
                                    ->orWhere('bitis_tarihi', '>=', now());
                              })
                              ->first();
            
            if ($ozelFiyat) {
                return $ozelFiyat->fiyat;
            }
        }
        
        return $this->bayi_fiyat ?? $this->fiyat;
    }

    public function getAnaResim()
    {
        return $this->resimler()->where('ana_resim', true)->first()?->resim_yolu ?? $this->gorsel;
    }

    public function getTumResimler()
    {
        $resimler = $this->resimler()->orderBy('sira')->get();
        
        if ($resimler->isEmpty() && $this->gorsel) {
            return collect([['resim_yolu' => $this->gorsel, 'ana_resim' => true]]);
        }
        
        return $resimler;
    }
}
