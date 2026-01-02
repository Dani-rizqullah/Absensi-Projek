<x-guest-layout>
    <div class="text-left mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6">
        <h2 class="text-3xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Pemulihan Akses') }}
        </h2>
        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed text-left">
            {{ __('Kehilangan kunci akses? Masukkan email personel Anda untuk menerima pancaran tautan rekonfigurasi password.') }}
        </p>
    </div>

    @if (session('status'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/10 flex items-center gap-3">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <p class="text-[9px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-[0.2em] italic">
                {{ session('status') }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div class="space-y-2 text-left">
            <label for="email" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest text-left">
                {{ __('Email Personel') }}
            </label>
            <input id="email" name="email" type="email" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 tabular-nums" 
                value="{{ old('email') }}" required autofocus placeholder="personel@dsm.com" />
            
            @if($errors->has('email'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="flex flex-col gap-4 pt-4">
            <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-90 active:scale-[0.98] transition-all italic shadow-2xl shadow-zinc-500/10">
                {{ __('Pancarkan Tautan Reset') }}
            </button>

            <div class="text-center">
                <a class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest hover:text-zinc-800 dark:hover:text-white transition-colors" href="{{ route('login') }}">
                    {{ __('Kembali ke Gerbang Masuk') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>