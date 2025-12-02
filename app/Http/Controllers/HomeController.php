<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Group;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Новости
        $latestNews = News::latest()->take(3)->get();
        
        // Группы пользователя
        $userGroups = Group::whereHas('students', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        // Статистика (можно заменить на реальные данные)
        $stats = [
            'completed_assignments' => 75,
            'average_grade' => 4.5,
            'study_hours' => 24,
            'achievements' => 5
        ];

        return view('home', compact('latestNews', 'userGroups', 'stats'));
    }
}