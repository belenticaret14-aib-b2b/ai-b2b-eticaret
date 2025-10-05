<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Kullanıcının profil formunu gösterir.
     */
    public function duzenle(Request $request): View
    {
        return view('profile.edit', [
            'kullanici' => $request->user(),
        ]);
    }

    // Geriye uyumluluk: Mevcut rotalar edit metodunu çağırıyorsa yönlendir.
    public function edit(Request $request): View
    {
        return $this->duzenle($request);
    }

    /**
     * Kullanıcı profil bilgilerini günceller.
     */
    public function guncelle(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profil-guncellendi');
    }

    // Geriye uyumluluk: update çağrılarını yeni metoda yönlendir.
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->guncelle($request);
    }

    /**
     * Kullanıcı hesabını siler.
     */
    public function sil(Request $request): RedirectResponse
    {
        $request->validateWithBag('kullaniciSilme', [
            'sifre' => ['required', 'current_password'],
        ]);

        $kullanici = $request->user();

        Auth::logout();

        $kullanici->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Geriye uyumluluk: destroy çağrılarını yeni metoda yönlendir.
    public function destroy(Request $request): RedirectResponse
    {
        return $this->sil($request);
    }
}
