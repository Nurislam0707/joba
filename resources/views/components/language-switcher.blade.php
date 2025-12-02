<div class="flex items-center space-x-2">
    <span class="text-sm text-gray-600">{{ __('Language') }}:</span>
    <div class="flex bg-gray-100 rounded-lg p-1">
        <button onclick="changeLanguage('ru')" class="lang-btn {{ app()->getLocale() == 'ru' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600' }} px-3 py-1 rounded text-sm font-medium transition-colors">
            RU
        </button>
        <button onclick="changeLanguage('en')" class="lang-btn {{ app()->getLocale() == 'en' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600' }} px-3 py-1 rounded text-sm font-medium transition-colors">
            EN
        </button>
        <button onclick="changeLanguage('kz')" class="lang-btn {{ app()->getLocale() == 'kz' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600' }} px-3 py-1 rounded text-sm font-medium transition-colors">
            KZ
        </button>
    </div>
</div>