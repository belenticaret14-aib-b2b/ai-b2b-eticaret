<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoriler';

    protected $fillable = [
        'ad',
        'slug',
        'aciklama',
        'resim',
        'parent_id',
        'sira',
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
    public function parent()
    {
        return $this->belongsTo(Kategori::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Kategori::class, 'parent_id');
    }

    public function urunler()
    {
        return $this->hasMany(Urun::class);
    }

    // Scope'lar
    public function scopeAktif($query)
    {
        return $query->where('durum', true);
    }

    public function scopeAnaKategoriler($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeAltKategoriler($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Helper metodları
    public function getFullPath()
    {
        $path = [$this->ad];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->ad);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }

    public function getAllChildren()
    {
        $children = collect();
        
        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->getAllChildren());
        }
        
        return $children;
    }
}