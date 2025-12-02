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
            <a href="{{ route('news') }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Все новости <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        @if(isset($latestNews) && $latestNews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestNews as $newsItem)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <img src="{{ $newsItem->image_url ?: 'https://picsum.photos/400/250?random=' . $loop->index }}" 
                     alt="{{ $newsItem->title }}" 
                     class="w-full h-48 object-cover" 
                     loading="lazy">
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-primary text-white px-2 py-1 rounded text-xs font-semibold">{{ $newsItem->category }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $newsItem->published_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $newsItem->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($newsItem->content, 100) }}</p>
                    <a href="{{ route('news.show', $newsItem->id) }}" class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                        Читать далее <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <i class="fas fa-newspaper text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Новостей пока нет</h3>
            <p class="text-gray-600">Скоро здесь появятся актуальные новости</p>
        </div>
        @endif
    </section>


    <!-- Quick Actions -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Быстрый доступ</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Расписание -->
            <a href="{{ route('schedule') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action block">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-alt text-primary text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Расписание</span>
            </a>

            <!-- Задания -->
            <a href="{{ route('assignments') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action block">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-book text-green-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Задания</span>
            </a>

            <!-- Оценки -->
            <a href="{{ route('grades') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action block">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-chart-bar text-accent text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Оценки</span>
            </a>

            <!-- Материалы -->
            <a href="{{ route('materials') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer quick-action block">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">Материалы</span>
            </a>
        </div>
    </section>

    <!-- Statistics -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Моя статистика</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-md p-4 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check-circle text-blue-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">75%</div>
                <div class="text-sm text-gray-600">Выполнено заданий</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-4 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-star text-green-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">4.5</div>
                <div class="text-sm text-gray-600">Средний балл</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-4 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">24</div>
                <div class="text-sm text-gray-600">Часов обучения</div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-4 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-trophy text-orange-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">5</div>
                <div class="text-sm text-gray-600">Достижения</div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Ближайшие события</h2>
            <a href="{{ route('calendar') }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Календарь <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-md">
            <div class="divide-y divide-gray-200">
                <!-- Пример события -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Экзамен по программированию</h4>
                                <p class="text-gray-600 text-sm">15 декабря, 10:00</p>
                            </div>
                        </div>
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Важно</span>
                    </div>
                </div>
                
                <!-- Другое событие -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-yellow-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Дедлайн по лабораторной</h4>
                                <p class="text-gray-600 text-sm">12 декабря, 23:59</p>
                            </div>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Срочно</span>
                    </div>
                </div>

                <!-- Третье событие -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Семинар по веб-разработке</h4>
                                <p class="text-gray-600 text-sm">10 декабря, 14:00</p>
                            </div>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Мероприятие</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notifications Section -->
    @auth
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Последние уведомления</h2>
            <a href="{{ route('notifications') }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Все уведомления <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-md">
            <div class="divide-y divide-gray-200">
                <!-- Пример уведомления -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-bell text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Новое задание</h4>
                            <p class="text-gray-600 text-sm">Добавлена новая лабораторная работа по программированию</p>
                            <span class="text-xs text-gray-500">2 часа назад</span>
                        </div>
                    </div>
                </div>

                <!-- Второе уведомление -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Работа проверена</h4>
                            <p class="text-gray-600 text-sm">Ваша контрольная работа по математике проверена</p>
                            <span class="text-xs text-gray-500">Вчера</span>
                        </div>
                    </div>
                </div>

                <!-- Третье уведомление -->
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Изменение расписания</h4>
                            <p class="text-gray-600 text-sm">Занятие по базам данных перенесено на пятницу</p>
                            <span class="text-xs text-gray-500">3 дня назад</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endauth

    <!-- Groups Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Мои группы</h2>
            <a href="{{ route('groups') }}" class="text-primary hover:text-secondary font-semibold transition-colors">
                Все группы <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if(isset($userGroups) && $userGroups->count() > 0)
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
        @else
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Группы не найдены</h3>
            <p class="text-gray-600">Вы пока не присоединились ни к одной группе</p>
        </div>
        @endif
    </section>
</div>
@endsection

@section('scripts')
<script>
// Quick actions hover effect
document.querySelectorAll('.quick-action').forEach(action => {
    action.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    action.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Auto-hide alerts
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection