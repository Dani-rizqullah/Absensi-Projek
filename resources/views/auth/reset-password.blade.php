<x-guest-layout>
    <div class="text-left mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6">
        <h2 class="text-3xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Rekonfigurasi Kunci') }}
        </h2>
        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed text-left">
            {{ __('Otorisasi diterima. Masukkan kredensial baru untuk memulihkan akses ke sistem kendali.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-2 text-left">
            <label for="email" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest text-left">
                {{ __('Email Personel') }}
            </label>
            <input id="email" name="email" type="email" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 tabular-nums" 
                value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            
            @if($errors->has('email'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="space-y-2 text-left">
            <label for="password" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest text-left">
                {{ __('Kredensial Baru') }}
            </label>
            <input id="password" name="password" type="password" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                required autocomplete="new-password" placeholder="••••••••" />
            
            @if($errors->has('password'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="space-y-2 text-left">
            <label for="password_confirmation" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest text-left">
                {{ __('Konfirmasi Kredensial') }}
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                required autocomplete="new-password" placeholder="••••••••" />
            
            @if($errors->has('password_confirmation'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-90 active:scale-[0.98] transition-all italic shadow-2xl shadow-zinc-500/10">
                {{ __('Terapkan Kredensial Baru') }}
            </button>
        </div>
    </form>
</x-guest-layout>