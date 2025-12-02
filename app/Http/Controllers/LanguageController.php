<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Проверяем, что локаль доступна
        if (!in_array($locale, ['ru', 'kz', 'en'])) {
            $locale = 'ru';
        }
        
        // Сохраняем локаль в сессии
        session(['locale' => $locale]);
        
        // Устанавливаем локаль для текущего запроса
        app()->setLocale($locale);
        
        // Возвращаем обратно на предыдущую страницу
        return redirect()->back();
    }
}