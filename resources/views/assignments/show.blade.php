@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $assignment->title }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-users"></i>
                    <span>Группа: {{ $assignment->group->name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>Мұғалім: {{ $assignment->teacher->name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar"></i>
                    <span>Мерзімі: {{ $assignment->due_date->format('d.m.Y H:i') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-clock"></i>
                    <span class="{{ $assignment->due_date < now() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $assignment->due_date->diffForHumans() }}
                    </span>
                </div>
            </div>
            
            <div class="prose max-w-none mb-6">
                <h3 class="text-xl font-semibold mb-3">Сипаттама</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $assignment->description }}</p>
            </div>
            
            @if($assignment->file_path)
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Қосымша материалдар</h3>
                <a href="{{ Storage::disk('public')->url($assignment->file_path) }}" 
                   target="_blank"
                   class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Файлды жүктеу</span>
                </a>
            </div>
            @endif
        </div>
        
        <!-- Жіберу формасы -->
        @if(!$submission)
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Тапсырманы жіберу</h2>
            
            <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Жауабыңыз *
                    </label>
                    <textarea name="content" id="content" rows="8" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Тапсырманың шешімін осы жерге жазыңыз..."
                              required></textarea>
                </div>
                
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Қосымша файл
                    </label>
                    <input type="file" name="file" id="file"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">PDF, Word, ZIP форматындағы файлдар (макс. 10MB)</p>
                </div>
                
                <button type="submit" 
                        class="w-full bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Тапсырманы жіберу
                </button>
            </form>
        </div>
        @else
        <!-- Жіберілген жұмыс -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Сіздің жіберген жұмысыңыз</h2>
            
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Жауабыңыз:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-line">{{ $submission->content }}</p>
                </div>
            </div>
            
            @if($submission->file_path)
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Жүктелген файл:</h3>
                <a href="{{ Storage::disk('public')->url($submission->file_path) }}" 
                   target="_blank"
                   class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Файлды жүктеу</span>
                </a>
            </div>
            @endif
            
            <div class="text-sm text-gray-500">
                Жіберілген: {{ $submission->submitted_at->format('d.m.Y H:i') }}
            </div>
            
            @if($submission->grade)
            <div class="mt-4 p-4 bg-green-50 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800 mb-2">Баға</h3>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-green-800">{{ $submission->grade }}/100</span>
                    <span class="text-green-600 text-sm">Тексерілді</span>
                </div>
                @if($submission->feedback)
                <div class="mt-2">
                    <h4 class="font-semibold text-green-800 mb-1">Пікір:</h4>
                    <p class="text-green-700">{{ $submission->feedback }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-clock text-yellow-600"></i>
                    <span class="text-yellow-800">Жұмыс әлі тексерілмеген</span>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection