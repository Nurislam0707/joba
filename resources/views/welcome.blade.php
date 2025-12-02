<!DOCTYPE html>
<html lang="ru">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Студенческий портал</title>
    <meta name="description" content="Современный портал для студентов с новостями, группами и профилем">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#3B82F6",
                        secondary: "#1E40AF",
                        accent: "#F59E0B"
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <nav class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">{{__('text.StudentPortal')}}</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/news.blade.php" class="nav-link text-primary font-semibold border-b-2 border-primary pb-1">
                        <i class="fas fa-newspaper mr-2"></i>Новости
                    </a>
                    <a href="" class="nav-link text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-users mr-2"></i>Группа
                    </a>
                    <a href="#" class="nav-link text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-address-book mr-2"></i>Контакты
                    </a>
                    <a href="#" class="nav-link text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-user mr-2"></i>Профиль
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden mobile-menu hidden py-4 border-t border-gray-200">
                <div class="flex flex-col space-y-4">
                    <a href="#" class="mobile-nav-link text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2">
                        <i class="fas fa-newspaper mr-2"></i>Новости
                    </a>
                    <a href="#" class="mobile-nav-link text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
                        <i class="fas fa-users mr-2"></i>Группа
                    </a>
                    <a href="#" class="mobile-nav-link text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
                        <i class="fas fa-address-book mr-2"></i>Контакты
                    </a>
                    <a href="#" class="mobile-nav-link text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
                        <i class="fas fa-user mr-2"></i>Профиль
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
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
                <a href="#" class="text-primary hover:text-secondary font-semibold transition-colors">
                    Все новости <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://picsum.photos/400/250?random=1" alt="Новость об учебном процессе" class="w-full h-48 object-cover" loading="lazy">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-primary text-white px-2 py-1 rounded text-xs font-semibold">Важно</span>
                            <span class="mx-2">•</span>
                            <span>2 часа назад</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Изменения в расписании занятий</h3>
                        <p class="text-gray-600 mb-4">С 15 декабря вносятся изменения в расписание лекций и практических занятий...</p>
                        <button class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                            Читать далее <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://picsum.photos/400/250?random=2" alt="Мероприятие для студентов" class="w-full h-48 object-cover" loading="lazy">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">Мероприятие</span>
                            <span class="mx-2">•</span>
                            <span>Вчера</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Студенческая научная конференция</h3>
                        <p class="text-gray-600 mb-4">Приглашаем всех студентов принять участие в ежегодной научной конференции...</p>
                        <button class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                            Читать далее <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://picsum.photos/400/250?random=3" alt="Объявление о стипендиях" class="w-full h-48 object-cover" loading="lazy">
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-accent text-white px-2 py-1 rounded text-xs font-semibold">Финансы</span>
                            <span class="mx-2">•</span>
                            <span>3 дня назад</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Повышение стипендий с нового года</h3>
                        <p class="text-gray-600 mb-4">С 1 января 2024 года произойдет индексация академических и социальных стипендий...</p>
                        <button class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                            Читать далее <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Groups Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Мои группы</h2>
                <a href="#" class="text-primary hover:text-secondary font-semibold transition-colors">
                    Все группы <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                                <i class="fas fa-laptop-code text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Программирование</h3>
                                <p class="text-sm text-gray-500">Иванов А.С.</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Активна</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Следующее занятие:</span>
                            <span class="text-gray-800 font-medium">Завтра, 10:00</p>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Заданий:</span>
                            <span class="text-gray-800 font-medium">3 новых</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Математика</h3>
                                <p class="text-sm text-gray-500">Петрова М.В.</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Активна</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Следующее занятие:</span>
                            <span class="text-gray-800 font-medium">Понедельник, 14:00</p>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Заданий:</span>
                            <span class="text-gray-800 font-medium">1 новое</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Быстрый доступ</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar-alt text-primary text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">Расписание</span>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">Задания</span>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-bar text-accent text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">Оценки</span>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">Материалы</span>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold">StudentPortal</span>
                    </div>
                    <p class="text-gray-300 max-w-md">Современная платформа для студентов, объединяющая учебные материалы, расписание и общение в одном месте.</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Навигация</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="i" class="hover:text-white transition-colors">Новости</a></li>
                        <li><a href="#dsd" class="hover:text-white transition-colors">Группы</a></li>
                        <li><a href="#sdsd" class="hover:text-white transition-colors">Контакты</a></li>
                        <li><a href="mk.html" class="hover:text-white transition-colors">Профиль</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Контакты</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone text-primary"></i>
                            <span>+7 (776)0130107</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <span>info@studentportal.ru</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <span>г. Москва, ул. Студенческая, 1</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2024 StudentPortal. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.querySelector('button.md\\:hidden');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Navigation link functionality
        const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const linkText = this.textContent.trim();
                alert("Переход на страницу: " + linkText);
            });
        });

        // Quick action buttons
        const quickActions = document.querySelectorAll('.grid.grid-cols-2 button, .grid.grid-cols-2 > div');
        quickActions.forEach(action => {
            action.addEventListener('click', function() {
                const actionText = this.querySelector('span').textContent;
                alert("Открыт раздел: " + actionText);
            });
        });

        // News and group cards
        const cards = document.querySelectorAll('.bg-white.rounded-xl');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('h3').textContent;
                alert("Открыта статья: " + title);
            });
        });

        // Define navigation data
        const navigationItems = [
            { "id": 1, "label": "Новости", "icon": "fa-newspaper" },
            { "id": 2, "label": "Группа", "icon": "fa-users" },
            { "id": 3, "label": "Контакты", "icon": "fa-address-book" },
            { "id": 4, "label": "Профиль", "icon": "fa-user" }
        ];

        // Define news data
        const newsItems = [
            { 
                "id": 1, 
                "title": "Изменения в расписании занятий", 
                "description": "С 15 декабря вносятся изменения в расписание лекций и практических занятий...", 
                "category": "Важно",
                "time": "2 часа назад"
            },
            { 
                "id": 2, 
                "title": "Студенческая научная конференция", 
                "description": "Приглашаем всех студентов принять участие в ежегодной научной конференции...", 
                "category": "Мероприятие",
                "time": "Вчера"
            },
            { 
                "id": 3, 
                "title": "Повышение стипендий с нового года", 
                "description": "С 1 января 2024 года произойдет индексация академических и социальных стипендий...", 
                "category": "Финансы",
                "time": "3 дня назад"
            }
        ];

        // Define groups data
        const groupsData = [
            {
                "id": 1,
                "name": "Программирование",
                "teacher": "Иванов А.С.",
                "status": "Активна",
                "nextClass": "Завтра, 10:00",
                "assignments": "3 новых"
            },
            {
                "id": 2,
                "name": "Математика",
                "teacher": "Петрова М.В.",
                "status": "Активна",
                "nextClass": "Понедельник, 14:00",
                "assignments": "1 новое"
            }
        ];
    </script>
</body>
</html>