@extends('layouts.app')

@section('title', 'Жаңа тапсырма құру')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Жаңа тапсырма құру</h1>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('teacher.assignments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Тапсырма атауы *
                    </label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="Тапсырманың атауын енгізіңіз">
                </div>
                
                <div class="mb-4">
                    <label for="group_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Группа *
                    </label>
                    <select name="group_id" id="group_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Группаны таңдаңыз</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Мерзімі *
                    </label>
                    <input type="datetime-local" name="due_date" id="due_date" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Сипаттама *
                    </label>
                    <textarea name="description" id="description" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Тапсырманың толық сипаттамасын жазыңыз..."></textarea>
                </div>
                
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Қосымша файл
                    </label>
                    <input type="file" name="file" id="file"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Қосымша материалдарды жүктеу үшін (макс. 10MB)</p>
                </div>
                
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Тапсырманы құру
                    </button>
                    <a href="{{ route('teacher.assignments') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors">
                        Болдырмау
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Автоматически устанавливаем минимальную дату (сегодня)
document.getElementById('due_date').min = new Date().toISOString().slice(0, 16);
</script>
@endsection