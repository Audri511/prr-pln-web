@extends('layouts.app')

@section('title', 'Riwayat Aktivitas - PLN ULP Sukabumi')

@section('content')
<div class="bg-white dark:bg-slate-800 shadow-md rounded-[2rem] overflow-hidden max-w-4xl border border-gray-100 dark:border-slate-700 mx-4 sm:mx-auto mt-2 mb-8 sm:mt-0">
    
    <div class="p-6 md:p-10 border-b border-gray-100 dark:border-slate-700 bg-gradient-to-br from-white dark:from-slate-800 to-gray-50 dark:to-slate-900">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 dark:text-slate-400 text-sm mb-4 hover:text-[#0a1f44] dark:hover:text-blue-300 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="uppercase tracking-wider text-[10px] font-bold">Kembali ke Dashboard</span>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 tracking-tight mb-2">Riwayat Aktivitas</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Daftar riwayat pencarian aset dan laporan pasang baru Anda.</p>

        {{-- Pill Tabs --}}
        @if(Auth::user()->role === 'teknisi')
        <div class="flex p-1 space-x-2 bg-gray-100 dark:bg-slate-900/50 rounded-xl max-w-sm">
            <button id="tab-pencarian" onclick="switchTab('pencarian')" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-bold transition-all shadow-sm bg-white dark:bg-slate-700 text-[#0a1f44] dark:text-white">
                Pencarian Aset
            </button>
            <button id="tab-pasang" onclick="switchTab('pasang')" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-bold transition-all text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800">
                Lapor Pasang
            </button>
        </div>
        @endif
    </div>

    <div class="p-6 md:p-10">
        
        {{-- CONTENT: Pencarian Aset --}}
        <div id="content-pencarian">
            @if ($riwayat->isEmpty())
                <div class="flex flex-col items-center justify-center text-center py-16 px-4">
                    <div class="w-20 h-20 rounded-full bg-gray-50 dark:bg-slate-900 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-2">Belum Ada Riwayat Pencarian</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 max-w-md leading-relaxed">
                        Anda belum melakukan pencarian aset. Lakukan pencarian untuk melihat riwayat di sini.
                    </p>
                    <a href="{{ route('dashboard') }}" class="bg-[#0a1f44] hover:bg-[#0c2a5e] text-white font-medium py-3 px-8 rounded-xl transition-all shadow-md">
                        Cari Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($riwayat as $item)
                        @php
                            $kategori = strtolower($item->kategori_pencarian);
                            $badgeColor = match($kategori) {
                                'tiang' => 'bg-blue-100 text-blue-700',
                                'gardu' => 'bg-amber-100 text-amber-700',
                                'bangunan' => 'bg-emerald-100 text-emerald-700',
                                'alamat' => 'bg-purple-100 text-purple-700',
                                default => 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300',
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
                               class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 border-l-4 {{ $borderColor }}
                                      rounded-xl p-5 hover:shadow-md hover:bg-gray-50 dark:hover:bg-slate-700 dark:bg-slate-900 transition-all group">
                        @else
                            <a href="{{ route('search.results', ['query' => $item->kata_kunci, 'kategori' => $kategori]) }}"
                               class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 border-l-4 {{ $borderColor }}
                                      rounded-xl p-5 hover:shadow-md hover:bg-gray-50 dark:hover:bg-slate-700 dark:bg-slate-900 transition-all group">
                        @endif
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded uppercase tracking-wider {{ $badgeColor }}">
                                        {{ $kategori }}
                                    </span>
                                </div>
                                <p class="text-lg font-bold text-gray-800 dark:text-slate-100 group-hover:text-[#0a1f44] dark:group-hover:text-blue-300 transition-colors">
                                    {{ $item->kata_kunci }}
                                </p>
                                @if($item->ditemukan)
                                    <p class="text-xs text-green-600 font-semibold mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Data Ditemukan
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 font-semibold mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tidak Ditemukan
                                    </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3 sm:flex-col sm:items-end text-right">
                                <span class="text-xs text-gray-400 font-medium whitespace-nowrap bg-gray-50 dark:bg-slate-900 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-700">
                                    {{ $item->updated_at->translatedFormat('d M Y') }}
                                </span>
                                <div class="flex w-8 h-8 rounded-full bg-gray-50 dark:bg-slate-900 items-center justify-center group-hover:bg-[#0a1f44] dark:group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- CONTENT: Laporan Pasang Baru --}}
        @if(Auth::user()->role === 'teknisi')
        <div id="content-pasang" class="hidden">
            @if ($laporanPasang->isEmpty())
                <div class="flex flex-col items-center justify-center text-center py-16 px-4">
                    <div class="w-20 h-20 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-blue-300 dark:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-2">Belum Ada Laporan Pasang Baru</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 max-w-md leading-relaxed">
                        Anda belum pernah mengirimkan laporan pemasangan baru.
                    </p>
                    <a href="{{ route('laporan.create') }}" class="bg-[#0a1f44] hover:bg-[#0c2a5e] text-white font-medium py-3 px-8 rounded-xl transition-all shadow-md">
                        Lapor Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($laporanPasang as $laporan)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 border-l-4 border-l-green-400 rounded-xl p-5 hover:shadow-md transition-all group">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">
                                        BERHASIL
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    <p class="text-xl font-bold text-gray-800 dark:text-slate-100 tracking-wider font-mono">
                                        {{ $laporan->id_pelanggan_baru }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 sm:flex-col sm:items-end text-right">
                                <span class="text-xs text-gray-500 font-medium whitespace-nowrap bg-gray-50 dark:bg-slate-900 px-3 py-1.5 rounded-lg border border-gray-100 dark:border-slate-700 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $laporan->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tabName) {
        const tabPencarian = document.getElementById('tab-pencarian');
        const tabPasang = document.getElementById('tab-pasang');
        const contentPencarian = document.getElementById('content-pencarian');
        const contentPasang = document.getElementById('content-pasang');

        const activeClasses = ['bg-white', 'dark:bg-slate-700', 'text-[#0a1f44]', 'dark:text-white', 'shadow-sm'];
        const inactiveClasses = ['text-gray-500', 'dark:text-slate-400', 'hover:text-gray-700', 'dark:hover:text-slate-300', 'hover:bg-gray-200', 'dark:hover:bg-slate-800'];

        if (tabPencarian && tabPasang && contentPencarian && contentPasang) {
            if (tabName === 'pencarian') {
                tabPencarian.classList.add(...activeClasses);
                tabPencarian.classList.remove(...inactiveClasses);
                
                tabPasang.classList.add(...inactiveClasses);
                tabPasang.classList.remove(...activeClasses);

                contentPencarian.classList.remove('hidden');
                contentPasang.classList.add('hidden');
            } else {
                tabPasang.classList.add(...activeClasses);
                tabPasang.classList.remove(...inactiveClasses);
                
                tabPencarian.classList.add(...inactiveClasses);
                tabPencarian.classList.remove(...activeClasses);

                contentPasang.classList.remove('hidden');
                contentPencarian.classList.add('hidden');
            }
        }
    }

    // Auto-open tab based on URL parameter (?tab=pasang_baru)
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'pasang_baru') {
            switchTab('pasang');
        }
    });
</script>
@endpush
@endsection