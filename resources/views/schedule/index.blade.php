@extends('layouts.app')

@section('title', 'Расписание')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Расписание занятий</h1>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b border-gray-200">
            <div class="flex">
                <button class="px-6 py-4 border-b-2 border-primary text-primary font-semibold">Неделя</button>
                <button class="px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-primary font-semibold">Месяц</button>
            </div>
        </div>
        
        <div class="p-6">
            @foreach($schedule as $day)
            <div class="mb-8 last:mb-0">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $day['day'] }}</h3>
                
                <div class="space-y-3">
                    @foreach($day['lessons'] as $lesson)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $lesson['subject'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $lesson['teacher'] }}</p>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ $lesson['time'] }}</p>
                            <p class="text-sm text-gray-600">Аудитория {{ $lesson['room'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection