<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewArticleNotification;
use App\Models\User;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleController extends Controller
{
    use AuthorizesRequests;
    // Display a listing of the articles
    public function index()
    {
        if (!Auth::check()) {
            abort(403, 'Доступ запрещён');
        }

        $userId = Auth::id();

        // Мои статьи
        $myArticles = Article::where('user_id', $userId)->get();

        // Статьи других пользователей
        $otherArticles = Article::where('user_id', '!=', $userId)->get();

        return view('articles.index', compact('myArticles', 'otherArticles'));
    }

    // Show the form for creating a new article
    public function create()
    {
        return view('articles.create');
    }

    // Store a newly created article in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Статья успешно создана.');
    }

    // Show the form for editing the specified article
    public function edit(Article $article)
    {
        $this->authorize('update', $article); // Автор статьи может редактировать
        return view('articles.edit', compact('article'));
    }

    // Update the specified article in storage
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $article->update($request->only('title', 'content'));

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    // Remove the specified article from storage
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        $averageRating = number_format($article->ratings()->avg('rating') ?? 0, 2);

        return view('articles.show', compact('article', 'averageRating'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // Получаем строку запроса

        $articles = Article::where('title', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            })
            ->with('user') // Для оптимизации загрузки имени автора
            ->get();

        return view('articles.search', compact('articles', 'query'));
    }
}
