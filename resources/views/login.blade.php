<h2>{{ __('auth.login_title') }}</h2>

<a href="/set-locale/kk">KK</a> |
<a href="/set-locale/ru">RU</a> |
<a href="/set-locale/en">EN</a>

<form action="{{ route('login.post') }}" method="POST">
    @csrf

    <input 
        type="email" 
        name="email" 
        placeholder="{{ __('auth.email') }}"
        value="{{ old('email') }}"
    >
    @error('email') 
        <p>{{ $message }}</p> 
    @enderror

    <input 
        type="password" 
        name="password" 
        placeholder="{{ __('auth.password') }}"
    >
    @error('password') 
        <p>{{ $message }}</p> 
    @enderror

    <button type="submit">{{ __('auth.login_title') }}</button>
</form>