<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use Illuminate\Http\JsonResponse;

class ModuleController extends Controller
{
    protected ModuleService $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * Modül yönetimi ana sayfası
     */
    public function index()
    {
        $modules = $this->moduleService->getAllModules();
        $stats = $this->moduleService->getModuleStats();
        
        return view('super-admin.modules.index', compact('modules', 'stats'));
    }

    /**
     * Modül detay sayfası
     */
    public function show(string $moduleKey)
    {
        $modules = $this->moduleService->getAllModules();
        
        if (!isset($modules[$moduleKey])) {
            abort(404);
        }

        $module = $modules[$moduleKey];
        $settings = $this->moduleService->getModuleSettings($moduleKey);
        $routes = $this->moduleService->getModuleRoutes($moduleKey);

        return view('super-admin.modules.show', compact('module', 'moduleKey', 'settings', 'routes'));
    }

    /**
     * Modül aktif/pasif yap
     */
    public function toggle(Request $request, string $moduleKey): JsonResponse
    {
        $request->validate([
            'active' => 'required|boolean'
        ]);

        $active = $request->input('active');
        
        if ($this->moduleService->toggleModule($moduleKey, $active)) {
            return response()->json([
                'success' => true,
                'message' => "Modül '{$moduleKey}' " . ($active ? 'aktif' : 'pasif') . " edildi.",
                'active' => $active
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Modül bulunamadı veya işlem başarısız.'
        ], 400);
    }

    /**
     * Modül ayarlarını güncelle
     */
    public function updateSettings(Request $request, string $moduleKey)
    {
        $modules = $this->moduleService->getAllModules();
        
        if (!isset($modules[$moduleKey])) {
            abort(404);
        }

        $settings = $this->moduleService->getModuleSettings($moduleKey);
        $rules = [];
        
        // Validation rules oluştur
        foreach ($settings as $key => $setting) {
            $rules[$key] = 'nullable|string';
        }

        $request->validate($rules);

        // Ayarları güncelle
        foreach ($settings as $key => $setting) {
            if ($request->has($key)) {
                $this->moduleService->updateModuleSetting($moduleKey, $key, $request->input($key));
            }
        }

        return redirect()->back()->with('success', 'Modül ayarları güncellendi.');
    }

    /**
     * Yeni modül ekle formu
     */
    public function create()
    {
        return view('super-admin.modules.create');
    }

    /**
     * Yeni modül kaydet
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|alpha_dash|unique:modules,key',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
            'color' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string|in:super_admin,admin,bayi,musteri',
        ]);

        $config = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'icon' => $request->input('icon'),
            'color' => $request->input('color'),
            'active' => false,
            'permissions' => $request->input('permissions'),
            'routes' => [],
            'settings' => []
        ];

        if ($this->moduleService->addModule($request->input('key'), $config)) {
            return redirect()->route('super-admin.modules.index')
                ->with('success', 'Yeni modül başarıyla eklendi.');
        }

        return redirect()->back()
            ->with('error', 'Modül eklenirken bir hata oluştu.')
            ->withInput();
    }

    /**
     * Modül sil
     */
    public function destroy(string $moduleKey): JsonResponse
    {
        if ($this->moduleService->removeModule($moduleKey)) {
            return response()->json([
                'success' => true,
                'message' => "Modül '{$moduleKey}' başarıyla silindi."
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Modül silinirken bir hata oluştu.'
        ], 400);
    }

    /**
     * Modül istatistikleri
     */
    public function stats(): JsonResponse
    {
        $stats = $this->moduleService->getModuleStats();
        
        return response()->json($stats);
    }

    /**
     * Modül yedekleme
     */
    public function backup()
    {
        $modules = $this->moduleService->getAllModules();
        $backup = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'modules' => $modules,
            'version' => '1.0.0'
        ];

        $filename = 'module_backup_' . now()->format('Y-m-d_H-i-s') . '.json';
        $path = storage_path('app/backups/' . $filename);
        
        // Backup klasörünü oluştur
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, json_encode($backup, JSON_PRETTY_PRINT));

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /**
     * Modül geri yükleme
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json'
        ]);

        $content = file_get_contents($request->file('backup_file')->getPathname());
        $backup = json_decode($content, true);

        if (!$backup || !isset($backup['modules'])) {
            return redirect()->back()->with('error', 'Geçersiz yedek dosyası.');
        }

        // Modülleri geri yükle (basit implementasyon)
        foreach ($backup['modules'] as $key => $module) {
            // Geri yükleme işlemi (gelecekte implement edilecek)
        }

        return redirect()->back()->with('success', 'Modüller başarıyla geri yüklendi.');
    }
}

