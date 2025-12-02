@extends("layouts.app")

@section("title", "Профильді өңдеу")
@section("description", "Пайдаланушы профилін өңдеу")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Профильді өңдеу</h1>

        <div class="bg-white rounded-xl shadow-md p-6">
            <!-- Хабарлама -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Аты -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Аты</label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Тіл -->
                    <div>
                        <label for="locale" class="block text-sm font-medium text-gray-700 mb-2">Тіл</label>
                        <select name="locale" id="locale" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="ru" {{ $user->locale == 'ru' ? 'selected' : '' }}>Русский</option>
                            <option value="en" {{ $user->locale == 'en' ? 'selected' : '' }}>English</option>
                            <option value="kz" {{ $user->locale == 'kz' ? 'selected' : '' }}>Қазақша</option>
                        </select>
                        @error('locale')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('profile') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition-colors">
                        Болдырмау
                    </a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                        Сақтау
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection