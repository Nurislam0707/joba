<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Support\Facades\Hash;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        // Мұғалім құру
        $teacher = User::create([
            'name' => 'Айгүл Мұғалім',
            'email' => 'teacher@edu.kz',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '+7 777 123 4567'
        ]);

        // Студент құру
        $student = User::create([
            'name' => 'Бақытжан Студент',
            'email' => 'student@edu.kz',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+7 777 765 4321'
        ]);

        // Группа құру
        $group = Group::create([
            'name' => 'П-21-01',
            'description' => 'Программирование группасы',
            'teacher_id' => $teacher->id
        ]);

        // Студентті группаға қосу
        $group->students()->attach($student->id);

        // Тапсырмалар құру
        Assignment::create([
            'title' => 'Лабораторная работа №1',
            'description' => 'Laravel негіздерін меңгеру. MVC архитектурасын құру.',
            'group_id' => $group->id,
            'teacher_id' => $teacher->id,
            'due_date' => now()->addDays(7)
        ]);

        Assignment::create([
            'title' => 'Веб-қолданба жобасы',
            'description' => 'Толық стек веб-қолданбасын жасау. Frontend және backend бөлімдері.',
            'group_id' => $group->id,
            'teacher_id' => $teacher->id,
            'due_date' => now()->addDays(14)
        ]);

        Assignment::create([
            'title' => 'Финальдық жоба',
            'description' => 'Жеке жобаны қорғау. Толық құжаттамамен бірге.',
            'group_id' => $group->id,
            'teacher_id' => $teacher->id,
            'due_date' => now()->addDays(30)
        ]);
    }
}