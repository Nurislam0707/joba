<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", __("Student Portal"))</title>
    <meta name="description" content="@yield("description", __("Modern student portal"))">
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
                        "sans": ["Inter", "system-ui", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield("styles")
</head>
<body class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <nav class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route("home") }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">StudentPortal</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route("news") }}" class="nav-link {{ request()->routeIs("news*") ? "text-primary font-semibold border-b-2 border-primary pb-1" : "text-gray-600 hover:text-primary transition-colors" }}">
                        <i class="fas fa-newspaper mr-2"></i>Новости
                    </a>
                    <a href="{{ route("groups") }}" class="nav-link {{ request()->routeIs("groups*") ? "text-primary font-semibold border-b-2 border-primary pb-1" : "text-gray-600 hover:text-primary transition-colors" }}">
                        <i class="fas fa-users mr-2"></i>Группы
                    </a>
                    
                    <!-- MATERIALS LINK -->
                    <a href="{{ route("teacher.materials") }}" class="nav-link {{ request()->routeIs("teacher.materials*") ? "text-primary font-semibold border-b-2 border-primary pb-1" : "text-gray-600 hover:text-primary transition-colors" }}">
                        <i class="fas fa-book mr-2"></i>Материалы
                    </a>
                    
                    <a href="{{ route("contacts") }}" class="nav-link {{ request()->routeIs("contacts") ? "text-primary font-semibold border-b-2 border-primary pb-1" : "text-gray-600 hover:text-primary transition-colors" }}">
                        <i class="fas fa-address-book mr-2"></i>Контакты
                    </a>
                    <a href="{{ route("profile") }}" class="nav-link {{ request()->routeIs("profile") ? "text-primary font-semibold border-b-2 border-primary pb-1" : "text-gray-600 hover:text-primary transition-colors" }}">
                        <i class="fas fa-user mr-2"></i>Профиль
                    </a>
                    
                    <!-- Управление (только для админов/преподавателей) -->
                    @auth
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('news.manage') }}" class="nav-link {{ request()->routeIs('news.manage') || request()->routeIs('news.create') || request()->routeIs('news.edit') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-primary transition-colors' }}">
                            <i class="fas fa-newspaper mr-2"></i>Управление новостями
                        </a>
                        <a href="{{ route('groups.manage') }}" class="nav-link {{ request()->routeIs('groups.manage') ? 'text-primary font-semibold border-b-2 border-primary pb-1' : 'text-gray-600 hover:text-primary transition-colors' }}">
                            <i class="fas fa-users mr-2"></i>Управление группами
                        </a>
                        @endif
                    @endauth
                    
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2">
                        <button data-lang="ru" class="lang-btn {{ app()->getLocale() == 'ru' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors">
                            RU
                        </button>
                        <button data-lang="en" class="lang-btn {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors">
                            EN
                        </button>
                        <button data-lang="kz" class="lang-btn {{ app()->getLocale() == 'kz' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors">
                            KZ
                        </button>
                    </div>
                    
                    <!-- Logout -->
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-primary transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Выйти
                        </button>
                    </form>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 transition-colors mobile-menu-button">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden mobile-menu hidden py-4 border-t border-gray-200">
                <div class="flex flex-col space-y-4">
                    <a href="{{ route("news") }}" class="mobile-nav-link {{ request()->routeIs("news*") ? "text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2" : "text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors" }}">
                        <i class="fas fa-newspaper mr-2"></i>Новости
                    </a>
                    <a href="{{ route("groups") }}" class="mobile-nav-link {{ request()->routeIs("groups*") ? "text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2" : "text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors" }}">
                        <i class="fas fa-users mr-2"></i>Группы
                    </a>
                    
                    <!-- MATERIALS LINK MOBILE -->
                    <a href="{{ route("teacher.materials") }}" class="mobile-nav-link {{ request()->routeIs("teacher.materials*") ? "text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2" : "text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors" }}">
                        <i class="fas fa-book mr-2"></i>Материалы
                    </a>
                    
                    <a href="{{ route("contacts") }}" class="mobile-nav-link {{ request()->routeIs("contacts") ? "text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2" : "text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors" }}">
                        <i class="fas fa-address-book mr-2"></i>Контакты
                    </a>
                    <a href="{{ route("profile") }}" class="mobile-nav-link {{ request()->routeIs("profile") ? "text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2" : "text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors" }}">
                        <i class="fas fa-user mr-2"></i>Профиль
                    </a>
                    
                    <!-- Управление для мобильных (только для админов/преподавателей) -->
                    @auth
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('news.manage') }}" class="mobile-nav-link {{ request()->routeIs('news.manage') || request()->routeIs('news.create') || request()->routeIs('news.edit') ? 'text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2' : 'text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors' }}">
                            <i class="fas fa-newspaper mr-2"></i>Управление новостями
                        </a>
                        <a href="{{ route('groups.manage') }}" class="mobile-nav-link {{ request()->routeIs('groups.manage') ? 'text-primary font-semibold bg-blue-50 rounded-lg px-3 py-2' : 'text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors' }}">
                            <i class="fas fa-users mr-2"></i>Управление группами
                        </a>
                        @endif
                    @endauth
                    
                    <!-- Mobile Language Switcher -->
                    <div class="flex space-x-2 px-3 py-2">
                        <button data-lang="ru" class="lang-btn {{ app()->getLocale() == 'ru' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors flex-1">
                            RU
                        </button>
                        <button data-lang="en" class="lang-btn {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors flex-1">
                            EN
                        </button>
                        <button data-lang="kz" class="lang-btn {{ app()->getLocale() == 'kz' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }} px-3 py-1 rounded text-sm font-medium transition-colors flex-1">
                            KZ
                        </button>
                    </div>
                    
                    <!-- Mobile Logout -->
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors text-left w-full">
                            <i class="fas fa-sign-out-alt mr-2"></i>Выйти
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield("content")
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
                        <li><a href="{{ route("news") }}" class="hover:text-white transition-colors">Новости</a></li>
                        <li><a href="{{ route("groups") }}" class="hover:text-white transition-colors">Группы</a></li>
                        
                        <!-- MATERIALS FOOTER LINK -->
                        <li><a href="{{ route("teacher.materials") }}" class="hover:text-white transition-colors">Материалы</a></li>
                        
                        <li><a href="{{ route("contacts") }}" class="hover:text-white transition-colors">Контакты</a></li>
                        <li><a href="{{ route("profile") }}" class="hover:text-white transition-colors">Профиль</a></li>
                        @auth
                            @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('news.manage') }}" class="hover:text-white transition-colors">Управление новостями</a></li>
                            <li><a href="{{ route('groups.manage') }}" class="hover:text-white transition-colors">Управление группами</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Контакты</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone text-primary"></i>
                            <span>+7 (776)013-01-07 </span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <span>nurislamtastanbek40@gmail.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <span>Толе би-86</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2025 StudentPortal. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.querySelector(".mobile-menu-button");
        const mobileMenu = document.querySelector(".mobile-menu");
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener("click", function() {
                mobileMenu.classList.toggle("hidden");
            });
        }

        // Quick action buttons
        const quickActions = document.querySelectorAll(".quick-action");
        quickActions.forEach(action => {
            action.addEventListener("click", function() {
                const actionText = this.querySelector("span").textContent;
                // Здесь можно добавить логику для каждого действия
                console.log("Action clicked:", actionText);
            });
        });

        // Language change function (used by event listeners)
        function changeLanguage(lang) {
            fetch('/change-language', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ locale: lang })
            })
            .then(response => {
                // try parse JSON safely
                return response.json().catch(() => null);
            })
            .then(data => {
                // if server returned success or no error, reload
                if (!data || data.success) {
                    location.reload();
                } else if (data && data.error) {
                    showNotification(data.error, 'error');
                }
            }).catch(err => {
                console.error('Language change failed', err);
                showNotification('Не удалось сменить язык', 'error');
            });
        }

        // Attach click listeners to language buttons
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                const lang = this.getAttribute('data-lang');
                if (lang) changeLanguage(lang);
            });
        });

        // Notification display
        @if(session('success'))
            setTimeout(() => {
                showNotification('{{ session('success') }}', 'success');
            }, 100);
        @endif

        @if(session('error'))
            setTimeout(() => {
                showNotification('{{ session('error') }}', 'error');
            }, 100);
        @endif

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Анимация кіру
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideNav = event.target.closest('nav');
            const isMobileMenuOpen = !mobileMenu.classList.contains('hidden');
            
            if (!isClickInsideNav && isMobileMenuOpen) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Prevent body scroll when mobile menu is open
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'hidden' : 'auto';
            });
        }
    </script>
    @yield("scripts")
</body>
</html>