<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'file_path',
        'submitted_at',
        'grade',
        'feedback',
        'graded_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'grade' => 'decimal:2'
    ];

    /**
     * Тапсырмамен байланыс
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Студентпен байланыс
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Баға қойылған ба
     */
    public function getIsGradedAttribute()
    {
        return !is_null($this->grade);
    }

    /**
     * Проценттік көрсеткіш
     */
    public function getGradePercentageAttribute()
    {
        if (!$this->grade || !$this->assignment->max_points) {
            return null;
        }
        return ($this->grade / $this->assignment->max_points) * 100;
    }
}