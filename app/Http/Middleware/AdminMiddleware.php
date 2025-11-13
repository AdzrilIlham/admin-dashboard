<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('AdminMiddleware check', [
            'user' => auth()->user(),
        ]);

        if (!auth()->check()) {
            Log::warning('AdminMiddleware: not authenticated');
            abort(403, 'Unauthorized - not logged in');
        }

        if (auth()->user()->role !== 'admin') {
            Log::warning('AdminMiddleware: not admin', [
                'role' => auth()->user()->role,
            ]);
            abort(403, 'Unauthorized - not admin');
        }

        return $next($request);
    }
}
