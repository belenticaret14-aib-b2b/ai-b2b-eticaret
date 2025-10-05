<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAyar extends Model
{
    use HasFactory;

    protected $table = 'site_ayarlari';

    protected $fillable = [
        'anahtar',
        'deger',
        'tip',
        'grup',
        'aciklama',
    ];

    // Helper metodları
    public static function get($anahtar, $default = null)
    {
        $ayar = static::where('anahtar', $anahtar)->first();
        
        if (!$ayar) {
            return $default;
        }

        // JSON tip ise decode et
        if ($ayar->tip === 'json') {
            return json_decode($ayar->deger, true);
        }

        return $ayar->deger;
    }

    public static function set($anahtar, $deger, $tip = 'text', $grup = 'genel')
    {
        // JSON tip ise encode et
        if ($tip === 'json' && is_array($deger)) {
            $deger = json_encode($deger);
        }

        return static::updateOrCreate(
            ['anahtar' => $anahtar],
            [
                'deger' => $deger,
                'tip' => $tip,
                'grup' => $grup,
            ]
        );
    }

    public static function getGrup($grup)
    {
        return static::where('grup', $grup)->get()->pluck('deger', 'anahtar');
    }
}