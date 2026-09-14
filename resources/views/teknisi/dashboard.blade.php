@extends('layouts.app')

@section('title', 'Pencarian PRR - PLN ULP Sukabumi')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-2 md:py-0">
    
    {{-- Top Greeting (Desktop only or optional) --}}
    <div class="hidden md:flex items-center gap-3 mb-4">
        <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Halo, {{ explode(' ', Auth::user()->name ?? 'Petugas')[0] }}</h1>
        <div class="flex items-center gap-1.5 px-3 py-1 bg-green-50 dark:bg-green-900/30 rounded-full border border-green-200 dark:border-green-800">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-xs font-bold text-green-700 dark:text-green-400">Petugas Online</span>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-sm md:shadow-md rounded-3xl mb-4 border border-gray-100 dark:border-slate-700">
        
        {{-- Search Section --}}
        <div class="p-6 md:p-10">
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-slate-100 tracking-tight mb-3">Dashboard Pencarian</h2>
            <p class="text-sm md:text-base text-gray-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                Temukan status PRR berdasarkan identitas fisik aset di lapangan (tiang, gardu, atau persil bangunan).
            </p>

            <form method="GET" action="{{ route('search.results') }}" class="mt-8 max-w-3xl" id="search-form">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Search input --}}
                    <div class="relative flex-1 group">
                        <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-[#0a1f44] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z" />
                        </svg>
                        <input
                            type="text"
                            name="query"
                            id="search-input"
                            placeholder="Masukkan ID Tiang, Gardu, atau Alamat..."
                            class="w-full border-2 border-gray-100 dark:border-slate-700 rounded-2xl pl-14 pr-24 py-4 text-gray-800 dark:text-slate-200 bg-white dark:bg-slate-900
                                   focus:outline-none focus:border-[#0a1f44] dark:focus:border-blue-500 transition-colors text-base md:text-lg font-medium shadow-sm hover:shadow-md focus:shadow-md"
                            required
                        >
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1">
                            <button type="button" id="mic-btn" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors focus:outline-none" title="Pencarian Suara">
                                <svg id="mic-icon" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                            <a href="{{ route('scan') }}" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors focus:outline-none" title="Scan Barcode/QR">
                                <svg class="w-5 h-5 text-gray-400 hover:text-[#0a1f44]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex flex-col md:flex-row gap-3">
                        <button type="submit"
                                class="w-full md:w-auto px-8 bg-[#0a1f44] hover:bg-blue-900 text-white font-bold tracking-wide
                                       py-4 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20 hover:shadow-xl transition-all hover:-translate-y-0.5">
                            CARI
                        </button>
                        
                        <button type="button" id="gps-btn"
                                class="w-full md:w-auto px-6 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-[#0a1f44] dark:text-blue-300 font-bold tracking-wide
                                       py-4 rounded-2xl border-2 border-gray-100 dark:border-slate-700 flex items-center justify-center gap-2 shadow-sm transition-all">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Terdekat
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="border-t border-gray-100 dark:border-slate-700"></div>

        {{-- Pencarian Terakhir --}}
        <div class="p-6 md:p-10 bg-gray-50/50 dark:bg-slate-900/50 rounded-b-3xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4">
                <h3 class="text-xs md:text-sm font-black text-gray-400 dark:text-slate-500 tracking-[0.2em] uppercase">Pencarian Terakhir Anda</h3>
                
                {{-- Dropdown Filter --}}
                <div class="relative">
                    <button type="button" onclick="document.getElementById('filter-dropdown').classList.toggle('hidden')"
                            class="flex items-center gap-2 bg-white dark:bg-slate-800 border-2 border-gray-100 dark:border-slate-700 hover:border-gray-200 text-gray-700 dark:text-slate-200 text-sm font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all focus:outline-none w-full sm:w-auto justify-between">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span id="active-filter-text">Semua Kategori</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-full sm:w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 z-20 overflow-hidden">
                        @php
                            $categories = [
                                'semua' => 'Semua Kategori',
                                'tiang' => 'Tiang',
                                'gardu' => 'Gardu',
                                'alamat' => 'Alamat',
                                'bangunan' => 'Bangunan',
                            ];
                        @endphp
                        <div class="py-1">
                            @foreach ($categories as $value => $label)
                                <button type="button" class="w-full text-left flex items-center px-5 py-3 hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer transition-colors group filter-option" data-value="{{ $value }}" data-label="{{ $label }}">
                                    <span class="text-sm text-gray-700 dark:text-slate-300 group-hover:text-[#0a1f44] font-bold filter-text">
                                        {{ $label }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @if($recentSearches->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada riwayat pencarian.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($recentSearches as $item)
                        @php
                            $kategori = strtolower($item->kategori_pencarian);
                            $badgeColor = match($kategori) {
                                'tiang' => 'bg-blue-100 text-blue-700',
                                'gardu' => 'bg-amber-100 text-amber-700',
                                'bangunan' => 'bg-emerald-100 text-emerald-700',
                                'alamat' => 'bg-purple-100 text-purple-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                            $borderColor = match($kategori) {
                                'tiang' => 'border-l-blue-400',
                                'gardu' => 'border-l-amber-400',
                                'bangunan' => 'border-l-emerald-400',
                                'alamat' => 'border-l-purple-400',
                                default => 'border-l-gray-300',
                            };
                        @endphp

                        @if($kategori === 'bangunan')
                            <a href="{{ route('bangunan.detail', ['id' => $item->kata_kunci]) }}"
                               class="recent-search-card flex items-center justify-between bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 border-l-4 {{ $borderColor }}
                                      rounded-2xl p-5 md:p-6 hover:shadow-lg transition-all group relative"
                               data-category="{{ $kategori }}">
                        @else
                            <a href="{{ route('search.results', ['query' => $item->kata_kunci, 'kategori' => $kategori]) }}"
                               class="recent-search-card flex items-center justify-between bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 border-l-4 {{ $borderColor }}
                                      rounded-2xl p-5 md:p-6 hover:shadow-lg transition-all group relative"
                               data-category="{{ $kategori }}">
                        @endif
                            
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider {{ $badgeColor }}">
                                        {{ $kategori }}
                                    </span>
                                </div>
                                <p class="text-lg md:text-xl font-black text-gray-900 dark:text-slate-100 group-hover:text-[#0a1f44] dark:group-hover:text-blue-300 transition-colors">
                                    {{ $item->kata_kunci }}
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-4 text-right">
                                <span class="hidden sm:block text-xs text-gray-400 font-semibold tracking-wide">
                                    {{ $item->updated_at->diffForHumans() }}
                                </span>
                                <div class="w-10 h-10 rounded-full border-2 border-gray-100 flex items-center justify-center group-hover:border-[#0a1f44] group-hover:bg-[#0a1f44] dark:border-slate-600 dark:group-hover:border-blue-500 dark:group-hover:bg-blue-500 transition-all">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter Logic
        const filterOptions = document.querySelectorAll('.filter-option');
        const searchCards = document.querySelectorAll('.recent-search-card');
        const activeFilterText = document.getElementById('active-filter-text');
        const dropdown = document.getElementById('filter-dropdown');

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.relative');
            if (!isClickInside && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        filterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const category = this.dataset.value;
                const label = this.dataset.label;

                activeFilterText.textContent = label;
                dropdown.classList.add('hidden');

                searchCards.forEach(card => {
                    if (category === 'semua' || (card.dataset.category && card.dataset.category.toLowerCase() === category.toLowerCase())) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        const micBtn = document.getElementById('mic-btn');
        const micIcon = document.getElementById('mic-icon');
        const searchInput = document.getElementById('search-input');

        // Voice Search Logic (Web Speech API)
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            
            recognition.lang = 'id-ID';
            recognition.continuous = false;
            recognition.interimResults = false;

            micBtn.addEventListener('click', (e) => {
                e.preventDefault();
                recognition.start();
                micIcon.classList.add('text-red-500', 'animate-pulse');
                searchInput.placeholder = "Mendengarkan...";
            });

            recognition.onresult = (event) => {
                searchInput.value = event.results[0][0].transcript;
            };

            recognition.onend = () => {
                micIcon.classList.remove('text-red-500', 'animate-pulse');
                searchInput.placeholder = "Masukkan ID Tiang, Gardu, atau Alamat...";
            };
        } else {
            micBtn.style.display = 'none';
        }

        // GPS Logic
        const gpsBtn = document.getElementById('gps-btn');
        if (gpsBtn) {
            gpsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const originalText = this.innerHTML;
                this.innerHTML = `<svg class="animate-spin w-5 h-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mencari...`;
                this.disabled = true;

                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        window.location.href = `/search-nearby?lat=${position.coords.latitude}&lng=${position.coords.longitude}`;
                    }, function(error) {
                        alert("Gagal mendapatkan lokasi. Pastikan GPS aktif.");
                        gpsBtn.innerHTML = originalText;
                        gpsBtn.disabled = false;
                    }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
                } else {
                    alert("Browser Anda tidak mendukung fitur lokasi GPS.");
                    gpsBtn.innerHTML = originalText;
                    gpsBtn.disabled = false;
                }
            });
        }
    });
</script>
@endpush
@endsection