<x-guest-layout>
    <div class="text-left mb-8 border-b border-zinc-100 dark:border-zinc-800 pb-6">
        <h2 class="text-3xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic tracking-tighter">
            {{ __('Verifikasi Identitas') }}
        </h2>
        <p class="mt-2 text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] leading-relaxed text-left">
            {{ __('Terima kasih telah bergabung. Sinyal verifikasi telah dikirim ke email Anda. Aktifkan akun Anda melalui tautan tersebut untuk melanjutkan.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/10 flex items-center gap-3">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <p class="text-[9px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-[0.2em] italic">
                {{ __('Tautan verifikasi baru telah dipancarkan ke alamat email Anda.') }}
            </p>
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:opacity-90 active:scale-[0.98] transition-all italic shadow-2xl shadow-zinc-500/10">
                {{ __('Kirim Ulang Sinyal Verifikasi') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest hover:text-zinc-800 dark:hover:text-white transition-colors underline decoration-2 underline-offset-4">
                {{ __('Putuskan Sesi (Keluar)') }}
            </button>
        </form>
    </div>
</x-guest-layout>