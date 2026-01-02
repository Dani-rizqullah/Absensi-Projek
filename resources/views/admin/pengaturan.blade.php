<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
                
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
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Otoritas</span>
                    <span class="text-[11px] font-black text-zinc-800 dark:text-zinc-200 uppercase mt-1 italic text-left">Administrator</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden relative group transition-all duration-500">
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 12px 12px;"></div>

                <div class="p-10 relative z-10 text-left">
                    <div class="mb-10 flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-8">
                        <div class="text-left">
                            <h3 class="text-2xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter leading-none text-left text-left">Operational Time</h3>
                            <p class="text-zinc-400 text-[10px] font-bold uppercase tracking-[0.4em] mt-2 italic text-left text-left">Global Attendance Rule</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center text-zinc-400 border border-zinc-200 dark:border-zinc-800 shadow-inner">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-10">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                            <div class="space-y-4 text-left">
                                <label class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase ml-2 tracking-[0.2em] block text-left text-left">Sinyal Masuk</label>
                                <div class="relative group text-left">
                                    <input type="time" name="jam_masuk" value="{{ \Carbon\Carbon::parse($jam_masuk)->format('H:i') }}"
                                        class="w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-xl p-5 text-zinc-800 dark:text-white focus:ring-zinc-500 focus:border-zinc-500 transition-all shadow-inner tabular-nums">
                                </div>
                            </div>

                            <div class="space-y-4 text-left">
                                <label class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase ml-2 tracking-[0.2em] block text-left">Sinyal Pulang</label>
                                <div class="relative group text-left">
                                    <input type="time" name="jam_pulang" value="{{ \Carbon\Carbon::parse($jam_pulang)->format('H:i') }}"
                                        class="w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-xl p-5 text-zinc-800 dark:text-white focus:ring-zinc-500 focus:border-zinc-500 transition-all shadow-inner tabular-nums">
                                </div>
                            </div>
                        </div>

                        <div class="bg-zinc-900 dark:bg-white p-7 rounded-3xl flex items-start gap-5 shadow-xl transition-all border border-zinc-800 dark:border-zinc-200 text-left">
                            <div class="p-3 bg-white/10 dark:bg-zinc-100 rounded-xl">
                                <svg class="w-5 h-5 text-white dark:text-zinc-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-white dark:text-zinc-900 font-black uppercase text-[10px] tracking-widest mb-1 italic">Impact Awareness</h4>
                                <p class="text-zinc-400 dark:text-zinc-500 text-[9px] font-bold leading-relaxed uppercase tracking-tighter">
                                    Format input mengikuti preferensi waktu browser. Perubahan ini akan segera memperbarui parameter countdown pada konsol kru secara real-time.
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-80 active:scale-[0.98] transition-all shadow-2xl shadow-zinc-500/10 italic">
                            Otorisasi Perubahan Aturan
                        </button>
                    </form>
                </div>
                
                <div class="h-2 w-full flex">
                    <div class="h-full w-1/3 bg-emerald-500"></div>
                    <div class="h-full w-1/3 bg-amber-500"></div>
                    <div class="h-full w-1/3 bg-rose-500"></div>
                </div>
            </div>
            
            <p class="text-center mt-10 text-[9px] font-black text-zinc-400 uppercase tracking-[0.4em]">DSM CORE &bull; Integrated Settings Manager</p>
        </div>
    </div>

    <style>
        input[type="time"]::-webkit-calendar-picker-indicator {
            display: block !important;
            background-color: transparent;
            cursor: pointer;
            filter: invert(0.5);
            padding: 5px;
            transition: all 0.3s;
        }
        .dark input[type="time"]::-webkit-calendar-picker-indicator { filter: invert(1); }
    </style>
</x-app-layout>