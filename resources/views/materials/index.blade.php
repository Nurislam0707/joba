@extends('layouts.app')

@section('title', 'Учебные материалы')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Бас бөлім -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Учебные материалы</h1>
        <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>Материал қосу
        </button>
    </div>

    <!-- Хабарламалар -->
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
    
    <!-- Негізгі контейнер -->
    <div class="bg-white rounded-xl shadow-md">
        <!-- Іздеу панелі -->
        <div class="border-b border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Все материалы</h2>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="text" placeholder="Поиск материалов..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-64">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Поиск
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Материалдар тізімі -->
        <div class="p-6">
            @if(count($materials) > 0)
                @foreach($materials as $subject)
                <div class="mb-8 last:mb-0">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $subject['subject'] }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subject['files'] as $file)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 bg-white">
                            <div class="flex items-center space-x-3 mb-3">
                                <!-- Файл түрі бойынша белгіше -->
                                @if($file['type'] === 'pdf')
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-pdf text-red-600 text-lg"></i>
                                </div>
                                @elseif($file['type'] === 'docx' || $file['type'] === 'doc')
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-word text-blue-600 text-lg"></i>
                                </div>
                                @elseif($file['type'] === 'xlsx' || $file['type'] === 'xls')
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-excel text-green-600 text-lg"></i>
                                </div>
                                @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file text-gray-600 text-lg"></i>
                                </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 text-sm truncate" title="{{ $file['name'] }}">
                                        {{ $file['name'] }}
                                    </h4>
                                    <p class="text-xs text-gray-600">{{ $file['size'] }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $file['date'] }}</span>
                                <div class="flex space-x-3">
                                    <button class="text-blue-600 hover:text-blue-700 transition-colors" title="Жүктеу">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-700 transition-colors" title="Көру">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('teacher.materials.destroy', $subject['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors" title="Жою" onclick="return confirm('Материалды жойғыңыз келе ме?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Материалдар табылған жоқ</p>
                    <button onclick="openModal()" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Бірінші материалды қосу
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Материал қосу модалды терезесі -->
<div id="addMaterialModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Жаңа материал қосу</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="addMaterialForm" action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Пән атауы *</label>
                    <input type="text" name="subject" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Мысалы: Программирование" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Файл атауы *</label>
                    <input type="text" name="filename" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Мысалы: Лекция 1" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Файл түрі *</label>
                    <select name="filetype" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="pdf">PDF</option>
                        <option value="docx">Word (DOCX)</option>
                        <option value="doc">Word (DOC)</option>
                        <option value="xlsx">Excel (XLSX)</option>
                        <option value="xls">Excel (XLS)</option>
                        <option value="other">Басқа</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Файл жүктеу *</label>
                    <input type="file" name="file" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <p class="text-xs text-gray-500 mt-1">Максималды өлшем: 10MB</p>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Бас тарту</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Сақтау</button>
            </div>
        </form>
    </div>
</div>

<script>
// Материал қосу модалды терезесі
function openModal() {
    document.getElementById('addMaterialModal').classList.remove('hidden');
    document.getElementById('addMaterialModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('addMaterialModal').classList.remove('flex');
    document.getElementById('addMaterialModal').classList.add('hidden');
}

// Модалды терезені жабу
document.getElementById('addMaterialModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Іздеу функциясы
document.querySelector('input[placeholder="Поиск материалов..."]').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const materialCards = document.querySelectorAll('.grid > div');
    
    materialCards.forEach(card => {
        const materialName = card.querySelector('h4').textContent.toLowerCase();
        const materialSubject = card.closest('.mb-8').querySelector('h3').textContent.toLowerCase();
        
        if (materialName.includes(searchTerm) || materialSubject.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

<style>
#addMaterialModal {
    backdrop-filter: blur(4px);
}

.grid > div {
    transition: all 0.3s ease;
}
</style>
@endsection