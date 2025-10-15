<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\ClaudeService;
use Illuminate\Http\Request;

class ClaudeController extends Controller
{
    private ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService)
    {
        $this->claudeService = $claudeService;
    }

    /**
     * Claude AI Yardımcı Sayfası
     */
    public function index()
    {
        return view('super-admin.claude', [
            'model' => $this->claudeService->getModel()
        ]);
    }

    /**
     * Chat API - Genel sohbet
     */
    public function chat(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:5000',
            'max_tokens' => 'nullable|integer|min:100|max:4096',
            'temperature' => 'nullable|numeric|min:0|max:1',
        ]);

        $result = $this->claudeService->chat(
            $request->input('prompt'),
            $request->input('max_tokens', 2048),
            $request->input('temperature', 0.7)
        );

        return response()->json($result);
    }

    /**
     * Ürün açıklaması oluştur
     */
    public function urunAciklamasi(Request $request)
    {
        $request->validate([
            'urun_adi' => 'required|string|max:255',
            'ozellikler' => 'nullable|array',
        ]);

        $aciklama = $this->claudeService->urunAciklamasiOlustur(
            $request->input('urun_adi'),
            $request->input('ozellikler', [])
        );

        return response()->json([
            'success' => true,
            'aciklama' => $aciklama
        ]);
    }

    /**
     * SEO meta açıklaması oluştur
     */
    public function seoMeta(Request $request)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
        ]);

        $meta = $this->claudeService->seoMetaOlustur(
            $request->input('baslik'),
            $request->input('icerik')
        );

        return response()->json([
            'success' => true,
            'meta' => $meta
        ]);
    }

    /**
     * Müşteri sorusunu yanıtla
     */
    public function musteriSorusu(Request $request)
    {
        $request->validate([
            'soru' => 'required|string|max:1000',
            'urun_bilgileri' => 'nullable|array',
        ]);

        $yanit = $this->claudeService->musteriSorusuYanitla(
            $request->input('soru'),
            $request->input('urun_bilgileri', [])
        );

        return response()->json([
            'success' => true,
            'yanit' => $yanit
        ]);
    }

    /**
     * Sipariş analizi yap
     */
    public function siparisAnalizi(Request $request)
    {
        $request->validate([
            'siparis_verileri' => 'required|array',
        ]);

        $result = $this->claudeService->siparisAnalizi(
            $request->input('siparis_verileri')
        );

        return response()->json($result);
    }

    /**
     * Metin çevirisi
     */
    public function ceviri(Request $request)
    {
        $request->validate([
            'icerik' => 'required|string|max:10000',
            'hedef_dil' => 'required|string|in:en,de,fr,es,it,ar',
        ]);

        $ceviri = $this->claudeService->ceviri(
            $request->input('icerik'),
            $request->input('hedef_dil')
        );

        return response()->json([
            'success' => true,
            'ceviri' => $ceviri
        ]);
    }

    /**
     * Stok uyarısı oluştur
     */
    public function stokUyarisi(Request $request)
    {
        $request->validate([
            'dusuk_stok_urunler' => 'required|array',
        ]);

        $uyari = $this->claudeService->stokUyarisiOlustur(
            $request->input('dusuk_stok_urunler')
        );

        return response()->json([
            'success' => true,
            'uyari' => $uyari
        ]);
    }

    /**
     * Hata analizi yap
     */
    public function hataAnalizi(Request $request)
    {
        $request->validate([
            'hata_metni' => 'required|string|max:5000',
        ]);

        $result = $this->claudeService->hataAnalizi(
            $request->input('hata_metni')
        );

        return response()->json($result);
    }

    /**
     * Test endpoint
     */
    public function test()
    {
        $result = $this->claudeService->chat(
            'Merhaba! Kısa bir test mesajı ile yanıt ver.',
            256,
            0.7
        );

        return response()->json([
            'test' => 'Claude API Testi',
            'result' => $result,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}







