<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // ==================== СТУДЕНТ БӨЛІМІ ====================
    
    /**
     * Студенттің заданияларын көрсету
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isStudent()) {
            // Студенттің группалары бойынша заданиялар
            $studentGroups = $user->groups()->pluck('groups.id');
            $assignments = Assignment::whereIn('group_id', $studentGroups)
                ->with(['group', 'teacher'])
                ->orderBy('due_date', 'asc')
                ->get()
                ->map(function($assignment) use ($user) {
                    $assignment->is_submitted = $assignment->submissions()
                        ->where('student_id', $user->id)
                        ->exists();
                    $assignment->submission = $assignment->submissions()
                        ->where('student_id', $user->id)
                        ->first();
                    return $assignment;
                });
        } else {
            // Егер студент емес болса, бос коллекция қайтару
            $assignments = collect();
        }
        
        return view('assignments.index', compact('assignments'));
    }
    
    /**
     * Студент үшін заданияны көрсету
     */
    public function show($id)
    {
        $assignment = Assignment::with(['group', 'teacher'])->findOrFail($id);
        $user = auth()->user();
        
        // Студент группаға тиісті екенін тексеру
        if ($user->isStudent() && !$assignment->group->students->contains($user->id)) {
            abort(403, 'Сіз бұл группаға жатпайсыз');
        }
        
        $submission = $assignment->submissions()
            ->where('student_id', $user->id)
            ->first();
            
        return view('assignments.show', compact('assignment', 'submission'));
    }
    
    /**
     * Студенттің заданияны жіберуі
     */
    public function submit($id, Request $request)
    {
        $assignment = Assignment::findOrFail($id);
        $user = auth()->user();
        
        // Студент группаға тиісті екенін тексеру
        if (!$assignment->group->students->contains($user->id)) {
            abort(403, 'Сіз бұл группаға жатпайсыз');
        }
        
        // Мерзім өтіп кеткенін тексеру
        if ($assignment->due_date < now()) {
            return back()->with('error', 'Тапсырма мерзімі өтіп кеткен!');
        }
        
        $request->validate([
            'content' => 'required|string|min:10',
            'file' => 'nullable|file|max:10240' // 10MB
        ]);
        
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments/submissions', 'public');
        }
        
        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => $user->id
            ],
            [
                'content' => $request->content,
                'file_path' => $filePath,
                'submitted_at' => now()
            ]
        );
        
        return redirect()->route('assignments.show', $assignment->id)
            ->with('success', 'Тапсырма сәтті жіберілді!');
    }
    
    // ==================== МҰҒАЛІМ БӨЛІМІ ====================
    
    /**
     * Мұғалімнің заданияларын көрсету
     */
    public function teacherIndex()
    {
        $user = auth()->user();
        $assignments = Assignment::where('teacher_id', $user->id)
            ->with(['group'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $groups = Group::where('teacher_id', $user->id)->get();
        
        return view('teacher.assignments.index', compact('assignments', 'groups'));
    }
    
    /**
     * Жаңа задания жасау формасы
     */
    public function create()
    {
        $user = auth()->user();
        $groups = Group::where('teacher_id', $user->id)->get();
        
        return view('teacher.assignments.create', compact('groups'));
    }
    
    /**
     * Жаңа заданияны сақтау
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'group_id' => 'required|exists:groups,id',
            'due_date' => 'required|date|after:today',
            'max_points' => 'required|numeric|min:1|max:1000',
            'file' => 'nullable|file|max:10240' // 10MB
        ]);
        
        // Мұғалімнің группасы екенін тексеру
        $group = Group::where('id', $request->group_id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
        
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }
        
        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'group_id' => $request->group_id,
            'teacher_id' => $user->id,
            'due_date' => $request->due_date,
            'max_points' => $request->max_points,
            'file_path' => $filePath
        ]);
        
        return redirect()->route('teacher.assignments')
            ->with('success', 'Тапсырма сәтті құрылды!');
    }
    
    /**
     * Мұғалім үшін заданияны көрсету
     */
    public function teacherShow($id)
    {
        $user = auth()->user();
        $assignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->with(['group', 'submissions.student'])
            ->firstOrFail();
            
        $submissionStats = [
            'total' => $assignment->submissions->count(),
            'graded' => $assignment->submissions->whereNotNull('grade')->count(),
            'pending' => $assignment->submissions->whereNull('grade')->count()
        ];
            
        return view('teacher.assignments.show', compact('assignment', 'submissionStats'));
    }
    
    /**
     * Тапсырманы өңдеу формасы
     */
    public function edit($id)
    {
        $user = auth()->user();
        $assignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
            
        $groups = Group::where('teacher_id', $user->id)->get();
        
        return view('teacher.assignments.edit', compact('assignment', 'groups'));
    }
    
    /**
     * Тапсырманы жаңарту
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $assignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'group_id' => 'required|exists:groups,id',
            'due_date' => 'required|date|after:today',
            'max_points' => 'required|numeric|min:1|max:1000',
            'file' => 'nullable|file|max:10240'
        ]);
        
        // Мұғалімнің группасы екенін тексеру
        $group = Group::where('id', $request->group_id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
        
        $filePath = $assignment->file_path;
        if ($request->hasFile('file')) {
            // Ескі файлды жою
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('assignments', 'public');
        }
        
        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'group_id' => $request->group_id,
            'due_date' => $request->due_date,
            'max_points' => $request->max_points,
            'file_path' => $filePath
        ]);
        
        return redirect()->route('teacher.assignments')
            ->with('success', 'Тапсырма сәтті жаңартылды!');
    }
    
    /**
     * Тапсырманы жою
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $assignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
            
        // Файлды жою
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }
        
        $assignment->delete();
        
        return redirect()->route('teacher.assignments')
            ->with('success', 'Тапсырма сәтті жойылды!');
    }
    
    /**
     * Тапсырма бойынша жіберілген жұмыстарды көрсету
     */
    public function submissions($id)
    {
        $user = auth()->user();
        $assignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->with(['submissions.student', 'group'])
            ->firstOrFail();
            
        $submissionStats = [
            'total' => $assignment->submissions->count(),
            'graded' => $assignment->submissions->whereNotNull('grade')->count(),
            'pending' => $assignment->submissions->whereNull('grade')->count(),
            'average_grade' => $assignment->submissions->whereNotNull('grade')->avg('grade')
        ];
            
        return view('teacher.assignments.submissions', compact('assignment', 'submissionStats'));
    }
    
    /**
     * Жұмысқа баға қою
     */
    public function gradeSubmission($id, Request $request)
    {
        $submission = AssignmentSubmission::with(['assignment', 'student'])->findOrFail($id);
        
        // Мұғалімнің тапсырмасы екенін тексеру
        if ($submission->assignment->teacher_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'grade' => 'required|numeric|min:0|max:' . $submission->assignment->max_points,
            'feedback' => 'nullable|string'
        ]);
        
        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'graded_at' => now()
        ]);
        
        return redirect()->route('teacher.assignments.submissions', $submission->assignment_id)
            ->with('success', 'Баға сәтті қойылды!');
    }
    
    /**
     * Тапсырмалар бойынша статистика
     */
    public function statistics()
    {
        $user = auth()->user();
        
        if (!$user->isTeacher()) {
            abort(403);
        }
        
        // Жалпы статистика
        $totalAssignments = Assignment::where('teacher_id', $user->id)->count();
        $totalSubmissions = AssignmentSubmission::whereHas('assignment', function($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->count();
        $gradedSubmissions = AssignmentSubmission::whereHas('assignment', function($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->whereNotNull('grade')->count();
        
        $averageGrade = AssignmentSubmission::whereHas('assignment', function($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->whereNotNull('grade')->avg('grade');
        
        // Группалар бойынша статистика
        $groups = Group::where('teacher_id', $user->id)
            ->withCount(['assignments', 'students'])
            ->get()
            ->map(function($group) {
                $group->submissions_count = AssignmentSubmission::whereHas('assignment', function($query) use ($group) {
                    $query->where('group_id', $group->id);
                })->count();
                $group->graded_count = AssignmentSubmission::whereHas('assignment', function($query) use ($group) {
                    $query->where('group_id', $group->id);
                })->whereNotNull('grade')->count();
                return $group;
            });
        
        $stats = [
            'total_assignments' => $totalAssignments,
            'total_submissions' => $totalSubmissions,
            'graded_submissions' => $gradedSubmissions,
            'pending_submissions' => $totalSubmissions - $gradedSubmissions,
            'average_grade' => round($averageGrade, 1),
            'submission_rate' => $totalAssignments > 0 ? round(($totalSubmissions / ($totalAssignments * $groups->sum('students_count'))) * 100, 1) : 0
        ];
        
        return view('teacher.assignments.statistics', compact('stats', 'groups'));
    }
    
    /**
     * Фильтрленген тапсырмаларды көрсету
     */
    public function filtered(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isTeacher()) {
            abort(403);
        }
        
        $query = Assignment::where('teacher_id', $user->id)
            ->with(['group']);
        
        // Группа бойынша фильтр
        if ($request->has('group_id') && $request->group_id) {
            $query->where('group_id', $request->group_id);
        }
        
        // Статус бойынша фильтр
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('due_date', '>', now());
                    break;
                case 'overdue':
                    $query->where('due_date', '<', now());
                    break;
                case 'completed':
                    // Барлық студенттер жіберген тапсырмалар
                    $query->whereHas('submissions');
                    break;
            }
        }
        
        $assignments = $query->orderBy('due_date', 'asc')->get();
        
        $groups = Group::where('teacher_id', $user->id)->get();
        
        return view('teacher.assignments.filtered', compact('assignments', 'groups'));
    }
    
    /**
     * Тапсырманы көшіріп, жаңа тапсырма ретінде сақтау
     */
    public function duplicate($id)
    {
        $user = auth()->user();
        $originalAssignment = Assignment::where('id', $id)
            ->where('teacher_id', $user->id)
            ->firstOrFail();
        
        $newAssignment = $originalAssignment->replicate();
        $newAssignment->title = $originalAssignment->title . ' (көшірме)';
        $newAssignment->created_at = now();
        $newAssignment->updated_at = now();
        $newAssignment->save();
        
        return redirect()->route('teacher.assignments.edit', $newAssignment->id)
            ->with('success', 'Тапсырма сәтті көшірілді! Енді оны өңдеуге болады.');
    }
}