<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all print:hidden">
        <div class="relative pl-6">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
            <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
            
            <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                <span>Reporting</span>
                <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                <span class="text-zinc-900 dark:text-zinc-100">Rekapitulasi Bulanan</span>
            </nav>
            <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-900 dark:text-white leading-none">
                Database <span class="text-zinc-400 dark:text-zinc-600">Rekapitulasi</span>
            </h2>
        </div>
        
        <button onclick="window.print()" class="group flex items-center gap-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl italic">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Generate Document
        </button>
    </div>
</x-slot>

    <div class="py-10" x-data="{ 
        selectedData: null, 
        openModal: false,
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
        init() {
            this.$nextTick(() => {
                const todayCol = document.getElementById('today-column');
                if (todayCol) {
                    todayCol.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            });
        }
    }">
        <div class="max-w-full mx-auto px-6 lg:px-10">
            
            <div class="bg-zinc-100/50 dark:bg-zinc-900/50 rounded-[2.5rem] p-3 mb-10 border border-zinc-200 dark:border-zinc-800 print:hidden shadow-sm">
                <form action="{{ route('admin.laporan') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-2">
                    <div class="relative md:col-span-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama..." 
                               class="w-full bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl py-4 pl-10 pr-4 text-xs font-bold text-zinc-700 dark:text-zinc-200 focus:ring-zinc-400">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="3"/></svg>
                    </div>
                    <select name="divisi" class="bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl py-4 px-6 text-xs font-bold text-zinc-700 dark:text-zinc-200">
                        <option value="">Semua Divisi</option>
                        @isset($daftarDivisi)
                            @foreach($daftarDivisi as $div)
                                <option value="{{ $div }}" {{ request('divisi') == $div ? 'selected' : '' }}>{{ strtoupper($div) }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <select name="bulan" class="bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl py-4 px-6 text-xs font-bold text-zinc-700 dark:text-zinc-200">
                        @for ($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                    <select name="tahun" class="bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl py-4 px-6 text-xs font-bold text-zinc-700 dark:text-zinc-200">
                        @for ($y=date('Y'); $y>=2024; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-2xl font-black text-[10px] uppercase tracking-widest italic transition-all hover:opacity-80">Jalankan</button>
                </form>
            </div>

            <div class="bg-white dark:bg-zinc-950 rounded-[3rem] border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden printable-area relative">
                
                <div class="hidden print:flex absolute inset-0 items-center justify-center pointer-events-none opacity-[0.03] rotate-[-35deg]">
                    <h1 class="text-[120px] font-black uppercase">DSM OFFICIAL REPORT</h1>
                </div>

                <div class="hidden print:flex justify-between items-start p-10 border-b-2 border-zinc-900 bg-white">
                    <div class="text-left">
                        <h1 class="text-3xl font-black uppercase italic tracking-tighter text-zinc-900">Laporan Rekapitulasi Absensi</h1>
                        <p class="text-[10px] font-bold uppercase tracking-[0.4em] mt-1 text-zinc-500">Document ID: #REC-{{ date('Ym') }}-{{ Str::upper(Str::random(5)) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-400 leading-none">Periode Laporan</p>
                        <p class="text-lg font-black italic text-zinc-900 mt-1">{{ $dateContext->translatedFormat('F Y') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar" id="matrix-scroll-container">
                    <table class="w-full text-left border-collapse border-spacing-0 tabular-nums">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-900">
                                <th class="px-8 py-6 sticky left-0 bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 text-[9px] font-black text-zinc-400 uppercase tracking-widest z-30 min-w-[240px] text-left shadow-md">PERSONNEL IDENTITY</th>
                                @for($d=1; $d<=$daysInMonth; $d++)
                                    @php $isCurrentDay = (date('j') == $d && date('n') == $bulan && date('Y') == $tahun); @endphp
                                    <th @if($isCurrentDay) id="today-column" @endif class="border border-zinc-200 dark:border-zinc-800 p-0 text-center min-w-[42px] h-12 text-[9px] font-black {{ $isCurrentDay ? 'text-emerald-500 bg-emerald-500/5' : 'text-zinc-400' }}">
                                        {{ str_pad($d, 2, '0', STR_PAD_LEFT) }}
                                        @if($isCurrentDay) <div class="text-[6px] leading-none mt-1 print:hidden">TODAY</div> @endif
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($users as $user)
                            <tr class="group hover:bg-zinc-50/50 dark:hover:bg-zinc-900/50 transition-colors">
                                <td class="px-8 py-4 sticky left-0 bg-white dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 z-10 text-left shadow-md">
                                    <div class="font-bold text-xs text-zinc-800 dark:text-zinc-100 leading-none italic">{{ $user->name }}</div>
                                    <div class="text-[7px] font-black text-zinc-400 uppercase mt-1">{{ $user->divisi }}</div>
                                </td>
                                @for($d=1; $d<=$daysInMonth; $d++)
                                    @php
                                        $dateString = sprintf('%04d-%02d-%02d', $tahun, $bulan, $d);
                                        $absen = $user->absensis->first(fn($item) => Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') === $dateString);
                                        $isWeekend = Carbon\Carbon::parse($dateString)->isWeekend();
                                        $isCurrentDay = (date('j') == $d && date('n') == $bulan && date('Y') == $tahun);
                                    @endphp
                                    <td class="border border-zinc-100 dark:border-zinc-800 p-0 text-center {{ $isWeekend ? 'bg-zinc-50/30 dark:bg-black/20' : '' }} {{ $isCurrentDay ? 'bg-emerald-500/5' : '' }}">
                                        <div class="flex items-center justify-center w-full h-12">
                                            @if($absen)
                                                @php 
                                                    $statusChar = match($absen->status) {
                                                        'Hadir', 'Selesai' => ['H', 'text-emerald-500'],
                                                        'Terlambat' => ['T', 'text-amber-500'],
                                                        'Sakit' => ['S', 'text-rose-500'],
                                                        'Izin' => ['I', 'text-blue-500'],
                                                        default => ['?', 'text-zinc-300']
                                                    };
                                                @endphp
                                                
                                                <button @click='selectedData = {!! json_encode(array_merge($absen->toArray(), ["user_name" => $user->name, "user_divisi" => $user->divisi])) !!}; openModal = true' 
                                                        class="print:hidden flex items-center justify-center w-full h-full hover:scale-110 transition-transform">
                                                    @if($absen->approval_status === 'Pending')
                                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></div>
                                                    @else
                                                        <span class="font-black text-[10px] {{ $statusChar[1] }}">{{ $statusChar[0] }}</span>
                                                    @endif
                                                </button>

                                                <span class="hidden print:block font-black text-[9px] {{ $statusChar[1] }}">
                                                    {{ $absen->approval_status === 'Pending' ? 'P' : $statusChar[0] }}
                                                </span>
                                            @else
                                                <div class="text-zinc-100 dark:text-zinc-800 text-[10px] select-none">&bull;</div>
                                            @endif
                                        </div>
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-10 bg-zinc-50 dark:bg-zinc-950/40 border-t border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row justify-between items-end gap-10">
                    <div class="flex flex-wrap gap-x-8 gap-y-4 justify-center md:justify-start">
                        <div class="flex items-center gap-2"><span class="text-emerald-500 font-black text-xs">H</span><span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest text-left">Hadir</span></div>
                        <div class="flex items-center gap-2"><span class="text-amber-500 font-black text-xs">T</span><span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest text-left">Terlambat</span></div>
                        <div class="flex items-center gap-2"><span class="text-rose-500 font-black text-xs">S</span><span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest text-left">Sakit</span></div>
                        <div class="flex items-center gap-2"><span class="text-blue-500 font-black text-xs">I</span><span class="text-[8px] font-bold text-zinc-400 uppercase tracking-widest text-left">Izin</span></div>
                    </div>

                    <div class="hidden print:flex gap-12 text-left">
                        <div class="flex flex-col items-center">
                            <p class="text-[8px] font-black uppercase tracking-widest text-zinc-400 mb-2">Digital Verify</p>
                            <div class="w-16 h-16 border-2 border-zinc-900 p-1">
                                <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="min-w-[180px]">
                            <p class="text-[9px] font-black uppercase tracking-widest text-zinc-500 mb-12 italic">Disahkan Oleh Admin Operasional,</p>
                            <p class="font-black text-zinc-900 border-b-2 border-zinc-900 inline-block uppercase italic">SYSTEM AUTHORIZED</p>
                            <p class="text-[8px] font-bold text-zinc-400 mt-1 uppercase leading-none">Waktu Cetak: {{ now()->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-[150] flex items-center justify-center p-6" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openModal = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[3.5rem] max-w-4xl w-full max-h-[90vh] overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 flex flex-col shadow-2xl transition-all" 
                 x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-8">
                
                <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                    <div class="text-left">
                        <h3 class="text-2xl font-black uppercase italic dark:text-white text-zinc-800 leading-none" x-text="selectedData?.user_name"></h3>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.3em] mt-2" x-text="(selectedData?.user_divisi || 'UNIT') + ' &bull; ' + (selectedData?.tanggal || 'DATE')"></p>
                    </div>
                    <button @click="openModal = false" class="w-10 h-10 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 text-zinc-400 rounded-full hover:text-zinc-900 dark:hover:text-white transition-all">✕</button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase mb-1 text-left">Masuk</p>
                                    <p class="text-base font-black dark:text-white tabular-nums" x-text="selectedData?.jam_masuk || '--:--'"></p>
                                </div>
                                <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase mb-1 text-left">Keluar</p>
                                    <p class="text-base font-black dark:text-white tabular-nums" x-text="selectedData?.jam_keluar || '--:--'"></p>
                                </div>
                                <div class="p-4 bg-zinc-900 text-white rounded-2xl shadow-xl">
                                    <p class="text-[8px] font-black text-zinc-500 uppercase mb-1 text-left">Durasi</p>
                                    <p class="text-[11px] font-black italic text-emerald-400 tabular-nums" x-text="calculateDuration(selectedData?.jam_masuk, selectedData?.jam_keluar)"></p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="p-6 bg-zinc-100 dark:bg-zinc-800/50 rounded-[2rem] border border-zinc-200 dark:border-zinc-700">
                                    <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mb-3">Laporan Kegiatan / Alasan</p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-200 italic leading-relaxed" x-text="selectedData?.kegiatan_harian || selectedData?.alasan_lupa_absen || 'Tidak ada catatan.'"></p>
                                </div>
                                
                                <div class="p-6 bg-zinc-900 text-white rounded-[2rem] shadow-xl border border-white/5">
                                    <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-3 italic text-emerald-500">Perubahan dari Sebelumnya</p>
                                    <p class="text-sm font-medium italic text-zinc-300 leading-relaxed" x-text="selectedData?.progres_perubahan || 'Tidak ada catatan perubahan.'"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2">Visual Validation</p>
                            <div class="aspect-[4/3] bg-zinc-200 dark:bg-zinc-800 rounded-3xl overflow-hidden border-2 border-white dark:border-zinc-700 shadow-inner">
                                <template x-if="selectedData?.foto_bukti">
                                    <img :src="'/storage/' + selectedData.foto_bukti" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                                </template>
                                <div x-show="!selectedData?.foto_bukti" class="w-full h-full flex items-center justify-center italic text-zinc-400 text-[10px] font-black uppercase">No Attachment</div>
                            </div>
                            <div class="p-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50 shadow-inner">
                                <p class="text-[9px] font-black text-zinc-400 uppercase">Status Final</p>
                                <span class="px-3 py-1 bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 rounded-lg text-[9px] font-black uppercase tracking-widest shadow-sm" x-text="selectedData?.status"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #today-column { border: 2px solid #10b981 !important; z-index: 10; position: relative; }
        
        @media print {
            @page { 
                size: A4 landscape; 
                margin: 0.5cm; 
            }
            nav, .print\:hidden, form, button { display: none !important; }
            .py-10 { padding: 0 !important; }
            .max-w-full { padding: 0 !important; }
            .printable-area { border: 1px solid #d1d5db !important; border-radius: 0 !important; width: 100% !important; margin: 0 !important; box-shadow: none !important; background: white !important; }
            
            table { 
                width: 100% !important; 
                table-layout: fixed !important; 
                border-collapse: collapse !important; 
            }
            th, td { 
                font-size: 7px !important; 
                padding: 4px 1px !important; 
                border: 0.5px solid #e5e7eb !important; 
                height: auto !important;
                color: black !important;
            }
            th:first-child, td:first-child { 
                width: 140px !important; 
                min-width: 140px !important; 
                font-size: 8px !important;
                position: static !important; 
                box-shadow: none !important;
                background: white !important;
            }

            .dark { background: white !important; color: black !important; }
            .dark .dark\:bg-zinc-950, .dark .dark\:bg-zinc-900, .dark .bg-zinc-900, .dark .bg-white { 
                background: white !important; 
                color: black !important; 
            }
            .dark .text-white, .dark .dark\:text-white { color: black !important; }
            
            .hidden.print\:flex { display: flex !important; }
            .hidden.print\:block { display: block !important; }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .text-emerald-500 { color: #059669 !important; }
            .text-amber-500 { color: #d97706 !important; }
            .text-rose-500 { color: #dc2626 !important; }
            .text-blue-500 { color: #2563eb !important; }
        }

        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 10px; }
    </style>
</x-app-layout>