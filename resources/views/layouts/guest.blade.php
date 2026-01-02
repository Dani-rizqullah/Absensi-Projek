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
<body class="antialiased font-sans bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 transition-colors duration-500">
    <div class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-2xl h-96 bg-indigo-500/5 dark:bg-indigo-500/[0.02] blur-[120px] pointer-events-none"></div>

        <div class="mb-12 text-center relative z-10">
            <a href="/" class="group inline-block">
                <div class="w-16 h-16 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-2xl flex items-center justify-center transition-all group-hover:scale-105 group-active:scale-95 duration-500 shadow-2xl shadow-zinc-500/20 dark:shadow-none border border-zinc-800 dark:border-zinc-200">
                    <svg class="h-9 w-9" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30 30H70V70H30V30Z" stroke="currentColor" stroke-width="8" stroke-linejoin="round"/>
                        <rect x="45" y="45" width="10" height="10" fill="currentColor"/>
                    </svg>
                </div>
            </a>
        </div>

        <div class="w-full max-w-[440px] bg-white dark:bg-zinc-900/50 backdrop-blur-sm border border-zinc-100 dark:border-zinc-800 rounded-[32px] p-8 sm:p-12 shadow-2xl shadow-zinc-200/50 dark:shadow-none relative z-10">
            {{ $slot }}
        </div>

        <div class="mt-20 text-center relative z-10">
            <p class="text-[10px] font-extrabold text-zinc-400 dark:text-zinc-600 uppercase tracking-[0.5em] italic">
                DSM &bull; Integrated Management System
            </p>
        </div>
    </div>
</body>
</html>