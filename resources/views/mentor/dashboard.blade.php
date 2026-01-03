<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500 rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span>Panel Otoritas</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Divisi {{ $mentor->divisi }}</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Mentor <span class="text-zinc-300 dark:text-zinc-600">Console</span>
                </h2>
            </div>

            <div class="flex items-center gap-6 bg-zinc-100/50 dark:bg-zinc-900/30 p-1.5 pr-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-xl">
                <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-700 text-emerald-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="flex flex-col items-end text-left">
                    <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none">Status Tim</span>
                    <span class="text-[11px] font-black text-zinc-800 dark:text-zinc-200 uppercase mt-1 italic">{{ $hadirHariIni }} / {{ $totalPersonil }} Hadir</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        openTugas: false, 
        isEdit: false,
        tugasTab: '{{ request('tab', 'perlu_review') }}',
        missionSearch: '',
        openViewLaporan: false,
        openDetailAbsen: false,
        selectedAbsen: null,
        selectedKaryawanTugas: null,
        formTugas: { id: '', judul: '', deskripsi: '', tgl_mulai: '', tgl_selesai: '', karyawan_ids: [] },
        
        editTugas(tugas) {
            this.isEdit = true;
            this.formTugas = {
                id: tugas.id,
                judul: tugas.judul,
                deskripsi: tugas.deskripsi,
                tgl_mulai: tugas.tgl_mulai.replace(' ', 'T').substring(0, 16),
                tgl_selesai: tugas.tgl_selesai.replace(' ', 'T').substring(0, 16),
                karyawan_ids: tugas.karyawans.map(k => k.id)
            };
            this.openTugas = true;
        },
        resetForm() {
            this.isEdit = false;
            this.formTugas = { id: '', judul: '', deskripsi: '', tgl_mulai: '', tgl_selesai: '', karyawan_ids: [] };
        },
        tambahTugasSpesifik(karyawanId) {
            this.resetForm();
            this.formTugas.karyawan_ids = [karyawanId];
            this.openTugas = true;
        },
        matchMission(judul) {
            return !this.missionSearch || judul.toLowerCase().includes(this.missionSearch.toLowerCase());
        },
        switchTab(tabName) {
            this.tugasTab = tabName;
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabName);
            window.history.replaceState({}, '', url);
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-12">
            
            <div class="space-y-6">
                <div class="text-left flex justify-between items-end">
                    <h3 class="text-2xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter">Manajemen Personel</h3>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm text-left">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50/50 dark:bg-zinc-950/20 border-b border-zinc-100 dark:border-zinc-800 text-[10px] font-black uppercase tracking-widest text-zinc-400">
                                <th class="px-8 py-6">Personel Tim</th>
                                <th class="px-6 py-6 text-center">Absensi Hari Ini</th>
                                <th class="px-6 py-6 text-center">Poin</th>
                                <th class="px-8 py-6 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                            @foreach($karyawanDivisi as $karyawan)
                            <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-all">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-xs italic">{{ substr($karyawan->name, 0, 1) }}</div>
                                        <div>
                                            <p class="text-sm font-bold text-zinc-800 dark:text-zinc-100 leading-none italic">{{ $karyawan->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php $absen = $karyawan->absensis->first(); @endphp
                                    @if($absen)
                                        <button @click="selectedAbsen = {{ $absen->toJson() }}; openDetailAbsen = true" class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 rounded-lg text-[8px] font-black border border-emerald-500/20 shadow-sm">LOG MASUK: {{ substr($absen->jam_masuk, 0, 5) }}</button>
                                    @else
                                        <span class="text-[8px] font-black text-zinc-400 uppercase">OFFLINE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center font-black text-[11px]">{{ $karyawan->poin }} PTS</td>
                                <td class="px-8 py-5 text-right">
                                    <button @click="tambahTugasSpesifik({{ $karyawan->id }})" class="group/opt flex items-center gap-2 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:text-emerald-500 border border-zinc-200 dark:border-zinc-700 ml-auto transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
                                        <span class="hidden group-hover/opt:block text-[8px] font-black uppercase tracking-widest px-1">Tugaskan</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-8 text-left">
                <div class="bg-zinc-50 dark:bg-zinc-950 p-6 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 shadow-inner space-y-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <div class="text-left leading-none">
                            <h3 class="text-3xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">Pusat Kendali Misi</h3>
                            <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em] mt-2 italic leading-none">Data Operations Hub</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                            <div class="relative group">
                                <input x-model="missionSearch" type="text" placeholder="Cari Nama Misi..." 
                                    class="w-full sm:w-64 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 rounded-2xl px-4 py-3 text-[11px] font-bold uppercase tracking-widest focus:ring-emerald-500 italic shadow-sm leading-none">
                                <svg class="absolute right-4 top-3.5 w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="3"/></svg>
                            </div>
                            <button @click="resetForm(); openTugas = true" class="bg-zinc-900 dark:bg-white text-white dark:text-black px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest italic hover:scale-105 transition-all shadow-xl leading-none">
                                + Launch New Mission
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col xl:flex-row justify-between items-center gap-6 pt-6 border-t border-zinc-100 dark:border-zinc-900">
                        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3 w-full xl:w-auto leading-none">
                            <input type="hidden" name="tab" :value="tugasTab">
                            <div class="flex items-center gap-2 bg-white dark:bg-zinc-900 p-1 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                                <select name="month" onchange="this.form.submit()" class="bg-transparent border-none text-[10px] font-black uppercase italic focus:ring-0 cursor-pointer">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ request('month', date('m')) == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endforeach
                                </select>
                                <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-800"></div>
                                <select name="year" onchange="this.form.submit()" class="bg-transparent border-none text-[10px] font-black uppercase italic focus:ring-0 cursor-pointer pr-8">
                                    @foreach(range(date('Y'), date('Y')-2) as $y)
                                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <div class="flex p-1 bg-zinc-100 dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 w-full xl:w-auto shadow-inner overflow-x-auto no-scrollbar">
                            <button @click="switchTab('perlu_review')" :class="tugasTab === 'perlu_review' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all italic focus:outline-none">Review</button>
                            <button @click="switchTab('berjalan')" :class="tugasTab === 'berjalan' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all italic focus:outline-none">Aktif</button>
                            <button @click="switchTab('mendatang')" :class="tugasTab === 'mendatang' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all italic focus:outline-none">Antrean</button>
                            <button @click="switchTab('selesai')" :class="tugasTab === 'selesai' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="whitespace-nowrap px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all italic focus:outline-none">Arsip</button>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach($daftarTugas as $tugas)
                        @php
                            $now = now();
                            $semuaKruSelesai = $tugas->karyawans->isNotEmpty() && $tugas->karyawans->every(fn($k) => $k->pivot->status === 'selesai');
                            $sudahDeadline = $tugas->tgl_selesai <= $now;
                            $isArchive = $semuaKruSelesai || $sudahDeadline;
                            $adaLaporanMasuk = $tugas->karyawans->contains(fn($k) => $k->pivot->status === 'dikumpulkan');
                            $belumMulai = $tugas->tgl_mulai > $now;
                            $isAktif = !$isArchive && !$belumMulai && !$adaLaporanMasuk;
                        @endphp

                        <div x-show="matchMission('{{ $tugas->judul }}') && ((tugasTab === 'perlu_review' && {{ ($adaLaporanMasuk && !$isArchive) ? 'true' : 'false' }}) || 
                                    (tugasTab === 'berjalan' && {{ $isAktif ? 'true' : 'false' }}) ||
                                    (tugasTab === 'mendatang' && {{ ($belumMulai && !$isArchive) ? 'true' : 'false' }}) ||
                                    (tugasTab === 'selesai' && {{ $isArchive ? 'true' : 'false' }}))"
                             class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm transition-all hover:border-emerald-500/30">
                            
                            <div class="p-8 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/20 flex justify-between items-center text-left leading-none">
                                <div class="text-left">
                                    <div class="flex items-center gap-3 mb-2">
                                        @if($semuaKruSelesai) <span class="text-[8px] font-black text-emerald-500 uppercase italic border-l-2 border-emerald-500 pl-2">Validated</span>
                                        @elseif($sudahDeadline) <span class="text-[8px] font-black text-rose-500 uppercase italic border-l-2 border-rose-500 pl-2">Expired</span>
                                        @elseif($adaLaporanMasuk) <span class="flex h-2 w-2 rounded-full bg-amber-500 animate-ping"></span><span class="text-[8px] font-black text-amber-500 uppercase">Input Baru</span>
                                        @else <span class="text-[8px] font-black text-zinc-400 uppercase italic">Operational</span> @endif
                                    </div>
                                    <h4 class="font-black text-xl text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none">{{ $tugas->judul }}</h4>
                                    <p class="text-[9px] font-black text-rose-500 uppercase mt-2 leading-none italic tracking-widest leading-none">Batas: {{ $tugas->tgl_selesai->format('d M Y, H:i') }}</p>
                                </div>
                                <button @click="editTugas({{ $tugas->toJson() }})" class="px-5 py-2.5 bg-zinc-100 dark:bg-zinc-800 rounded-xl text-[9px] font-black uppercase tracking-widest text-zinc-500 hover:text-zinc-900 border border-zinc-200 dark:border-zinc-700 italic shadow-sm transition-all leading-none">Konfigurasi</button>
                            </div>

                            <div class="overflow-x-auto text-left leading-none">
                                <table class="w-full text-left border-collapse leading-none">
                                    <thead class="bg-zinc-50/30 dark:bg-zinc-950/10 text-[9px] font-black uppercase tracking-widest text-zinc-400">
                                        <tr>
                                            <th class="px-8 py-4">Kru Pelaksana</th>
                                            <th class="px-6 py-4 text-center">Status</th>
                                            <th class="px-6 py-4">Pesan Laporan</th>
                                            <th class="px-8 py-4 text-right">Opsi Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                                        @foreach($tugas->karyawans as $karyawan)
                                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/10 transition-all duration-200">
                                            <td class="px-8 py-6 font-bold text-zinc-700 dark:text-zinc-200 italic text-left">{{ $karyawan->name }}</td>
                                            <td class="px-6 py-6 text-center text-left leading-none">
                                                <span class="px-3 py-1.5 rounded-lg text-[8px] font-black uppercase italic border
                                                    {{ $karyawan->pivot->status == 'selesai' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 
                                                       ($karyawan->pivot->status == 'dikumpulkan' ? 'bg-amber-500/10 text-amber-600 border-amber-500/20 animate-pulse' : 'bg-zinc-100 text-zinc-400 border-zinc-200') }}">
                                                    {{ $karyawan->pivot->status == 'dikumpulkan' ? 'LAPORAN BARU' : $karyawan->pivot->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 max-w-xs text-left leading-none">
                                                <p class="text-xs text-zinc-500 italic line-clamp-1 truncate">{{ $karyawan->pivot->pesan_karyawan ?? '-' }}</p>
                                            </td>
                                            <td class="px-8 py-6 text-right leading-none">
                                                <div class="flex justify-end gap-2 text-left">
                                                    @if($karyawan->pivot->status != 'pending')
                                                    <button @click="selectedKaryawanTugas = {
                                                        tugas_id: {{ $tugas->id }},
                                                        user_id: {{ $karyawan->id }},
                                                        name: '{{ $karyawan->name }}',
                                                        judul: '{{ $tugas->judul }}',
                                                        status: '{{ $karyawan->pivot->status }}',
                                                        pesan: '{{ addslashes($karyawan->pivot->pesan_karyawan) }}',
                                                        link: '{{ $karyawan->pivot->link_tautan }}',
                                                        file: '{{ $karyawan->pivot->file_hasil }}'
                                                    }; openViewLaporan = true" class="p-2.5 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-xl hover:scale-105 shadow-md">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    </button>
                                                    @else
                                                    <span class="text-[8px] font-black text-zinc-300 uppercase italic">Standby</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="openTugas" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md transition-opacity" @click="openTugas = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] max-w-2xl w-full p-8 md:p-12 z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar text-left"
                 x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4">
                
                <div class="flex justify-between items-start mb-8">
                    <h3 class="text-2xl font-black uppercase italic text-zinc-800 dark:text-white tracking-tighter text-left leading-none" x-text="isEdit ? 'Konfigurasi Misi' : 'Delegasi Misi Baru'"></h3>
                    
                    <template x-if="isEdit">
                        <form :action="'{{ url('mentor/tugas/destroy') }}/' + formTugas.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapuskan misi ini secara permanen dari sistem operasional?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-500/10 text-rose-500 rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all border border-rose-500/20">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Terminate Mission
                            </button>
                        </form>
                    </template>
                </div>

                <form :action="isEdit ? '{{ url('mentor/tugas/update') }}/' + formTugas.id : '{{ route('mentor.tugas.store') }}'" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-5 text-left">
                        <div class="text-left">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 leading-none block mb-2">Judul Misi</label>
                            <input type="text" name="judul" x-model="formTugas.judul" required class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-emerald-500 shadow-inner leading-none">
                        </div>
                        <div class="text-left">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 leading-none block mb-2">Briefing Operasional</label>
                            <textarea name="deskripsi" x-model="formTugas.deskripsi" rows="3" required class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-emerald-500 shadow-inner leading-relaxed"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-left leading-none">
                            <div class="text-left leading-none">
                                <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 leading-none block mb-2">Start</label>
                                <input type="datetime-local" name="tgl_mulai" x-model="formTugas.tgl_mulai" required class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-xs text-zinc-700 dark:text-zinc-300 shadow-inner">
                            </div>
                            <div class="text-left leading-none">
                                <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest ml-2 leading-none block mb-2">End</label>
                                <input type="datetime-local" name="tgl_selesai" x-model="formTugas.tgl_selesai" required class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-xs text-zinc-700 dark:text-zinc-300 shadow-inner">
                            </div>
                        </div>
                        <div class="text-left pt-2 leading-none">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2 block mb-3 text-left italic leading-none">Kru Pelaksana Operasi:</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-left">
                                @foreach($karyawanDivisi as $k)
                                <label class="group/item flex items-center gap-4 p-4 bg-zinc-50 dark:bg-zinc-950 rounded-2xl border border-zinc-200 dark:border-zinc-800 cursor-pointer hover:border-emerald-500 transition-all shadow-sm leading-none">
                                    <input type="checkbox" name="karyawan_ids[]" value="{{ $k->id }}" x-model="formTugas.karyawan_ids" class="w-5 h-5 rounded-lg border-zinc-300 dark:border-zinc-700 text-emerald-500 focus:ring-emerald-500 bg-white dark:bg-zinc-900 leading-none">
                                    <div class="text-left leading-none">
                                        <p class="text-[11px] font-black text-zinc-700 dark:text-zinc-200 uppercase leading-none group-hover/item:text-emerald-500 italic">{{ $k->name }}</p>
                                        <p class="text-[8px] font-bold text-zinc-400 uppercase mt-1 leading-none italic">Unit Operational</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-6 text-left leading-none">
                        <button type="submit" class="w-full bg-emerald-500 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl hover:bg-emerald-600 transition-all italic active:scale-95 leading-none uppercase" x-text="isEdit ? 'SINKRONISASI KONFIGURASI' : 'LUNCURKAN OPERASI'"></button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="openViewLaporan" class="fixed inset-0 z-[110] flex items-center justify-center p-6" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md transition-opacity" @click="openViewLaporan = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[3rem] max-w-xl w-full p-10 z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl overflow-hidden text-left" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.3)]"></div>
                <div class="text-left space-y-8">
                    <div class="text-left leading-none">
                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic leading-none">Report Intelligence Summary</span>
                        <h3 class="text-3xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-2 leading-none" x-text="selectedKaryawanTugas?.name"></h3>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase mt-2 italic tracking-widest border-l-2 border-zinc-200 dark:border-zinc-700 pl-3 ml-1 leading-none" x-text="selectedKaryawanTugas?.judul"></p>
                    </div>
                    <div class="p-7 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 italic text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed shadow-inner min-h-[120px]" x-text="selectedKaryawanTugas?.pesan"></div>
                    <div class="grid grid-cols-1 gap-4 text-left leading-none">
                        <template x-if="selectedKaryawanTugas?.file">
                            <a :href="'{{ asset('storage') }}/' + selectedKaryawanTugas?.file" target="_blank" class="group flex items-center justify-center gap-3 p-5 rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-black text-[10px] uppercase tracking-widest shadow-sm hover:scale-[1.02] transition-all italic border border-zinc-200 dark:border-zinc-700 leading-none">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-y-[-2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4 4m4 4V4"/></svg>
                                DOWNLOAD DOKUMEN TRANSMISI
                            </a>
                        </template>

                        <template x-if="selectedKaryawanTugas?.link && selectedKaryawanTugas?.link !== 'null'">
                            <a :href="selectedKaryawanTugas?.link" target="_blank" class="group flex items-center justify-center gap-3 p-5 rounded-2xl bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-all italic leading-none">
                                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                BUKA TAUTAN EKSTERNAL
                            </a>
                        </template>
                    </div>
                    <template x-if="selectedKaryawanTugas?.status == 'dikumpulkan'">
                        <form :action="'{{ url('mentor/tugas/selesai') }}/' + selectedKaryawanTugas?.tugas_id + '/' + selectedKaryawanTugas?.user_id" method="POST" class="pt-4 border-t border-zinc-100 dark:border-zinc-800 text-left leading-none">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-500 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20 italic hover:bg-emerald-600 transition-all active:scale-95 leading-none uppercase">OTORISASI MISI SELESAI</button>
                        </form>
                    </template>
                </div>
            </div>
        </div>

        <div x-show="openDetailAbsen" class="fixed inset-0 z-[120] flex items-center justify-center p-6" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md transition-opacity" @click="openDetailAbsen = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] max-w-lg w-full p-10 z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl overflow-hidden text-left" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95">
                <div class="text-left space-y-6">
                    <div class="text-left border-l-4 border-emerald-500 pl-4 text-left leading-none">
                        <span class="text-[9px] font-black text-zinc-400 uppercase tracking-widest block italic leading-none">Operational Log Entry</span>
                        <h3 class="text-2xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-2 tabular-nums leading-none" x-text="selectedAbsen?.tanggal"></h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-left leading-none uppercase italic">
                        <div class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <span class="text-[8px] font-black text-zinc-400 block mb-1">Entry</span>
                            <p class="text-lg font-black text-zinc-800 dark:text-zinc-200 tabular-nums" x-text="selectedAbsen?.jam_masuk"></p>
                        </div>
                        <div class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <span class="text-[8px] font-black text-zinc-400 block mb-1">Exit</span>
                            <p class="text-lg font-black text-zinc-800 dark:text-zinc-200 tabular-nums" x-text="selectedAbsen?.jam_keluar || '--:--'"></p>
                        </div>
                    </div>
                    <div class="p-5 rounded-2xl bg-zinc-900 text-white shadow-xl border border-zinc-800 text-left leading-none">
                        <span class="text-[8px] font-black text-zinc-500 uppercase block mb-2 tracking-widest italic text-emerald-500 leading-none uppercase">Briefing Report</span>
                        <p class="text-sm font-bold italic text-zinc-300 leading-relaxed" x-text="selectedAbsen?.kegiatan_harian || 'Catatan aktivitas nihil.'"></p>
                    </div>
                    <div class="aspect-video rounded-2xl bg-zinc-200 dark:bg-zinc-950 overflow-hidden border border-zinc-200 dark:border-zinc-800 group relative leading-none">
                        <template x-if="selectedAbsen?.foto_bukti"><img :src="'/storage/' + selectedAbsen?.foto_bukti" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"></template>
                        <div x-show="!selectedAbsen?.foto_bukti" class="w-full h-full flex flex-col items-center justify-center text-[9px] font-black text-zinc-400 uppercase italic opacity-50"><svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>Evidence Missing</div>
                    </div>
                    <button @click="openDetailAbsen = false" class="w-full py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 font-black text-[10px] uppercase rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all italic tracking-widest leading-none">TUTUP LOG DATA</button>
                </div>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #3f3f46; }
        input[type="datetime-local"] { outline: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
    </style>
</x-app-layout>