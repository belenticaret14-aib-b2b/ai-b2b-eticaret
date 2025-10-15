<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ClaudeContextService
{
    protected $contextPath;
    protected $contextFile;

    public function __construct()
    {
        $this->contextPath = base_path('.claude');
        $this->contextFile = $this->contextPath . '/context.json';
        
        $this->ensureContextExists();
    }

    /**
     * Context dizininin ve dosyasının varlığını kontrol eder
     */
    protected function ensureContextExists()
    {
        if (!File::exists($this->contextPath)) {
            File::makeDirectory($this->contextPath, 0755, true);
        }

        if (!File::exists($this->contextFile)) {
            $this->createDefaultContext();
        }
    }

    /**
     * Varsayılan context dosyasını oluşturur
     */
    protected function createDefaultContext()
    {
        $defaultContext = [
            'project' => [
                'name' => 'NetMarketiniz B2B/B2C',
                'owner' => 'BELEN',
                'description' => 'Excel VBA\'dan Laravel\'e geçiş projesi',
                'type' => 'B2B/B2C E-Commerce Platform',
            ],
            'tech_stack' => [
                'framework' => 'Laravel 12',
                'php' => '8.2',
                'database' => 'MySQL 8.0',
                'patterns' => ['Repository', 'Service Layer'],
                'ai' => 'Claude Sonnet 4.5',
            ],
            'conventions' => [
                'naming' => 'Türkçe method isimleri',
                'architecture' => 'Repository + Service Pattern',
                'special' => [
                    'panel_name' => 'pano (not panel)',
                    'language' => 'Türkçe',
                    'teamwork' => 'Birlikte çalışıyoruz (biz kavramı)',
                ],
            ],
            'status' => [
                'phase' => 'Development',
                'completed' => [
                    'Laravel kurulumu',
                    'ClaudeService entegrasyonu',
                    'GitHub repository',
                ],
                'in_progress' => [
                    'Auth sistemi',
                    'Admin panosu',
                ],
                'planned' => [
                    'Ürün yönetimi',
                    'Bayi sistemi',
                    'Sipariş takibi',
                ],
            ],
            'important_notes' => [
                'Excel background',
                'Context is critical',
                'Detailed explanations needed',
                'Always say "Kolay gelsin"',
            ],
            'last_updated' => now()->toIso8601String(),
        ];

        File::put($this->contextFile, json_encode($defaultContext, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Mevcut context'i getirir
     */
    public function getContext(): array
    {
        return json_decode(File::get($this->contextFile), true);
    }

    /**
     * Context'i günceller
     */
    public function updateContext(array $data): void
    {
        $currentContext = $this->getContext();
        $updatedContext = array_merge($currentContext, $data);
        $updatedContext['last_updated'] = now()->toIso8601String();

        File::put($this->contextFile, json_encode($updatedContext, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Context özetini oluşturur (Cursor için)
     */
    public function generateSummary(): string
    {
        $context = $this->getContext();
        
        return sprintf(
            "📦 Proje: %s\n" .
            "👤 Owner: %s\n" .
            "🛠️  Stack: %s + %s\n" .
            "📊 Durum: %s\n" .
            "✅ Tamamlanan: %d görev\n" .
            "⏳ Devam Eden: %d görev\n" .
            "📅 Güncelleme: %s\n",
            $context['project']['name'],
            $context['project']['owner'],
            $context['tech_stack']['framework'],
            $context['tech_stack']['php'],
            $context['status']['phase'],
            count($context['status']['completed']),
            count($context['status']['in_progress']),
            $context['last_updated']
        );
    }

    /**
     * Tamamlanan görev ekler
     */
    public function addCompletedTask(string $task): void
    {
        $context = $this->getContext();
        
        if (!in_array($task, $context['status']['completed'])) {
            $context['status']['completed'][] = $task;
            
            // In progress'ten kaldır
            $context['status']['in_progress'] = array_filter(
                $context['status']['in_progress'],
                fn($item) => $item !== $task
            );
            
            $this->updateContext($context);
        }
    }

    /**
     * Devam eden görev ekler
     */
    public function addInProgressTask(string $task): void
    {
        $context = $this->getContext();
        
        if (!in_array($task, $context['status']['in_progress'])) {
            $context['status']['in_progress'][] = $task;
            $this->updateContext($context);
        }
    }

    /**
     * Planlanan görev ekler
     */
    public function addPlannedTask(string $task): void
    {
        $context = $this->getContext();
        
        if (!in_array($task, $context['status']['planned'])) {
            $context['status']['planned'][] = $task;
            $this->updateContext($context);
        }
    }

    /**
     * Context'i Cursor için hazırlar
     */
    public function exportForCursor(): string
    {
        $context = $this->getContext();
        
        return json_encode([
            'cursor_context' => [
                'project_name' => $context['project']['name'],
                'owner' => $context['project']['owner'],
                'conventions' => $context['conventions'],
                'current_status' => $context['status'],
                'tech_stack' => $context['tech_stack'],
            ],
            'generated_at' => now()->toIso8601String(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
