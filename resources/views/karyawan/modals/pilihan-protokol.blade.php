<div x-show="openPilihan" class="fixed inset-0 z-[250] flex items-end md:items-center justify-center p-0 md:p-6" x-cloak>
    <div class="absolute inset-0 bg-zinc-950/95 backdrop-blur-md" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         @click="openPilihan = false"></div>

    <div class="bg-white dark:bg-zinc-900 rounded-t-[3rem] md:rounded-[3.5rem] max-w-md w-full p-8 md:p-12 z-10 relative border-t md:border border-zinc-200 dark:border-zinc-800 shadow-[0_-20px_50px_rgba(0,0,0,0.5)] transition-all" 
        x-show="openPilihan" 
        x-transition:enter="ease-out duration-300 transform" 
        x-transition:enter-start="translate-y-full md:scale-95 md:translate-y-0" 
        x-transition:enter-end="translate-y-0 md:scale-100">
        
        <div class="mb-10 text-left relative">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_#10b981]"></div>
                <h3 class="text-2xl font-black uppercase italic text-zinc-900 dark:text-white tracking-tighter leading-none">Pilih Protokol</h3>
            </div>
            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-[0.4em] leading-none">Data Ganda Terdeteksi di Sektor Ini</p>
        </div>

        <div class="space-y-4 text-left">
            <template x-if="selectedData">
                <button @click="openDetail = true; openPilihan = false" 
                        class="w-full flex items-center justify-between p-6 bg-emerald-500/5 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-[2rem] border border-emerald-500/20 text-left transition-all hover:bg-emerald-500 hover:text-white group italic shadow-sm active:scale-95">
                    <div class="flex items-center gap-4">
                        <div class="w-3 h-3 rounded-full bg-current animate-pulse"></div>
                        <span class="font-black text-xs uppercase tracking-widest leading-none">Buka_Log Kehadiran</span>
                    </div>
                    <svg class="w-4 h-4 opacity-30 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </template>
            
            <template x-for="(t, index) in tugasPilihan" :key="t.id">
                <button @click="selectedTugas = t; openDetailTugas = true; openPilihan = false" 
                        class="w-full flex items-center justify-between p-6 bg-zinc-50 dark:bg-zinc-950 hover:bg-zinc-900 dark:hover:bg-white hover:text-white dark:hover:text-zinc-900 rounded-[2rem] border border-zinc-100 dark:border-zinc-800 text-left transition-all italic group shadow-sm active:scale-95">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div :class="'w-3 h-3 rounded-full ' + ['bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-rose-500'][index % 5]"></div>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-zinc-400 uppercase tracking-widest group-hover:text-current">Transmit_Data</span>
                            <span class="font-bold text-sm truncate uppercase group-hover:text-current" x-text="t.judul"></span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 opacity-10 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </template>
        </div>

        <button @click="openPilihan = false" 
                class="w-full mt-10 py-5 text-[10px] font-black uppercase text-zinc-400 hover:text-rose-500 tracking-[0.5em] text-center transition-colors">
            BATALKAN_KONEKSI
        </button>
    </div>
</div>