<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KullaniciController extends Controller
{
    /**
     * Kullanıcı kaydı
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:kullanicilar',
            'sifre' => 'required|string|min:8|confirmed',
            'telefon' => 'nullable|string|max:20',
            'rol' => 'required|in:musteri,bayi'
        ]);
        
        $kullanici = Kullanici::create([
            'ad' => $request->ad,
            'soyad' => $request->soyad,
            'email' => $request->email,
            'sifre' => Hash::make($request->sifre),
            'telefon' => $request->telefon,
            'rol' => $request->rol,
            'durum' => true,
            'email_verified_at' => now()
        ]);
        
        $token = $kullanici->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla oluşturuldu',
            'data' => [
                'kullanici' => $kullanici,
                'token' => $token
            ]
        ], 201);
    }
    
    /**
     * Kullanıcı girişi
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'sifre' => 'required|string'
        ]);
        
        $kullanici = Kullanici::where('email', $request->email)->first();
        
        if (!$kullanici || !Hash::check($request->sifre, $kullanici->sifre)) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz email veya şifre'
            ], 401);
        }
        
        if (!$kullanici->durum) {
            return response()->json([
                'success' => false,
                'message' => 'Hesabınız aktif değil'
            ], 401);
        }
        
        $token = $kullanici->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Giriş başarılı',
            'data' => [
                'kullanici' => $kullanici,
                'token' => $token
            ]
        ]);
    }
    
    /**
     * B2B Girişi (Bayi)
     */
    public function b2bLogin(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'sifre' => 'required|string'
        ]);
        
        $kullanici = Kullanici::where('email', $request->email)
            ->where('rol', 'bayi')
            ->first();
        
        if (!$kullanici || !Hash::check($request->sifre, $kullanici->sifre)) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz bayi bilgileri'
            ], 401);
        }
        
        if (!$kullanici->durum) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi hesabınız aktif değil'
            ], 401);
        }
        
        // Bayi bilgilerini kontrol et
        if (!$kullanici->bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi profili bulunamadı'
            ], 404);
        }
        
        $token = $kullanici->createToken('b2b_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'B2B giriş başarılı',
            'data' => [
                'kullanici' => $kullanici->load('bayi'),
                'token' => $token
            ]
        ]);
    }
    
    /**
     * Kullanıcı bilgileri
     */
    public function user(Request $request): JsonResponse
    {
        $kullanici = $request->user()->load('bayi');
        
        return response()->json([
            'success' => true,
            'data' => $kullanici
        ]);
    }
    
    /**
     * Çıkış yap
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Çıkış başarılı'
        ]);
    }
    
    /**
     * Profil güncelle
     */
    public function profilGuncelle(Request $request): JsonResponse
    {
        $request->validate([
            'ad' => 'sometimes|string|max:255',
            'soyad' => 'sometimes|string|max:255',
            'telefon' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255|unique:kullanicilar,email,' . $request->user()->id
        ]);
        
        $kullanici = $request->user();
        $kullanici->update($request->only(['ad', 'soyad', 'telefon', 'email']));
        
        return response()->json([
            'success' => true,
            'message' => 'Profil güncellendi',
            'data' => $kullanici
        ]);
    }
    
    /**
     * Şifre değiştir
     */
    public function sifreDegistir(Request $request): JsonResponse
    {
        $request->validate([
            'eski_sifre' => 'required|string',
            'yeni_sifre' => 'required|string|min:8|confirmed'
        ]);
        
        $kullanici = $request->user();
        
        if (!Hash::check($request->eski_sifre, $kullanici->sifre)) {
            return response()->json([
                'success' => false,
                'message' => 'Mevcut şifre yanlış'
            ], 400);
        }
        
        $kullanici->update([
            'sifre' => Hash::make($request->yeni_sifre)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Şifre başarıyla değiştirildi'
        ]);
    }
}




