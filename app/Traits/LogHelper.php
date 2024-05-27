<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth; // To get authenticated user (if needed)

trait LogHelper
{
    public function logAction($action, $details = null)
    {
        Log::create([
            'user_id' => Auth::id(), // Log the authenticated user
            'action' => $action,
            'details' => $details,
        ]);
    }
}