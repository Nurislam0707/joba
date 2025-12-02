<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'schedule'
    ];

    /**
     * Мұғаліммен байланыс
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Студенттермен байланыс
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'group_student', 'group_id', 'student_id');
    }

    /**
     * Тапсырмалармен байланыс
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Студенттер саны
     */
    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }

    /**
     * Белсенді тапсырмалар
     */
    public function getActiveAssignmentsAttribute()
    {
        return $this->assignments()->where('due_date', '>', now())->get();
    }
}