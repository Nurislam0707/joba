@extends("layouts.app")

@section("title", "Профиль пользователя")
@section("description", "Страница профиля пользователя")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Мой профиль</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Основная информация -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-700 mb-2">Основная информация</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Роль:</span>
                                    <span class="font-medium">
                                        @if($user->isTeacher())
                                            Преподаватель
                                        @else
                                            Студент
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Язык:</span>
                                    <span class="font-medium">
                                        @if($user->locale == 'ru')
                                            Русский
                                        @elseif($user->locale == 'en')
                                            English
                                        @else
                                            Қазақша
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Зарегистрирован:</span>
                                    <span class="font-medium">{{ $user->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-700 mb-2">Статистика</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Новостей создано:</span>
                                    <span class="font-medium">
                                          @if(auth()->user()->role === 'teacher')
                                         {{-- {{ \App\Models\News::where('author_id', auth()->id())->count() }} --}}
                                         {{ \App\Models\News::count() }} {{-- БАРЛЫҚ ЖАҢАЛЫҚТАРДЫ САНАУ --}}
                                           @else
            -
                                      @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Групп:</span>
                                    <span class="font-medium">
                                        @if(isset($user->groups))
                                            {{ $user->groups()->count() }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('profile.edit') }}" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>Редактировать профиль
                        </a>
                        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-key mr-2"></i>Сменить пароль
                        </button>
                    </div>
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Быстрые действия</h3>
                    <div class="space-y-3">
                        <a href="{{ route('news.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-newspaper text-blue-600"></i>
                            </div>
                            <span class="text-gray-700">Управление новостями</span>
                        </a>
                        <a href="{{ route('news') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list text-green-600"></i>
                            </div>
                            <span class="text-gray-700">Все новости</span>
                        </a>
                        <a href="{{ route('groups') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <span class="text-gray-700">Мои группы</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection