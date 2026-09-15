@extends('layouts.app')

@section('title', 'Hasil Pencarian - PLN ULP Sukabumi')

@section('content')
<div class="bg-white dark:bg-slate-800 md:shadow-md md:rounded-2xl overflow-hidden w-full max-w-4xl mx-auto">
    
    <div class="p-6 md:p-10 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-br from-white dark:from-slate-800 to-gray-50 dark:to-slate-900">
        {{-- Back + judul pencarian --}}
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 dark:text-slate-400 text-sm mb-4 hover:text-[#0a1f44] dark:hover:text-blue-300 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="uppercase tracking-wider text-[10px] font-bold">Kembali ke Pencarian</span>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 mb-6">
            Hasil untuk "{{ $query ?? '-' }}"
            <span class="text-sm font-normal text-gray-500 dark:text-slate-400 block md:inline md:ml-2 mt-1 md:mt-0">
                (Kategori: {{ ucfirst($kategori ?? 'Semua') }})
            </span>
        </h1>

        @if ($hasil->isNotEmpty())
            @php
                $totalBangunan = $hasil->count();
                $prrCount = $hasil->where('status_prr', true)->count();
                $amanCount = $totalBangunan - $prrCount;
                $totalTunggakan = $hasil->sum('jumlah_tunggakan');
            @endphp
            
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm p-4 md:p-5 mb-2 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Ringkasan Area</h3>
                    <p class="text-sm text-gray-800 dark:text-slate-100 font-medium">
                        Total <b>{{ $totalBangunan }}</b> Bangunan terhubung. 
                        <span class="text-green-600 font-bold">{{ $amanCount }} Aman</span>, 
                        <span class="text-red-600 font-bold">{{ $prrCount }} PRR</span>.
                    </p>
                    @if($prrCount > 0)
                        <p class="text-xs font-bold text-red-600 mt-1">Total Tunggakan: Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</p>
                    @endif
                </div>
                
                @if($prrCount > 0 && $amanCount > 0 || request('status') === 'prr')
                    <div class="flex-shrink-0">
                        @if(request('status') === 'prr')
                            <a href="{{ route('search.results', ['query' => request('query'), 'kategori' => request('kategori')]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 text-gray-700 dark:text-slate-200 text-xs font-bold rounded-full transition-colors border border-gray-200 dark:border-slate-700">
                                <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                                Tampilkan Semua
                            </a>
                        @else
                            <a href="{{ route('search.results', ['query' => request('query'), 'kategori' => request('kategori'), 'status' => 'prr']) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-full transition-colors border border-red-200">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path></svg>
                                Sembunyikan yang Aman
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Sorting Dropdown --}}
            <div class="mt-4 flex justify-end">
                <form method="GET" action="{{ isset($isNearby) && $isNearby ? route('search.nearby') : route('search.results') }}" class="flex items-center gap-2">
                    @if(!isset($isNearby) || !$isNearby)
                        <input type="hidden" name="query" value="{{ request('query') }}">
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @else
                        <input type="hidden" name="lat" value="{{ request('lat') }}">
                        <input type="hidden" name="lng" value="{{ request('lng') }}">
                    @endif
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    
                    <label for="sort" class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Urutkan:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()" class="text-sm bg-white dark:bg-slate-800 text-gray-800 dark:text-slate-200 border-gray-200 dark:border-slate-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1.5 pl-3 pr-8 shadow-sm">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Relevansi (Jarak/Penting)</option>
                        <option value="tunggakan_desc" {{ request('sort') == 'tunggakan_desc' ? 'selected' : '' }}>Tunggakan Tertinggi</option>
                        <option value="tunggakan_asc" {{ request('sort') == 'tunggakan_asc' ? 'selected' : '' }}>Tunggakan Terendah</option>
                    </select>
                </form>
            </div>
        @endif

    </div>

    <div class="p-6 md:p-10 bg-gray-50 dark:bg-slate-900/50 min-h-[400px]">
        @if ($hasil->isEmpty())
            {{-- Empty state: Tidak ada di daftar PRR (Aman) --}}
            <div class="flex flex-col items-center justify-center text-center py-16 px-4">
                <div class="w-20 h-20 rounded-full bg-gray-50 dark:bg-slate-900 shadow-sm flex items-center justify-center mb-6 border border-gray-100 dark:border-slate-700">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-extrabold text-gray-700 dark:text-slate-200 mb-2">Data Tidak Ditemukan</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 max-w-md leading-relaxed font-medium">
                    Hasil untuk pencarian "<span class="font-bold text-gray-800 dark:text-slate-100">{{ $query ?? '-' }}</span>" tidak ditemukan dalam database.
                    <br><br>
                    <span class="text-xs text-gray-400 font-normal italic">*Pastikan ID atau alamat tidak salah ketik. Apabila sudah dipastikan benar namun tetap tidak ditemukan, kemungkinan besar aset tersebut belum terdata dalam sistem PLN.</span>
                </p>
                <a href="{{ route('dashboard') }}"
                   class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 dark:bg-slate-900 text-gray-700 dark:text-slate-200 font-medium
                          py-3 px-8 rounded-xl flex items-center gap-2 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z" />
                    </svg>
                    Cari Aset Lain
                </a>
            </div>
        @else
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm font-semibold text-gray-500 dark:text-slate-400">{{ $hasil->count() }} Aset Ditemukan</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach ($hasil as $item)
                    <a href="{{ route('bangunan.detail', ['id' => $item->id]) }}"
                       class="block bg-white dark:bg-slate-800 border {{ $item->status_prr ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-green-500' }} border-gray-100 dark:border-slate-700
                              rounded-xl p-5 hover:shadow-lg hover:border-r-gray-200 transition-all group relative overflow-hidden pr-12">
                        
                        @php
                            $statusText = $item->status_prr ? 'PRR (Ada Tunggakan Rp ' . number_format($item->jumlah_tunggakan, 0, ',', '.') . ')' : 'Normal (Aman)';
                            $template = "*[LAPORAN ASET PLN]*\n"
                                      . "ID Bangunan: {$item->id_bangunan}\n"
                                      . "No Tiang: {$item->no_tiang}\n"
                                      . "Alamat: {$item->alamat_lengkap}\n"
                                      . "Status: {$statusText}\n\n"
                                      . "*Keluhan / Catatan Petugas:*\n"
                                      . "- ";
                            $waText = rawurlencode($template);
                        @endphp

                        

                        
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between border-b border-gray-100 dark:border-slate-700 pb-3">
                                <span class="text-xs font-extrabold px-2.5 py-1 rounded bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 uppercase tracking-wider">
                                    {{ $item->id_bangunan }}
                                </span>
                                
                                <div class="flex items-center gap-2">
                                    <div class="text-right mr-1">
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">No Tiang</span>
                                        <span class="text-sm font-bold text-gray-800 dark:text-slate-100 whitespace-nowrap">{{ $item->no_tiang }}</span>
                                    </div>
                                    


                                    <!-- Bookmark Button -->
                                    <button type="button" 
                                            class="bookmark-btn w-7 h-7 rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex items-center justify-center text-gray-300 hover:scale-110 transition-all"
                                            data-id="{{ $item->id }}"
                                            data-idpel="{{ $item->id_bangunan }}"
                                            data-alamat="{{ $item->alamat_lengkap }}"
                                            data-prr="{{ $item->status_prr ? 1 : 0 }}"
                                            data-nominal="{{ $item->jumlah_tunggakan }}"
                                            onclick="event.preventDefault(); window.BookmarkSystem.toggle({id: this.dataset.id, idpel: this.dataset.idpel, alamat: this.dataset.alamat, prr: this.dataset.prr == '1', nominal: this.dataset.nominal}); window.dispatchEvent(new Event('bookmarksUpdated'));">
                                        <svg class="w-4 h-4 star-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-700 dark:text-slate-200 leading-relaxed font-medium mt-1">
                                {{ $item->alamat_lengkap }}
                            </p>
                            
                            <div class="mt-2 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 flex-wrap flex-1">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] sm:text-xs font-extrabold uppercase tracking-wider whitespace-nowrap
                                                 {{ $item->status_prr ? 'bg-red-50 text-red-700 ring-1 ring-red-600/30' : 'bg-green-50 text-green-700 ring-1 ring-green-600/30' }}">
                                        @if($item->status_prr)
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            PRR / ADA TUNGGAKAN
                                        @else
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            AMAN
                                        @endif
                                    </span>
                                    
                                    @if(isset($isNearby) && $isNearby && isset($item->distance))
                                        <span class="text-[10px] font-bold text-gray-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 px-2.5 py-1.5 rounded-md tracking-wider flex items-center gap-1 shadow-sm whitespace-nowrap">
                                            <svg class="w-3 h-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            {{ number_format($item->distance, 2) }} km
                                        </span>
                                    @endif
                                </div>

                                <div class="w-8 h-8 rounded-full bg-gray-50 dark:bg-slate-900 flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a1f44] dark:group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <p class="text-center text-xs font-semibold text-gray-400 mt-8 tracking-wider uppercase">
                Menampilkan semua {{ $hasil->count() }} hasil
            </p>
        @endif
    </div>
</div>

<script>
    function updateBookmarkButtons() {
        document.querySelectorAll('.bookmark-btn').forEach(btn => {
            const id = btn.dataset.id;
            if (window.BookmarkSystem && window.BookmarkSystem.isBookmarked(id)) {
                btn.classList.add('text-yellow-400', 'bg-yellow-50', 'dark:bg-yellow-900/30', 'border-yellow-200', 'dark:border-yellow-900/50');
                btn.classList.remove('text-gray-300', 'bg-white', 'dark:bg-slate-800', 'border-gray-200', 'dark:border-slate-700');
            } else {
                btn.classList.remove('text-yellow-400', 'bg-yellow-50', 'dark:bg-yellow-900/30', 'border-yellow-200', 'dark:border-yellow-900/50');
                btn.classList.add('text-gray-300', 'bg-white', 'dark:bg-slate-800', 'border-gray-200', 'dark:border-slate-700');
            }
        });
    }

    // Update initially if BookmarkSystem is already loaded
    if (window.BookmarkSystem) {
        updateBookmarkButtons();
    } else {
        // Fallback if script loads before BookmarkSystem
        window.addEventListener('load', updateBookmarkButtons);
    }

    window.addEventListener('bookmarksUpdated', updateBookmarkButtons);
</script>
@endsection