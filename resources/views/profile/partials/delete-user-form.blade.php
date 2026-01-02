<section class="text-left space-y-8" x-data="{ openDeleteModal: false }">
    <header class="mb-8 border-b border-rose-100 dark:border-rose-900/30 pb-6 text-left">
        <h2 class="text-xl font-black text-rose-600 dark:text-rose-500 uppercase italic tracking-tighter">
            {{ __('Terminasi Akun') }}
        </h2>

        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed text-left">
            {{ __('Peringatan: Penghapusan akun bersifat permanen. Seluruh data operasional dan riwayat poin akan dieliminasi dari sistem secara total.') }}
        </p>
    </header>

    <button
        type="button"
        @click="openDeleteModal = true"
        class="bg-rose-500/10 hover:bg-rose-500 text-rose-600 hover:text-white px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] transition-all italic border border-rose-200 dark:border-rose-500/20 active:scale-95 shadow-xl shadow-rose-500/5"
    >
        {{ __('Inisiasi Penghapusan') }}
    </button>

    <div 
        x-show="openDeleteModal" 
        class="fixed inset-0 z-[500] flex items-center justify-center p-4 overflow-y-auto"
        x-cloak
    >
        <div 
            x-show="openDeleteModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="openDeleteModal = false"
            class="fixed inset-0 bg-zinc-950/90 backdrop-blur-sm"
        ></div>

        <div 
            x-show="openDeleteModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-2xl max-w-lg w-full overflow-hidden relative z-10"
        >
            <form method="post" action="{{ route('profile.destroy') }}" class="p-10 text-left">
                @csrf
                @method('delete')

                <div class="absolute top-0 left-0 w-full h-1.5 bg-rose-500"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-500 flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="text-left">
                        <h2 class="text-2xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter leading-none">
                            {{ __('Konfirmasi Final') }}
                        </h2>
                        <p class="text-zinc-400 text-[9px] font-black uppercase tracking-[0.3em] mt-1">Otorisasi penghapusan data diperlukan</p>
                    </div>
                </div>

                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 italic leading-relaxed mb-8">
                    {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan kredensial akses (password) Anda untuk mengonfirmasi bahwa Anda benar-benar ingin melikuidasi identitas digital ini.') }}
                </p>

                <div class="space-y-2">
                    <label for="password" class="sr-only">{{ __('Kredensial Password') }}</label>
                    <input 
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4"
                        placeholder="{{ __('Konfirmasi Password Anda') }}"
                        required
                    />

                    @if($errors->userDeletion->get('password'))
                        <p class="mt-2 text-xs text-rose-500 font-bold italic">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-10 flex gap-4">
                    <button 
                        type="button" 
                        @click="openDeleteModal = false" 
                        class="flex-1 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 font-black text-[10px] uppercase rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all active:scale-95 italic tracking-widest"
                    >
                        {{ __('Batalkan') }}
                    </button>

                    <button 
                        type="submit" 
                        class="flex-1 py-4 bg-rose-600 text-white font-black text-[10px] uppercase rounded-2xl shadow-xl shadow-rose-500/20 hover:bg-rose-500 transition-all active:scale-95 italic tracking-widest"
                    >
                        {{ __('Likuidasi Akun') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>