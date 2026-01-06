<nav x-data="{ open: false, profileOpen: false }" 
     class="sticky top-0 z-[60] bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-900 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex justify-between h-20">
            
            <div class="flex items-center gap-12">
                <a href="{{ route('dashboard') }}" class="group flex items-center shrink-0 py-2">
                    {{-- overflow-visible agar logo bisa sedikit keluar dari garis nav jika perlu --}}
                    <div class="w-28 h-28 flex items-center justify-center transition-all group-hover:scale-110 active:scale-95 duration-300 overflow-visible">
                        
                        {{-- PEMANGGILAN LOGO PNG --}}
                        <img src="{{ asset('images/logo.png') }}" 
                            alt="Logo" 
                            {{-- h-full & w-full memastikan gambar mengisi kontainer besar --}}
                            class="h-full w-full object-contain transition-all duration-500 
                                    {{-- Mode Terang: Jadi Hitam Pekat --}}
                                    grayscale brightness-0 
                                    {{-- Mode Gelap: Jadi Putih Bersih --}}
                                    dark:invert">
                                    
                    </div>
                </a>

                {{-- Menu Navigasi Tetap Sama --}}
                <div class="hidden sm:flex items-center gap-1">
                    @php
                        $navItems = [['route' => 'dashboard', 'label' => 'Ringkasan']];
                        if(Auth::user()->role === 'karyawan') { $navItems[] = ['route' => 'tugas.index', 'label' => 'Pusat Misi']; }
                        if(Auth::user()->role === 'mentor') { 
                            $navItems[] = ['route' => 'mentor.dashboard', 'label' => 'Pusat Komando'];
                            $navItems[] = ['route' => 'mentor.personnel', 'label' => 'Personel'];
                        }
                        if(Auth::user()->role === 'admin') {
                            $navItems[] = ['route' => 'admin.monitoring', 'label' => 'Pemantauan'];
                            $navItems[] = ['route' => 'admin.tugas.index', 'label' => 'Overwatch'];
                            $navItems[] = ['route' => 'admin.laporan', 'label' => 'Pelaporan'];
                            $navItems[] = ['route' => 'admin.users.index', 'label' => 'Otoritas'];
                            $navItems[] = ['route' => 'admin.pengaturan.index', 'label' => 'Pengaturan'];
                        }
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" 
                            class="px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-[0.2em] transition-all duration-200 
                            {{ request()->routeIs($item['route']) 
                                ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-900' 
                                : 'text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-900/50' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Bagian Kanan (Theme Toggle & Profile) Tetap Sama --}}
            <div class="hidden sm:flex items-center gap-6">
                <button @click="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-xl text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-all active:scale-90">
                    <svg x-show="document.documentElement.classList.contains('dark')" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                    <svg x-show="!document.documentElement.classList.contains('dark')" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                <div class="relative leading-none">
                    <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl border border-transparent hover:border-zinc-100 dark:hover:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-all group leading-none">
                        <div class="text-right hidden lg:block leading-none">
                            <p class="text-[10px] font-bold dark:text-white leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[8px] font-bold text-zinc-400 uppercase tracking-tighter mt-1 italic leading-none">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-zinc-900 dark:bg-white text-white dark:text-black flex items-center justify-center text-[10px] font-black leading-none">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div x-show="profileOpen" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute right-0 mt-3 w-56 bg-white dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-900 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden z-[70] text-left">
                        <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-900 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <p class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest leading-none text-left">Masuk sebagai</p>
                            <p class="text-[10px] font-bold text-zinc-800 dark:text-zinc-200 truncate mt-1 leading-none text-left">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="p-2 text-left">
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-2.5 text-[10px] font-bold uppercase tracking-widest text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900 rounded-lg transition-all leading-none text-left">Pengaturan Akun</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2.5 text-[10px] font-bold uppercase tracking-widest text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-all leading-none">Akhiri Sesi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sm:hidden flex items-center text-left leading-none">
                <button @click="open = !open" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-all text-zinc-900 dark:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" d="M4 8h16M4 16h16" stroke-width="2.5" stroke-linecap="round"/>
                        <path x-show="open" d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Menu Mobile --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         class="sm:hidden bg-white dark:bg-zinc-950 border-t border-zinc-100 dark:border-zinc-900 px-8 py-12 space-y-10 shadow-2xl text-left">
        <div class="grid gap-6 text-left">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" class="text-3xl font-black tracking-tighter italic uppercase text-left {{ request()->routeIs($item['route']) ? 'text-zinc-900 dark:text-white' : 'text-zinc-300 dark:text-zinc-800' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>