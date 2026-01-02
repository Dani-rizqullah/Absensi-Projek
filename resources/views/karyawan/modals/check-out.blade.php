<div x-show="openModalKeluar" class="fixed inset-0 z-[210] flex items-center justify-center p-4" x-cloak>
    <div class="fixed inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openModalKeluar = false"></div>
    
    <div class="bg-white dark:bg-zinc-900 rounded-[3rem] shadow-2xl max-w-lg w-full overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 transition-all"
         x-transition:enter="ease-out duration-300 transform" 
         x-transition:enter-start="opacity-0 translate-y-8 scale-95">
        
        <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/40">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </div>
                <div class="text-left">
                    <h3 class="text-2xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">Terminate Duty</h3>
                    <p class="text-zinc-400 text-[9px] font-black uppercase tracking-[0.3em] mt-1">Finalizing daily operational report</p>
                </div>
            </div>
        </div>

        <form action="{{ route('absen.keluar') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 space-y-6 text-left">
            @csrf
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase ml-2 tracking-widest block text-left">Daily Activity Log (Min. 20 Chars)</label>
                <textarea name="kegiatan_harian" required minlength="20" rows="3"
                    class="w-full rounded-[1.5rem] border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-zinc-500 focus:border-zinc-500 font-medium text-sm italic text-zinc-700 dark:text-zinc-300 placeholder-zinc-300 dark:placeholder-zinc-700 shadow-inner"
                    placeholder="Describe your missions today..."></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase ml-2 tracking-widest block text-left">Progress & Obstacles</label>
                <textarea name="progres_perubahan" required rows="2"
                    class="w-full rounded-[1.5rem] border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 focus:ring-zinc-500 focus:border-zinc-500 font-medium text-sm italic text-zinc-700 dark:text-zinc-300 placeholder-zinc-300 dark:placeholder-zinc-700 shadow-inner"
                    placeholder="Any technical issues or milestones?"></textarea>
            </div>

            <div class="space-y-2 text-left">
                <label class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase ml-2 tracking-widest block text-left">Visual Verification</label>
                <div class="relative group text-left">
                    <input type="file" name="foto_bukti" required accept="image/*"
                        class="w-full text-xs text-zinc-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-zinc-900 dark:file:bg-white file:text-white dark:file:text-zinc-900 hover:file:opacity-80 cursor-pointer bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700 p-2 shadow-inner transition-all">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-6">
                <button type="button" @click="openModalKeluar = false" 
                    class="py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 font-black text-[10px] uppercase rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all active:scale-95">
                    Abort
                </button>
                <button type="submit" 
                    class="py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-black text-[10px] uppercase rounded-2xl shadow-2xl shadow-zinc-500/20 hover:opacity-90 transition-all italic active:scale-95 tracking-widest">
                    Submit & Finish
                </button>
            </div>
        </form>

        <div class="h-1.5 w-full bg-zinc-100 dark:bg-zinc-800 flex">
            <div class="h-full w-1/2 bg-amber-500"></div>
            <div class="h-full w-1/2 bg-rose-500"></div>
        </div>
    </div>
</div>