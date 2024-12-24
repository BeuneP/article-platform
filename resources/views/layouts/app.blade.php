<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">Платформа статей</a>
            <ul class="flex space-x-4">
                @auth
                    <li>
                        <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-blue-600">Статьи</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-blue-600">Профиль</a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="text-gray-700 hover:text-blue-600">{{ __('messages.logout')}}</button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Вход</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    <main class="py-8">
        <div class="container mx-auto">
            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif
            @yield('content')
        </div>
    </main>

    <nav class="fixed top-30 left-30 flex space-x-2">
    <a href="{{ route('change.language', 'en') }}">
        <!-- <img src="/images/flags/en.png" alt="English" class="w-8 h-8 inline"> -->
        <p>{{ __('messages.language.english') }}</p>
    </a>
    <a href="{{ route('change.language', 'ru') }}">
        <!-- <img src="/images/flags/ru.png" alt="Русский" class="w-8 h-8 inline"> -->
        <p>{{ __('messages.language.russian') }}</p>
    </a>
</nav>
</body>
</html>