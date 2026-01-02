<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span class="hover:text-zinc-900 dark:hover:text-zinc-100 cursor-pointer">Sistem Inti</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Pusat Kendali</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Operasional <span class="text-zinc-300 dark:text-zinc-600">Kru</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-6 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl text-left">
                <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-zinc-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Status Sinyal</span>
                    <span class="flex items-center gap-2 text-[11px] font-black text-emerald-600 dark:text-emerald-400 uppercase mt-1 tabular-nums">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> {{ now()->format('H:i:s') }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ 
        selectedData: null, 
        openModal: false, 
        openConfirm: false, 
        confirmAction: '', 
        confirmId: null,
        calculateDuration(start, end) {
            if(!start || !end) return '-- j -- m -- d';
            let s = start.split(':');
            let e = end.split(':');
            let startDate = new Date(0, 0, 0, s[0], s[1], s[2] || 0);
            let endDate = new Date(0, 0, 0, e[0], e[1], e[2] || 0);
            let diff = endDate.getTime() - startDate.getTime();
            if (diff < 0) return '0j 0m 0d';
            let h = Math.floor(diff / 3600000);
            let m = Math.floor((diff % 3600000) / 60000);
            let sd = Math.floor((diff % 60000) / 1000);
            return `${h}j ${m}m ${sd}d`;
        },
        get statusColor() {
            if (!this.selectedData) return 'zinc';
            const s = this.selectedData.status_label || this.selectedData.status;
            if (s === 'Hadir' || s === 'Selesai') return 'emerald';
            if (s === 'Terlambat') return 'amber';
            if (s === 'Sakit' || s === 'Izin') return 'rose';
            return 'zinc';
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 text-left">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                @foreach([
                    ['label' => 'Total Personel', 'value' => $totalKaryawan, 'color' => 'zinc'],
                    ['label' => 'Kru Hadir', 'value' => $totalHadir, 'color' => 'emerald'],
                    ['label' => 'Keterlambatan', 'value' => $totalTerlambat, 'color' => 'amber'],
                    ['label' => 'Antrian Persetujuan', 'value' => $menungguApproval, 'color' => 'rose'],
                ] as $stat)
                <div class="relative bg-zinc-50/50 dark:bg-zinc-900/50 p-6 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-sm transition-all hover:scale-[1.02]">
                    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 10px 10px;"></div>
                    <p class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest leading-tight relative z-10">{{ $stat['label'] }}</p>
                    <h3 class="text-5xl font-black tracking-tighter italic text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-500 leading-none mt-4 relative z-10 tabular-nums">
                        {{ str_pad($stat['value'], 2, '0', STR_PAD_LEFT) }}
                    </h3>
                </div>
                @endforeach
            </div>

            <div class="bg-zinc-100/50 dark:bg-zinc-800/40 rounded-[2.5rem] p-2 mb-12 border border-zinc-200 dark:border-zinc-800 transition-all">
                <form action="{{ route('admin.monitoring') }}" method="GET" class="flex flex-col md:flex-row w-full gap-2 text-left">
                    <div class="flex-1 relative group text-left text-left">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full bg-white dark:bg-zinc-950 border-none rounded-2xl py-4 pl-12 text-sm font-bold text-zinc-700 dark:text-zinc-200 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-400 transition-all shadow-sm"
                               placeholder="Cari kru berdasarkan identitas...">
                        <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 group-focus-within:text-zinc-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="bg-zinc-800 dark:bg-white text-white dark:text-zinc-900 px-12 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:opacity-80 active:scale-95 transition-all italic">
                        Perbarui Dashboard
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-left">
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-zinc-900/40 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                        <div class="px-10 py-6 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between bg-zinc-50/50 dark:bg-zinc-950/20">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.3em] text-zinc-500">Data Trafik Langsung</h3>
                        </div>
                        <div class="overflow-x-auto max-h-[600px] custom-scrollbar">
                            <table class="w-full">
                                <thead class="sticky top-0 bg-white dark:bg-zinc-900 z-10 text-left text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 border-b border-zinc-100 dark:border-zinc-800">
                                    <tr>
                                        <th class="px-10 py-6">Personel</th>
                                        <th class="px-6 py-6 text-center">Waktu Log</th>
                                        <th class="px-6 py-6 text-center">Status Sinyal</th>
                                        <th class="px-10 py-6 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                                    @foreach($absensiHariIni as $data)
                                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors duration-300">
                                        <td class="px-10 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-black text-xs text-zinc-400">
                                                    {{ substr($data['user']->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-sm text-zinc-800 dark:text-zinc-100 italic leading-none">{{ $data['user']->name }}</p>
                                                    <p class="text-[9px] font-black text-zinc-400 uppercase mt-1 tracking-widest text-left text-left">{{ $data['user']->divisi }} UNIT</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="font-black text-xs tabular-nums text-zinc-700 dark:text-zinc-300">
                                                {{ $data['absen'] ? date('H:i', strtotime($data['absen']->jam_masuk)) : '--:--' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-widest
                                                @if(in_array($data['status_label'], ['Selesai', 'Hadir'])) border-emerald-500/20 text-emerald-600 dark:text-emerald-400
                                                @elseif($data['status_label'] == 'Terlambat') border-amber-500/20 text-amber-600 dark:text-amber-400
                                                @else border-rose-500/20 text-rose-600 dark:text-rose-400 @endif">
                                                <span class="w-1 h-1 rounded-full bg-current"></span>
                                                {{ $data['status_label'] }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-5 text-right">
                                            <div class="flex justify-end gap-2">
                                                @if($data['absen'])
                                                <button @click='selectedData = {!! json_encode(array_merge($data["absen"]->toArray(), ["user_name" => $data["user"]->name, "user_divisi" => $data["user"]->divisi, "status_label" => $data["status_label"]])) !!}; openModal = true' 
                                                        class="p-2.5 text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all hover:scale-110 text-right text-right">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                                @endif
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data['user']->no_wa) }}" target="_blank" class="p-2.5 text-zinc-400 hover:text-emerald-500 transition-all text-right text-right">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 relative overflow-hidden transition-all duration-500">
                        <div class="absolute -right-20 -top-20 w-48 h-48 bg-rose-500/[0.08] blur-[80px]"></div>
                        <div class="p-8 pb-0 relative z-10 text-left">
                            <div class="flex justify-between items-center mb-6 border-b border-zinc-100 dark:border-zinc-800 pb-6">
                                <div class="text-left text-left">
                                    <h3 class="font-black text-[11px] text-zinc-800 dark:text-zinc-200 uppercase tracking-[0.3em]">Antrian Persetujuan</h3>
                                    <p class="text-[9px] font-bold text-zinc-400 uppercase mt-1 italic text-left">{{ $menungguApproval }} Permintaan Masuk</p>
                                </div>
                                <div class="w-10 h-10 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border border-zinc-200 dark:border-zinc-700 shadow-inner text-left">
                                    <span class="text-xs font-black text-rose-500 animate-pulse">{{ $menungguApproval }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 pb-8 space-y-4 max-h-[600px] overflow-y-auto custom-scrollbar relative z-10">
                            @forelse($pengajuanPending as $pending)
                            <div class="p-5 bg-white dark:bg-zinc-950/50 rounded-[2rem] border border-zinc-100 dark:border-zinc-800 group transition-all hover:border-zinc-400">
                                <div class="flex justify-between items-start mb-4 text-left">
                                    <div class="text-left text-left">
                                        <p class="font-black text-[10px] text-zinc-800 dark:text-zinc-100 uppercase tracking-tighter italic leading-none">{{ $pending->user->name }}</p>
                                        <span class="inline-block mt-2 px-3 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-[8px] font-black text-zinc-500 uppercase">
                                            Protokol {{ $pending->status }}
                                        </span>
                                    </div>
                                    <button @click='selectedData = {!! json_encode(array_merge($pending->toArray(), ["user_name" => $pending->user->name, "user_divisi" => $pending->user->divisi])) !!}; openModal = true' 
                                            class="p-2 bg-zinc-50 dark:bg-zinc-800 rounded-lg text-zinc-400 hover:text-zinc-900 dark:hover:white transition-all text-right text-right">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>

                                <div class="bg-zinc-50 dark:bg-white/5 p-4 rounded-2xl mb-4 text-[10px] text-zinc-500 dark:text-zinc-400 italic leading-relaxed shadow-inner line-clamp-2">
                                    "{{ $pending->alasan_lupa_absen }}"
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-left text-left">
                                    <button @click="confirmId = {{ $pending->id }}; confirmAction = 'approve'; openConfirm = true" 
                                            class="bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 py-3 rounded-xl text-[8px] font-black uppercase tracking-widest hover:scale-[1.02] transition-all italic text-left text-left">Setujui</button>
                                    <button @click="confirmId = {{ $pending->id }}; confirmAction = 'reject'; openConfirm = true" 
                                            class="bg-white dark:bg-transparent text-rose-500 border border-rose-100 dark:border-rose-500/20 py-3 rounded-xl text-[8px] font-black uppercase hover:bg-rose-500 hover:text-white transition-all text-right text-right text-right">Tolak</button>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-20 opacity-20 text-left text-left">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] italic text-left text-left">Sinyal Bersih</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-[150] flex items-center justify-center p-6 text-left" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openModal = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] max-w-4xl w-full max-h-[90vh] overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 flex flex-col shadow-2xl transition-all text-left" 
                 x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8">
                
                <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-950/40 text-left">
                    <div class="flex items-center gap-6 text-left">
                        <div class="w-16 h-16 rounded-2xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 flex items-center justify-center text-2xl font-black italic shadow-xl text-left" x-text="selectedData?.user_name ? selectedData.user_name.substring(0,1) : '?'"></div>
                        <div class="text-left text-left text-left">
                            <h3 class="text-2xl font-black uppercase italic dark:text-white text-zinc-800 leading-none tracking-tighter text-left" x-text="selectedData?.user_name"></h3>
                            <div class="flex items-center gap-2 mt-2 text-left">
                                <span :class="'bg-'+statusColor+'-500/10 text-'+statusColor+'-500 border border-'+statusColor+'-500/20'" class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest text-left" x-text="selectedData?.status_label || selectedData?.status"></span>
                                <p class="text-[9px] font-bold text-zinc-400 uppercase tracking-[0.3em] text-left" x-text="selectedData?.tanggal"></p>
                            </div>
                        </div>
                    </div>
                    <button @click="openModal = false" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-zinc-800 text-zinc-400 rounded-full hover:text-zinc-900 dark:hover:text-white transition-all shadow-sm text-right text-right">✕</button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar text-left bg-white dark:bg-zinc-900 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-left">
                        <div class="space-y-8 text-left text-left">
                            <template x-if="!selectedData?.alasan_lupa_absen">
                                <div class="grid grid-cols-3 gap-3 text-left text-left">
                                    <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner text-left">
                                        <p class="text-[8px] font-black text-zinc-400 uppercase mb-1 text-left text-left">Waktu Masuk</p>
                                        <p class="text-base font-black dark:text-white tabular-nums text-left" x-text="selectedData?.jam_masuk || '--:--'"></p>
                                    </div>
                                    <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner text-left">
                                        <p class="text-[8px] font-black text-zinc-400 uppercase mb-1 text-left">Waktu Keluar</p>
                                        <p class="text-base font-black dark:text-white tabular-nums text-left" x-text="selectedData?.jam_keluar || '--:--'"></p>
                                    </div>
                                    <div class="p-4 bg-zinc-900 text-white rounded-2xl shadow-xl text-left">
                                        <p class="text-[8px] font-black text-zinc-500 uppercase mb-1 text-left">Durasi Kerja</p>
                                        <p class="text-[11px] font-black italic text-emerald-400 tabular-nums text-left" x-text="calculateDuration(selectedData?.jam_masuk, selectedData?.jam_keluar)"></p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="selectedData?.alasan_lupa_absen">
                                <div class="p-5 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-500/20 rounded-3xl text-left">
                                    <p class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] mb-2 text-left">Justifikasi Pengajuan</p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-200 italic leading-relaxed text-left text-left" x-text="selectedData?.alasan_lupa_absen"></p>
                                </div>
                            </template>

                            <div class="space-y-4 text-left text-left">
                                <div class="p-6 bg-zinc-100 dark:bg-zinc-800/50 rounded-3xl border border-zinc-200 dark:border-zinc-700 shadow-inner text-left text-left">
                                    <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mb-3 italic text-left">Laporan Kegiatan Harian</p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-200 italic leading-relaxed text-left text-left" x-text="selectedData?.kegiatan_harian || 'Tidak ada catatan kegiatan harian.'"></p>
                                </div>
                                <div class="p-6 bg-zinc-900 text-white rounded-3xl shadow-xl border border-white/5 text-left text-left">
                                    <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-3 italic text-emerald-500 text-left">Pembaruan Progres</p>
                                    <p class="text-sm font-medium italic text-zinc-300 leading-relaxed text-left text-left" x-text="selectedData?.progres_perubahan || 'Status progres: Stabil.'"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 text-left">
                            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 text-left">Validasi Visual</p>
                            <div class="aspect-[4/3] bg-zinc-100 dark:bg-zinc-800 rounded-[2rem] overflow-hidden border-4 border-white dark:border-zinc-700 shadow-2xl group/img text-left">
                                <template x-if="selectedData?.foto_bukti">
                                    <img :src="'/storage/' + selectedData.foto_bukti" class="w-full h-full object-cover transition-all duration-1000 group-hover/img:scale-110 group-hover/img:rotate-1">
                                </template>
                                <div x-show="!selectedData?.foto_bukti" class="w-full h-full flex flex-col items-center justify-center italic text-zinc-400 text-[10px] font-black uppercase text-center">Sinyal Bukti Tidak Ditemukan</div>
                            </div>
                            <div class="p-5 rounded-3xl border border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50 shadow-inner text-left text-left">
                                <div class="text-left text-left text-left">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase leading-none mb-1 text-left">Sektor Unit</p>
                                    <p class="text-[10px] font-black text-zinc-800 dark:text-white uppercase tracking-wider text-left text-left" x-text="selectedData?.user_divisi"></p>
                                </div>
                                <div class="text-right text-right">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase leading-none mb-1 text-right text-right">Metode Log</p>
                                    <span class="px-3 py-1 bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 rounded-lg text-[9px] font-black uppercase text-right" x-text="selectedData?.alasan_lupa_absen ? 'Manual' : 'Standar'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openConfirm" class="fixed inset-0 z-[200] flex items-center justify-center p-6 text-center" x-cloak>
            <div class="absolute inset-0 bg-zinc-900/95 backdrop-blur-sm" @click="openConfirm = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] max-w-sm w-full p-10 z-10 relative border border-zinc-200 dark:border-zinc-800 text-center shadow-2xl">
                <div class="w-20 h-20 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-8 border border-zinc-200 dark:border-zinc-700 text-center">
                    <svg class="w-10 h-10 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h4 class="text-2xl font-black uppercase dark:text-white text-zinc-800 tracking-tighter text-center" x-text="confirmAction === 'approve' ? 'Verifikasi Data?' : 'Tolak Pengajuan?'"></h4>
                <div class="mt-10 space-y-3 text-center">
                    <form :action="'/admin/' + confirmAction + '/' + confirmId" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-zinc-900 dark:bg-white text-zinc-100 dark:text-zinc-900 font-black text-[10px] uppercase rounded-2xl tracking-[0.3em] transition-all hover:scale-105 italic shadow-xl text-center">Eksekusi Misi</button>
                    </form>
                    <button @click="openConfirm = false" class="w-full py-4 text-zinc-400 text-[10px] font-bold uppercase tracking-widest hover:text-zinc-600 transition-colors text-center">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>