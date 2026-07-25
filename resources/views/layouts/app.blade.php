<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Orbit') · Project clarity</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="noise"></div>
<header class="nav shell">
    <a href="{{ auth()->check() ? route('projects.index') : route('home') }}" class="brand"><span class="brand-mark">O</span><span>orbit</span></a>
    <nav>
        @auth
            <span class="nav-user"><span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-btn">Sign out</button></form>
        @else
            <a href="{{ route('login') }}" class="text-btn">Sign in</a><a href="{{ route('register') }}" class="btn btn-small">Start free</a>
        @endauth
    </nav>
</header>
<main>@yield('content')</main>

@if(session('success') || session('error') || session('completed'))
<div class="toast {{ session('error') ? 'toast-error' : '' }} {{ session('completed') ? 'toast-complete' : '' }}" data-toast>
    <span class="toast-icon">{{ session('error') ? '!' : (session('completed') ? '✓' : '↗') }}</span>
    <div><strong>{{ session('error') ? 'Something went wrong' : (session('completed') ? 'Nice one!' : 'All set') }}</strong><p>{{ session('error') ?? session('completed') ?? session('success') }}</p></div>
    <button aria-label="Close" data-dismiss>×</button>
</div>
@endif
@yield('scripts')
</body>
</html>
