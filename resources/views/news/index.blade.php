@extends("layouts.app")

@section("title", "Новости - Студенческий портал")
@section("description", "Последние новости и события студенческого портала")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Новости</h1>
        <p class="text-gray-600">Будьте в курсе последних событий и объявлений</p>
    </div>

    @if($news->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($news as $newsItem)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <img src="{{ $newsItem->image_url ?: 'https://picsum.photos/400/250?random=' . $loop->index }}" 
                 alt="{{ $newsItem->title }}" 
                 class="w-full h-48 object-cover" 
                 loading="lazy">
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span class="bg-primary text-white px-2 py-1 rounded text-xs font-semibold">{{ $newsItem->category }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $newsItem->published_at->format('d.m.Y') }}</span>
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

    <!-- Пагинация -->
    <div class="mt-8">
        {{ $news->links() }}
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <i class="fas fa-newspaper text-gray-400 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Новостей пока нет</h3>
        <p class="text-gray-600">Скоро здесь появятся актуальные новости</p>
    </div>
    @endif
</div>
@endsection