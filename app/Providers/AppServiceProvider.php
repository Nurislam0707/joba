<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App; // App фасадын импорттау
use Illuminate\Support\Facades\Session; // Session фасадын импорттау

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * * Бұл жерде тілді орнату логикасы орналасқан.
     */
    public function boot(): void
    {
        // Егер сессияда 'locale' кілті болса (қолданушы тілді таңдаған болса),
        // сол тілді Laravel қолданбасына орнатамыз.
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } 
        
        // Егер сессияда тіл жоқ болса, сіз мұнда әдепкі тілді (мысалы, 'en' немесе 'kk') орната аласыз.
        // Бірақ Laravel әдепкі бойынша config/app.php файлындағы тілді қолданады.
        
    }
}