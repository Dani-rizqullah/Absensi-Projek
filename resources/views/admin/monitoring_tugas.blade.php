<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span class="hover:text-zinc-900 dark:hover:text-zinc-100 cursor-pointer text-left text-left">Sistem Inti</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100 text-left text-left">Global Overwatch</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none text-left">
                    Mission <span class="text-zinc-300 dark:text-zinc-600">Control</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-3 bg-zinc-100/50 dark:bg-zinc-900/30 p-2 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl text-left">
                <form action="{{ route('admin.tugas.index') }}" method="GET" class="flex items-center gap-2 text-left">
                    <div class="relative group text-left">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="bg-white dark:bg-zinc-950 border-none rounded-2xl py-3 pl-10 pr-4 text-[10px] font-black uppercase tracking-widest text-zinc-700 dark:text-zinc-200 placeholder-zinc-400 focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm w-48 lg:w-64"
                               placeholder="Cari Identitas Misi...">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="bg-zinc-800 dark:bg-white text-white dark:text-zinc-900 p-3 rounded-2xl hover:opacity-80 active:scale-95 transition-all shadow-lg text-left">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-10 text-left" x-data="{ 
        activeTab: 'semua',
        openModal: false, 
        selectedMisi: '', 
        unitData: [] 
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-12 text-left">
            
            <div class="flex justify-center md:justify-start text-left">
                <div class="flex bg-zinc-100/50 dark:bg-zinc-900/50 p-1.5 rounded-[2rem] border border-zinc-200 dark:border-zinc-800 backdrop-blur-md shadow-inner text-left">
                    @foreach([
                        ['id' => 'semua', 'label' => 'Semua Arus'],
                        ['id' => 'aktif', 'label' => 'Misi Aktif'],
                        ['id' => 'akan_datang', 'label' => 'Akan Datang'],
                        ['id' => 'selesai', 'label' => 'Misi Selesai']
                    ] as $tab)
                    <button @click="activeTab = '{{ $tab['id'] }}'" 
                        :class="activeTab === '{{ $tab['id'] }}' 
                            ? 'bg-zinc-900 dark:bg-white text-white dark:text-black shadow-xl scale-105' 
                            : 'text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100'" 
                        class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase italic tracking-[0.2em] transition-all duration-500 leading-none text-left">
                        {{ $tab['label'] }}
                    </button>
                    @endforeach
                </div>
            </div>

            @forelse($tugasPerDivisi as $divisi => $daftarTugas)
            <div class="space-y-6 transition-all duration-500 text-left" 
                 x-show="activeTab === 'semua' || 
                        (activeTab === 'aktif' && $el.querySelectorAll('.row-aktif').length > 0) || 
                        (activeTab === 'akan_datang' && $el.querySelectorAll('.row-akan-datang').length > 0) || 
                        (activeTab === 'selesai' && $el.querySelectorAll('.row-selesai').length > 0)">
                
                <div class="flex items-center gap-6 px-2 text-left">
                    <div class="flex flex-col leading-none text-left text-left">
                        <h3 class="text-2xl font-black uppercase italic tracking-tighter text-zinc-800 dark:text-white leading-none text-left">
                            Sektor <span class="text-zinc-400">{{ $divisi }}</span>
                        </h3>
                        <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.4em] mt-2 italic text-left text-left">Operasional Terverifikasi</p>
                    </div>
                    <div class="h-[1px] flex-1 bg-zinc-200 dark:bg-zinc-800 text-left"></div>
                    <div class="bg-zinc-100 dark:bg-zinc-900 px-4 py-2 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm leading-none text-left">
                        <span class="text-[10px] font-black text-zinc-500 tabular-nums uppercase tracking-widest leading-none text-left text-left">{{ str_pad($daftarTugas->count(), 2, '0', STR_PAD_LEFT) }} Unit Misi</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-950 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden text-left">
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] custom-scrollbar text-left text-left">
                        <table class="w-full text-left border-collapse text-left text-left">
                            <thead class="sticky top-0 bg-white dark:bg-zinc-950 z-20 text-[9px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-100 dark:border-zinc-800 text-left">
                                <tr>
                                    <th class="px-10 py-6 bg-zinc-50 dark:bg-zinc-900/50 text-left">Otoritas Mentor</th>
                                    <th class="px-6 py-6 bg-zinc-50 dark:bg-zinc-900/50 text-left">Identitas Operasi</th>
                                    <th class="px-6 py-6 bg-zinc-50 dark:bg-zinc-900/50 text-center text-left">Status Personel</th>
                                    <th class="px-6 py-6 bg-zinc-50 dark:bg-zinc-900/50 text-center text-left text-left">Limit Waktu</th>
                                    <th class="px-10 py-6 bg-zinc-50 dark:bg-zinc-900/50 text-right text-left">Intervensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50 text-left text-left">
                                @foreach($daftarTugas as $t)
                                @php
                                    $now = now();
                                    $isUrgent = $t->tgl_selesai->isPast() && $t->unit_selesai < $t->total_unit;
                                    $rowType = $t->unit_selesai >= $t->total_unit ? 'selesai' : (($t->tgl_mulai > $now) ? 'akan-datang' : 'aktif');
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-all group row-{{ $rowType }} text-left text-left"
                                    x-show="activeTab === 'semua' || (activeTab === 'aktif' && '{{ $rowType }}' === 'aktif') || (activeTab === 'akan_datang' && '{{ $rowType }}' === 'akan-datang') || (activeTab === 'selesai' && '{{ $rowType }}' === 'selesai')">
                                    
                                    <td class="px-10 py-6 text-left text-left">
                                        <div class="flex items-center gap-4 text-left">
                                            <div class="w-10 h-10 rounded-2xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 flex items-center justify-center font-black text-xs italic shadow-xl text-left">
                                                {{ substr($t->mentor->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div class="text-left text-left text-left">
                                                <p class="text-xs font-black text-zinc-800 dark:text-zinc-200 uppercase italic leading-none text-left">{{ $t->mentor->name ?? 'System' }}</p>
                                                <p class="text-[8px] font-bold text-zinc-400 uppercase mt-1 text-left text-left text-left">Mentor Utama</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-left text-left">
                                        <div class="flex flex-col leading-none text-left text-left">
                                            <span class="text-sm font-black text-zinc-800 dark:text-white uppercase italic group-hover:text-emerald-500 transition-colors leading-none text-left">{{ $t->judul }}</span>
                                            <span class="text-[9px] font-bold text-zinc-400 uppercase mt-2 tracking-widest text-left text-left text-left">Code: OP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-left">
                                        <div class="flex flex-col items-center gap-3 text-left">
                                            <div class="flex items-center gap-2 leading-none text-left text-left">
                                                <span class="text-xs font-black text-zinc-800 dark:text-white italic tabular-nums leading-none text-left">{{ $t->unit_selesai }}/{{ $t->total_unit }}</span>
                                                <span class="text-[8px] font-black text-zinc-400 uppercase tracking-tighter italic text-left text-left">Unit</span>
                                            </div>
                                            <div class="w-32 h-1.5 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden leading-none text-left text-left">
                                                <div class="h-full transition-all duration-1000 {{ $rowType === 'selesai' ? 'bg-zinc-400' : ($isUrgent ? 'bg-rose-500 shadow-[0_0_10px_#f43f5e]' : 'bg-emerald-500 shadow-[0_0_10px_#10b981]') }}" 
                                                     style="width: {{ $t->total_unit > 0 ? ($t->unit_selesai / $t->total_unit) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-center text-left text-left text-left">
                                        <div class="flex flex-col leading-none text-left text-left text-left">
                                            <span class="text-[11px] font-black italic tabular-nums {{ $rowType === 'akan-datang' ? 'text-amber-500' : ($isUrgent ? 'text-rose-500 animate-pulse' : 'text-zinc-800 dark:text-zinc-200') }} text-center text-left">
                                                {{ $t->tgl_selesai->format('d/m/Y') }}
                                            </span>
                                            <span class="text-[9px] font-bold text-zinc-400 uppercase mt-2 italic tracking-widest text-center text-left text-left">{{ $t->tgl_selesai->format('H:i') }} WIB</span>
                                        </div>
                                    </td>

                                    <td class="px-10 py-6 text-right text-left text-left text-left text-left">
                                        <div class="flex justify-end items-center gap-4 text-left text-left">
                                            @if($isUrgent)
                                                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-rose-500/20 bg-rose-500/5 text-left text-left">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping text-left text-left"></span>
                                                    <span class="text-[8px] font-black text-rose-500 uppercase italic text-left text-left text-left">Kritis</span>
                                                </div>
                                            @endif
                                            <button @click="openModal = true; selectedMisi = '{{ addslashes($t->judul) }}'; unitData = [ @foreach($t->karyawans as $k) { name: '{{ addslashes($k->name) }}', status: '{{ $k->pivot->status }}' }, @endforeach ]" 
                                                class="bg-zinc-100 dark:bg-zinc-800 text-zinc-400 hover:text-zinc-900 dark:hover:text-white p-3 rounded-2xl transition-all shadow-sm border border-zinc-200/50 dark:border-zinc-700/50 hover:scale-110 text-left text-left">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-24 bg-zinc-50/50 dark:bg-zinc-900/30 rounded-[3rem] border border-dashed border-zinc-200 dark:border-zinc-800 flex flex-col items-center justify-center opacity-40 text-center text-left text-left">
                <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] italic text-center text-left text-left text-left">Pusat Overwatch Belum Mendeteksi Sinyal Operasi Aktif</p>
            </div>
            @endforelse
        </div>

        <div x-show="openModal" 
             x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             class="fixed inset-0 z-[150] flex items-center justify-center p-6 text-left text-left" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openModal = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[3rem] max-w-lg w-full z-10 relative border border-zinc-200 dark:border-zinc-800 flex flex-col shadow-2xl overflow-hidden text-left text-left text-left">
                <div class="p-10 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/40 leading-none text-left text-left text-left text-left text-left">
                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] italic block mb-3 leading-none text-left text-left text-left text-left text-left text-left">Intelligence Unit Analysis</span>
                    <h3 class="text-3xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none text-left text-left text-left text-left text-left text-left text-left" x-text="selectedMisi"></h3>
                </div>
                <div class="p-10 space-y-4 max-h-[450px] overflow-y-auto custom-scrollbar text-left text-left text-left text-left text-left text-left">
                    <template x-for="unit in unitData">
                        <div class="flex items-center justify-between p-6 rounded-3xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 group transition-all hover:border-zinc-400 dark:hover:border-zinc-500 text-left text-left text-left text-left">
                            <div class="flex flex-col leading-none text-left text-left text-left text-left text-left">
                                <span class="text-sm font-black text-zinc-800 dark:text-zinc-100 uppercase tracking-tight italic leading-none text-left text-left text-left text-left text-left" x-text="unit.name"></span>
                                <span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest mt-2 leading-none text-left text-left text-left text-left text-left text-left" x-text="unit.status === 'selesai' ? 'Mission Cleared' : 'In Field Operation'"></span>
                            </div>
                            <span :class="unit.status === 'selesai' ? 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20' : 'text-amber-500 bg-amber-500/10 border-amber-500/20'" 
                                  class="px-4 py-2 rounded-xl text-[9px] font-black uppercase italic border shadow-sm transition-colors text-left text-left text-left text-left text-left"
                                  x-text="unit.status"></span>
                        </div>
                    </template>
                </div>
                <div class="p-8 bg-zinc-50/50 dark:bg-zinc-950/20 border-t border-zinc-100 dark:border-zinc-800 text-left text-left text-left text-left">
                    <button @click="openModal = false" class="w-full py-5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-black text-[10px] uppercase rounded-2xl tracking-[0.3em] transition-all hover:scale-[1.02] italic shadow-xl text-center text-left text-left text-left text-left">
                        Tutup Pusat Analisis
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #3f3f46; }
    </style>
</x-app-layout>