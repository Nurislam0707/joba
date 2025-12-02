@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Контакты</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Контактная информация -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Контактная информация</h2>
            
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Телефон</h3>
                        <p class="text-gray-600">+7 (776) 013-01-07</p>
                        <p class="text-gray-600">+7 (708) 013-01-07</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                        <p class="text-gray-600">info@studentportal.ru</p>
                        <p class="text-gray-600">support@studentportal.ru</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Адрес</h3>
                        <p class="text-gray-600">г. Tole bi-86</p>
                        <p class="text-gray-600">Лек 111, 1 этаж</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Время работы</h3>
                        <p class="text-gray-600">Понедельник - Пятница: 9:00 - 18:00</p>
                        <p class="text-gray-600">Суббота: 10:00 - 16:00</p>
                        <p class="text-gray-600">Воскресенье: выходной</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Форма обратной связи -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Свяжитесь с нами</h2>
            
            <form class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ваше имя *</label>
                        <input type="text" id="name" name="name" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                               placeholder="Введите ваше имя">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                               placeholder="Введите ваш email">
                    </div>
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Тема сообщения</label>
                    <select id="subject" name="subject" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        <option value="">Выберите тему</option>
                        <option value="technical">Техническая поддержка</option>
                        <option value="academic">Учебные вопросы</option>
                        <option value="payment">Финансовые вопросы</option>
                        <option value="other">Другое</option>
                    </select>
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Сообщение *</label>
                    <textarea id="message" name="message" rows="5" required 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                              placeholder="Опишите ваш вопрос или проблему..."></textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Отправить сообщение
                </button>
            </form>
        </div>
    </div>
    
    <!-- Дополнительная информация -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Наша команда</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-tie text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Техническая поддержка</h3>
                <p class="text-gray-600 mb-3">Помощь с техническими вопросами и проблемами платформы</p>
                <p class="text-primary font-medium">support@studentportal.ru</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Учебный отдел</h3>
                <p class="text-gray-600 mb-3">Вопросы по учебному процессу и расписанию</p>
                <p class="text-primary font-medium">academic@studentportal.ru</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Общие вопросы</h3>
                <p class="text-gray-600 mb-3">По всем остальным вопросам и предложениям</p>
                <p class="text-primary font-medium">info@studentportal.ru</p>
            </div>
        </div>
    </div>
    
    <!-- Карта -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Мы на карте</h2>
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-map-marked-alt text-4xl mb-3"></i>
                    <p>Интерактивная карта</p>
                    <p class="text-sm">г. Tole bi-86</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Простая валидация формы
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    
    if (!name || !email || !message) {
        alert('Пожалуйста, заполните все обязательные поля');
        return;
    }
    
    // Здесь можно добавить AJAX отправку формы
    alert('Сообщение отправлено! Мы свяжемся с вами в ближайшее время.');
    this.reset();
});
</script>
@endsection