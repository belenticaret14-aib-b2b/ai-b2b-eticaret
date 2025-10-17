<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ClaudeContextService
{
    private $contextPath;
    private $backupPath;

    public function __construct()
    {
        $this->contextPath = base_path('.claude/context.json');
        $this->backupPath = storage_path('claude/sessions');
        
        $this->ensureDirectories();
    }

    private function ensureDirectories()
    {
        $claudeDir = base_path('.claude');
        if (!File::exists($claudeDir)) {
            File::makeDirectory($claudeDir, 0755, true);
        }

        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    public function getContext()
    {
        if (!File::exists($this->contextPath)) {
            return $this->createDefaultContext();
        }

        return json_decode(File::get($this->contextPath), true);
    }

    public function updateContext($updates)
    {
        $context = $this->getContext();
        $context = array_merge_recursive($context, $updates);
        $context['project']['last_updated'] = Carbon::now()->toIso8601String();
        
        File::put($this->contextPath, json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPING_UNICODE));
        $this->createBackup($context);
        
        return true;
    }

    public function markCompleted($task)
    {
        $context = $this->getContext();
        
        $filtered = array();
        foreach ($context['in_progress'] as $item) {
            if ($item !== $task) {
                $filtered[] = $item;
            }
        }
        $context['in_progress'] = $filtered;
        
        if (!in_array($task, $context['completed'])) {
            $context['completed'][] = $task;
        }
        
        File::put($this->contextPath, json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPING_UNICODE));
    }

    public function generateSummary()
    {
        $context = $this->getContext();
        
        $summary = "NetMarketiniz Durumu\n";
        $summary .= "Tamamlanan: " . count($context['completed']) . "\n";
        $summary .= "Devam Eden: " . count($context['in_progress']) . "\n";
        
        return $summary;
    }

    private function createDefaultContext()
    {
        $default = array(
            'project' => array(
                'name' => 'NetMarketiniz',
                'version' => '1.0-dev',
                'last_updated' => Carbon::now()->toIso8601String()
            ),
            'completed' => array(
                'Laravel kurulumu'
            ),
            'in_progress' => array(
                'Admin panel'
            ),
            'next_steps' => array(
                'Auth sistemi'
            )
        );
        
        File::put($this->contextPath, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPING_UNICODE));
        
        return $default;
    }

    private function createBackup($context)
    {
        $filename = 'backup-' . Carbon::now()->format('Y-m-d_His') . '.json';
        $path = $this->backupPath . '/' . $filename;
        
        File::put($path, json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPING_UNICODE));
    }
}