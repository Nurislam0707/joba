<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\NotificationController;


// Аутентификация
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Смена языка
Route::post('/change-language', [LocalizationController::class, 'changeLanguage'])->name('change-language');
// also allow simple GET links like /language/en
Route::get('/language/{locale}', [LocalizationController::class, 'changeLanguage'])->name('language.change');

// Защищенные маршруты
Route::middleware(['auth'])->group(function () {
    // Главная страница
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Новости
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

    // Группы
    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');

    // Контакты
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
    
    // Профиль
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Быстрый доступ
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::get('/grades', [GradeController::class, 'index'])->name('grades');
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // ==================== СТУДЕНТ МАРШРУТТАРЫ ====================
    Route::middleware(['auth'])->group(function () {
        // Задания для студентов
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments');
        Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');
        Route::post('/assignments/{id}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    });

    // ==================== МҰҒАЛІМ МАРШРУТТАРЫ ====================
    Route::prefix('teacher')->group(function () {
        // Задания для мұғалімдер
        Route::get('/assignments', [AssignmentController::class, 'teacherIndex'])->name('teacher.assignments');
        Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('teacher.assignments.create');
        Route::post('/assignments', [AssignmentController::class, 'store'])->name('teacher.assignments.store');
        Route::get('/assignments/{id}', [AssignmentController::class, 'teacherShow'])->name('teacher.assignments.show');
        Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('teacher.assignments.edit');
        Route::put('/assignments/{id}', [AssignmentController::class, 'update'])->name('teacher.assignments.update');
        Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('teacher.assignments.destroy');
        
        // Проверка работ
        Route::get('/assignments/{id}/submissions', [AssignmentController::class, 'submissions'])->name('teacher.assignments.submissions');
        Route::post('/submissions/{id}/grade', [AssignmentController::class, 'gradeSubmission'])->name('teacher.submissions.grade');
        
        // Статистика и фильтры
        Route::get('/assignments/statistics', [AssignmentController::class, 'statistics'])->name('teacher.assignments.statistics');
        Route::get('/assignments/filter', [AssignmentController::class, 'filtered'])->name('teacher.assignments.filtered');
        Route::post('/assignments/{id}/duplicate', [AssignmentController::class, 'duplicate'])->name('teacher.assignments.duplicate');

        // Группы для преподавателей
        Route::get('/groups', [GroupController::class, 'teacherIndex'])->name('teacher.groups');
        Route::get('/groups/{id}', [GroupController::class, 'teacherShow'])->name('teacher.groups.show');

        // Материалы для преподавателей
        Route::get('/materials', [MaterialController::class, 'teacherIndex'])->name('teacher.materials');
        Route::get('/materials/create', [MaterialController::class, 'create'])->name('teacher.materials.create');
        Route::post('/materials', [MaterialController::class, 'store'])->name('teacher.materials.store');
        Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('teacher.materials.destroy');

        // Оценки для преподавателей
        Route::get('/grades', [GradeController::class, 'teacherIndex'])->name('teacher.grades');
    });

    // ==================== АДМИН МАРШРУТТАРЫ ====================
    Route::prefix('admin')->group(function () {
        // Управление новостями
        Route::get('/news', [NewsController::class, 'manage'])->name('news.manage');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

        // Управление группами
        Route::get('/groups', [GroupController::class, 'manage'])->name('groups.manage');
        Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
        Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
        Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
        Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
        Route::post('/groups/{group}/students', [GroupController::class, 'addStudent'])->name('groups.add-student');
        Route::delete('/groups/{group}/students/{student}', [GroupController::class, 'removeStudent'])->name('groups.remove-student');

        // Управление пользователями
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
});

// ==================== API МАРШРУТТАРЫ ====================
Route::prefix('api')->middleware(['auth'])->group(function () {
    // Календарь события
    Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('api.calendar.events');
    Route::post('/calendar/events', [CalendarController::class, 'storeEvent'])->name('api.calendar.events.store');
    
    // Уведомления
    Route::get('/notifications/count', [NotificationController::class, 'unreadCount'])->name('api.notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.read-all');
    
    // Задания
    Route::get('/assignments/student', [AssignmentController::class, 'getStudentAssignments'])->name('api.assignments.student');
    Route::get('/assignments/{id}/submissions', [AssignmentController::class, 'getSubmissions'])->name('api.assignments.submissions');
});

// ==================== FALLBACK МАРШРУТ ====================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);

    
// Teacher materials routes
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/materials', [MaterialController::class, 'teacherIndex'])->name('materials');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::delete('/materials/{materialId}/files/{fileId}', [MaterialController::class, 'destroyFile'])->name('materials.files.destroy');
});

// Student materials route
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    
});