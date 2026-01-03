<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex flex-col text-left">
                <h2 class="font-black text-4xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Daftar <span class="text-zinc-300 dark:text-zinc-700">Personel</span>
                </h2>
                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Divisi: {{ Auth::user()->divisi }} / Unit Pemantauan Aktif
                </p>
            </div>
            
            <div class="bg-zinc-100 dark:bg-zinc-900/50 px-6 py-3 rounded-2xl border border-zinc-200 dark:border-zinc-800">
                <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none mb-1 text-left">Total Kru</p>
                <p class="text-xl font-black text-zinc-800 dark:text-zinc-100 leading-none text-left italic">{{ $karyawans->count() }} <span class="text-xs tracking-normal opacity-50">Personel Terdata</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($karyawans as $k)
                <div class="group relative bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 p-8 overflow-hidden transition-all duration-500 hover:border-emerald-500/50 hover:shadow-[0_30px_60px_rgba(0,0,0,0.1)]">
                    
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-bl-[5rem] -mr-10 -mt-10 transition-transform group-hover:scale-110 duration-500"></div>

                    <div class="relative flex flex-col items-start text-left">
                        <div class="flex justify-between w-full items-start mb-8">
                            <div class="w-16 h-16 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-2xl italic shadow-2xl shadow-zinc-500/20 group-hover:-rotate-3 transition-transform duration-500">
                                {{ substr($k->name, 0, 1) }}
                            </div>
                            <div class="text-right flex flex-col items-end gap-2">
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[8px] font-black uppercase tracking-widest border border-emerald-500/20">
                                    Unit Aktif
                                </span>
                                <div class="flex flex-col items-end">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase tracking-widest">Skor Disiplin</p>
                                    <p class="text-lg font-black text-zinc-800 dark:text-zinc-100 tabular-nums italic leading-none">{{ $k->poin }} <span class="text-[10px] opacity-50 not-italic">PTS</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-2xl font-black text-zinc-800 dark:text-white tracking-tighter leading-none mb-2 group-hover:text-emerald-500 transition-colors">
                                {{ $k->name }}
                            </h3>
                            <div class="flex items-center gap-2">
                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest italic">
                                    ID Agen: {{ str_pad($k->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                                <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest italic">
                                    Divisi {{ $k->divisi }}
                                </p>
                            </div>
                        </div>

                        <div class="w-full space-y-2 mb-8">
                            <div class="flex justify-between items-center text-[8px] font-black uppercase tracking-widest text-zinc-400">
                                <span>Status Integritas</span>
                                <span class="text-emerald-500">Terverifikasi</span>
                            </div>
                            <div class="h-1.5 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-zinc-900 dark:bg-emerald-500 rounded-full transition-all duration-1000 group-hover:w-full" style="width: 70%"></div>
                            </div>
                        </div>

                        <a href="{{ route('mentor.show_karyawan', $k->id) }}" 
                           class="w-full group/btn relative inline-flex items-center justify-center px-6 py-4 font-black text-[10px] uppercase tracking-[0.2em] text-white dark:text-black transition-all duration-300 bg-zinc-900 dark:bg-white rounded-2xl hover:bg-emerald-500 dark:hover:bg-emerald-400 hover:text-white active:scale-95 italic shadow-lg shadow-zinc-500/10">
                            Buka Laporan Intelijen
                            <svg class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($karyawans->isEmpty())
            <div class="text-center py-24 bg-zinc-50 dark:bg-zinc-900/30 rounded-[3rem] border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                <div class="w-20 h-20 bg-zinc-100 dark:bg-zinc-800 rounded-3xl flex items-center justify-center mx-auto mb-6 text-zinc-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h4 class="text-zinc-800 dark:text-zinc-200 font-black uppercase italic tracking-widest text-lg">Tidak Ada Personel</h4>
                <p class="text-zinc-400 font-bold uppercase tracking-[0.3em] text-[10px] mt-2">Belum ada unit yang terdaftar dalam sektor ini</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>