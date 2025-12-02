<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Группалар тізімін көрсету
     */
    public function index()
    {
        $groups = Group::with('teacher')->get();
        
        return view('groups.index', compact('groups'));
    }

    /**
     * Белгілі бір группаны көрсету
     */
    public function show($id)
    {
        $group = Group::with(['teacher', 'students'])->findOrFail($id);
        
        return view('groups.show', compact('group'));
    }

    /**
     * Группаларды басқару (админдер/оқытушылар үшін)
     */
    public function manage()
    {
        // Тек админдер/оқытушылар үшін
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Сізде рұқсат жоқ');
        }

        $groups = Group::with(['teacher', 'students'])->latest()->get();
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        return view('groups.manage', compact('groups', 'students', 'teachers'));
    }

    /**
     * Жаңа группа құру
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Сізде рұқсат жоқ');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
            'schedule' => 'nullable|string'
        ]);

        Group::create($request->all());

        return back()->with('success', 'Группа сәтті құрылды!');
    }

    /**
     * Группаға студент қосу
     */
    public function addStudent(Request $request, $groupId)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Сізде рұқсат жоқ');
        }

        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);

        $group = Group::findOrFail($groupId);
        
        // Студент группада бар ма екенін тексеру
        if ($group->students()->where('user_id', $request->student_id)->exists()) {
            return back()->with('error', 'Бұл студент группада бар!');
        }

        $group->students()->attach($request->student_id);

        return back()->with('success', 'Студент группаға сәтті қосылды!');
    }

    /**
     * Группадан студентті жою
     */
    public function removeStudent($groupId, $studentId)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Сізде рұқсат жоқ');
        }

        $group = Group::findOrFail($groupId);
        $group->students()->detach($studentId);

        return back()->with('success', 'Студент группадан сәтті жойылды!');
    }
}