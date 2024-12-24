@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $article->title }}</h1>
        <p class="text-gray-700 mb-6">{{ $article->content }}</p>
        <p class="text-sm text-gray-500 mb-4">Автор: {{ $article->user->name }}</p>
        <p class="text-sm text-gray-500 mb-6">Дата создания: {{ $article->created_at->format('d.m.Y H:i') }}</p>

        <div class="mb-8">
            <h2 class="text-lg font-bold mb-4">Рейтинг</h2>
            <form action="{{ route('articles.rate', $article) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <select name="rating" class="rounded-lg border-gray-300 shadow-sm focus:ring-blue-500">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Оценить</button>
            </form>
            <p class="text-sm text-gray-500 mt-2">Средняя оценка: {{ $averageRating ?? 'Нет оценок' }}</p>
        </div>

        <div class="mb-8">
            <h2 class="text-lg font-bold mb-4">Комментарии</h2>
            <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-4">
                @csrf
                <textarea name="content" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500" placeholder="Напишите комментарий..." required></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Отправить</button>
            </form>

            {{-- Вывод комментариев --}}
            @foreach ($article->comments as $comment)
                @include('comments.partials.comment', ['comment' => $comment])
            @endforeach
        </div>

        <div class="flex space-x-4">
            @can('update', $article)
                <a href="{{ route('articles.edit', $article) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Редактировать</a>
            @endcan
            @can('delete', $article)
                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Удалить</button>
                </form>
            @endcan
            <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Назад</a>
        </div>
    </div>
@endsection
