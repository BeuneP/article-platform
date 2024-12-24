@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Статьи</h1>

        {{-- Форма поиска --}}
        <div class="mb-6">
            <form action="{{ route('articles.search') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="query" placeholder="Поиск по темам и авторам..." class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Поиск</button>
            </form>
        </div>
        
        {{-- Список статей --}}
        <h2 class="text-lg font-bold mb-4">Мои статьи</h2>
        <a href="{{ route('articles.create') }}" class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Добавить статью</a>
        <ul class="space-y-4">
            @foreach ($myArticles as $article)
                <li class="p-4 bg-gray-50 rounded-lg shadow hover:bg-gray-100">
                    <a href="{{ route('articles.show', $article) }}" class="text-lg font-semibold text-blue-600 hover:underline">{{ $article->title }}</a>
                    <p class="text-sm text-gray-500">Автор: {{ $article->user->name }}</p>
                </li>
            @endforeach
        </ul>

        <h2 class="text-lg font-bold mb-4 mt-8">Другие статьи</h2>
        <ul class="space-y-4">
            @foreach ($otherArticles as $article)
                <li class="p-4 bg-gray-50 rounded-lg shadow hover:bg-gray-100">
                    <a href="{{ route('articles.show', $article) }}" class="text-lg font-semibold text-blue-600 hover:underline">{{ $article->title }}</a>
                    <p class="text-sm text-gray-500">Автор: {{ $article->user->name }}</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
