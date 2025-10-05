<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $kullanici = Auth::user();
        if (Auth::check() && $kullanici->rol === 'bayi') {
            return $next($request);
        }
        return redirect('/b2b-login')->withErrors(['email' => 'Bayi yetkisi yok!']);
    }
}
