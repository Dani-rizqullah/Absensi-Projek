<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span>Anggota Kru</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Konsol Operasional</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Konsol <span class="text-zinc-300 dark:text-zinc-600">Kru</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-6 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl transition-all hover:border-zinc-400">
                <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-zinc-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex flex-col items-end text-left">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Waktu Sistem</span>
                    <span class="flex items-center gap-2 text-[11px] font-black text-emerald-600 dark:text-emerald-400 uppercase mt-1 tabular-nums">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> {{ now()->format('H:i:s') }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        // Mengambil jam buka sinyal pulang langsung dari buffer_keluar (Serba Waktu)
        $jamBukaPulang = \App\Models\Pengaturan::getVal('buffer_keluar', '16:45');
        $targetTime = date('Y-m-d') . ' ' . (strlen($jamBukaPulang) == 5 ? $jamBukaPulang . ':00' : $jamBukaPulang);
    @endphp

    <div class="py-10" 
        x-data="{ 
            openDetail: false, selectedData: null, openModalKeluar: false, openModalBackdate: false,
            targetTime: '{{ $targetTime }}',
            countdown: '',
            isLocked: {{ $statusAbsen['boleh_absen_keluar'] ? 'false' : 'true' }},

            updateCountdown() {
                const now = new Date().getTime();
                const target = new Date(this.targetTime).getTime();
                const distance = target - now;

                if (distance <= 0) {
                    // Jika sudah lewat jam buka, sinkronkan dengan status dari server
                    this.isLocked = {{ $statusAbsen['boleh_absen_keluar'] ? 'false' : 'true' }};
                    this.countdown = 'TERSEDIA';
                    return;
                }

                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);
                
                this.countdown = `${h}j ${m}m ${s}d`;
                this.isLocked = true;
            },

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
                const s = this.selectedData.status;
                if (s === 'Hadir' || s === 'Selesai') return 'emerald';
                if (s === 'Terlambat') return 'amber';
                if (s === 'Sakit' || s === 'Izin') return 'rose';
                return 'zinc';
            },
            init() {
                this.updateCountdown();
                setInterval(() => this.updateCountdown(), 1000);
                
                this.$nextTick(() => {
                    const todayCell = document.getElementById('today-cell');
                    if (todayCell) {
                        todayCell.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }
        }"
        x-init="init()"
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-10">

            <div class="group/main relative bg-zinc-900 dark:bg-white rounded-[2.5rem] p-1 shadow-2xl mb-12 transition-all duration-500 hover:shadow-emerald-500/10">
                <div class="bg-white dark:bg-zinc-900 rounded-[2.3rem] p-8 md:p-12 relative overflow-hidden text-left transition-all duration-500 group-hover/main:bg-zinc-50/50 dark:group-hover/main:bg-zinc-900/80">
                    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 15px 15px;"></div>
                    
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-10 relative z-10 text-left">
                        <div class="w-full lg:w-auto text-left transform transition-all duration-500 group-hover/main:translate-x-2">
                            
                            @if($statusAbsen['is_libur'])
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                    <span class="text-[11px] font-black text-rose-500 uppercase tracking-[0.3em]">🔴 Sistem Off: Hari Libur</span>
                                </div>
                                <h3 class="text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">Operasional Libur</h3>
                                <p class="text-zinc-500 mt-4 font-medium text-sm italic text-left underline decoration-rose-500/30 decoration-2">{{ $statusAbsen['keterangan_libur'] }}</p>

                            @elseif(!$absenHariIni)
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="w-2 h-2 rounded-full {{ $statusAbsen['boleh_absen_masuk'] ? 'bg-emerald-500 animate-ping' : 'bg-rose-500 animate-pulse' }}"></span>
                                    <span class="text-[11px] font-black {{ $statusAbsen['boleh_absen_masuk'] ? 'text-emerald-500' : 'text-rose-500' }} uppercase tracking-[0.3em]">
                                        {{ $statusAbsen['boleh_absen_masuk'] ? '🟢 Akses Terbuka' : '🔴 Akses Terkunci' }}
                                    </span>
                                </div>
                                <h3 class="text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">Status Standby</h3>
                                <p class="text-zinc-500 mt-4 font-medium text-sm italic text-left">{{ $statusAbsen['pesan_masuk'] }}</p>

                            @elseif(!$absenHariIni->jam_keluar)
                                <div class="flex items-center gap-2 mb-6 text-left">
                                    <template x-if="isLocked">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    </template>
                                    <template x-if="!isLocked">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-bounce"></span>
                                    </template>
                                    <span class="text-[11px] font-black uppercase tracking-[0.3em]" :class="isLocked ? 'text-amber-500' : 'text-emerald-500'" x-text="isLocked ? '🟡 Misi Sedang Berjalan' : '🟢 Siap Melapor Keluar'"></span>
                                </div>
                                <h3 class="text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none" x-text="isLocked ? 'Tugas Terkunci' : 'Tugas Selesai'"></h3>
                                <p class="text-zinc-500 mt-4 font-medium text-sm italic text-left">
                                    <span x-show="isLocked">Sinyal keluar terbuka dalam: <strong class="text-zinc-900 dark:text-white tabular-nums" x-text="countdown"></strong></span>
                                    <span x-show="!isLocked" class="text-emerald-600 dark:text-emerald-400">{{ $statusAbsen['pesan_keluar'] }}</span>
                                </p>
                            @else
                                <div class="flex items-center gap-2 mb-6 text-left">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[11px] font-black text-emerald-500 uppercase tracking-[0.3em]">🟢 Tugas Rampung</span>
                                </div>
                                <h3 class="text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">Misi Berhasil</h3>
                                <p class="text-zinc-500 mt-4 font-medium text-sm italic text-left">Data presensi harian Anda telah tersinkronisasi.</p>
                            @endif
                        </div>

                        <div class="flex flex-wrap justify-center gap-4">
                            @if(!$statusAbsen['is_libur'])
                                @if(!$absenHariIni)
                                    @if($statusAbsen['boleh_absen_masuk'])
                                        <form action="{{ route('absen.masuk') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-12 py-6 rounded-3xl font-black text-xs uppercase tracking-[0.3em] hover:scale-110 transition-all shadow-xl italic active:scale-95">MULAI PRESENSI</button>
                                        </form>
                                    @else
                                        <div class="bg-zinc-100 dark:bg-zinc-800 px-10 py-6 rounded-3xl opacity-50 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                            <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest italic leading-none">Akses Terkunci</span>
                                        </div>
                                    @endif
                                @elseif(!$absenHariIni->jam_keluar)
                                    <button @click="openModalKeluar = true" 
                                        :disabled="isLocked"
                                        :class="isLocked ? 'opacity-30 cursor-not-allowed grayscale' : 'hover:scale-110 shadow-emerald-500/20'"
                                        class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-12 py-6 rounded-3xl font-black text-xs uppercase tracking-[0.3em] transition-all shadow-xl italic active:scale-95">
                                        <span x-text="isLocked ? countdown : 'AKHIRI TUGAS'"></span>
                                    </button>
                                @endif
                            @endif

                            <button @click="openModalBackdate = true" class="group/btn flex items-center gap-4 px-8 py-6 bg-zinc-50 dark:bg-zinc-800 rounded-3xl border border-zinc-200 dark:border-zinc-700 hover:border-zinc-400 transition-all active:scale-95">
                                <svg class="w-5 h-5 text-zinc-400 group-hover/btn:text-zinc-900 dark:group-hover/btn:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 group-hover/btn:text-zinc-900 dark:group-hover/btn:text-white uppercase tracking-widest leading-none text-left">Protokol Khusus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-950 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-10 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/30">
                    <div class="text-left">
                        <h3 class="text-2xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter">Riwayat Presensi</h3>
                        <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em] mt-1">{{ Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="?month={{ $month-1 }}&year={{ $year }}" class="nav-btn"> ❮ </a>
                        <a href="?month={{ $month+1 }}&year={{ $year }}" class="nav-btn"> ❯ </a>
                    </div>
                </div>

                <div class="p-6 md:p-12">
                    <div class="grid grid-cols-7 gap-2 md:gap-4">
                        @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
                            <div class="text-center text-[10px] font-black text-zinc-300 dark:text-zinc-600 uppercase tracking-[0.3em] mb-4">{{ $dayName }}</div>
                        @endforeach

                        @php
                            $startDay = Carbon\Carbon::create($year, $month, 1)->dayOfWeek;
                            $daysInMonth = Carbon\Carbon::create($year, $month)->daysInMonth;
                        @endphp

                        @for ($i = 0; $i < $startDay; $i++)
                            <div class="aspect-square bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl opacity-20 border border-dashed border-zinc-200 dark:border-zinc-800"></div>
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $absen = $riwayatAbsen->first(fn($q) => Carbon\Carbon::parse($q->tanggal)->format('Y-m-d') === $dateStr);
                                $libur = $listLiburBulanIni->first(fn($q) => $q->tanggal->format('Y-m-d') === $dateStr);
                                $isToday = $dateStr === date('Y-m-d');
                                $isWeekend = in_array(Carbon\Carbon::parse($dateStr)->dayOfWeek, [0, 6]);
                            @endphp

                            <div 
                                @if($absen) 
                                    x-on:click="selectedData = {{ $absen->toJson() }}; 
                                               selectedData.user_name = '{{ Auth::user()->name }}'; 
                                               selectedData.user_divisi = '{{ Auth::user()->divisi }}'; 
                                               openDetail = true" 
                                @endif
                                @if($isToday) id="today-cell" @endif
                                class="relative aspect-square md:h-36 border-2 transition-all duration-300 group cursor-pointer rounded-3xl p-3 md:p-6 text-left
                                {{ $isToday ? 'border-emerald-500 bg-emerald-500/5 shadow-[0_0_20px_rgba(16,185,129,0.1)]' : 'border-zinc-50 dark:border-zinc-900' }} 
                                {{ $absen ? 'bg-white dark:bg-zinc-900 shadow-xl hover:scale-105 z-10' : ($libur ? 'bg-rose-50 dark:bg-rose-500/5 border-rose-100 dark:border-rose-500/10' : ($isWeekend ? 'bg-zinc-50/50 dark:bg-zinc-950/50 opacity-50' : 'bg-white dark:bg-zinc-950 hover:bg-zinc-50 dark:hover:bg-zinc-800')) }}">
                                
                                <span class="text-xs md:text-sm font-black {{ $isToday ? 'text-emerald-600' : ($libur ? 'text-rose-500' : ($isWeekend ? 'text-zinc-300 dark:text-zinc-700' : 'text-zinc-400 group-hover:text-zinc-900')) }}">
                                    {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                @if($libur)
                                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none px-2 text-center text-left">
                                        <span class="text-[7px] md:text-[8px] font-black text-rose-500/60 uppercase leading-tight">{{ $libur->keterangan }}</span>
                                    </div>
                                @elseif($absen)
                                    <div class="absolute inset-0 flex flex-col items-center justify-center mt-4 pointer-events-none transition-transform duration-500 group-hover:scale-110">
                                        @if($absen->approval_status === 'Pending')
                                            <div class="w-2 h-2 bg-amber-400 rounded-full animate-ping"></div>
                                        @else
                                            <span class="text-[9px] md:text-[11px] font-black uppercase italic tracking-tighter
                                                @if(in_array($absen->status, ['Hadir', 'Selesai'])) text-emerald-500
                                                @elseif($absen->status == 'Terlambat') text-amber-500
                                                @else text-rose-500 @endif">
                                                {{ $absen->status == 'Selesai' ? 'HADIR' : $absen->status }}
                                            </span>
                                            <p class="text-[8px] font-mono font-bold text-zinc-400 mt-1 tabular-nums">
                                                {{ substr($absen->jam_masuk, 0, 5) }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openDetail" class="fixed inset-0 z-[150] flex items-center justify-center p-6 text-left" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md transition-opacity" x-show="openDetail" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="openDetail = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[3rem] max-w-4xl w-full max-h-[90vh] overflow-hidden z-10 relative border border-zinc-200 dark:border-zinc-800 flex flex-col shadow-2xl" x-show="openDetail" x-transition:enter="ease-out duration-500 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-10" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-950/40 text-left">
                    <div class="flex items-center gap-6 text-left">
                        <div class="w-16 h-16 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 flex items-center justify-center text-2xl font-black italic shadow-xl" x-text="selectedData?.user_name ? selectedData.user_name.substring(0,1) : '?'"></div>
                        <div class="text-left">
                            <h3 class="text-2xl font-black uppercase italic dark:text-white text-zinc-800 leading-none tracking-tighter" x-text="selectedData?.user_name"></h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span :class="'bg-'+statusColor+'-500/10 text-'+statusColor+'-500 border border-'+statusColor+'-500/20'" class="px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-widest" x-text="selectedData?.status"></span>
                                <p class="text-[9px] font-bold text-zinc-400 uppercase tracking-[0.3em]" x-text="selectedData?.tanggal"></p>
                            </div>
                        </div>
                    </div>
                    <button @click="openDetail = false" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-zinc-800 text-zinc-400 rounded-full hover:text-zinc-900 dark:hover:text-white transition-all shadow-sm">✕</button>
                </div>
                <div class="p-8 overflow-y-auto custom-scrollbar text-left bg-white dark:bg-zinc-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase mb-1">Masuk</p>
                                    <p class="text-base font-black dark:text-white tabular-nums" x-text="selectedData?.jam_masuk || '--:--'"></p>
                                </div>
                                <div class="p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-inner">
                                    <p class="text-[8px] font-black text-zinc-400 uppercase mb-1">Keluar</p>
                                    <p class="text-base font-black dark:text-white tabular-nums" x-text="selectedData?.jam_keluar || '--:--'"></p>
                                </div>
                                <div class="p-4 bg-zinc-900 text-white rounded-2xl shadow-xl">
                                    <p class="text-[8px] font-black text-zinc-500 uppercase mb-1">Durasi</p>
                                    <p class="text-[11px] font-black italic text-emerald-400 tabular-nums" x-text="calculateDuration(selectedData?.jam_masuk, selectedData?.jam_keluar)"></p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="p-6 bg-zinc-100 dark:bg-zinc-800/50 rounded-3xl border border-zinc-200 dark:border-zinc-700 shadow-inner text-left">
                                    <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mb-3 italic">Laporan Operasional</p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-200 italic leading-relaxed" x-text="selectedData?.kegiatan_harian || selectedData?.alasan_lupa_absen || 'Tidak ada catatan.'"></p>
                                </div>
                                <div class="p-6 bg-zinc-900 text-white rounded-3xl shadow-xl border border-white/5 text-left">
                                    <p class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-3 italic text-emerald-500">Pembaruan Progres</p>
                                    <p class="text-sm font-medium italic text-zinc-300 leading-relaxed" x-text="selectedData?.progres_perubahan || 'Progres belum tercatat.'"></p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4 text-left">
                            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2">Validasi Bukti</p>
                            <div class="aspect-[4/3] bg-zinc-200 dark:bg-zinc-800 rounded-[2rem] overflow-hidden border-2 border-white dark:border-zinc-700 shadow-inner group/img">
                                <template x-if="selectedData?.foto_bukti">
                                    <img :src="'/storage/' + selectedData.foto_bukti" class="w-full h-full object-cover transition-transform duration-1000 group-hover/img:scale-110">
                                </template>
                            </div>
                            <div class="p-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-900/50 shadow-inner">
                                <p class="text-[9px] font-black text-zinc-400 uppercase leading-none">Status Operasional</p>
                                <span class="px-4 py-1.5 bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 rounded-lg text-[9px] font-black uppercase tracking-widest" x-text="selectedData?.status"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('karyawan.modals.check-out')
        @include('karyawan.modals.backdate')
    </div>
</x-app-layout>

<style>
    [x-cloak] { display: none !important; }
    .nav-btn { @apply w-10 h-10 flex items-center justify-center bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl hover:bg-zinc-900 hover:text-white transition-all shadow-sm active:scale-90; }
    .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 20px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #3f3f46; }

    @media (max-width: 768px) {
        .aspect-square { height: auto !important; width: 100% !important; border-radius: 1.5rem !important; }
    }
</style>