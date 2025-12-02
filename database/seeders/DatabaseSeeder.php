<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Group;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // SQLite үшін FOREIGN_KEY_CHECKS қолданбаймыз
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        
        // Кестелерді тазарту
        Schema::disableForeignKeyConstraints();
        
        DB::table('assignment_submissions')->truncate();
        DB::table('assignments')->truncate();
        DB::table('group_student')->truncate();
        DB::table('groups')->truncate();
        DB::table('news')->truncate();
        DB::table('users')->truncate();
        
        Schema::enableForeignKeyConstraints();

        // Create teacher
        $teacher = User::create([
            "name" => "Иванов Александр Сергеевич",
            "email" => "teacher@university.ru",
            "password" => Hash::make("password"),
            "role" => "teacher",
            "phone" => "+7 (999) 123-45-67",
            "locale" => "ru"
        ]);

        // Create students
        $student1 = User::create([
            "name" => "Петров Иван",
            "email" => "student1@university.ru", 
            "password" => Hash::make("password"),
            "role" => "student",
            "phone" => "+7 (999) 123-45-68",
            "locale" => "ru"
        ]);

        $student2 = User::create([
            "name" => "Сидорова Мария",
            "email" => "student2@university.ru",
            "password" => Hash::make("password"), 
            "role" => "student",
            "phone" => "+7 (999) 123-45-69",
            "locale" => "ru"
        ]);

        // Create admin
        $admin = User::create([
            "name" => "Администратор",
            "email" => "admin@university.ru",
            "password" => Hash::make("password"),
            "role" => "admin",
            "phone" => "+7 (999) 123-45-70",
            "locale" => "ru"
        ]);

        // Create news
        News::create([
            "title" => "Изменения в расписании занятий",
            "content" => "С 15 декабря вносятся изменения в расписание лекций и практических занятий. Пожалуйста, ознакомьтесь с обновленным расписанием в личном кабинете.",
            "category" => "Важно",
            "image_url" => "https://picsum.photos/400/250?random=1",
            "published_at" => now()->subHours(2),
            "is_published" => true,
            "author_id" => $teacher->id
        ]);

        News::create([
            "title" => "Студенческая научная конференция", 
            "content" => "Приглашаем всех студентов принять участие в ежегодной научной конференции. Регистрация открыта до 20 декабря.",
            "category" => "Мероприятие",
            "image_url" => "https://picsum.photos/400/250?random=2",
            "published_at" => now()->subDay(),
            "is_published" => true,
            "author_id" => $teacher->id
        ]);

        // Create groups
        $group1 = Group::create([
            "name" => "Программирование",
            "description" => "Курс по основам программирования и алгоритмам",
            "teacher_id" => $teacher->id,
            "schedule" => "Понедельник, 10:00 - 12:00"
        ]);

        $group2 = Group::create([
            "name" => "Веб-разработка",
            "description" => "Современные технологии веб-разработки", 
            "teacher_id" => $teacher->id,
            "schedule" => "Среда, 14:00 - 16:00"
        ]);

        // Attach students to groups
        $group1->students()->attach([$student1->id, $student2->id]);
        $group2->students()->attach([$student1->id]);

        // Create assignments
        $assignment1 = Assignment::create([
            "title" => "Лабораторная работа №1 - Основы Laravel",
            "description" => "Создайте простое веб-приложение на Laravel с использованием MVC архитектуры. Реализуйте CRUD операции для управления студентами.",
            "group_id" => $group1->id,
            "teacher_id" => $teacher->id,
            "due_date" => now()->addDays(7),
            "max_points" => 100
        ]);

        $assignment2 = Assignment::create([
            "title" => "Веб-сайт на Bootstrap",
            "description" => "Создайте адаптивный веб-сайт используя Bootstrap 5. Сайт должен содержать навигацию, основные секции и работать на мобильных устройствах.",
            "group_id" => $group2->id,
            "teacher_id" => $teacher->id,
            "due_date" => now()->addDays(5),
            "max_points" => 80
        ]);

        // Create assignment submissions
        AssignmentSubmission::create([
            "assignment_id" => $assignment1->id,
            "student_id" => $student1->id,
            "content" => "Выполнил лабораторную работу. Создал модели, миграции и контроллеры для управления студентами. Реализовал все CRUD операции.",
            "submitted_at" => now()->subDays(1),
            "grade" => 85,
            "feedback" => "Отличная работа! Хорошая структура кода."
        ]);

        AssignmentSubmission::create([
            "assignment_id" => $assignment2->id,
            "student_id" => $student1->id,
            "content" => "Создал адаптивный веб-сайт для туристического агентства.",
            "submitted_at" => now()->subHours(12),
            "grade" => null,
            "feedback" => null
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('=== АККАУНТТАР ===');
        $this->command->info('Мұғалім: teacher@university.ru / password');
        $this->command->info('Студент 1: student1@university.ru / password');
        $this->command->info('Студент 2: student2@university.ru / password');
        $this->command->info('Админ: admin@university.ru / password');
        $this->command->info('==================');
    }
}