<?php

namespace App\Observers;

use App\Models\ActivityLog;

class ActivityObserver
{
    public function created($model)
    {
        $this->log('CREATE', $model);
    }

    public function updated($model)
    {
        $this->log('UPDATE', $model);
    }

    public function deleted($model)
    {
        $this->log('DELETE', $model);
    }

    private function log($action, $model)
{
    if (!auth()->check()) return;

    $modelName = class_basename($model);

    $data = [
        'user_id' => auth()->id(),
        'description' => $modelName . ' : ' . json_encode($model->toArray()),
    ];

    // 🔥 cek kolom di DB
    if (Schema::hasColumn('activity_logs', 'action')) {
        $data['action'] = $action;
    } else {
        $data['activity'] = $action;
    }

    \App\Models\ActivityLog::create($data);
}
}