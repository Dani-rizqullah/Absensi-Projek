<x-guest-layout>
    <div class="text-left mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6">
        <h2 class="text-3xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Inisiasi Akun') }}
        </h2>
        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed">
            {{ __('Daftarkan identitas kru baru untuk mengakses konsol operasional.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="name" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Nama Personel') }}
            </label>
            <input id="name" name="name" type="text" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Lengkap..." />
            @if($errors->get('name'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="email" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Email Operasional') }}
            </label>
            <input id="email" name="email" type="email" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 tabular-nums" 
                value="{{ old('email') }}" required autocomplete="username" placeholder="email@perusahaan.com" />
            @if($errors->get('email'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="divisi" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Sektor Unit / Divisi') }}
            </label>
            <div class="relative">
                <select id="divisi" name="divisi" 
                    class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 appearance-none cursor-pointer" required>
                    <option value="" disabled selected>-- Pilih Divisi Anda --</option>
                    <option value="Jurnalis" {{ old('divisi') == 'Jurnalis' ? 'selected' : '' }}>Jurnalis / Wartawan</option>
                    <option value="Web Developer" {{ old('divisi') == 'Web Developer' ? 'selected' : '' }}>Web Developer</option>
                    <option value="UI/UX Design" {{ old('divisi') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                    <option value="Videographer/Editor" {{ old('divisi') == 'Videographer/Editor' ? 'selected' : '' }}>Videographer / Editor</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-400">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                </div>
            </div>
            @if($errors->get('divisi'))
                <p class="mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-wider ml-2">{{ $errors->first('divisi') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="password" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                    {{ __('Kredensial Password') }}
                </label>
                <input id="password" name="password" type="password" 
                    class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                    required autocomplete="new-password" placeholder="••••••••" />
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                    {{ __('Konfirmasi Kredensial') }}
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                    class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                    required autocomplete="new-password" placeholder="••••••••" />
            </div>
        </div>

        @if($errors->has('password'))
            <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-wider ml-2">{{ $errors->first('password') }}</p>
        @endif

        <div class="flex flex-col gap-4 pt-6">
            <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-90 active:scale-[0.98] transition-all italic shadow-2xl shadow-zinc-500/10">
                {{ __('Otorisasi & Daftar Akun') }}
            </button>

            <div class="text-center">
                <a class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest hover:text-zinc-800 dark:hover:text-white transition-colors" href="{{ route('login') }}">
                    {{ __('Sudah terdaftar dalam sistem? Masuk') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>