<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 text-left">
            <a href="{{ route('mentor.personnel') }}" class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-xl text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex flex-col leading-none text-left">
                <h2 class="font-black text-3xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none text-left">
                    Laporan <span class="text-zinc-300 dark:text-zinc-700">Intelijen Personel</span>
                </h2>
                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.4em] mt-1 italic leading-none text-left">Data Operasional Terverifikasi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 text-left" x-data="attendanceManager()">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-10 text-left">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 leading-none text-left">
                <div class="lg:col-span-1 bg-zinc-900 dark:bg-white p-8 rounded-[2.5rem] text-white dark:text-black flex flex-col justify-center relative overflow-hidden shadow-2xl text-left">
                    <div class="relative z-10 text-left leading-none">
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50 italic block text-left leading-none">Identitas Unit</span>
                        <h3 class="text-4xl font-black uppercase italic tracking-tighter mt-4 leading-tight text-left leading-none text-white dark:text-black">{{ $user->name }}</h3>
                        <div class="flex items-center gap-2 mt-4 leading-none text-left">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse leading-none"></span>
                            <p class="text-[10px] font-black opacity-70 uppercase tracking-widest leading-none">Divisi {{ $user->divisi }}</p>
                        </div>
                        <p class="text-[9px] font-bold text-zinc-400 dark:text-zinc-500 mt-6 uppercase leading-none text-left leading-none">ID Kontrol: OS-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 leading-none text-left text-left">
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-[2rem] border border-zinc-200 dark:border-zinc-800 text-left shadow-sm flex flex-col justify-between leading-none text-left text-left text-left">
                        <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest block text-left leading-none text-left">Misi Selesai</span>
                        <div class="flex items-baseline gap-2 mt-4 leading-none text-left text-left text-left text-left">
                            <span class="text-5xl font-black text-zinc-800 dark:text-white italic leading-none">{{ $stats['selesai'] }}</span>
                            <span class="text-xs font-bold text-zinc-400 uppercase leading-none">Unit</span>
                        </div>
                        <div class="mt-6 h-1.5 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden text-left leading-none text-left">
                            <div class="h-full bg-emerald-500" style="width: {{ $stats['success_rate'] }}%"></div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-[2rem] border border-zinc-200 dark:border-zinc-800 text-left shadow-sm flex flex-col justify-between leading-none text-left text-left text-left">
                        <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest block text-left leading-none">Keberhasilan</span>
                        <div class="flex items-baseline gap-1 mt-4 text-emerald-500 leading-none text-left text-left">
                            <span class="text-5xl font-black italic leading-none">{{ $stats['success_rate'] }}</span>
                            <span class="text-xl font-black italic leading-none">%</span>
                        </div>
                        <p class="text-[9px] font-bold text-zinc-400 mt-6 uppercase italic leading-none block text-left leading-none text-left text-left text-left">Efektivitas Operasi</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 p-8 rounded-[2rem] border border-zinc-200 dark:border-zinc-800 text-left shadow-sm flex flex-col justify-between leading-none text-left text-left text-left text-left text-left">
                        <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest block text-left leading-none text-left text-left text-left text-left">Kedisiplinan</span>
                        <div class="flex items-baseline gap-2 mt-4 leading-none text-left text-left text-left text-left text-left">
                            <span class="text-5xl font-black {{ $user->poin < 50 ? 'text-rose-500' : 'text-zinc-800 dark:text-white' }} italic leading-none tabular-nums text-left leading-none text-left text-left">{{ $user->poin }}</span>
                        </div>
                        <p class="text-[9px] font-bold text-zinc-400 mt-6 uppercase italic leading-none block text-left leading-none text-left text-left text-left text-left text-left text-left">Kredit Poin Saat Ini</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-5 gap-10 leading-none text-left">
                
                <div class="xl:col-span-3 space-y-6 text-left leading-none text-left text-left text-left text-left">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 leading-none text-left text-left text-left">
                        <div class="flex items-center gap-3 text-left leading-none text-left text-left text-left text-left text-left">
                            <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)] leading-none text-left text-left text-left text-left text-left"></div>
                            <h4 class="text-xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none text-left text-left text-left text-left">Riwayat Operasi Misi</h4>
                        </div>
                        <div class="flex bg-zinc-100 dark:bg-zinc-800 p-1 rounded-xl shadow-inner leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                            <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="px-3 py-1.5 text-[9px] font-black uppercase rounded-lg transition-all leading-none">Semua</button>
                            <button @click="activeTab = 'berjalan'" :class="activeTab === 'berjalan' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="px-3 py-1.5 text-[9px] font-black uppercase rounded-lg transition-all leading-none text-left text-left text-left">Aktif</button>
                            <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm' : 'text-zinc-400'" class="px-3 py-1.5 text-[9px] font-black uppercase rounded-lg transition-all leading-none text-left text-left text-left">Selesai</button>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                        <div class="overflow-x-auto max-h-[500px] overflow-y-auto custom-scrollbar leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                            <table class="w-full text-left border-collapse leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                <thead class="sticky top-0 bg-zinc-50 dark:bg-zinc-950 z-20 text-[9px] font-black text-zinc-400 uppercase tracking-widest border-b border-zinc-100 dark:border-zinc-800 text-left text-left text-left text-left text-left text-left text-left text-left">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-left text-left text-left">Misi</th>
                                        <th class="px-4 py-5 text-center text-left text-left text-left text-left text-left">Status</th>
                                        <th class="px-4 py-5 text-center leading-none text-left text-left text-left text-left text-left text-left text-left">Deadline</th>
                                        <th class="px-4 py-5 text-center leading-none text-left text-left text-left text-left text-left text-left text-left text-left">Dikumpulkan</th>
                                        <th class="px-8 py-5 text-right text-left text-left text-left text-left text-left text-left text-left text-left text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50 leading-none text-left text-left text-left text-left text-left">
                                    @foreach($user->tugas as $t)
                                    <tr x-show="activeTab === 'semua' || (activeTab === 'berjalan' && '{{ $t->pivot->status }}' !== 'selesai') || (activeTab === 'selesai' && '{{ $t->pivot->status }}' === 'selesai')"
                                        class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/10 transition-all group leading-none text-left text-left text-left text-left text-left">
                                        <td class="px-8 py-6 text-left leading-none text-left text-left text-left text-left text-left">
                                            <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200 group-hover:text-emerald-500 transition-colors italic mb-1 leading-none text-left text-left text-left text-left whitespace-nowrap">{{ $t->judul }}</p>
                                            <p class="text-[8px] font-black text-zinc-400 uppercase opacity-50 italic leading-none text-left text-left text-left text-left text-left text-left text-left">CODE: {{ $t->id }}</p>
                                        </td>
                                        <td class="px-4 py-6 text-center leading-none text-left text-left text-left text-left text-left text-left text-left">
                                            <span class="px-3 py-1.5 rounded-lg text-[8px] font-black uppercase italic border leading-none text-left text-left text-left text-left text-left
                                                {{ $t->pivot->status == 'selesai' ? 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20' : 'text-zinc-400 bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-left text-left text-left text-left text-left text-left' }}">
                                                {{ $t->pivot->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-6 text-center leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                                            <p class="text-[10px] font-black text-rose-500 tabular-nums italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">{{ $t->tgl_selesai->format('d/m H:i') }}</p>
                                        </td>
                                        <td class="px-4 py-6 text-center leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                            <div class="flex flex-col items-center gap-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                                <p class="text-[10px] font-black {{ $t->pivot->tgl_pengumpulan && $t->pivot->tgl_pengumpulan <= $t->tgl_selesai ? 'text-emerald-500' : 'text-rose-500' }} tabular-nums italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                                    {{ $t->pivot->tgl_pengumpulan ? \Carbon\Carbon::parse($t->pivot->tgl_pengumpulan)->format('d/m H:i') : '---' }}
                                                </p>
                                                @if($t->pivot->tgl_pengumpulan)
                                                    @php $diff = \Carbon\Carbon::parse($t->pivot->tgl_pengumpulan)->diffInMinutes($t->tgl_selesai, false); @endphp
                                                    <span class="text-[7px] font-bold uppercase {{ $diff >= 0 ? 'text-zinc-400' : 'text-rose-600' }} leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                                        {{ $diff >= 0 ? 'On Time' : 'Telat ' . abs(round($diff/60, 1)) . ' Jam' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                            @if($t->pivot->status == 'selesai' || $t->pivot->status == 'dikumpulkan')
                                                <button @click="openMissionDetail('{{ addslashes($t->judul) }}', '{{ addslashes($t->deskripsi) }}', '{{ addslashes($t->pivot->pesan_karyawan) }}', '{{ $t->pivot->link_tautan }}', '{{ $t->pivot->file_hasil }}')" 
                                                    class="p-2.5 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-xl hover:scale-110 shadow-md transition-all leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            @else
                                                <span class="text-[8px] font-black text-zinc-300 uppercase italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left">Standby</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-2 space-y-6 text-left leading-none text-left text-left text-left text-left text-left text-left text-left">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                        <div class="flex items-center gap-3 text-left leading-none text-left text-left text-left text-left text-left text-left text-left">
                            <div class="w-1.5 h-6 bg-zinc-900 dark:bg-white rounded-full leading-none text-left text-left text-left text-left text-left text-left text-left text-left"></div>
                            <h4 class="text-xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter leading-none text-left text-left text-left text-left text-left text-left text-left">Heatmap Aktivitas</h4>
                        </div>
                        <div class="flex items-center gap-2 bg-zinc-100 dark:bg-zinc-800 p-1 rounded-xl shadow-inner leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                            <button @click="prevMonth()" class="p-1.5 hover:bg-white dark:hover:bg-zinc-700 rounded-lg text-zinc-400 hover:text-emerald-500 transition-all leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <span class="text-[9px] font-black uppercase text-zinc-600 dark:text-zinc-300 px-2 italic tracking-widest min-w-[110px] text-center leading-none text-left text-left text-left text-left text-left text-left text-left text-left" x-text="monthLabel"></span>
                            <button @click="nextMonth()" class="p-1.5 hover:bg-white dark:hover:bg-zinc-700 rounded-lg text-zinc-400 hover:text-emerald-500 transition-all leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 p-8 shadow-sm relative overflow-hidden leading-none text-left text-left text-left text-left text-left text-left text-left text-left">
                        <div class="grid grid-cols-7 gap-2 mb-6 text-center leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                            <template x-for="dayName in ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']">
                                <span class="text-[7px] font-black text-zinc-400 uppercase tracking-widest leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-center text-left" x-text="dayName"></span>
                            </template>
                        </div>

                        <div class="grid grid-cols-7 gap-2 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                            <template x-for="blank in blankDays">
                                <div class="aspect-square bg-transparent leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left"></div>
                            </template>
                            
                            <template x-for="day in daysInMonth" :key="currentDate.getTime() + day">
                                <div class="group relative aspect-square rounded-md border border-black/5 dark:border-white/5 transition-all duration-300 cursor-help flex items-center justify-center text-left text-left text-left text-left"
                                     :class="getHeatmapClass(day)"
                                     x-init="initTippy($el, day)">
                                    <span class="text-[8px] font-black opacity-30 group-hover:opacity-100 transition-opacity leading-none text-left text-left text-left text-left text-left" :class="getAttendanceData(day) ? 'text-white' : 'text-zinc-400'" x-text="day"></span>
                                </div>
                            </template>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-3 pt-6 border-t border-zinc-50 dark:border-zinc-800/50 text-[7px] font-black uppercase text-zinc-400 italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                            <div class="flex items-center gap-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left"><span class="w-2 h-2 bg-emerald-500 rounded-sm leading-none text-left text-left text-left text-left text-left text-left"></span> Hadir</div>
                            <div class="flex items-center gap-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left"><span class="w-2 h-2 bg-amber-500 rounded-sm leading-none text-left text-left text-left text-left text-left text-left"></span> Izin</div>
                            <div class="flex items-center gap-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left"><span class="w-2 h-2 bg-blue-500 rounded-sm leading-none text-left text-left text-left text-left text-left text-left text-left"></span> Sakit</div>
                            <div class="flex items-center gap-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left"><span class="w-2 h-2 bg-rose-500 rounded-sm leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left"></span> Alpha</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openViewLaporan" class="fixed inset-0 z-[110] flex items-center justify-center p-6 text-left text-left text-left text-left" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md transition-opacity leading-none text-left text-left text-left text-left text-left" @click="openViewLaporan = false"></div>
            <div class="bg-white dark:bg-zinc-900 rounded-[3rem] max-w-xl w-full p-10 z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl overflow-hidden text-left text-left text-left text-left text-left" 
                 x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 leading-none text-left text-left text-left text-left text-left">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.3)] leading-none text-left text-left text-left text-left text-left text-left text-left"></div>
                <div class="text-left space-y-8 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                    <div class="text-left leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic mb-2 block leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">Mission Intelligence Report</span>
                        <h3 class="text-3xl font-black text-zinc-800 dark:text-white uppercase italic tracking-tighter mt-1 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left" x-text="selectedKaryawanTugas?.judul"></h3>
                    </div>
                    <div class="space-y-4 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                        <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">Briefing & Catatan Pengumpulan</p>
                        <div class="p-6 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                            <p class="text-xs text-zinc-500 uppercase font-black mb-2 opacity-50 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">Deskripsi Awal:</p>
                            <p class="text-sm text-zinc-800 dark:text-zinc-200 leading-relaxed mb-6 italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left" x-text="selectedKaryawanTugas?.deskripsi"></p>
                            <p class="text-xs text-zinc-500 uppercase font-black mb-2 opacity-50 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">Pesan Karyawan:</p>
                            <p class="text-sm text-emerald-600 dark:text-emerald-400 leading-relaxed italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left" x-text="selectedKaryawanTugas?.pesan || 'Tidak ada pesan laporan.'"></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                        <template x-if="selectedKaryawanTugas?.link && selectedKaryawanTugas?.link !== 'null'">
                            <a :href="selectedKaryawanTugas?.link" target="_blank" class="group flex items-center justify-center gap-3 p-5 rounded-2xl bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-all italic leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                <svg class="w-5 h-5 leading-none text-left text-left text-left text-left text-left text-left text-left text-left" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                BUKA TAUTAN EKSTERNAL
                            </a>
                        </template>
                        <template x-if="selectedKaryawanTugas?.file">
                            <a :href="'{{ asset('storage') }}/' + selectedKaryawanTugas?.file" target="_blank" class="group flex items-center justify-center gap-3 p-5 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-black font-black text-[10px] uppercase tracking-widest shadow-xl hover:scale-[1.02] transition-all italic border border-zinc-800 dark:border-zinc-200 leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-y-[-2px] leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                DOWNLOAD DOKUMEN HASIL
                            </a>
                        </template>
                    </div>
                    <button @click="openViewLaporan = false text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left" class="w-full py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 font-black text-[10px] uppercase rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all italic tracking-widest leading-none text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left text-left">KEMBALI KE LAPORAN</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    
    <script>
        function attendanceManager() {
            return {
                activeTab: 'semua',
                openViewLaporan: false,
                selectedKaryawanTugas: null,
                currentDate: new Date(),
                // SINKRONISASI KEY TANGGAL
                attendanceData: {
                    @foreach($riwayatAbsensi as $absen)
                    "{{ \Carbon\Carbon::parse($absen->tanggal)->format('Y-m-d') }}": {
                        masuk: '{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format("H:i") : "---" }}',
                        keluar: '{{ $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format("H:i") : "---" }}',
                        status: '{{ strtolower($absen->status ?? "hadir") }}',
                        tanggalStr: '{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat("d F Y") }}'
                    },
                    @endforeach
                },

                openMissionDetail(judul, deskripsi, pesan, link, file) {
                    this.selectedKaryawanTugas = { judul, deskripsi, pesan, link, file };
                    this.openViewLaporan = true;
                },

                get monthLabel() {
                    return this.currentDate.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                },
                get daysInMonth() {
                    return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
                },
                get blankDays() {
                    return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
                },
                prevMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1); },
                nextMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1); },
                
                getFormattedDate(day) {
                    const y = this.currentDate.getFullYear();
                    const m = String(this.currentDate.getMonth() + 1).padStart(2, '0');
                    const d = String(day).padStart(2, '0');
                    return `${y}-${m}-${d}`;
                },

                getAttendanceData(day) {
                    const dateKey = this.getFormattedDate(day);
                    return this.attendanceData[dateKey];
                },

                getHeatmapClass(day) {
                    const data = this.getAttendanceData(day);
                    if (!data) return 'bg-zinc-100 dark:bg-zinc-800/40';
                    
                    switch(data.status) {
                        case 'hadir': return 'bg-emerald-500 shadow-lg shadow-emerald-500/20';
                        case 'sakit': return 'bg-blue-500 shadow-lg shadow-blue-500/20';
                        case 'izin': return 'bg-amber-500 shadow-lg shadow-amber-500/20';
                        case 'alpha': return 'bg-rose-500 shadow-lg shadow-rose-500/20';
                        case 'selesai': return 'bg-emerald-500 shadow-lg shadow-emerald-500/20';
                        default: return 'bg-emerald-500';
                    }
                },

                getTooltipContent(day) {
                    const data = this.getAttendanceData(day);
                    if (!data) return null;

                    const statusLabels = { 'hadir': 'Hadir', 'sakit': 'Sakit', 'izin': 'Izin', 'alpha': 'Alpha', 'selesai': 'Hadir' };
                    const statusColor = { 'hadir': 'text-emerald-400', 'sakit': 'text-blue-400', 'izin': 'text-amber-400', 'alpha': 'text-rose-400', 'selesai': 'text-emerald-400' };

                    return `
                        <div class="p-3 bg-zinc-950 border border-zinc-800 rounded-xl shadow-2xl text-left leading-none text-left">
                            <p class="text-[8px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic leading-none text-left text-left">${day} ${this.monthLabel}</p>
                            <p class="text-[9px] font-black ${statusColor[data.status]} uppercase mb-3 italic tracking-widest leading-none text-left text-left text-left">STATUS: ${statusLabels[data.status]}</p>
                            <div class="flex gap-4 items-center text-left text-left text-left">
                                <div class="text-left text-left text-left text-left">
                                    <p class="text-[7px] font-bold text-zinc-600 uppercase mb-1 leading-none text-left text-left text-left">Entry</p>
                                    <p class="text-xs font-black text-zinc-100 italic leading-none text-left text-left text-left text-left">${data.masuk}</p>
                                </div>
                                <div class="w-[1px] h-6 bg-zinc-800 leading-none text-left text-left text-left text-left"></div>
                                <div class="text-left text-left text-left text-left">
                                    <p class="text-[7px] font-bold text-zinc-600 uppercase mb-1 leading-none text-left text-left text-left text-left text-left">Exit</p>
                                    <p class="text-xs font-black text-zinc-100 italic leading-none text-left text-left text-left text-left text-left text-left">${data.keluar}</p>
                                </div>
                            </div>
                        </div>
                    `;
                },

                initTippy(el, day) {
                    const content = this.getTooltipContent(day);
                    if (content) {
                        tippy(el, {
                            content: content,
                            allowHTML: true,
                            theme: 'material',
                            placement: 'top',
                            animation: 'shift-away',
                            appendTo: document.body
                        });
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #3f3f46; }
    </style>
</x-app-layout>

coba buat paginasinya di bagian misi (tabel) jangan pake scroll, tapi paginasi angka. buatkan full code nya lagi ya tanpa rusak yang lain._