<?php

use App\Models\ActivityLog;

if (!function_exists('activity_log')) {

    function activity_log($action, $description = null)
    {
        if (!auth()->check()) return;

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,       // ✅ sesuai $fillable di model
            'description' => $description,
        ]);
    }
}