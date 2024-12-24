<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id', // Убедитесь, что parent_id может быть null или должен существовать
        ]);

        Comment::create([
            'content' => $validated['content'],
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->route('articles.show', $article)->with('success', 'Комментарий добавлен.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        // Пометить комментарий как удалённый
        $comment->update(['is_deleted' => true]);

        return back()->with('success', 'Комментарий помечен как удалённый.');
    }
}
