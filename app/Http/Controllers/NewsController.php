<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
                   ->whereNotNull('published_at')
                   ->where('published_at', '<=', now())
                   ->latest('published_at')
                   ->paginate(10);

        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::where('is_published', true)
                   ->whereNotNull('published_at')
                   ->where('published_at', '<=', now())
                   ->findOrFail($id);

        return view('news.show', compact('news'));
    }

    // Страница управления новостями (только для админов)
    public function manage()
    {
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для доступа к этой странице');
        }

        $news = News::latest()->paginate(10);
        return view('news.manage', compact('news'));
    }

    // Форма создания новости
    public function create()
    {
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для создания новостей');
        }

        return view('news.create');
    }

    // Сохранение новости
    public function store(Request $request)
    {
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для создания новостей');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'required|date',
            'is_published' => 'boolean'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'image_url' => $imagePath ? Storage::url($imagePath) : null,
            'published_at' => $request->published_at,
            'is_published' => $request->boolean('is_published'),
            //'author_id' => auth()->id()
        ]);

        return redirect()->route('news.manage')->with('success', 'Новость успешно создана!');
    }

    // Форма редактирования
    public function edit($id)
    {
        $news = News::findOrFail($id);
        
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для редактирования новостей');
        }

        return view('news.edit', compact('news'));
    }

    // Обновление новости
    public function update(Request $request, $id)
    {
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для редактирования новостей');
        }

        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'required|date',
            'is_published' => 'boolean'
        ]);

        $imagePath = $news->image_url;
        if ($request->hasFile('image')) {
            // Удаляем старое изображение если есть
            if ($news->image_url) {
                $oldImage = str_replace('/storage/', '', $news->image_url);
                Storage::disk('public')->delete($oldImage);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $imagePath = Storage::url($imagePath);
        }

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'image_url' => $imagePath,
            'published_at' => $request->published_at,
            'is_published' => $request->boolean('is_published')
        ]);

        return redirect()->route('news.manage')->with('success', 'Новость успешно обновлена!');
    }

    // Удаление новости
    public function destroy($id)
    {
        // Проверяем права
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'У вас нет прав для удаления новостей');
        }

        $news = News::findOrFail($id);

        // Удаляем изображение если есть
        if ($news->image_url) {
            $imagePath = str_replace('/storage/', '', $news->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $news->delete();

        return redirect()->route('news.manage')->with('success', 'Новость успешно удалена!');
    }
}