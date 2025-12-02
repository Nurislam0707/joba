@extends("layouts.app")

@section("title", $group->name . " - Группа")
@section("description", $group->description)

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Хлебные крошки -->
        <nav class="mb-6">
            <a href="{{ route('groups') }}" class="text-primary hover:text-secondary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Группаларға оралу
            </a>
        </nav>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Заголовок группы -->
            <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $group->name }}</h1>
                        <p class="text-blue-100">{{ $group->description }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Информация о группе -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Группа ақпараты</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Оқытушы:</span>
                                <span class="font-semibold">{{ $group->teacher->name ?? "Тағайындалмаған" }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Кесте:</span>
                                <span class="font-semibold">{{ $group->schedule ?? "Белгіленбеген" }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Студенттер саны:</span>
                                <span class="font-semibold">{{ $group->students->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Студенты -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Студенттер</h2>
                        @if($group->students->count() > 0)
                        <div class="space-y-3">
                            @foreach($group->students as $student)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <i class="fas fa-user-graduate text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500">Группада студенттер жоқ</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection