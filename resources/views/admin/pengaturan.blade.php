<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span>Sistem Inti</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Global Config</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Core <span class="text-zinc-300 dark:text-zinc-600">Settings</span>
                </h2>
            </div>

            <div class="flex items-center gap-6 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl">
                <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-zinc-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="flex flex-col items-end text-left">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Otoritas</span>
                    <span class="text-[11px] font-black text-zinc-800 dark:text-zinc-200 uppercase mt-1 italic">Administrator</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 text-left">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                <div class="bg-white dark:bg-zinc-900 rounded-[3rem] shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 15px 15px;"></div>
                    
                    <div class="p-10 relative z-10">
                        <header class="mb-10 flex flex-col gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-6 bg-zinc-900 dark:bg-white rounded-full"></div>
                                <h3 class="text-2xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter leading-none">Protokol Jendela</h3>
                            </div>
                            <p class="text-zinc-400 text-[10px] font-bold uppercase tracking-[0.4em] italic pl-5">Time-Based Access Configuration</p>
                        </header>

                        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6">
                            @csrf @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($pengaturans as $item)
                                    <div class="group relative space-y-3 p-6 bg-zinc-50/50 dark:bg-zinc-950/40 rounded-[2.5rem] border border-zinc-100 dark:border-zinc-800 transition-all hover:border-zinc-300 dark:hover:border-zinc-700">
                                        
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-emerald-500 rounded-r-full shadow-[2px_0_15px_rgba(16,185,129,0.3)]"></div>

                                        <div class="flex justify-between items-center px-2">
                                            <label class="text-[11px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-widest block leading-none">{{ $item->label }}</label>
                                            <span class="px-3 py-1 bg-emerald-500/10 rounded-full text-[8px] font-black text-emerald-500 uppercase tracking-widest">Waktu</span>
                                        </div>

                                        <div class="relative pl-2">
                                            <input type="time" 
                                                   name="{{ $item->key }}" 
                                                   value="{{ date('H:i', strtotime($item->value)) }}"
                                                   class="w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 font-black text-xl p-5 text-emerald-600 dark:text-emerald-400 focus:ring-2 focus:ring-zinc-500 focus:border-transparent transition-all shadow-inner tabular-nums">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-6 rounded-[2rem] font-black text-xs uppercase tracking-[0.4em] hover:scale-[1.02] active:scale-95 transition-all shadow-2xl italic">
                                    SINKRONISASI KONFIGURASI
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-10">
                    <div class="bg-zinc-900 dark:bg-zinc-100 rounded-[3rem] p-10 text-left shadow-2xl relative overflow-hidden group">
                         <div class="absolute right-0 top-0 w-32 h-32 bg-rose-500 opacity-10 rounded-full -translate-y-12 translate-x-12 blur-3xl"></div>
                         <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-6 text-left">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                <h3 class="text-xl font-black text-white dark:text-zinc-900 uppercase italic tracking-tighter">Daftarkan Hari Libur</h3>
                            </div>
                            <form action="{{ route('admin.libur.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <span class="text-[8px] font-black text-zinc-500 uppercase tracking-widest ml-4">Tanggal</span>
                                        <input type="date" name="tanggal" required class="w-full bg-white/5 dark:bg-zinc-200 border-white/10 dark:border-zinc-300 rounded-2xl p-4 text-white dark:text-zinc-900 font-bold text-sm focus:ring-rose-500">
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[8px] font-black text-zinc-500 uppercase tracking-widest ml-4">Keterangan</span>
                                        <input type="text" name="keterangan" placeholder="Nama Libur" required class="w-full bg-white/5 dark:bg-zinc-200 border-white/10 dark:border-zinc-300 rounded-2xl p-4 text-white dark:text-zinc-900 font-bold text-sm focus:ring-rose-500 text-left">
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] transition-all italic shadow-xl shadow-rose-500/20">
                                    Konfirmasi Libur Sistem
                                </button>
                            </form>
                         </div>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm flex flex-col">
                        <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/40 text-left flex justify-between items-center">
                            <h3 class="text-lg font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">Kalender Off</h3>
                            <span class="px-3 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-full text-[9px] font-black text-zinc-400 uppercase tracking-widest">Global Record</span>
                        </div>
                        <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                                    @forelse($hariLiburs as $libur)
                                    <tr class="group hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40 transition-all">
                                        <td class="px-8 py-5">
                                            <div class="flex flex-col text-left">
                                                <span class="text-sm font-black text-zinc-800 dark:text-zinc-200 italic tabular-nums leading-none mb-1">{{ $libur->tanggal->format('d M Y') }}</span>
                                                <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest">{{ $libur->tanggal->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5">
                                            <span class="text-[10px] font-black text-rose-500 dark:text-rose-400 uppercase tracking-widest italic">{{ $libur->keterangan }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <form action="{{ route('admin.libur.destroy', $libur->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal libur ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-16 text-center text-[10px] font-black text-zinc-300 dark:text-zinc-700 uppercase tracking-[0.4em] italic">Zero Holiday Records</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative bg-zinc-900/5 dark:bg-white/5 backdrop-blur-xl p-10 rounded-[3rem] border border-zinc-200 dark:border-white/10 text-left overflow-hidden">
                <div class="flex items-start gap-6 relative z-10">
                    <div class="p-4 bg-zinc-900 dark:bg-white rounded-2xl shadow-xl border border-white/20">
                        <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-left max-w-2xl text-left">
                        <h4 class="text-zinc-800 dark:text-white font-black uppercase text-[12px] tracking-widest mb-2 italic">Global Security Advisory</h4>
                        <p class="text-zinc-500 dark:text-zinc-400 text-[10px] font-bold leading-relaxed uppercase tracking-tighter">
                            Parameter Jendela menentukan otoritas masuk kru secara <span class="text-zinc-900 dark:text-white font-black underline">Real-Time</span>. Sistem ini kini menggunakan input waktu murni untuk mencegah kegagalan otorisasi. Pastikan sinkronisasi dilakukan dengan pengawasan penuh.
                        </p>
                    </div>
                </div>
            </div>
            
            <p class="text-center mt-10 text-[9px] font-black text-zinc-400 dark:text-zinc-600 uppercase tracking-[0.4em]">DSM CORE &bull; Config & Holiday Manager v3.0 Enterprise</p>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); }
        
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="date"]::-webkit-calendar-picker-indicator {
            background-color: transparent;
            cursor: pointer;
            filter: invert(0.5);
            padding: 10px;
        }
        .dark input[type="time"]::-webkit-calendar-picker-indicator,
        .dark input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1); }
    </style>
</x-app-layout>