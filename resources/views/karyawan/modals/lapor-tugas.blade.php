<div x-show="openDetailTugas" class="fixed inset-0 z-[200] flex items-center justify-center p-4 md:p-8" x-cloak>
    <div class="absolute inset-0 bg-zinc-950/95 backdrop-blur-2xl" @click="openDetailTugas = false" 
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
    
    <div class="bg-white dark:bg-zinc-900 rounded-[3rem] max-w-6xl w-full max-h-[90vh] overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl flex flex-col md:flex-row"
        x-transition:enter="ease-out duration-500 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-10" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
        
        <div class="w-full md:w-1/2 bg-zinc-50 dark:bg-zinc-950 p-10 border-r border-zinc-100 dark:border-zinc-800 overflow-y-auto custom-scrollbar text-left">
            <div class="flex justify-between items-start mb-10">
                <div class="text-left">
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.4em] mb-2 block">Mission Briefing</span>
                    <h3 class="text-3xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-tight" x-text="selectedTugas?.judul"></h3>
                </div>
            </div>

            <div class="space-y-8">
                <div class="text-left">
                    <p class="text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-4 border-b border-zinc-200 dark:border-zinc-800 pb-2">Deskripsi Tugas & Instruksi:</p>
                    <div class="text-sm font-medium text-zinc-600 dark:text-zinc-300 leading-relaxed italic whitespace-pre-line bg-white dark:bg-zinc-900/50 p-6 rounded-3xl border border-zinc-100 dark:border-zinc-800 shadow-inner" x-text="selectedTugas?.deskripsi"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-zinc-100 dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 text-left">
                        <p class="text-[8px] font-black text-zinc-400 uppercase mb-1">Mulai</p>
                        <p class="text-[10px] font-bold dark:text-zinc-200" x-text="selectedTugas?.tgl_mulai ? new Date(selectedTugas.tgl_mulai).toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'}) : '-'"></p>
                    </div>
                    <div class="p-4 bg-rose-500/5 rounded-2xl border border-rose-500/20 text-left">
                        <p class="text-[8px] font-black text-rose-500 uppercase mb-1">Deadline</p>
                        <p class="text-[10px] font-bold text-rose-500" x-text="selectedTugas?.tgl_selesai ? new Date(selectedTugas.tgl_selesai).toLocaleString('id-ID', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'}) : '-'"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 overflow-y-auto bg-white dark:bg-zinc-900">
            <div class="flex justify-between items-center mb-10 text-left">
                <div class="text-left">
                    <h4 class="text-xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter">Laporan Penyelesaian</h4>
                    <p class="text-[10px] font-black text-zinc-400 uppercase tracking-widest mt-1">Sinkronisasi hasil kerja ke Mentor</p>
                </div>
                <button @click="openDetailTugas = false" class="w-10 h-10 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 rounded-full text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all">✕</button>
            </div>

            <form action="{{ route('tugas.kumpul') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
                @csrf
                <input type="hidden" name="tugas_id" :value="selectedTugas?.id">

                <div class="text-left">
                    <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 block mb-2">Tautan Dokumen (Google Drive/Link)</label>
                    <input type="url" name="link_tautan" placeholder="https://..." class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                </div>

                <div class="text-left">
                    <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 block mb-2">Unggah File Pendukung (Opsional)</label>
                    <input type="file" name="file_hasil" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-zinc-900 file:text-white dark:file:bg-white dark:file:text-black">
                </div>

                <div class="text-left">
                    <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 block mb-2">Catatan Progres</label>
                    <textarea name="pesan_karyawan" rows="4" required placeholder="Jelaskan detail progres yang Anda kerjakan..." class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-2 focus:ring-emerald-500 transition-all outline-none text-left"></textarea>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] italic transition-all hover:scale-[1.02] shadow-xl">KIRIM LAPORAN SEKARANG</button>
                </div>
            </form>
        </div>
    </div>
</div>

