<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        try {
            return view('admin.dashboard');
        } catch (\Exception $e) {
            Log::error('Failed to load dashboard: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
