<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full opacity-50"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[8px] md:text-[10px] font-black text-zinc-400 uppercase tracking-[0.3em] md:tracking-[0.4em]">
                    <span>Anggota Kru</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100 text-left">Konsol Operasional</span>
                </nav>
                <h2 class="font-black text-3xl md:text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none text-left">
                    Konsol <span class="text-zinc-300 dark:text-zinc-600">Kru</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-4 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-6 md:pr-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl group transition-all hover:border-emerald-500/50 text-left">
                <div class="flex items-center gap-3 md:gap-4 text-left">
                    <div class="bg-white dark:bg-zinc-800 p-2 md:p-2.5 rounded-xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-zinc-400 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex flex-col items-start text-left">
                        <span class="text-[7px] md:text-[8px] font-black text-zinc-400 uppercase tracking-widest leading-none">Sistem_Status</span>
                        <span class="flex items-center gap-2 text-[10px] md:text-[11px] font-black text-emerald-600 dark:text-emerald-400 uppercase mt-1 tabular-nums">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> {{ now()->format('H:i:s') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $taskColors = ['bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-rose-500'];
        $jamBukaPulang = \App\Models\Pengaturan::getVal('buffer_keluar', '16:45');
        $targetTime = date('Y-m-d') . ' ' . (strlen($jamBukaPulang) == 5 ? $jamBukaPulang . ':00' : $jamBukaPulang);
        $startDay = Carbon\Carbon::create($year, $month, 1)->dayOfWeek;
        $daysInMonth = Carbon\Carbon::create($year, $month)->daysInMonth;
        $tugasButuhRevisi = $tugasOngoing->filter(fn($t) => $t->pivot->alasan_tolak != null);
    @endphp

    <div class="py-6 md:py-10 text-left relative" x-data="calendarData()" x-init="initCountdown()">

        {{-- Tooltip tetap sama --}}
        <template x-if="tooltipOpen">
            <div class="fixed pointer-events-none z-[9999] bg-zinc-900/95 dark:bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-zinc-700/50 dark:border-zinc-200 shadow-2xl min-w-[200px]"
                 :style="`left: ${tooltipX + 15}px; top: ${tooltipY + 15}px;`"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-zinc-700 dark:border-zinc-200 pb-2">
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest italic" x-text="tooltipDate"></span>
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    </div>
                    <div class="space-y-2">
                        <template x-if="tooltipAbsen">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full" :class="tooltipAbsenColor"></div>
                                <span class="text-[9px] font-black text-zinc-300 dark:text-zinc-600 uppercase" x-text="'LOG: ' + (tooltipAbsen === 'Selesai' ? 'Hadir' : tooltipAbsen)"></span>
                            </div>
                        </template>
                        <template x-for="(t, index) in tooltipTugas" :key="t.id">
                            <div class="flex items-start gap-2">
                                <div class="w-1 h-3 mt-0.5 rounded-full" :class="['bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-rose-500'][index % 5]"></div>
                                <span class="text-[9px] font-bold text-white dark:text-zinc-900 leading-tight italic uppercase" x-text="t.judul"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 md:px-10 space-y-8 text-left">
            {{-- Bagian Banner Status --}}
            <div class="relative bg-zinc-900 dark:bg-white rounded-[2.5rem] p-1 shadow-2xl">
                <div class="bg-white dark:bg-zinc-900 rounded-[2.3rem] p-6 md:p-10 relative overflow-hidden text-left transition-all duration-500">
                    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 15px 15px;"></div>
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-8 relative z-10">
                        <div class="w-full lg:w-auto text-left">
                            @if($statusAbsen['is_libur'])
                                <span class="px-3 py-1 bg-rose-500/10 text-rose-500 rounded-lg text-[9px] font-black uppercase border border-rose-500/20">SYSTEM_OFF</span>
                                <h3 class="text-2xl md:text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-4">{{ $statusAbsen['keterangan_libur'] }}</h3>
                            @elseif(!$absenHariIni)
                                <span class="px-3 py-1 {{ $statusAbsen['boleh_absen_masuk'] ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border-rose-500/20' }} rounded-lg text-[9px] font-black uppercase border">{{ $statusAbsen['boleh_absen_masuk'] ? 'ACCESS_GRANTED' : 'ACCESS_DENIED' }}</span>
                                <h3 class="text-2xl md:text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-4">Status: Standby</h3>
                            @elseif(!$absenHariIni->jam_keluar)
                                <span class="px-3 py-1 bg-amber-500/10 text-amber-500 rounded-lg text-[9px] font-black uppercase border border-amber-500/20">MISSION_IN_PROGRESS</span>
                                <h3 class="text-2xl md:text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-4" x-text="isLocked ? 'Menjalankan Tugas' : 'Otorisasi Pulang'"></h3>
                                <p class="text-zinc-500 mt-4 font-medium text-sm italic leading-none text-left"><span x-show="isLocked">Sinyal keluar terbuka dalam: <strong class="text-zinc-900 dark:text-white tabular-nums" x-text="countdown"></strong></span></p>
                            @else
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 rounded-lg text-[9px] font-black uppercase border border-emerald-500/20">MISSION_SUCCESS</span>
                                <h3 class="text-2xl md:text-4xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-4">Siklus Selesai</h3>
                            @endif

                            @if($tugasButuhRevisi->count() > 0)
                                <div class="mt-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center gap-4 animate-pulse">
                                    <div class="bg-rose-500 p-2 rounded-xl text-white">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <div class="text-left leading-tight">
                                        <p class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest leading-none">Peringatan_Evaluasi</p>
                                        <p class="text-xs font-bold text-zinc-600 dark:text-zinc-400 mt-1 uppercase italic leading-none">Ada laporan yang ditolak. Cek kolom misi di bawah.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap md:flex-nowrap w-full md:w-auto gap-3 text-left">
                            @if(!$statusAbsen['is_libur'])
                                @if(!$absenHariIni && $statusAbsen['boleh_absen_masuk'])
                                    <form action="{{ route('absen.masuk') }}" method="POST" class="w-full md:w-auto text-left">@csrf<button type="submit" class="w-full md:w-auto bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl italic active:scale-95 transition-all text-center">DEKLARE KEHADIRAN</button></form>
                                @elseif($absenHariIni && !$absenHariIni->jam_keluar)
                                    <button @click="openModalKeluar = true" :disabled="isLocked" :class="isLocked ? 'opacity-30 cursor-not-allowed grayscale' : 'hover:scale-105 shadow-emerald-500/20'" class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl italic transition-all text-center"><span x-text="isLocked ? countdown : 'LAPOR PULANG'"></span></button>
                                @endif
                            @endif
                            <button @click="openModalBackdate = true" class="group/btn flex items-center justify-center gap-3 px-6 py-5 bg-zinc-50 dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 hover:border-emerald-500/50 transition-all shadow-sm">
                                <svg class="w-4 h-4 text-zinc-400 group-hover:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 group-hover:text-emerald-500 uppercase tracking-widest italic">Protocol</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start text-left">
                {{-- Kolom Kalender tetap sama --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white dark:bg-zinc-950 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden"
                         @mousemove="updateTooltipPos($event)"
                         @mouseleave="hideTooltip()"> 
                        <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/30">
                            <h3 class="text-sm font-black text-zinc-800 dark:text-white uppercase italic tracking-widest">{{ Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}</h3>
                            <div class="flex gap-2 text-left">
                                <a href="?month={{ $month-1 }}&year={{ $year }}" class="nav-btn">❮</a>
                                <a href="?month={{ $month+1 }}&year={{ $year }}" class="nav-btn">❯</a>
                            </div>
                        </div>

                        <div class="p-4 md:p-6 text-left text-left">
                            <div class="grid grid-cols-7 gap-2">
                                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
                                    <div class="text-center text-[10px] font-black text-zinc-400 dark:text-zinc-600 uppercase mb-2">{{ $dayName }}</div>
                                @endforeach

                                @for ($i = 0; $i < $startDay; $i++)
                                    <div class="aspect-square rounded-xl opacity-10 bg-zinc-100 dark:bg-zinc-800"></div>
                                @endfor

                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                        $rawAbsen = $riwayatAbsen[$dateStr] ?? null;
                                        $absen = ($rawAbsen && in_array($rawAbsen->approval_status, ['Approved', 'Auto'])) ? $rawAbsen : null;
                                        $libur = $listLiburBulanIni[$dateStr] ?? null;
                                        $isToday = $dateStr === date('Y-m-d');
                                        $isWeekend = in_array(Carbon\Carbon::parse($dateStr)->dayOfWeek, [0, 6]);
                                        
                                        $tugasDiTanggalIni = $tugasKalender->filter(fn($t) => 
                                            $dateStr >= \Carbon\Carbon::parse($t->tgl_mulai)->format('Y-m-d') && 
                                            $dateStr <= \Carbon\Carbon::parse($t->tgl_selesai)->format('Y-m-d') &&
                                            strtolower($t->pivot->status) !== 'selesai'
                                        );
                                    @endphp

                                    <div 
                                        @mouseenter="showTooltip('{{ Carbon\Carbon::parse($dateStr)->format('d M Y') }}', {{ $absen ? json_encode($absen) : 'null' }}, {{ $tugasDiTanggalIni->values()->toJson() }}, '{{ $libur ? $libur->keterangan : '' }}')"
                                        @click="handleDayClick({{ $absen ? $absen->toJson() : 'null' }}, {{ $tugasDiTanggalIni->values()->toJson() }})"
                                        class="relative aspect-square flex flex-col items-center justify-center rounded-2xl border-2 transition-all duration-300 cursor-pointer overflow-hidden group text-left
                                        {{ $isToday ? 'border-emerald-500 bg-emerald-500/5 z-10 shadow-[0_0_15px_rgba(16,185,129,0.2)]' : 'border-zinc-50 dark:border-zinc-900/50' }}
                                        {{ $libur ? 'pattern-diagonal bg-rose-500/5 border-rose-500/20' : '' }}
                                        {{ $absen && in_array($absen->status, ['Hadir', 'Selesai', 'Terlambat']) ? 'bg-emerald-500/5 border-emerald-500/20' : '' }}
                                        {{ $absen && in_array($absen->status, ['Izin', 'Sakit', 'Alpha']) ? 'bg-rose-500/5 border-rose-500/20' : '' }}
                                        {{ !$absen && !$libur && !$isToday ? ($isWeekend ? 'bg-zinc-50/50 dark:bg-zinc-950/50' : 'bg-white dark:bg-zinc-900') : '' }}"
                                    >
                                        <div class="absolute left-1 top-2 bottom-2 flex flex-col gap-0.5">
                                            @foreach($tugasDiTanggalIni->values() as $index => $th)
                                                <div class="w-1 rounded-full {{ $taskColors[$index % 5] }} h-1/4 shadow-sm shadow-black/20 text-left"></div>
                                            @endforeach
                                        </div>
                                        <span class="text-xs md:text-sm font-black {{ $isToday ? 'text-emerald-500' : ($libur ? 'text-rose-500' : ($isWeekend ? 'text-zinc-300 dark:text-zinc-700' : 'text-zinc-500 dark:text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-white')) }}">
                                            {{ $day }}
                                        </span>
                                        @if($absen)
                                            <div class="absolute top-2 right-2">
                                                <div class="w-2 h-2 rounded-full @if(in_array($absen->status, ['Hadir', 'Selesai', 'Terlambat'])) bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)] @elseif($absen->status == 'Sakit') bg-rose-600 shadow-[0_0_8px_rgba(225,29,72,0.6)] @elseif($absen->status == 'Izin') bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.6)] @else bg-rose-50 @endif"></div>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                            
                            <div class="mt-8 grid grid-cols-2 md:grid-cols-5 gap-4 px-2 pt-6 border-t border-zinc-100 dark:border-zinc-800 text-left">
                                <div class="flex items-center gap-3 text-left"><div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div><span class="text-[9px] font-black uppercase text-zinc-400 tracking-widest">Hadir</span></div>
                                <div class="flex items-center gap-3 text-left"><div class="w-2.5 h-2.5 rounded-full bg-rose-600"></div><span class="text-[9px] font-black uppercase text-zinc-400 tracking-widest">Sakit</span></div>
                                <div class="flex items-center gap-3 text-left"><div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div><span class="text-[9px] font-black uppercase text-zinc-400 tracking-widest">Izin</span></div>
                                <div class="flex items-center gap-3 text-left"><div class="w-1 h-3.5 bg-blue-500 rounded-full"></div><span class="text-[9px] font-black uppercase text-zinc-400 tracking-widest">Misi/Tugas</span></div>
                                <div class="flex items-center gap-3 text-left"><div class="w-3.5 h-3.5 pattern-diagonal border border-rose-200 rounded-sm"></div><span class="text-[9px] font-black uppercase text-zinc-400 tracking-widest">Libur Sistem</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Sidebar Misi Aktif (RE-DESIGNED) --}}
                <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-10 text-left">
                    <div class="flex items-center justify-between px-2 text-left text-left">
                        <div class="flex items-center gap-3 text-left"><div class="w-1 h-5 bg-zinc-900 dark:bg-white rounded-full text-left"></div><h4 class="text-sm font-black text-zinc-800 dark:text-white uppercase italic tracking-widest">Misi Aktif Hari Ini</h4></div>
                        <span class="flex items-center gap-1.5 bg-emerald-500/10 text-emerald-500 px-2 py-1 rounded-full text-[8px] font-black uppercase border border-emerald-500/20"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> ONLINE</span>
                    </div>

                    <div class="space-y-4 max-h-[75vh] overflow-y-auto custom-scrollbar pr-3 text-left">
                        @forelse($tugasOngoing->filter(fn($t) => strtolower($t->pivot->status) !== 'selesai' && now()->between($t->tgl_mulai, $t->tgl_selesai))->values() as $index => $tgs)
                            <div class="group relative bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 p-6 transition-all duration-500 hover:border-zinc-900 dark:hover:border-white shadow-sm overflow-hidden text-left">
                                {{-- Warna Indikator Samping --}}
                                <div class="absolute left-0 top-1/4 bottom-1/4 w-1.5 {{ $taskColors[$index % 5] }} rounded-r-full"></div>

                                <div class="flex justify-between items-start mb-4 text-left">
                                    <div class="flex flex-col text-left">
                                        <span class="text-[9px] font-black {{ str_replace('bg-', 'text-', $taskColors[$index % 5]) }} uppercase tracking-widest italic mb-1 text-left leading-none">Task_Identifier: UNIT_{{ str_pad($tgs->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        <h5 class="text-lg font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-tight group-hover:translate-x-1 transition-transform text-left leading-none">{{ $tgs->judul }}</h5>
                                    </div>
                                    <div class="flex flex-col items-end text-left leading-none">
                                        <span class="text-[8px] font-black text-zinc-400 uppercase italic">Deadline</span>
                                        <span class="text-[11px] font-black text-rose-500 tabular-nums uppercase">{{ \Carbon\Carbon::parse($tgs->tgl_selesai)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>

                                <div class="relative bg-zinc-50 dark:bg-zinc-950 p-4 rounded-2xl mb-6 text-left">
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 font-bold italic leading-relaxed line-clamp-3 text-left">{{ $tgs->deskripsi }}</p>
                                </div>

                                {{-- BOX ALASAN PENOLAKAN (MODERN DESIGN) --}}
                                @if($tgs->pivot->alasan_tolak)
                                    <div class="mb-6 relative group/memo text-left">
                                        <div class="absolute -inset-1 bg-rose-500/20 rounded-[2rem] blur-sm"></div>
                                        <div class="relative bg-white dark:bg-zinc-950 border-2 border-rose-500/30 p-5 rounded-[1.8rem] shadow-sm">
                                            <div class="flex items-center gap-2 mb-3 text-left leading-none">
                                                <div class="bg-rose-500 p-1.5 rounded-lg text-white">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </div>
                                                <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest italic leading-none">Catatan_Revisi_Mentor</span>
                                            </div>
                                            <p class="text-[11px] font-bold text-zinc-700 dark:text-zinc-300 italic leading-relaxed text-left">
                                                "{{ $tgs->pivot->alasan_tolak }}"
                                            </p>
                                            <div class="absolute -right-2 -bottom-2 opacity-5">
                                                <svg class="w-16 h-16 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $pivStatus = strtolower($tgs->pivot->status ?? '');
                                    $isSubmitted = ($pivStatus === 'dikumpulkan');
                                @endphp

                                <div class="flex items-center gap-3 text-left">
                                    @if($isSubmitted)
                                        <div class="flex-1 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-600 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] italic border border-zinc-200 dark:border-zinc-700 text-center flex items-center justify-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 animate-pulse"></span> MENUNGGU EVALUASI
                                        </div>
                                    @else
                                        <button @click="selectedTugas = {{ $tgs->toJson() }}; openDetailTugas = true" 
                                            class="flex-1 py-4 {{ $tgs->pivot->alasan_tolak ? 'bg-rose-500 text-white shadow-rose-500/20' : 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 shadow-zinc-900/20' }} rounded-2xl font-black text-[10px] uppercase tracking-[0.15em] italic active:scale-95 transition-all text-center group-hover:shadow-lg">
                                            {{ $tgs->pivot->alasan_tolak ? 'PERBAIKI LAPORAN' : 'TRANSMISI DATA' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-20 border-2 border-dashed border-zinc-100 dark:border-zinc-800 rounded-[2.5rem] flex flex-col items-center justify-center opacity-40 text-center">
                                <p class="text-[10px] font-black uppercase tracking-widest italic text-center">Sinyal Misi Bersih</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @include('karyawan.modals.check-out')
        @include('karyawan.modals.backdate') 
        @include('karyawan.modals.lapor-tugas')
        @include('karyawan.modals.detail-absen')
        @include('karyawan.modals.pilihan-protokol') 
    </div>

    <script>
        function calendarData() {
            return {
                openDetail: false, selectedData: null, openModalKeluar: false, openModalBackdate: false,
                openDetailTugas: false, selectedTugas: null, openPilihan: false, tugasPilihan: [],
                countdown: '', isLocked: true,
                tooltipOpen: false, tooltipX: 0, tooltipY: 0, tooltipDate: '', tooltipAbsen: null, tooltipTugas: [], tooltipLibur: '',
                
                updateTooltipPos(e) {
                    this.tooltipX = e.clientX;
                    this.tooltipY = e.clientY;
                },

                showTooltip(date, absen, tugas, libur) {
                    if(window.innerWidth < 768) return; 
                    if(!absen && tugas.length === 0 && !libur) {
                        this.hideTooltip();
                        return;
                    }
                    this.tooltipOpen = true;
                    this.tooltipDate = date;
                    this.tooltipAbsen = absen ? absen.status : null;
                    this.tooltipTugas = tugas;
                    this.tooltipLibur = libur;
                },

                hideTooltip() { 
                    this.tooltipOpen = false;
                    this.tooltipAbsen = null;
                    this.tooltipTugas = [];
                    this.tooltipLibur = '';
                },

                get tooltipAbsenColor() {
                    if(!this.tooltipAbsen) return '';
                    const s = this.tooltipAbsen;
                    if(s === 'Hadir' || s === 'Selesai' || s === 'Terlambat') return 'bg-emerald-500';
                    if(s === 'Sakit') return 'bg-rose-600';
                    if(s === 'Izin') return 'bg-amber-500';
                    return 'bg-zinc-400';
                },

                handleDayClick(absen, tugas) {
                    this.tugasPilihan = tugas;
                    this.selectedData = absen;
                    if(absen) { 
                        this.selectedData.user_name = '{{ Auth::user()->name }}'; 
                        this.selectedData.user_divisi = '{{ Auth::user()->divisi }}'; 
                    }
                    
                    if((tugas.length > 0 && absen) || tugas.length > 1) {
                        this.openPilihan = true;
                    } else if(tugas.length === 1) {
                        this.selectedTugas = tugas[0];
                        this.openDetailTugas = true;
                    } else if(absen) {
                        this.openDetail = true;
                    }
                },

                initCountdown() {
                    const update = () => {
                        const now = new Date().getTime();
                        const target = new Date('{{ $targetTime }}').getTime();
                        const distance = target - now;
                        if (distance <= 0) {
                            this.isLocked = {{ $statusAbsen['boleh_absen_keluar'] ? 'false' : 'true' }};
                            this.countdown = 'TERSEDIA';
                            return;
                        }
                        const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const s = Math.floor((distance % (1000 * 60)) / 1000);
                        this.countdown = `${h}j ${m}m ${s}d`;
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .pattern-diagonal { background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(244, 63, 94, 0.05) 10px, rgba(244, 63, 94, 0.05) 20px); }
        .nav-btn { @apply w-10 h-10 flex items-center justify-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl hover:bg-zinc-900 dark:hover:bg-white hover:text-white dark:hover:text-zinc-900 transition-all shadow-sm active:scale-90 text-[10px]; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</x-app-layout>