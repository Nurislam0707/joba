@extends("layouts.app")

@section("title", "Группалар")
@section("description", "Студенттік группалар")

@section("content")
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Группалар</h1>

    @if($groups->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($groups as $group)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $group->teacher->name ?? "Оқытушы тағайындалмаған" }}</p>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Белсенді</span>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Кесте:</span>
                        <span class="font-medium">{{ $group->schedule ?? "Кесте белгіленбеген" }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Студенттер:</span>
                        <span class="font-medium">{{ $group->students_count ?? 0 }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('groups.show', $group->id) }}" class="text-primary hover:text-secondary font-semibold text-sm transition-colors">
                        Толығырақ <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Группалар табылмады</h3>
        <p class="text-gray-600">Әзірге группалар жоқ</p>
    </div>
    @endif
</div>
@endsection