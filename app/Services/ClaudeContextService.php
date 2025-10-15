public function markCompleted(string $task): void
{
    $context = $this->getContext();
    
    // Eski kod (sorunlu):
    // $context['in_progress'] = array_values(array_filter(
    //     $context['in_progress'], 
    //     fn($item) => $item !== $task
    // ));
    
    // Yeni kod (uyumlu):
    $filtered = [];
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