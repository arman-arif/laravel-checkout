<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('extra-css')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="bg-gray-100">
        <div class="container">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 hidden px-12 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="mx-2 text-sm text-gray-700 underline dark:text-gray-500">Dashboard</a>
                    @else
                        @if (!Route::is('home'))
                            <a href="{{ route('home') }}" class="mx-2 text-sm text-gray-700 underline dark:text-gray-500">Home</a>
                        @endif
                        @if (!Route::is('login'))
                            <a href="{{ route('login') }}" class="mx-2 text-sm text-gray-700 underline dark:text-gray-500">Log in</a>
                        @endif

                        @if (Route::has('register') && !Route::is('register'))
                            <a href="{{ route('register') }}" class="mx-2 text-sm text-gray-700 underline dark:text-gray-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.js') }}"></script>
    @stack('extra-js')
</body>

</html>
