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
    public function bayi()
    {
        return $this->hasOne(Bayi::class);
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

    // Eğer veritabanında şifre alanı 'sifre' ise, aşağıdaki gibi mapleyin
    public function getAuthPassword()
    {
        return $this->sifre ?? $this->password;
    }
}
