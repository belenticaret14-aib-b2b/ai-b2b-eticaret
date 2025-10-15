<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ClaudeContextService;

class CursorSyncContext extends Command
{
    protected $signature = 'cursor:sync-context';
    protected $description = 'Sync Claude context to Cursor';

    public function handle(ClaudeContextService $contextService)
    {
        $this->info('Syncing context to Cursor...');
        
        $context = $contextService->getContext();
        $summary = $contextService->generateSummary();
        
        $this->line($summary);
        $this->info('Context synced!');
        
        return 0;
    }
}
