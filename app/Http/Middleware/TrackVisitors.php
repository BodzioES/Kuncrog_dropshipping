<?php

namespace App\Http\Middleware;

use App\Models\Visitors;
use Closure;
use Illuminate\Support\Facades\Log;


class TrackVisitors
{
    public function handle($request, Closure $next)
    {
        try {
            Visitors::firstOrCreate([
                'ip_address' => $request->ip(),
            ]);
        } catch (\Exception $e) {
            Log::error('Visitor log failed: '.$e->getMessage());
        }

        return $next($request);
    }
}
