@extends("layouts.app")

@section("title", "Профиль")
@section("description", "Страница профиля")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="w-20 h-20 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Профиль пользователя</h1>
            <p class="text-gray-600 mb-6">Страница профиля в разработке</p>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Имя: {{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-600">Email: {{ auth()->user()->email }}</p>
                <p class="text-sm text-gray-600">Роль: {{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</div>
@endsection