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
            <div class="absolute -top-[10%] -left-[10%] w-[70%] md:w-[40%] h-[40%] bg-zinc-200 dark:bg-zinc-800 rounded-full blur-[80px] md:blur-[120px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[70%] md:w-[40%] h-[40%] bg-zinc-100 dark:bg-zinc-900 rounded-full blur-[80px] md:blur-[120px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col">
            <nav class="w-full max-w-7xl mx-auto flex justify-between items-center px-6 md:px-10 py-4 md:py-6 z-20">
                
                <div class="flex items-center gap-2 md:gap-4 group -ml-2 md:-ml-6"> 
                    {{-- Container Logo (Besar & Pop-out) --}}
                    <div class="w-20 h-20 md:w-32 md:h-32 flex items-center justify-center transition-all group-hover:scale-105 duration-500 overflow-visible">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Logo {{ config('app.name') }}" 
                             class="h-full w-full object-contain transition-all duration-500 
                                    grayscale brightness-0 dark:invert">
                    </div>


                </div>

                @if (Route::has('login'))
                    <div class="flex gap-2 md:gap-4 items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[9px] md:text-[10px] font-black uppercase tracking-widest px-5 md:px-7 py-3 md:py-4 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-2xl hover:opacity-80 transition-all active:scale-95 shadow-2xl shadow-zinc-500/20 border border-transparent dark:border-zinc-800">Enter Console</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[9px] md:text-[10px] font-black uppercase tracking-widest px-3 md:px-6 py-2.5 md:py-3 text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-all">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hidden xs:flex text-[9px] md:text-[10px] font-black uppercase tracking-widest px-5 md:px-7 py-3 md:py-4 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-2xl hover:opacity-80 transition-all active:scale-95 shadow-xl shadow-zinc-500/10">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>

            <main class="flex-1 flex items-center justify-center px-6 md:px-10 py-10 relative">
                <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    
                    <div class="space-y-8 md:space-y-10 text-left order-2 lg:order-1">
                        <div class="space-y-4 md:space-y-6">
                            <div class="inline-flex items-center gap-2 px-3 md:px-4 py-1.5 md:py-2 bg-zinc-100 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-full">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[8px] md:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">System Core v2.0 Online</span>
                            </div>
                            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black italic tracking-tighter leading-[0.95] md:leading-[0.9] uppercase transition-all duration-700">
                                DSM <br class="hidden sm:block">
                                <span class="text-zinc-300 dark:text-zinc-700">Management <br class="sm:hidden">System.</span>
                            </h1>
                            <p class="max-w-md text-zinc-500 dark:text-zinc-400 text-xs md:text-sm font-medium leading-relaxed tracking-tight">
                                Pusat kendali manajemen personel dan monitoring aktivitas operasional DSM secara real-time. Terenkripsi, efisien, dan taktis.
                            </p>
                        </div>

                        <div class="grid grid-cols-3 sm:flex items-center gap-4 md:gap-8">
                            <div class="space-y-1">
                                <p class="text-xl md:text-2xl font-black italic tabular-nums leading-none">24/7</p>
                                <p class="text-[7px] md:text-[8px] font-bold text-zinc-400 uppercase tracking-widest leading-tight">Monitoring</p>
                            </div>
                            <div class="w-px h-6 md:h-8 bg-zinc-200 dark:bg-zinc-800"></div>
                            <div class="space-y-1">
                                <p class="text-xl md:text-2xl font-black italic tabular-nums leading-none">AES</p>
                                <p class="text-[7px] md:text-[8px] font-bold text-zinc-400 uppercase tracking-widest leading-tight">Encryption</p>
                            </div>
                            <div class="hidden sm:block w-px h-8 bg-zinc-200 dark:bg-zinc-800"></div>
                            <div class="space-y-1">
                                <p class="text-xl md:text-2xl font-black italic tabular-nums leading-none">DSM</p>
                                <p class="text-[7px] md:text-[8px] font-bold text-zinc-400 uppercase tracking-widest leading-tight">Protocol</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2 relative group w-full max-w-md mx-auto lg:max-w-none">
                        <div class="absolute -inset-1 bg-gradient-to-r from-zinc-200 to-zinc-100 dark:from-zinc-800 dark:to-zinc-900 rounded-[2.5rem] md:rounded-[3rem] blur opacity-30 group-hover:opacity-100 transition duration-1000"></div>
                        <div class="relative bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-[2.5rem] p-8 md:p-12 overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>
                            
                            <div class="relative z-10 space-y-6 md:space-y-8">
                                <div class="flex justify-between items-start">
                                    <div class="w-10 md:w-12 h-1 md:h-1.5 bg-zinc-900 dark:bg-white rounded-full"></div>
                                    <div class="text-right leading-none">
                                        <p class="text-[8px] md:text-[9px] font-black text-zinc-400 uppercase tracking-widest">Auth Level</p>
                                        <p class="text-[10px] md:text-[11px] font-black italic mt-1 uppercase tracking-tighter leading-none">Personnel Only</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4 md:space-y-6 pt-6 md:pt-10">
                                    <div class="h-1.5 md:h-2 w-3/4 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                    <div class="h-1.5 md:h-2 w-1/2 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                    <div class="h-1.5 md:h-2 w-2/3 bg-zinc-100 dark:bg-zinc-900 rounded-full"></div>
                                </div>

                                <div class="pt-12 md:pt-20 flex justify-between items-end">
                                    <div class="space-y-1 md:space-y-2 text-left leading-none">
                                        <div class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <p class="text-[7px] md:text-[8px] font-black text-zinc-400 uppercase tracking-widest leading-none">System Ready</p>
                                    </div>
                                    <div class="text-right text-zinc-900 dark:text-white">
                                        <p class="text-[18px] md:text-[24px] font-black italic leading-none tracking-tighter uppercase tabular-nums">ID: 001-CORE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="w-full max-w-7xl mx-auto px-6 md:px-10 py-6 md:py-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-[8px] md:text-[9px] font-black text-zinc-400 uppercase tracking-[0.2em] md:tracking-[0.4em] z-10 text-center sm:text-left">
                <p>&copy; 2026 DSM Core Division.</p>
                <div class="flex gap-4 md:gap-8">
                    <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Security</a>
                </div>
            </footer>
        </div>
    </body>
</html>