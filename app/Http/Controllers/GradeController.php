<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        // Пример данных оценок
        $grades = [
            [
                'subject' => 'Программирование',
                'teacher' => 'Иванов А.С.',
                'assignments' => [
                    ['title' => 'Лабораторная работа №1', 'grade' => 85, 'max_grade' => 100, 'date' => '2024-11-20'],
                    ['title' => 'Практическая работа', 'grade' => 92, 'max_grade' => 100, 'date' => '2024-11-25'],
                    ['title' => 'Тест по основам', 'grade' => 78, 'max_grade' => 100, 'date' => '2024-12-01'],
                ],
                'average' => 85.0
            ],
            [
                'subject' => 'Математика',
                'teacher' => 'Петрова М.В.',
                'assignments' => [
                    ['title' => 'Контрольная работа №1', 'grade' => 45, 'max_grade' => 50, 'date' => '2024-11-18'],
                    ['title' => 'Домашнее задание', 'grade' => 38, 'max_grade' => 40, 'date' => '2024-11-22'],
                ],
                'average' => 91.1
            ],
            [
                'subject' => 'Базы данных',
                'teacher' => 'Сидоров П.К.',
                'assignments' => [
                    ['title' => 'Проект БД', 'grade' => 95, 'max_grade' => 100, 'date' => '2024-11-28'],
                    ['title' => 'SQL запросы', 'grade' => 88, 'max_grade' => 100, 'date' => '2024-12-02'],
                ],
                'average' => 91.5
            ]
        ];

        $overallStats = $this->calculateOverallStats($grades);

        return view('grades.index', compact('grades', 'overallStats'));
    }

    private function calculateOverallStats($grades)
    {
        $totalGrades = 0;
        $totalMaxGrades = 0;
        $totalAssignments = 0;

        foreach ($grades as $subject) {
            foreach ($subject['assignments'] as $assignment) {
                $totalGrades += $assignment['grade'];
                $totalMaxGrades += $assignment['max_grade'];
                $totalAssignments++;
            }
        }

        return [
            'average' => $totalMaxGrades > 0 ? round(($totalGrades / $totalMaxGrades) * 100, 1) : 0,
            'total_assignments' => $totalAssignments,
            'total_subjects' => count($grades),
            'highest_grade' => collect($grades)->flatMap(function($subject) {
                return $subject['assignments'];
            })->max('grade'),
            'lowest_grade' => collect($grades)->flatMap(function($subject) {
                return $subject['assignments'];
            })->min('grade')
        ];
    }
}