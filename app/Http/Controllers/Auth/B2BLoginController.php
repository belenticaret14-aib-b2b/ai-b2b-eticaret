<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class B2BLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.b2b-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['rol'] = ['bayi', 'admin'];

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $kullanici = Auth::user(); // Eğer auth modeliniz Kullanici ise, config/auth.php'de model tanımını güncelleyin
            if (in_array($kullanici->rol, ['bayi', 'admin'])) {
                if ($kullanici->rol === 'bayi') {
                    return redirect()->route('bayi.panel');
                } else {
                    return redirect()->route('admin.panel');
                }
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'B2B yetkisi yok!']);
            }
        }
        return back()->withErrors(['email' => 'Giriş bilgileri hatalı!']);
    }
}
