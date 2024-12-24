<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Маршрут поиска должен быть выше ресурса
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('articles', ArticleController::class);
    Route::post('/articles/{article}/rate', [RatingController::class, 'store'])->name('articles.rate');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ru'])) {
        Session::put('locale', $locale); // Сохраняем выбранный язык в сессии
    }
    return redirect()->back(); // Возвращаем пользователя на предыдущую страницу
})->name('change.language');

require __DIR__ . '/auth.php';
