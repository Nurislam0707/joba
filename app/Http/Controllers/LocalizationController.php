<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function changeLanguage(Request $request)
    {
        // accept route param or request input
        $locale = $request->route('locale') ?? $request->input('locale');

        $allowed = config('app.locales') ?? config('app.available_locales') ?? ['ru', 'kz', 'en'];
        if (! $locale || ! in_array($locale, $allowed, true)) {
            return redirect()->back()->with('error', __('Invalid locale'));
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        // persist on user if logged in
        if (Auth::check()) {
            $user = Auth::user();
            if ($user) {
                // guard against mass-assignment issues — update specific column if exists
                if (property_exists($user, 'locale') || array_key_exists('locale', $user->getAttributes())) {
                    $user->update(['locale' => $locale]);
                }
            }
        }

        // If request expects JSON (AJAX/fetch), return JSON so frontend can react
        if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'locale' => $locale,
            ]);
        }

        return redirect()->back()->with('success', __('Language changed successfully'));
    }
}