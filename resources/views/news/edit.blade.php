@extends("layouts.app")

@section("title", "Редактировать новость")
@section("description", "Форма редактирования новости")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Редактировать новость</h1>

        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Заголовок -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Заголовок *</label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           value="{{ old('title', $news->title) }}"
                           placeholder="Введите заголовок новости">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Категория -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Категория *</label>
                    <input type="text" name="category" id="category" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           value="{{ old('category', $news->category) }}"
                           placeholder="Например: Важно, Мероприятие, Новости">
                    @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Изображение -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Изображение</label>
                    
                    <!-- Текущее изображение -->
                    @if($news->image_url)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Текущее изображение:</p>
                        <img src="{{ $news->image_url }}" 
                             alt="{{ $news->title }}" 
                             class="w-64 h-48 object-cover rounded-lg shadow-md">
                    </div>
                    @endif

                    <input type="file" name="image" id="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Оставьте пустым, чтобы сохранить текущее изображение. Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
                </div>

                <!-- Дата публикации -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Дата публикации *</label>
                    <input type="datetime-local" name="published_at" id="published_at" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           value="{{ old('published_at', $news->published_at->format('Y-m-d\TH:i')) }}">
                    @error('published_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Статус -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" 
                               {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-700">Опубликовано</span>
                    </label>
                </div>

                <!-- Содержание -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Содержание *</label>
                    <textarea name="content" id="content" rows="10" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Введите содержание новости">{{ old('content', $news->content) }}</textarea>
                    @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Информация о новости -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Информация о новости</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Автор:</span> {{ $news->author->name }}
                        </div>
                        <div>
                            <span class="font-medium">Создана:</span> {{ $news->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Обновлена:</span> {{ $news->updated_at->format('d.m.Y H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">ID:</span> {{ $news->id }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8">
                <div>
                    <a href="{{ route('news.show', $news->id) }}" target="_blank" class="text-primary hover:text-secondary font-semibold text-sm transition-colors mr-4">
                        <i class="fas fa-external-link-alt mr-1"></i>Посмотреть на сайте
                    </a>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('news.manage') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors">
                        Отмена
                    </a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Обновить новость
                    </button>
                </div>
            </div>
        </form>

        <!-- Форма удаления -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-6 border border-red-200">
            <h3 class="text-lg font-semibold text-red-700 mb-4">Опасная зона</h3>
            <p class="text-gray-600 mb-4">Удаление новости нельзя отменить. Все данные будут безвозвратно удалены.</p>
            <form action="{{ route('news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость? Это действие нельзя отменить.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>Удалить новость
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Предпросмотр изображения перед загрузкой
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Создаем или обновляем блок предпросмотра
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mb-4';
                    preview.innerHTML = '<p class="text-sm text-gray-600 mb-2">Новое изображение:</p>';
                    const img = document.createElement('img');
                    img.className = 'w-64 h-48 object-cover rounded-lg shadow-md';
                    preview.appendChild(img);
                    document.querySelector('input[name="image"]').before(preview);
                }
                preview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection