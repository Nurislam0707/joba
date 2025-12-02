<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'group_id',
        'teacher_id',
        'due_date',
        'max_points',
        'file_path'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    /**
     * Группамен байланыс
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Мұғаліммен байланыс
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Жіберілген жұмыстармен байланыс
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Студент жіберген ба
     */
    public function isSubmittedByStudent($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->exists();
    }

    /**
     * Мерзімі өткен ба
     */
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now();
    }

    /**
     * Белсенді ба
     */
    public function getIsActiveAttribute()
    {
        return $this->due_date > now();
    }
}