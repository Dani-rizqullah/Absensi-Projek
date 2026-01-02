<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DSM') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans bg-white text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 transition-colors duration-300">
    
    <div class="min-h-screen flex flex-col">
        <nav class="sticky top-0 z-50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-900">
            @include('layouts.navigation')
        </nav>

        @isset($header)
            <header class="bg-white dark:bg-zinc-950 border-b border-zinc-100 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto py-10 px-6 sm:px-8 lg:px-10">
                    <h2 class="font-extrabold text-3xl tracking-tighter uppercase italic italic">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        <main class="flex-1 w-full max-w-7xl mx-auto px-6 lg:px-10 py-10">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     class="fixed bottom-10 right-10 z-[100] flex items-center gap-3 bg-zinc-900 dark:bg-white text-white dark:text-black px-6 py-4 rounded-2xl shadow-2xl border border-zinc-800 dark:border-zinc-200">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <p class="text-xs font-bold uppercase tracking-widest leading-none">{{ session('success') }}</p>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mt-auto border-t border-zinc-100 dark:border-zinc-900 py-12 text-center">
            <p class="text-[9px] font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} DSM CORE &bull; Operation System
            </p>
        </footer>
    </div>

    <script>
        window.toggleTheme = function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</body>
</html>