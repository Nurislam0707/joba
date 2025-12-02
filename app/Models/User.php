<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "email", 
        "password",
        "role",
        "phone",
        "avatar",
        "locale"
    ];

    protected $hidden = [
        "password",
        "remember_token"
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student', 'student_id', 'group_id');
    }

    public function taughtGroups()
    {
        return $this->hasMany(Group::class, "teacher_id");
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isAdmin()
    {
        return $this->role === 'admin' || $this->isTeacher();
    }

    public function news()
    {
     //   return $this->hasMany(News::class, 'author_id');
    }
}