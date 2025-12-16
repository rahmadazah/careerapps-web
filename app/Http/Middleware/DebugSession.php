<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugSession
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('🧪 DebugSession middleware aktif. Isi session:', session()->all());
        return $next($request);
    }
}
