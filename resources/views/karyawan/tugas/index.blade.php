<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full opacity-50"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[8px] md:text-[10px] font-black text-zinc-400 uppercase tracking-[0.3em] md:tracking-[0.4em]">
                    <span>Kru Operasional</span>
                    <svg class="w-2 h-2 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Mission Hub</span>
                </nav>
                <h2 class="font-black text-3xl md:text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Mission <span class="text-zinc-300 dark:text-zinc-600">Hub</span>
                </h2>
            </div>

            <div class="hidden md:flex items-center gap-6 bg-zinc-50 dark:bg-zinc-900/50 px-6 py-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-inner">
                <div class="text-center border-r border-zinc-200 dark:border-zinc-800 pr-6">
                    <p class="text-[7px] font-black text-zinc-400 uppercase tracking-widest mb-1">Active</p>
                    <p class="text-sm font-black text-emerald-500 italic tabular-nums leading-none">{{ $tugasActive->count() }}</p>
                </div>
                <div class="text-center">
                    <p class="text-[7px] font-black text-zinc-400 uppercase tracking-widest mb-1">Success</p>
                    <p class="text-sm font-black text-zinc-900 dark:text-white italic tabular-nums leading-none">{{ $tugasCompleted->count() }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
        tab: 'active', 
        search: '', 
        selectedTugas: null, 
        openDetailTugas: false, 
        openViewDetail: false,
        
        matches(judul) {
            return !this.search || judul.toLowerCase().includes(this.search.toLowerCase());
        }
    }" class="py-8">

        <div class="max-w-7xl mx-auto px-4 md:px-10 space-y-8">
            
            <div class="flex flex-col lg:flex-row gap-6 justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/30 p-2 rounded-[2rem] border border-zinc-200 dark:border-zinc-800 backdrop-blur-sm">
                <div class="flex p-1 bg-zinc-200/50 dark:bg-zinc-800/50 rounded-2xl w-full lg:w-auto">
                    @foreach(['active' => 'Berjalan', 'upcoming' => 'Jadwal', 'completed' => 'Arsip'] as $key => $label)
                        <button @click="tab = '{{ $key }}'" 
                            :class="tab === '{{ $key }}' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm ring-1 ring-zinc-900/5 dark:ring-zinc-600' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex-1 lg:flex-none px-8 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all italic focus:outline-none">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="relative group w-full lg:w-96 px-2 lg:px-0">
                    <div class="absolute inset-y-0 left-4 lg:left-3 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-emerald-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input x-model="search" type="text" placeholder="CARI KODE MISI ATAU NAMA..." 
                        class="w-full bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 rounded-2xl pl-12 lg:pl-10 pr-4 py-3 text-[10px] font-bold tracking-[0.2em] text-zinc-800 dark:text-white placeholder-zinc-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all italic uppercase shadow-sm">
                </div>
            </div>

            <div x-show="tab === 'active'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tugasActive as $index => $tgs)
                    <div x-show="matches('{{ $tgs->judul }}')"
                         class="group relative bg-white dark:bg-zinc-900 p-1 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/50 transition-all duration-500 shadow-sm hover:shadow-2xl hover:shadow-emerald-500/5 flex flex-col">
                        <div class="p-7 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest italic flex items-center gap-2">
                                        <span class="w-1 h-3 bg-zinc-300 dark:bg-zinc-700 rounded-full"></span>
                                        OP_LOG // 0{{ $index + 1 }}
                                    </span>
                                    <div class="px-3 py-1 {{ $tgs->pivot->status === 'dikumpulkan' ? 'text-amber-500 bg-amber-500/5 border-amber-500/20' : 'text-emerald-500 bg-emerald-500/5 border-emerald-500/20' }} text-[8px] font-black uppercase tracking-widest border rounded-lg italic">
                                        {{ $tgs->pivot->status === 'dikumpulkan' ? 'Menunggu Review' : 'Status: Aktif' }}
                                    </div>
                                </div>
                                <h4 class="text-xl font-black text-zinc-900 dark:text-white uppercase italic leading-tight mb-4 tracking-tighter group-hover:text-emerald-500 transition-colors">
                                    {{ $tgs->judul }}
                                </h4>
                                <p class="text-[12px] text-zinc-500 dark:text-zinc-400 font-medium italic line-clamp-3 leading-relaxed mb-6">
                                    {{ $tgs->deskripsi }}
                                </p>
                            </div>
                            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[7px] font-black text-zinc-400 uppercase tracking-widest mb-1">Target Selesai</span>
                                    <span class="text-[11px] font-black text-rose-500 tabular-nums italic uppercase">{{ $tgs->tgl_selesai->format('d M Y') }}</span>
                                </div>
                                <button @click="selectedTugas = {{ $tgs->toJson() }}; openDetailTugas = true" 
                                    class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-lg italic">
                                    {{ $tgs->pivot->status === 'dikumpulkan' ? 'Perbarui' : 'Lapor Progres' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-[3rem] text-center opacity-40">
                        <p class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.5em]">Belum Ada Penugasan Aktif</p>
                    </div>
                @endforelse
            </div>

            <div x-show="tab === 'upcoming'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tugasUpcoming as $tgs)
                    <div x-show="matches('{{ $tgs->judul }}')"
                         class="bg-zinc-50/50 dark:bg-zinc-900/30 p-7 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 opacity-60 grayscale flex flex-col justify-between min-h-[220px]">
                        <div>
                            <div class="px-3 py-1 bg-zinc-200 dark:bg-zinc-800 text-zinc-500 rounded-lg text-[8px] font-black uppercase tracking-widest italic inline-block mb-6 border border-zinc-300 dark:border-zinc-700">Terjadwal</div>
                            <h4 class="text-xl font-black text-zinc-400 dark:text-zinc-500 uppercase italic leading-tight tracking-tighter">{{ $tgs->judul }}</h4>
                        </div>
                        <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                            <span class="text-[8px] font-black text-zinc-400 uppercase tracking-widest italic">Estimasi Mulai: {{ $tgs->tgl_mulai->format('d M Y') }}</span>
                            <svg class="w-5 h-5 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full py-32 text-center opacity-30">
                        <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Kosong</p>
                    </div>
                @endforelse
            </div>

            <div x-show="tab === 'completed'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tugasCompleted as $tgs)
                    <div x-show="matches('{{ $tgs->judul }}')"
                         @click="selectedTugas = {{ $tgs->toJson() }}; openViewDetail = true"
                         class="group cursor-pointer bg-white dark:bg-zinc-900 p-1 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/40 transition-all duration-500 shadow-sm">
                        
                        <div class="p-7 flex flex-col justify-between min-h-[200px]">
                            <div class="relative z-10">
                                <div class="mb-4 flex justify-between items-center">
                                    <span class="px-2 py-0.5 bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 rounded-md text-[7px] font-black uppercase italic tracking-widest shadow-md">Arsip Berhasil</span>
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                                <h4 class="text-xl font-black text-zinc-800 dark:text-zinc-100 uppercase italic leading-tight mb-1 group-hover:text-emerald-500 transition-colors tracking-tighter">
                                    {{ $tgs->judul }}
                                </h4>
                            </div>
                            
                            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                                <span class="text-[8px] font-black text-zinc-400 uppercase tracking-widest italic">SYSLOG // {{ $tgs->pivot->updated_at->format('d.m.Y') }}</span>
                                <span class="text-[8px] font-black text-emerald-600 dark:text-emerald-400 uppercase italic">Lihat Detail &rarr;</span>
                            </div>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full py-32 text-center opacity-30">
                        <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Arsip Kosong</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="openViewDetail" x-cloak class="fixed inset-0 z-[120] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-zinc-950/95 backdrop-blur-md" @click="openViewDetail = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
            
            <div class="relative bg-white dark:bg-zinc-900 w-full max-w-2xl rounded-[3rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-2xl"
                 x-show="openViewDetail" x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="scale-95 opacity-0 translate-y-10" x-transition:enter-end="scale-100 opacity-100 translate-y-0">
                
                <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 flex justify-between items-center text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest italic mb-1">Laporan Misi Terverifikasi</p>
                            <h3 class="text-3xl font-black uppercase italic tracking-tighter text-zinc-900 dark:text-white leading-none" x-text="selectedTugas?.judul"></h3>
                        </div>
                    </div>
                    <button @click="openViewDetail = false" class="w-10 h-10 flex items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 hover:text-zinc-900 transition-all">✕</button>
                </div>

                <div class="p-8 space-y-8 max-h-[65vh] overflow-y-auto custom-scrollbar text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-5 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <span class="text-[8px] font-black text-zinc-400 uppercase block mb-2 tracking-widest">Waktu Transmisi</span>
                            <span class="text-xs font-black text-zinc-800 dark:text-zinc-200 tabular-nums italic uppercase" x-text="selectedTugas?.pivot?.tgl_pengumpulan"></span>
                        </div>
                        <div class="p-5 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <span class="text-[8px] font-black text-zinc-400 uppercase block mb-2 tracking-widest">Status Validasi</span>
                            <span class="text-[11px] font-black text-emerald-500 uppercase italic">Terverifikasi Mentor</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <span class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.3em] italic ml-1">Deskripsi Laporan Kru</span>
                        <div class="p-7 rounded-[2.5rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 italic text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed shadow-inner" x-text="selectedTugas?.pivot?.pesan_karyawan"></div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                        <template x-if="selectedTugas?.pivot?.file_hasil">
                            <a :href="'/storage/' + selectedTugas.pivot.file_hasil" target="_blank" class="flex-1 group flex items-center justify-center gap-3 p-5 rounded-[1.5rem] bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-black text-[11px] uppercase tracking-[0.2em] shadow-xl transition-all hover:scale-[1.02]">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-y-[-2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Buka Dokumen Bukti
                            </a>
                        </template>
                        <template x-if="selectedTugas?.pivot?.link_tautan">
                            <a :href="selectedTugas.pivot.link_tautan" target="_blank" class="flex-1 flex items-center justify-center gap-3 p-5 rounded-[1.5rem] bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 font-black text-[11px] uppercase tracking-[0.2em] hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all italic">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Sumber Eksternal
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        @include('karyawan.modals.lapor-tugas')
    </div>
</x-app-layout>