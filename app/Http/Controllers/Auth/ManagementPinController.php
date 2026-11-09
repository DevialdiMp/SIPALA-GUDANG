<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class ManagementPinController extends Controller
{
    public function show()
    {
        if (!session()->has('sipala_pin_pending')) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'pin' => ['required', 'digits:6'],
            'feature' => ['required', 'in:teknisi,alat'],
        ]);
        $feature = $request->feature;
        $destinations = [
            'teknisi' => 'masterdata.teknisi.index',
            'alat' => 'masterdata.alat.index',
        ];

        $key = 'sipala-management-pin:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with(
                'pin_error',
                'Terlalu banyak percobaan PIN. Silakan coba kembali.'
            );
        }

        $storedPin = config('sipala.management_pin_hash');

        if (!$storedPin || !Hash::check($request->pin, $storedPin)) {

            RateLimiter::hit($key, 60);

            return back()->with(
                'pin_error',
                'PIN salah! Silakan hubungi DEVMP Solutions.'
            );
        }

        RateLimiter::clear($key);

        session([
            "sipala_pin_access.{$feature}" => true,
        ]);

        return redirect()->route($destinations[$feature]);
    }

    public function leave(string $feature)
    {
        abort_unless(
            in_array($feature, ['teknisi', 'alat']),
            404
        );

        session()->forget("sipala_pin_access.{$feature}");

        return redirect()->route('dashboard');
    }
}
