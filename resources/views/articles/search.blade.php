@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Результаты поиска</h1>

        <p class="mb-4">Поиск по запросу: <strong>{{ $query }}</strong></p>

        @if ($articles->isEmpty())
            <p class="text-gray-500">Нет статей, соответствующих вашему запросу.</p>
        @else
            <ul class="space-y-4">
                @foreach ($articles as $article)
                    <li class="p-4 bg-gray-50 rounded-lg shadow hover:bg-gray-100">
                        <a href="{{ route('articles.show', $article) }}" class="text-lg font-semibold text-blue-600 hover:underline">{{ $article->title }}</a>
                        <p class="text-sm text-gray-500">Автор: {{ $article->user->name }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
