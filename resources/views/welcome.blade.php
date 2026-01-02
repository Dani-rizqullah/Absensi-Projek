<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} | Tactical System</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-zinc-900 dark:text-white font-['Instrument_Sans'] antialiased selection:bg-zinc-900 selection:text-white">
        
        <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-50 dark:opacity-20">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-zinc-200 dark:bg-zinc-800 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-zinc-100 dark:bg-zinc-900 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col">
            <nav class="flex justify-between items-center px-10 py-8 z-10">
                <div class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-zinc-900 dark:bg-white rounded-xl flex items-center justify-center text-white dark:text-black transition-all group-hover:rotate-12 duration-500 shadow-xl shadow-zinc-500/10">
                        <svg class="h-6 w-6" viewBox="0 0 100 100" fill="none"><path d="M30 30H70V70H30V30Z" stroke="currentColor" stroke-width="10" stroke-linejoin="round"/><rect x="45" y="45" width="10" height="10" fill="currentColor"/></svg>
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-[0.4em] italic">{{ config('app.name') }}</span>
                </div>

                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[10px] font-black uppercase tracking-widest px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-xl hover:opacity-80 transition-all active:scale-95 shadow-xl shadow-zinc-500/10">Enter Console</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest px-6 py-3 text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-all">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-[10px] font-black uppercase tracking-widest px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-xl hover:opacity-80 transition-all active:scale-95 shadow-xl shadow-zinc-500/10">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>

            <main class="flex-1 flex items-center justify-center px-10 relative">
                <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    
                    <div class="space-y-10 text-left">
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-100 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">System Core v2.0 Online</span>
                            </div>
                            <h1 class="text-7xl lg:text-8xl font-black italic tracking-tighter leading-[0.9] uppercase transition-all duration-700">
                                Operational <br>
                                <span class="text-zinc-300 dark:text-zinc-700">Excellence.</span>
                            </h1>
                            <p class="max-w-md text-zinc-500 dark:text-zinc-400 text-sm font-medium leading-relaxed tracking-tight">
                                Pusat kendali manajemen personel dan monitoring aktivitas operasional DSM secara real-time. Terenkripsi, efisien, dan taktis.
                            </p>
                        </div>

                        <div class="flex items-center gap-8">
                            <div class="space-y-1">
                                <p class="text-2xl font-black italic tabular-nums leading-none">24/7</p>
                                <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Monitoring</p>
                            </div>
                            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-800"></div>
                            <div class="space-y-1">
                                <p class="text-2xl font-black italic tabular-nums leading-none">AES</p>
                                <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Encryption</p>
                            </div>
                            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-800"></div>
                            <div class="space-y-1">
                                <p class="text-2xl font-black italic tabular-nums leading-none">DSM</p>
                                <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">Protocol</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-zinc-200 to-zinc-100 dark:from-zinc-800 dark:to-zinc-900 rounded-[3rem] blur opacity-30 group-hover:opacity-100 transition duration-1000"></div>
                        <div class="relative bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-[2.5rem] p-12 overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>
                            
                            <div class="relative z-10 space-y-8">
                                <div class="flex justify-between items-start">
                                    <div class="w-12 h-1.5 bg-zinc-900 dark:bg-white rounded-full"></div>
                                    <div class="text-right">
                                        <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Auth Level</p>
                                        <p class="text-[11px] font-black italic mt-1 uppercase tracking-tighter">Personnel Access Only</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-6 pt-10">
                                    <div class="h-2 w-3/4 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                    <div class="h-2 w-1/2 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                    <div class="h-2 w-2/3 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                </div>

                                <div class="pt-20 flex justify-between items-end">
                                    <div class="space-y-2">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <p class="text-[8px] font-black text-zinc-400 uppercase tracking-widest">System Ready</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[24px] font-black italic leading-none tracking-tighter uppercase tabular-nums">ID: 001-CORE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="px-10 py-8 flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] font-black text-zinc-400 uppercase tracking-[0.4em] z-10">
                <p>&copy; 2026 DSM Core Division. All Rights Reserved.</p>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Security Protocol</a>
                </div>
            </footer>
        </div>
    </body>
</html>