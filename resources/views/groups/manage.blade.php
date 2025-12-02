@extends("layouts.app")

@section("title", "Группаларды басқару")
@section("description", "Группалар мен студенттерді басқару")

@section("content")
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Группаларды басқару</h1>
        <button onclick="toggleGroupForm()" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Жаңа группа
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Жаңа группа формасы -->
    <div id="groupForm" class="bg-white rounded-xl shadow-md p-6 mb-8 hidden">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Жаңа группа құру</h2>
        <form action="{{ route('groups.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Группа аты</label>
                    <input type="text" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Оқытушы</label>
                    <select name="teacher_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Оқытушыны таңдаңыз</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Сипаттама</label>
                    <input type="text" name="description" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Кесте</label>
                    <input type="text" name="schedule" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="toggleGroupForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition-colors">
                    Болдырмау
                </button>
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                    Құру
                </button>
            </div>
        </form>
    </div>

    <!-- Группалар тізімі -->
    <div class="space-y-6">
        @foreach($groups as $group)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $group->name }}</h3>
                            <p class="text-gray-600">{{ $group->teacher->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Кесте: {{ $group->schedule ?? 'Белгіленбеген' }}</p>
                        <p class="text-sm text-gray-500">Студенттер: {{ $group->students->count() }}</p>
                    </div>
                </div>

                <!-- Студенттерді қосу формасы -->
                <div class="mb-4">
                    <form action="{{ route('groups.add-student', $group->id) }}" method="POST" class="flex space-x-4">
                        @csrf
                        <select name="student_id" required 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">Студентті таңдаңыз</option>
                            @foreach($students as $student)
                                @if(!$group->students->contains($student->id))
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>Қосу
                        </button>
                    </form>
                </div>

                <!-- Студенттер тізімі -->
                @if($group->students->count() > 0)
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Группа студенттері:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($group->students as $student)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('groups.remove-student', [$group->id, $student->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Студентті группадан шығарғыңыз келе ме?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function toggleGroupForm() {
    const form = document.getElementById('groupForm');
    form.classList.toggle('hidden');
}
</script>
@endsection