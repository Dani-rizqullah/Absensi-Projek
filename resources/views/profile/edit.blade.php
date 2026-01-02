<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span>Personel</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Pusat Identitas</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Profil <span class="text-zinc-300 dark:text-zinc-600">Kru</span>
                </h2>
            </div>

            <div class="flex items-center gap-6 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl">
                <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-zinc-400 text-left">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex flex-col items-end text-left">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Otoritas</span>
                    <span class="text-[11px] font-black text-zinc-800 dark:text-zinc-200 uppercase mt-1 italic">
                        {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Kru Operasional' }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-8">
            
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden relative group transition-all duration-500">
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 12px 12px;"></div>
                <div class="p-8 sm:p-12 relative z-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden relative group transition-all duration-500">
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 12px 12px;"></div>
                <div class="p-8 sm:p-12 relative z-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden relative group transition-all duration-500">
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 12px 12px;"></div>
                <div class="p-8 sm:p-12 relative z-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
                <div class="h-1.5 w-full bg-rose-500/20"></div>
            </div>
            
        </div>
    </div>
</x-app-layout>