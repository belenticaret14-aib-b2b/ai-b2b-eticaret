<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kullanici extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'kullanicilar';

    protected $fillable = [
        'ad',
        'email',
        'password',
        'rol',
        'telefon',
        'adres',
        'durum',
        'email_verified_at',
        'magaza_id',
        'bayi_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // İlişkiler
    public function magaza()
    {
        return $this->belongsTo(Magaza::class);
    }

    public function bayi()
    {
        return $this->belongsTo(Bayi::class);
    }

    public function siparisler()
    {
        return $this->hasMany(Siparis::class);
    }

    public function sepetItems()
    {
        return $this->hasMany(Sepet::class);
    }

    // Scope'lar
    public function scopeSuperAdminler($query)
    {
        return $query->where('rol', 'super_admin');
    }

    public function scopeStoreAdminler($query)
    {
        return $query->where('rol', 'store_admin');
    }

    public function scopeDealerAdminler($query)
    {
        return $query->where('rol', 'dealer_admin');
    }

    public function scopeAdminler($query)
    {
        return $query->where('rol', 'admin');
    }

    public function scopeBayiler($query)
    {
        return $query->where('rol', 'bayi');
    }

    public function scopeMusteriler($query)
    {
        return $query->where('rol', 'musteri');
    }

    // Helper metodları
    public function isSuperAdmin()
    {
        return $this->rol === 'super_admin';
    }

    public function isStoreAdmin()
    {
        return $this->rol === 'store_admin';
    }

    public function isDealerAdmin()
    {
        return $this->rol === 'dealer_admin';
    }

    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isBayi()
    {
        return $this->rol === 'bayi';
    }

    public function isMusteri()
    {
        return $this->rol === 'musteri';
    }

    // Şifre alanı mapping
    public function getAuthPassword()
    {
        return $this->password;
    }
}
