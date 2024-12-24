<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        Rating::updateOrCreate(
            ['article_id' => $article->id, 'user_id' => Auth::id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Ваша оценка сохранена.');
    }
}
