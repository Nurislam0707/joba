// resources/views/home.blade.php
@extends("layouts.app")

@section("title", "Главная - Студенческий портал")
@section("description", "Добро пожаловать в студенческий портал - все необходимое для успешной учебы")

@section("content")
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold mb-4">Добро пожаловать в студенческий портал</h1>
                <p class="text-lg opacity-90 mb-6">Все необходимое для успешной учебы в одном месте</p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-accent hover:bg-yellow-500 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-rocket mr-2"></i>Начать обучение
                    </button>
                    <button class="bg-white hover:bg-gray-100 text-primary font-semibold px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-play-circle mr-2"></i>Смотреть видео
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Последние новости</h2>
            <a href="{{ route("news") }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Все новости <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestNews as $news)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <img src="{{ $news->image_url ?: "https://picsum.photos/400/250?random=" . $loop->index }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-48 object-cover" 
                     loading="lazy">
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-primary text-white px-2 py-1 rounded text-xs font-semibold">{{ $news->category }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $news->published_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $news->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($news->content, 100) }}</p>
                    <a href="{{ route("news.show", $news->id) }}" class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                        Читать далее <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Groups Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Мои группы</h2>
            <a href="{{ route("groups") }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Все группы <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($userGroups as $group)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                            <i class="fas fa-laptop-code text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $group->teacher->name ?? "Преподаватель не назначен" }}</p>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Активна</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Следующее занятие:</span>
                        <span class="text-gray-800 font-medium">{{ $group->schedule ?? "Расписание не установлено" }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Заданий:</span>
                        <span class="text-gray-800 font-medium">3 новых</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Быстрый доступ</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-alt text-primary text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Расписание</span>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-book text-green-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Задания</span>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-chart-bar text-accent text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Оценки</span>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Материалы</span>
            </div>
        </div>
    </section>
</div>
@endsection

