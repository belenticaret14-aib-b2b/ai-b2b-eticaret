<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayi extends Model
{
    use HasFactory;

    protected $table = 'bayiler';
    protected $fillable = [
        'ad', 'email', 'telefon', 'adres', 'kullanici_id'
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class);
    }
}
