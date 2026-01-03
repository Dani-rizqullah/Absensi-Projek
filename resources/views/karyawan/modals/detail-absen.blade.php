<div x-show="openDetail" class="fixed inset-0 z-[150] flex items-center justify-center p-4 md:p-6" x-cloak>
    <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openDetail = false"></div>
    <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] md:rounded-[3.5rem] max-w-4xl w-full max-h-[90vh] overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 flex flex-col shadow-2xl transition-all" 
         x-show="openDetail" x-transition:enter="ease-out duration-500 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8">
        
        <div class="p-6 md:p-10 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/50">
            <div class="text-left">
                <h3 class="text-xl md:text-3xl font-black uppercase italic dark:text-white text-zinc-800 leading-none tracking-tighter" x-text="selectedData?.user_name"></h3>
                <div class="flex items-center gap-3 mt-3">
                    <span :class="{
                        'bg-emerald-500/10 text-emerald-500 border-emerald-500/20': selectedData?.status === 'Hadir' || selectedData?.status === 'Selesai',
                        'bg-amber-500/10 text-amber-500 border-amber-500/20': selectedData?.status === 'Terlambat',
                        'bg-rose-500/10 text-rose-500 border-rose-500/20': ['Sakit', 'Izin', 'Alpha'].includes(selectedData?.status)
                    }" class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border" x-text="selectedData?.status"></span>
                    <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] tabular-nums" x-text="selectedData?.tanggal"></p>
                </div>
            </div>
            <button @click="openDetail = false" class="w-12 h-12 flex items-center justify-center bg-white dark:bg-zinc-800 text-zinc-400 rounded-2xl hover:text-zinc-900 dark:hover:text-white transition-all border border-zinc-100 dark:border-zinc-700 shadow-sm text-xl font-bold">✕</button>
        </div>

        <div class="p-6 md:p-10 overflow-y-auto custom-scrollbar bg-white dark:bg-zinc-900">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                
                <div class="space-y-8">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-[1.5rem] border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <p class="text-[8px] font-black text-zinc-400 uppercase mb-2 tracking-widest">Entry</p>
                            <p class="text-lg font-black dark:text-white tabular-nums leading-none" x-text="selectedData?.jam_masuk || '--:--'"></p>
                        </div>
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-[1.5rem] border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <p class="text-[8px] font-black text-zinc-400 uppercase mb-2 tracking-widest">Exit</p>
                            <p class="text-lg font-black dark:text-white tabular-nums leading-none" x-text="selectedData?.jam_keluar || '--:--'"></p>
                        </div>
                        <div class="p-4 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-[1.5rem] shadow-xl">
                            <p class="text-[8px] font-black opacity-50 dark:opacity-40 uppercase mb-2 tracking-widest text-left">Duration</p>
                            <p class="text-[11px] font-black italic text-emerald-400 dark:text-emerald-600 tabular-nums leading-none" x-text="calculateDuration(selectedData?.jam_masuk, selectedData?.jam_keluar)"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="p-6 bg-zinc-50 dark:bg-zinc-800/50 rounded-[2rem] border border-zinc-200 dark:border-zinc-700 shadow-inner text-left">
                            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mb-4 italic">Log Kegiatan Harian</p>
                            <p class="text-sm font-bold text-zinc-700 dark:text-zinc-200 italic leading-relaxed" x-text="selectedData?.kegiatan_harian || 'Tidak ada catatan aktivitas.'"></p>
                        </div>
                        <div class="p-6 bg-zinc-900 text-white rounded-[2rem] shadow-xl border border-white/5 text-left">
                            <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-4 italic text-emerald-500">Pembaruan Progres</p>
                            <p class="text-sm font-medium italic text-zinc-300 leading-relaxed" x-text="selectedData?.progres_perubahan || 'Progres operasional stabil.'"></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-4">Visual Evidence</p>
                    <div class="aspect-[4/3] bg-zinc-200 dark:bg-zinc-800 rounded-[2.5rem] overflow-hidden border-4 border-white dark:border-zinc-700 shadow-2xl group relative">
                        <template x-if="selectedData?.foto_bukti">
                            <img :src="'/storage/' + selectedData.foto_bukti" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-105">
                        </template>
                        <div x-show="!selectedData?.foto_bukti" class="w-full h-full flex flex-col items-center justify-center italic text-zinc-400 text-[10px] font-black uppercase text-center gap-3">
                            <svg class="w-12 h-12 opacity-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Sinyal Bukti Tidak Ditemukan
                        </div>
                    </div>
                    
                    <div class="p-6 rounded-[2rem] border border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900 shadow-inner">
                        <div class="text-left">
                            <p class="text-[8px] font-black text-zinc-400 uppercase leading-none mb-1">Status Sinyal</p>
                            <p class="text-[10px] font-black text-zinc-800 dark:text-white uppercase tracking-widest italic" x-text="selectedData?.alasan_lupa_absen ? 'MANUAL BYPASS' : 'ENCRYPTED LOG'"></p>
                        </div>
                        <div class="h-8 w-[1px] bg-zinc-200 dark:bg-zinc-700"></div>
                        <div class="text-right">
                            <p class="text-[8px] font-black text-zinc-400 uppercase leading-none mb-1">Unit</p>
                            <p class="text-[10px] font-black text-zinc-800 dark:text-white uppercase tracking-widest" x-text="selectedData?.user_divisi"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/40">
            <button @click="openDetail = false" class="w-full py-5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-black text-[10px] uppercase rounded-2xl tracking-[0.3em] transition-all hover:scale-[1.01] italic shadow-xl">
                Tutup Konsol Detail
            </button>
        </div>
    </div>
</div>