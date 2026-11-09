<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyManagementPin
{
    public function handle(
        Request $request,
        Closure $next,
        string $feature
    ): Response {

        if (session("sipala_pin_access.{$feature}") === true) {
            return $next($request);
        }

        session([
            'sipala_pin_pending' => [
                'feature' => $feature,
                'url' => $request->fullUrl(),
            ],
        ]);

        return redirect()->route('pin.form');
    }
}
