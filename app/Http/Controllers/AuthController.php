<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Валидация
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Сохраняем локаль пользователя
            if (auth()->user()->locale) {
                Session::put('locale', auth()->user()->locale);
                app()->setLocale(auth()->user()->locale);
            }
            
            return redirect()->intended(route('home'));
        }

        // Используем правильный ключ перевода
        return back()->withErrors([
            "email" => trans('auth.failed') // или просто __('auth.failed')
        ])->withInput($request->only('email', 'remember'));
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users",
            "password" => "required|min:8|confirmed"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => "student",
            "locale" => app()->getLocale()
        ]);

        Auth::login($user);
        Session::put('locale', $user->locale);

        return redirect()->route('home')->with('success', __('Registration successful!'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}