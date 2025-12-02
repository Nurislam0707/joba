@extends('layouts.app')

@section('title', __('messages.navigation.chat'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('messages.navigation.chat') }}</h1>
        
        <div class="bg-white rounded-xl shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-4 h-96">
                <!-- Список пользователей -->
                <div class="border-r border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <input type="text" placeholder="Поиск..." class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="overflow-y-auto h-80">
                        @foreach($users as $user)
                        <a href="{{ route('chat.show', $user) }}" 
                           class="flex items-center space-x-3 p-3 hover:bg-gray-50 border-b border-gray-100">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 truncate">{{ $user->role }}</p>
                            </div>
                            @if($user->unread_count > 0)
                            <span class="bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $user->unread_count }}
                            </span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Область чата -->
                <div class="md:col-span-3 flex flex-col">
                    <div class="flex-1 p-4 text-center text-gray-500">
                        <i class="fas fa-comments text-4xl mb-4 text-gray-300"></i>
                        <p>Выберите пользователя для начала общения</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection