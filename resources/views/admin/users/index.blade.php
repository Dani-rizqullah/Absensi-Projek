<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pb-6 border-b border-zinc-200 dark:border-zinc-800 transition-all duration-500">
            <div class="relative pl-6 text-left">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 dark:bg-white rounded-full"></div>
                <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-zinc-200 dark:border-zinc-700 rounded-full"></div>
                
                <nav class="flex items-center gap-2 mb-2 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">
                    <span>Sistem Inti</span>
                    <svg class="w-2.5 h-2.5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 dark:text-zinc-100">Otoritas Personel</span>
                </nav>
                <h2 class="font-black text-5xl tracking-tighter uppercase italic text-zinc-800 dark:text-white leading-none">
                    Control <span class="text-zinc-300 dark:text-zinc-600">Center</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ openEdit: false, selectedUser: {} }">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm relative transition-all duration-500">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50/50 dark:bg-zinc-950/20 border-b border-zinc-100 dark:border-zinc-800 text-[10px] font-black uppercase tracking-widest text-zinc-400">
                                <th class="px-8 py-6 tracking-[0.3em]">Personel</th>
                                <th class="px-6 py-6 text-center tracking-[0.3em]">Unit</th>
                                <th class="px-6 py-6 text-center tracking-[0.3em]">WhatsApp</th>
                                <th class="px-8 py-6 text-right tracking-[0.3em]">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                            @foreach($users as $user)
                            <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-all duration-300">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-xs italic shadow-lg shadow-zinc-500/10 dark:shadow-none">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-bold text-zinc-800 dark:text-zinc-100 italic leading-none group-hover:text-zinc-900 dark:group-hover:text-white">{{ $user->name }}</p>
                                            <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mt-1">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-[9px] font-black uppercase text-zinc-500 border border-zinc-200/50 dark:border-zinc-700">
                                        {{ $user->divisi }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center font-mono text-[11px] text-zinc-500 tabular-nums">
                                    {{ $user->no_wa }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="selectedUser = {{ json_encode($user) }}; openEdit = true" 
                                            class="p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all border border-zinc-200 dark:border-zinc-700 shadow-sm active:scale-95">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Terminasi personel ini dari sistem?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-400 hover:text-rose-600 transition-all border border-rose-100 dark:border-rose-500/20 shadow-sm active:scale-95">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="text-center mt-10 text-[9px] font-black text-zinc-400 uppercase tracking-[0.4em]">DSM CORE &bull; Personnel Authority System</p>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div class="absolute inset-0 bg-zinc-950/90 backdrop-blur-md" @click="openEdit = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
            
            <div class="bg-white dark:bg-zinc-900 rounded-[2.5rem] max-w-lg w-full p-10 z-10 relative border border-zinc-200 dark:border-zinc-800 shadow-2xl overflow-hidden"
                x-transition:enter="transition ease-out duration-300" 
                x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-zinc-800 dark:bg-white"></div>
                
                <h3 class="text-2xl font-black uppercase italic text-zinc-800 dark:text-white tracking-tighter mb-8">Edit <span class="text-zinc-400">Personel</span></h3>
                
                <form :action="'/admin/users/' + selectedUser.id" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div class="text-left">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2">Nama Lengkap</label>
                            <input type="text" name="name" x-model="selectedUser.name" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 transition-all">
                        </div>

                        <div class="text-left">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2">Sektor Unit</label>
                            <div class="relative">
                                <select id="divisi" name="divisi" x-model="selectedUser.divisi"
                                    class="block w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 shadow-inner p-4 appearance-none cursor-pointer" required>
                                    <option value="" disabled>-- Pilih Divisi --</option>
                                    <option value="Jurnalis">Jurnalis / Wartawan</option>
                                    <option value="Web Developer">Web Developer</option>
                                    <option value="UI/UX Design">UI/UX Design</option>
                                    <option value="Videographer/Editor">Videographer / Editor</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-400">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="text-left">
                            <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-2">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" x-model="selectedUser.no_wa" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 font-bold text-sm text-zinc-700 dark:text-zinc-300 focus:ring-zinc-500 transition-all tabular-nums">
                        </div>

                        <div class="text-left pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <label class="text-[9px] font-black text-rose-500 uppercase tracking-widest ml-2 italic">Reset Password (Isi jika perlu)</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-rose-500/5 dark:bg-rose-500/10 border-rose-500/20 rounded-2xl p-4 font-bold text-sm text-rose-600 dark:text-rose-400 placeholder-rose-300 focus:ring-rose-500 transition-all">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 font-black text-[10px] uppercase rounded-2xl hover:bg-zinc-200 transition-all italic tracking-widest">
                            Batal
                        </button>
                        <button type="submit" class="flex-[2] bg-zinc-900 dark:bg-white text-white dark:text-black py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] italic transition-all hover:opacity-80 active:scale-[0.98] shadow-xl shadow-zinc-500/10">
                            Otorisasi Pembaruan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>