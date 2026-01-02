<section class="text-left">
    <header class="mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6">
        <h2 class="text-xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Informasi Identitas') }}
        </h2>
        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed">
            {{ __("Perbarui data kredensial dan unit operasional akun Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <label for="name" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Nama Personel') }}
            </label>
            <input id="name" name="name" type="text" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <p class="mt-2 text-xs text-rose-500 font-bold italic lowercase italic">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="email" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                {{ __('Email Operasional') }}
            </label>
            <input id="email" name="email" type="email" 
                class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 tabular-nums" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <p class="mt-2 text-xs text-rose-500 font-bold italic lowercase italic">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="divisi" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                    {{ __('Sektor Unit / Divisi') }}
                </label>
                <div class="relative">
                    <select id="divisi" name="divisi" 
                        class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 appearance-none cursor-pointer" 
                        required>
                        <option value="" disabled>-- Pilih Divisi --</option>
                        <option value="Jurnalis" {{ old('divisi', $user->divisi) == 'Jurnalis' ? 'selected' : '' }}>Jurnalis / Wartawan</option>
                        <option value="Web Developer" {{ old('divisi', $user->divisi) == 'Web Developer' ? 'selected' : '' }}>Web Developer</option>
                        <option value="UI/UX Design" {{ old('divisi', $user->divisi) == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                        <option value="Videographer/Editor" {{ old('divisi', $user->divisi) == 'Videographer/Editor' ? 'selected' : '' }}>Videographer / Editor</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-400">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label for="no_wa" class="block ml-2 text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                    {{ __('Jalur WhatsApp (Nudge)') }}
                </label>
                <input id="no_wa" name="no_wa" type="text" 
                    class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 tabular-nums" 
                    value="{{ old('no_wa', $user->no_wa) }}" placeholder="08123456789" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-10 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-80 active:scale-95 transition-all italic shadow-xl">
                {{ __('Otorisasi Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-[10px] font-black uppercase text-emerald-500 italic tracking-widest">
                    {{ __('Identitas Diperbarui') }}
                </p>
            @endif
        </div>
    </form>
</section>