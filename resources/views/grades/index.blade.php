@extends('layouts.app')

@section('title', 'Оценки')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Мои оценки</h1>
    
    <!-- Общая статистика -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-primary mb-2">{{ $overallStats['average'] }}%</div>
            <div class="text-sm text-gray-600">Средний балл</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-green-600 mb-2">{{ $overallStats['total_assignments'] }}</div>
            <div class="text-sm text-gray-600">Всего работ</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-blue-600 mb-2">{{ $overallStats['total_subjects'] }}</div>
            <div class="text-sm text-gray-600">Предметов</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-purple-600 mb-2">{{ $overallStats['highest_grade'] }}</div>
            <div class="text-sm text-gray-600">Лучшая оценка</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 text-center">
            <div class="text-2xl font-bold text-orange-600 mb-2">{{ $overallStats['lowest_grade'] }}</div>
            <div class="text-sm text-gray-600">Худшая оценка</div>
        </div>
    </div>
    
    <!-- Оценки по предметам -->
    <div class="space-y-6">
        @foreach($grades as $subject)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $subject['subject'] }}</h2>
                        <p class="text-gray-600 text-sm">Преподаватель: {{ $subject['teacher'] }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-primary">{{ $subject['average'] }}%</div>
                        <div class="text-sm text-gray-600">Средний балл</div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Задание</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Дата</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Оценка</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Процент</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subject['assignments'] as $assignment)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $assignment['title'] }}</td>
                                <td class="px-4 py-3">{{ $assignment['date'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-gray-800">
                                        {{ $assignment['grade'] }}/{{ $assignment['max_grade'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $percentage = round(($assignment['grade'] / $assignment['max_grade']) * 100, 1);
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($percentage >= 90) bg-green-100 text-green-800
                                        @elseif($percentage >= 70) bg-blue-100 text-blue-800
                                        @elseif($percentage >= 60) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $percentage }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($percentage >= 60)
                                    <span class="text-green-600 font-semibold">Сдано</span>
                                    @else
                                    <span class="text-red-600 font-semibold">Не сдано</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection