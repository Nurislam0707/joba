<h2>{{ __('messages.register') }}</h2>


<a href="/set-locale/kk">KK</a> |
<a href="/set-locale/ru">RU</a> |
<a href="/set-locale/en">EN</a>


<form action="{{ route('register.post') }}" method="POST">
@csrf


<input type="text" name="name" placeholder="Name">
@error('name') <p>{{ $message }}</p> @enderror


<input type="email" name="email" placeholder="Email">
@error('email') <p>{{ $message }}</p> @enderror


<input type="password" name="password" placeholder="Password">
@error('password') <p>{{ $message }}</p> @enderror


<button type="submit">{{ __('messages.register') }}</button>
</form>