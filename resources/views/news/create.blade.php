@extends("layouts.app")

@section("title", "Добавить новость")
@section("description", "Форма добавления новой новости")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Добавить новость</h1>

        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Заголовок -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Заголовок *</label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           value="{{ old('title') }}"
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
                           value="{{ old('category') }}"
                           placeholder="Например: Важно, Мероприятие, Новости">
                    @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Изображение -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Изображение</label>
                    <input type="file" name="image" id="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
                </div>

                <!-- Дата публикации -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Дата публикации *</label>
                    <input type="datetime-local" name="published_at" id="published_at" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                    @error('published_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Статус -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" 
                               {{ old('is_published', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-700">Опубликовать сразу</span>
                    </label>
                </div>

                <!-- Содержание -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Содержание *</label>
                    <textarea name="content" id="content" rows="10" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Введите содержание новости">{{ old('content') }}</textarea>
                    @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('news.manage') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors">
                    Отмена
                </a>
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Сохранить новость
                </button>
            </div>
        </form>
    </div>
</div>
@endsection