@php
    $locales = config('app.available_locales', ['ru','kz','en']);
    $current = app()->getLocale();
    $routeName = request()->route()?->getName();
@endphp

<div class="lang-switcher">
    @foreach($locales as $loc)
        @if($loc === $current)
            <span class="lang active">{{ strtoupper($loc) }}</span>
        @else
            {{-- Prefer GET link for easy switching --}} 
            <a class="lang" href="{{ route('language.change', $loc) }}">{{ strtoupper($loc) }}</a>
        @endif
    @endforeach
</div>

<style>
    .lang-switcher { display:inline-flex; gap:8px; }
    .lang { text-decoration:none; color:#333; }
    .lang.active { font-weight:bold; }
</style>
