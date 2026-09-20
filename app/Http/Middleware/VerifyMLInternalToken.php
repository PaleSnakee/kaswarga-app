<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyMLInternalToken
{
    /**
     * Verifikasi token internal untuk endpoint ML training data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $expectedToken = (string) config('services.ml_service.internal_token');

        if ($expectedToken === '' || ! hash_equals($expectedToken, (string) $request->header('X-ML-Internal-Token'))) {
            Log::warning('Unauthorized ML internal data request.', [
                'ip' => $request->ip(),
                'provided_token' => $request->header('X-ML-Internal-Token') ? '***REDACTED***' : 'missing',
            ]);

            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
