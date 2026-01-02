{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Presensi & Laporan Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <p class="text-sm font-medium text-slate-500">Tanggal Hari Ini</p>
                    <p class="text-lg font-bold text-slate-900">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <p class="text-sm font-medium text-slate-500 text-emerald-600">Jam Masuk</p>
                    <p class="text-lg font-bold text-slate-900">{{ $absenHariIni->jam_masuk ?? '--:--' }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <p class="text-sm font-medium text-slate-500 text-rose-600">Jam Pulang</p>
                    <p class="text-lg font-bold text-slate-900">{{ $absenHariIni->jam_keluar ?? '--:--' }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-8 text-center">
                    
                    @if(!$absenHariIni)
                        <div class="max-w-md mx-auto">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-900">Selamat Pagi, {{ Auth::user()->name }}!</h3>
                                <p class="text-slate-500 mt-2">Silakan klik tombol di bawah untuk mencatat kehadiran masuk Anda.</p>
                            </div>
                            <form action="{{ route('absen.masuk') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.01]">
                                    Absen Masuk Sekarang
                                </button>
                            </form>
                        </div>

                    @elseif($absenHariIni && !$absenHariIni->jam_keluar)
                        <div class="max-w-2xl mx-auto text-left">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 text-center">Laporan Pertanggungjawaban</h3>
                            <p class="text-sm text-slate-500 mb-6 text-center italic text-rose-500 font-medium">Sesuai aturan DSM CORE: Wajib isi laporan & upload foto bukti untuk absen keluar.</p>
                            
                            <form action="{{ route('absen.keluar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-5">
                                    <div>
                                        <x-input-label for="kegiatan_harian" :value="__('Kegiatan Hari Ini (Min. 20 Karakter)')" />
                                        <textarea id="kegiatan_harian" name="kegiatan_harian" rows="4" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" required>{{ old('kegiatan_harian') }}</textarea>
                                        <x-input-error :messages="$errors->get('kegiatan_harian')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="progres_perubahan" :value="__('Progres (Apa yang berubah dari sebelumnya?)')" />
                                        <textarea id="progres_perubahan" name="progres_perubahan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" required>{{ old('progres_perubahan') }}</textarea>
                                        <x-input-error :messages="$errors->get('progres_perubahan')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="foto_bukti" :value="__('Unggah Foto Bukti Kerja (Maks 2MB)')" />
                                        <input type="file" id="foto_bukti" name="foto_bukti" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required />
                                        <x-input-error :messages="$errors->get('foto_bukti')" class="mt-2" />
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="w-full py-4 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.01]">
                                            Kirim Laporan & Absen Keluar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    @else
                        <div class="py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 rounded-full mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900">Tugas Tuntas!</h3>
                            <p class="text-slate-500 mt-2">Terima kasih atas dedikasi Anda hari ini. Laporan Anda telah tersimpan.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}