<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Пример расписания
        $schedule = [
            [
                'day' => 'Понедельник',
                'lessons' => [
                    ['time' => '09:00 - 10:30', 'subject' => 'Программирование', 'room' => '101', 'teacher' => 'Иванов А.С.'],
                    ['time' => '10:45 - 12:15', 'subject' => 'Математика', 'room' => '203', 'teacher' => 'Петрова М.В.'],
                ]
            ],
            [
                'day' => 'Вторник',
                'lessons' => [
                    ['time' => '09:00 - 10:30', 'subject' => 'Базы данных', 'room' => '105', 'teacher' => 'Сидоров П.К.'],
                ]
            ],
            // ... другие дни
        ];

        return view('schedule.index', compact('schedule'));
    }
}