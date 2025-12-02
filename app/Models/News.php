<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "category",
        "image_url",
        "published_at",
        "is_published",
       // "author_id"
    ];

    protected $casts = [
        "published_at" => "datetime",
        "is_published" => "boolean"
    ];

    // Связь с автором
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope для получения опубликованных новостей
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    // Метод для получения краткого описания
    public function getExcerptAttribute()
    {
        return Str::limit($this->content, 150);
    }

    // Scope для новостей конкретного автора
    public function scopeByAuthor($query, $userId)
    {
        return $query->where('author_id', $userId);
    }
}