@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center mb-6">Добро пожаловать на Платформу статей!</h1>
        <p class="text-lg text-gray-600 text-center mb-4">
            Здесь вы можете писать, редактировать и обсуждать статьи. Присоединяйтесь, чтобы поделиться своими идеями и узнать что-то новое!
        </p>
        <div class="text-center">
            <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Присоединиться</a>
        </div>
    </div>
@endsection
