<section class="text-left">
    <header class="mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6 text-left">
        <h2 class="text-xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Protokol Keamanan') }}
        </h2>

        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed text-left">
            {{ __('Pastikan akun Anda menggunakan kredensial enkripsi yang kuat untuk menjaga integritas data.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8 text-left">
        @csrf
        @method('put')

        <div class="space-y-2 text-left">
            <label for="update_password_current_password" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Kredensial Saat Ini') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                autocomplete="current-password" placeholder="••••••••" />
            
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-xs text-rose-500 font-bold italic lowercase italic">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div class="space-y-2 text-left">
            <label for="update_password_password" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Kredensial Baru') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                autocomplete="new-password" placeholder="••••••••" />
            
            @if($errors->updatePassword->get('password'))
                <p class="mt-2 text-xs text-rose-500 font-bold italic lowercase italic">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div class="space-y-2 text-left">
            <label for="update_password_password_confirmation" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Konfirmasi Kredensial Baru') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                autocomplete="new-password" placeholder="••••••••" />
            
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-xs text-rose-500 font-bold italic lowercase italic">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-4 text-left">
            <button type="submit" class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-80 active:scale-95 transition-all italic shadow-xl">
                {{ __('Perbarui Kredensial') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-500"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                    <p class="text-[10px] font-black uppercase tracking-widest italic">{{ __('Kredensial Terverifikasi') }}</p>
                </div>
            @endif
        </div>
    </form>
</section>