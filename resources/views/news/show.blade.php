@extends("layouts.app")

@section("title", $news->title . " - Студенческий портал")
@section("description", Str::limit($news->content, 160))

@section("content")
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        <!-- Хлебные крошки -->
        <nav class="mb-6">
            <a href="{{ route('news') }}" class="text-primary hover:text-secondary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Назад к новостям
            </a>
        </nav>

        <!-- Заголовок новости -->
        <header class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold">{{ $news->category }}</span>
                <span class="mx-3">•</span>
                <span><i class="far fa-clock mr-1"></i>{{ $news->published_at->format('d.m.Y H:i') }}</span>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $news->title }}</h1>
            
            @if($news->image_url)
            <div class="mb-6">
                <img src="{{ $news->image_url }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-xl shadow-md"
                     loading="lazy">
            </div>
            @endif
        </header>

        <!-- Содержание новости -->
        <div class="prose max-w-none mb-8">
            <div class="text-gray-700 leading-relaxed text-lg">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>

        <!-- Дополнительная информация -->
        <footer class="border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>Опубликовано: {{ $news->published_at->diffForHumans() }}</span>
                <a href="{{ route('news') }}" class="text-primary hover:text-secondary transition-colors">
                    Все новости <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </footer>
    </article>
</div>
@endsection