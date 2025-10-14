<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class HataliLinkController extends Controller
{
    private array $config;
    private bool $mockMode;
    private array $analizSonuclari;

    public function __construct()
    {
        $this->config = config('app', []);
        $this->mockMode = config('app.env') === 'local' && env('HATALI_LINK_MOCK_MODE', true);
        $this->analizSonuclari = [];
    }

    /**
     * Hatalı link kontrolü sayfası
     */
    public function index()
    {
        return view('super-admin.hatali-link-kontrol');
    }

    /**
     * Linkleri tara ve hataları bul - ClaudeService yapısında
     */
    public function tara(Request $request)
    {
        Log::info('Hatalı Link Tara - Request alındı', [
            'mock_mode' => $this->mockMode,
            'request_data' => $request->all()
        ]);

        if ($this->mockMode) {
            return $this->mockTaraResponse();
        }

        try {
            $analizSonucu = $this->kapsamliLinkAnalizi();
            
            Log::info('Hatalı Link Analizi Tamamlandı', [
                'toplam_hata' => $analizSonucu['toplam_hata'],
                'kategoriler' => $analizSonucu['kategoriler'],
                'analiz_suresi' => $analizSonucu['analiz_suresi']
            ]);

            return response()->json([
                'success' => true,
                'analiz_tarihi' => now()->format('d.m.Y H:i'),
                'toplam_hata' => $analizSonucu['toplam_hata'],
                'hatalar' => $analizSonucu['hatalar'],
                'kategoriler' => $analizSonucu['kategoriler'],
                'oncelikler' => $analizSonucu['oncelikler'],
                'cozum_onerileri' => $analizSonucu['cozum_onerileri'],
                'analiz_suresi' => $analizSonucu['analiz_suresi']
            ]);

        } catch (\Exception $e) {
            Log::error('Hatalı Link Tarama Hatası', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Tarama sırasında sistem hatası oluştu',
                'detay' => $e->getMessage(),
                'cozum' => 'Lütfen sistem yöneticisi ile iletişime geçin'
            ]);
        }
    }

    /**
     * Kapsamlı link analizi - ClaudeService tarzında
     */
    private function kapsamliLinkAnalizi(): array
    {
        $baslangic = microtime(true);
        
        $analiz = [
            'toplam_hata' => 0,
            'hatalar' => [],
            'kategoriler' => [
                'route' => 0,
                'view' => 0,
                'asset' => 0,
                'middleware' => 0,
                'config' => 0
            ],
            'oncelikler' => [
                'kritik' => 0,
                'yuksek' => 0,
                'orta' => 0,
                'dusuk' => 0
            ],
            'cozum_onerileri' => []
        ];

        // 1. Route Analizi
        $routeAnalizi = $this->routeAnalizi();
        $analiz['hatalar'] = array_merge($analiz['hatalar'], $routeAnalizi['hatalar']);
        $analiz['kategoriler']['route'] = $routeAnalizi['hata_sayisi'];

        // 2. View Analizi
        $viewAnalizi = $this->viewAnalizi();
        $analiz['hatalar'] = array_merge($analiz['hatalar'], $viewAnalizi['hatalar']);
        $analiz['kategoriler']['view'] = $viewAnalizi['hata_sayisi'];

        // 3. Asset Analizi
        $assetAnalizi = $this->assetAnalizi();
        $analiz['hatalar'] = array_merge($analiz['hatalar'], $assetAnalizi['hatalar']);
        $analiz['kategoriler']['asset'] = $assetAnalizi['hata_sayisi'];

        // 4. Middleware Analizi
        $middlewareAnalizi = $this->middlewareAnalizi();
        $analiz['hatalar'] = array_merge($analiz['hatalar'], $middlewareAnalizi['hatalar']);
        $analiz['kategoriler']['middleware'] = $middlewareAnalizi['hata_sayisi'];

        // 5. Config Analizi
        $configAnalizi = $this->configAnalizi();
        $analiz['hatalar'] = array_merge($analiz['hatalar'], $configAnalizi['hatalar']);
        $analiz['kategoriler']['config'] = $configAnalizi['hata_sayisi'];

        // Toplam hesapla
        $analiz['toplam_hata'] = array_sum($analiz['kategoriler']);

        // Öncelik analizi
        $analiz['oncelikler'] = $this->oncelikAnalizi($analiz['hatalar']);

        // Çözüm önerileri
        $analiz['cozum_onerileri'] = $this->cozumOnerileriOlustur($analiz['hatalar']);

        $analiz['analiz_suresi'] = round((microtime(true) - $baslangic) * 1000, 2) . 'ms';

        return $analiz;
    }

    /**
     * Route analizi - Detaylı kontrol
     */
    private function routeAnalizi(): array
    {
        $hatalar = [];
        $routes = Route::getRoutes();
        
        foreach ($routes as $route) {
            $routeName = $route->getName();
            if (!$routeName) continue;

            try {
                // Route URL oluşturma testi
                $url = route($routeName);
                
                // Controller ve method kontrolü
                $action = $route->getAction();
                if (isset($action['controller'])) {
                    $controllerMethod = explode('@', $action['controller']);
                    if (count($controllerMethod) === 2) {
                        $controller = $controllerMethod[0];
                        $method = $controllerMethod[1];
                        
                        if (!class_exists($controller)) {
                            $hatalar[] = [
                                'tip' => 'route',
                                'kategori' => 'controller_bulunamadi',
                                'oncelik' => 'kritik',
                                'route' => $routeName,
                                'hata' => "Controller bulunamadı: {$controller}",
                                'cozum' => "Controller dosyasını oluşturun: {$controller}",
                                'dosya' => 'routes/web.php'
                            ];
                        } else {
                            if (!method_exists($controller, $method)) {
                                $hatalar[] = [
                                    'tip' => 'route',
                                    'kategori' => 'method_bulunamadi',
                                    'oncelik' => 'kritik',
                                    'route' => $routeName,
                                    'hata' => "Method bulunamadı: {$controller}@{$method}",
                                    'cozum' => "Method'u controller'a ekleyin: {$method}",
                                    'dosya' => 'routes/web.php'
                                ];
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                $hatalar[] = [
                    'tip' => 'route',
                    'kategori' => 'route_hatasi',
                    'oncelik' => 'yuksek',
                    'route' => $routeName,
                    'hata' => $e->getMessage(),
                    'cozum' => 'Route parametrelerini kontrol edin',
                    'dosya' => 'routes/web.php'
                ];
            }
        }

        return [
            'hatalar' => $hatalar,
            'hata_sayisi' => count($hatalar)
        ];
    }

    /**
     * View analizi - Blade dosyalarındaki linkler
     */
    private function viewAnalizi(): array
    {
        $hatalar = [];
        $viewDosyalari = $this->viewDosyalariniBul();
        
        foreach ($viewDosyalari as $dosya) {
            try {
                $icerik = File::get($dosya);
                $dosyaYolu = $dosya->getPathname();
                
                // Route linklerini bul
                preg_match_all('/route\([\'"]([^\'"]+)[\'"]\)/', $icerik, $matches);
                
                foreach ($matches[1] as $routeName) {
                    try {
                        route($routeName);
                    } catch (\Exception $e) {
                        $hatalar[] = [
                            'tip' => 'view',
                            'kategori' => 'route_bulunamadi',
                            'oncelik' => 'yuksek',
                            'dosya' => basename($dosyaYolu),
                            'route' => $routeName,
                            'hata' => "View'da tanımlanmayan route: {$routeName}",
                            'cozum' => "Route'u tanımlayın veya mevcut route adını kullanın",
                            'satir' => $this->satirNumarasiBul($icerik, $routeName)
                        ];
                    }
                }

                // View extends kontrolü
                preg_match_all('/@extends\([\'"]([^\'"]+)[\'"]\)/', $icerik, $extendsMatches);
                foreach ($extendsMatches[1] as $extendView) {
                    if (!$this->viewDosyasiVarMi($extendView)) {
                        $hatalar[] = [
                            'tip' => 'view',
                            'kategori' => 'extends_bulunamadi',
                            'oncelik' => 'kritik',
                            'dosya' => basename($dosyaYolu),
                            'view' => $extendView,
                            'hata' => "Extend edilen view bulunamadı: {$extendView}",
                            'cozum' => "View dosyasını oluşturun: resources/views/{$extendView}.blade.php",
                            'satir' => $this->satirNumarasiBul($icerik, $extendView)
                        ];
                    }
                }

            } catch (\Exception $e) {
                $hatalar[] = [
                    'tip' => 'view',
                    'kategori' => 'dosya_okunamadi',
                    'oncelik' => 'orta',
                    'dosya' => basename($dosya->getPathname()),
                    'hata' => 'View dosyası okunamadı',
                    'cozum' => 'Dosya izinlerini kontrol edin'
                ];
            }
        }

        return [
            'hatalar' => $hatalar,
            'hata_sayisi' => count($hatalar)
        ];
    }

    /**
     * Asset analizi - CSS, JS, resim dosyaları
     */
    private function assetAnalizi(): array
    {
        $hatalar = [];
        $publicDosyalar = File::allFiles(public_path());
        
        foreach ($publicDosyalar as $dosya) {
            if (in_array($dosya->getExtension(), ['css', 'js', 'html'])) {
                $dosyaYolu = $dosya->getPathname();
                
                if (!File::exists($dosyaYolu)) {
                    $hatalar[] = [
                        'tip' => 'asset',
                        'kategori' => 'dosya_bulunamadi',
                        'oncelik' => 'orta',
                        'dosya' => $dosya->getFilename(),
                        'yol' => $dosya->getRelativePathname(),
                        'hata' => 'Asset dosyası bulunamadı',
                        'cozum' => 'Dosyayı oluşturun veya referansını kaldırın'
                    ];
                } else {
                    // CSS içindeki @import kontrolü
                    if ($dosya->getExtension() === 'css') {
                        $cssIcerik = File::get($dosyaYolu);
                        preg_match_all('/@import\s+[\'"]([^\'"]+)[\'"]/', $cssIcerik, $importMatches);
                        
                        foreach ($importMatches[1] as $importPath) {
                            if (!$this->cssDosyasiVarMi($importPath)) {
                                $hatalar[] = [
                                    'tip' => 'asset',
                                    'kategori' => 'css_import_hatasi',
                                    'oncelik' => 'dusuk',
                                    'dosya' => $dosya->getFilename(),
                                    'import' => $importPath,
                                    'hata' => "CSS import dosyası bulunamadı: {$importPath}",
                                    'cozum' => "Import dosyasını oluşturun veya yolu düzeltin"
                                ];
                            }
                        }
                    }
                }
            }
        }

        return [
            'hatalar' => $hatalar,
            'hata_sayisi' => count($hatalar)
        ];
    }

    /**
     * Middleware analizi
     */
    private function middlewareAnalizi(): array
    {
        $hatalar = [];
        $middlewareDosyalari = File::allFiles(app_path('Http/Middleware'));
        
        foreach ($middlewareDosyalari as $dosya) {
            if ($dosya->getExtension() === 'php') {
                $className = $dosya->getBasename('.php');
                $fullClassName = "App\\Http\\Middleware\\{$className}";
                
                if (!class_exists($fullClassName)) {
                    $hatalar[] = [
                        'tip' => 'middleware',
                        'kategori' => 'class_bulunamadi',
                        'oncelik' => 'yuksek',
                        'dosya' => $className,
                        'hata' => "Middleware class bulunamadı: {$fullClassName}",
                        'cozum' => "Class'ı düzeltin veya namespace'i kontrol edin"
                    ];
                }
            }
        }

        return [
            'hatalar' => $hatalar,
            'hata_sayisi' => count($hatalar)
        ];
    }

    /**
     * Config analizi
     */
    private function configAnalizi(): array
    {
        $hatalar = [];
        $configDosyalari = File::allFiles(config_path());
        
        foreach ($configDosyalari as $dosya) {
            if ($dosya->getExtension() === 'php') {
                try {
                    $configArray = include $dosya->getPathname();
                    if (!is_array($configArray)) {
                        $hatalar[] = [
                            'tip' => 'config',
                            'kategori' => 'config_format_hatasi',
                            'oncelik' => 'orta',
                            'dosya' => $dosya->getBasename('.php'),
                            'hata' => 'Config dosyası array döndürmüyor',
                            'cozum' => "Config dosyasının array döndürdüğünden emin olun"
                        ];
                    }
                } catch (\Exception $e) {
                    $hatalar[] = [
                        'tip' => 'config',
                        'kategori' => 'config_syntax_hatasi',
                        'oncelik' => 'kritik',
                        'dosya' => $dosya->getBasename('.php'),
                        'hata' => 'Config dosyası syntax hatası: ' . $e->getMessage(),
                        'cozum' => 'Config dosyasının PHP syntax\'ını kontrol edin'
                    ];
                }
            }
        }

        return [
            'hatalar' => $hatalar,
            'hata_sayisi' => count($hatalar)
        ];
    }

    /**
     * Öncelik analizi
     */
    private function oncelikAnalizi(array $hatalar): array
    {
        $oncelikler = ['kritik' => 0, 'yuksek' => 0, 'orta' => 0, 'dusuk' => 0];
        
        foreach ($hatalar as $hata) {
            $oncelikler[$hata['oncelik']]++;
        }
        
        return $oncelikler;
    }

    /**
     * Çözüm önerileri oluştur
     */
    private function cozumOnerileriOlustur(array $hatalar): array
    {
        $oneriKategorileri = [];
        
        foreach ($hatalar as $hata) {
            $kategori = $hata['kategori'];
            if (!isset($oneriKategorileri[$kategori])) {
                $oneriKategorileri[$kategori] = [
                    'kategori' => $kategori,
                    'sayi' => 0,
                    'ornek_cozum' => $hata['cozum'] ?? 'Çözüm belirtilmemiş'
                ];
            }
            $oneriKategorileri[$kategori]['sayi']++;
        }
        
        return array_values($oneriKategorileri);
    }

    /**
     * Mock response - Test için
     */
    private function mockTaraResponse()
    {
        return response()->json([
            'success' => true,
            'analiz_tarihi' => now()->format('d.m.Y H:i'),
            'toplam_hata' => 35,
            'message' => '🤖 Mock Mode: Test verileri döndürülüyor',
            'hatalar' => [
                [
                    'tip' => 'route',
                    'kategori' => 'route_bulunamadi',
                    'oncelik' => 'kritik',
                    'route' => 'vitrin.index',
                    'hata' => 'Route bulunamadı: vitrin.index',
                    'cozum' => 'Route\'u anasayfa olarak güncelleyin',
                    'dosya' => 'resources/views/layouts/app.blade.php'
                ],
                [
                    'tip' => 'view',
                    'kategori' => 'extends_bulunamadi',
                    'oncelik' => 'kritik',
                    'dosya' => 'proje-detaylari.blade.php',
                    'view' => 'layouts.admin',
                    'hata' => 'Extend edilen view bulunamadı',
                    'cozum' => 'super-admin.layouts.app olarak güncelleyin'
                ]
            ],
            'kategoriler' => [
                'route' => 15,
                'view' => 12,
                'asset' => 5,
                'middleware' => 2,
                'config' => 1
            ],
            'oncelikler' => [
                'kritik' => 8,
                'yuksek' => 12,
                'orta' => 10,
                'dusuk' => 5
            ],
            'cozum_onerileri' => [
                [
                    'kategori' => 'route_bulunamadi',
                    'sayi' => 15,
                    'ornek_cozum' => 'Route\'ları güncelleyin veya oluşturun'
                ],
                [
                    'kategori' => 'extends_bulunamadi',
                    'sayi' => 12,
                    'ornek_cozum' => 'View dosyalarını oluşturun'
                ]
            ],
            'analiz_suresi' => '125.5ms'
        ]);
    }

    /**
     * View dosyası var mı kontrol et
     */
    private function viewDosyasiVarMi(string $viewName): bool
    {
        $viewPath = resource_path('views/' . str_replace('.', '/', $viewName) . '.blade.php');
        return File::exists($viewPath);
    }

    /**
     * CSS dosyası var mı kontrol et
     */
    private function cssDosyasiVarMi(string $cssPath): bool
    {
        $fullPath = public_path($cssPath);
        return File::exists($fullPath);
    }

    /**
     * View dosyalarını bul
     */
    private function viewDosyalariniBul(): array
    {
        $viewDosyalari = [];
        $viewDizini = resource_path('views');
        
        if (File::exists($viewDizini)) {
            $viewDosyalari = File::allFiles($viewDizini);
            $viewDosyalari = array_filter($viewDosyalari, function($dosya) {
                return $dosya->getExtension() === 'blade.php';
            });
        }
        
        return $viewDosyalari;
    }

    /**
     * Satır numarası bul
     */
    private function satirNumarasiBul(string $icerik, string $arama): int
    {
        $satirlar = explode("\n", $icerik);
        foreach ($satirlar as $index => $satir) {
            if (strpos($satir, $arama) !== false) {
                return $index + 1;
            }
        }
        return 0;
    }

    /**
     * Hatalı linkleri otomatik düzelt - Geliştirme aşamasında
     */
    public function duzelt(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => '🔧 Otomatik düzeltme özelliği geliştirme aşamasında',
            'not' => 'Güvenlik nedeniyle otomatik düzeltme devre dışı. Hataları manuel olarak düzeltin.',
            'oneri' => 'Hatalı Link Kontrolü sonuçlarına göre manuel düzeltme yapın'
        ]);
    }
}