@extends('layouts.app')

@section('title', 'Менің тапсырмаларым')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Менің тапсырмаларым</h1>
    
    @if($assignments && $assignments->count() > 0)
    <div class="grid grid-cols-1 gap-6">
        @foreach($assignments as $assignment)
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $assignment->title }}</h3>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($assignment->is_submitted) bg-green-100 text-green-800
                            @elseif($assignment->due_date < now()) bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            @if($assignment->is_submitted) Жіберілді
                            @elseif($assignment->due_date < now()) Мерзімі өткен
                            @else Орындалуда @endif
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-3">{{ \Illuminate\Support\Str::limit($assignment->description, 200) }}</p>
                    
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-users"></i>
                            <span>{{ $assignment->group->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-user"></i>
                            <span>{{ $assignment->teacher->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-calendar"></i>
                            <span>Мерзімі: {{ $assignment->due_date->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="ml-6">
                    <a href="{{ route('assignments.show', $assignment->id) }}" 
                       class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                        @if($assignment->is_submitted)
                        Қарау
                        @else
                        Орындау
                        @endif
                    </a>
                </div>
            </div>
            
            @if($assignment->is_submitted && $assignment->submission && $assignment->submission->grade)
            <div class="mt-3 p-3 bg-green-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <span class="text-green-800 font-semibold">Баға: {{ $assignment->submission->grade }}/100</span>
                    <span class="text-green-600 text-sm">Тексерілді</span>
                </div>
                @if($assignment->submission->feedback)
                <p class="text-green-700 text-sm mt-1">{{ $assignment->submission->feedback }}</p>
                @endif
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <i class="fas fa-tasks text-gray-400 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Тапсырмалар жоқ</h3>
        <p class="text-gray-600">Сізге әлі тапсырмалар берілген жоқ</p>
    </div>
    @endif
</div>
@endsection