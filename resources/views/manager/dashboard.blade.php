@extends('layouts.app')
@section('title', 'Rekap Laporan Teknisi - PRR PLN')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
<div class="px-4 pt-4 pb-8 w-full max-w-6xl mx-auto">
    
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dashboard Laporan</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ringkasan performa teknisi dan riwayat pemasangan baru.</p>
        </div>
    </div>

    {{-- Sleek Global Filter Toolbar --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-4 mb-6">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end w-full">
            
            <div class="w-full md:flex-1">
                <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID Pelanggan..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 dark:border-slate-600 rounded-xl text-sm bg-gray-50/50 dark:bg-slate-900/50 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            
            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">Filter Tanggal</label>
                <div class="flex gap-2 items-center bg-gray-50/50 dark:bg-slate-900/50 p-1 rounded-xl border border-gray-200 dark:border-slate-600">
                    <input type="text" id="start_date" name="start_date" value="{{ $start_date ?? '' }}" placeholder="Pilih Tanggal..." class="block w-full md:w-36 px-3 py-1.5 bg-transparent text-sm text-gray-700 dark:text-gray-200 focus:outline-none cursor-pointer">
                    <span class="text-gray-300 dark:text-slate-600">|</span>
                    <input type="text" id="end_date" name="end_date" value="{{ $end_date ?? '' }}" placeholder="Pilih Tanggal..." class="block w-full md:w-36 px-3 py-1.5 bg-transparent text-sm text-gray-700 dark:text-gray-200 focus:outline-none cursor-pointer">
                </div>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-[#0a1f44] hover:bg-blue-900 dark:bg-blue-600 dark:hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-md">
                    Saring Data
                </button>
                @if(request('search') || request('start_date') || request('end_date'))
                    <a href="{{ route('laporan.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-xl transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        {{-- Card 1: Hari Ini (Fix) --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-slate-400">Pasang Hari Ini</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">{{ $todayCount }}</h3>
                    <p class="text-xs font-medium text-gray-400 mt-1">Total murni tanggal hari ini</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
        </div>

        {{-- Card 2: Sesuai Filter --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 dark:bg-purple-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-slate-400">Total Pemasangan</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">{{ $monthCount }}</h3>
                    <p class="text-xs font-medium text-gray-400 mt-1">Sesuai filter tanggal dipilih</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
        </div>

        {{-- Card 3: Teknisi Aktif --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-slate-400">Teknisi Aktif</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-2 tracking-tight">{{ $teknisiAktif }}</h3>
                    <p class="text-xs font-medium text-gray-400 mt-1">Sesuai filter tanggal dipilih</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Section --}}
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-800 dark:text-slate-200">Daftar Data Pemasangan</h2>
        <button onclick="exportTableToCSV('rekap_pasang_baru.csv')" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors shadow-sm focus:outline-none">
            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </button>
    </div>

    {{-- Table Data --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="laporanTable" class="w-full text-left text-sm">
                <thead class="bg-gray-50/80 dark:bg-slate-900/50 text-gray-500 dark:text-slate-400 border-b border-gray-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 font-bold text-center w-16">No</th>
                        <th class="px-6 py-4 font-bold">Tanggal & Waktu</th>
                        <th class="px-6 py-4 font-bold">Nama Teknisi</th>
                        <th class="px-6 py-4 font-bold">ID Pelanggan (Baru)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/80">
                    @forelse($laporans as $index => $laporan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $laporan->created_at->translatedFormat('d M Y') }}</span>
                            <span class="text-gray-400 ml-2 font-medium">{{ $laporan->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">
                            {{ $laporan->petugas->nama_petugas ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-gray-900 dark:text-gray-100 font-bold tracking-widest bg-gray-100 dark:bg-slate-900 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-slate-700">
                                {{ $laporan->id_pelanggan_baru }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 dark:bg-slate-900 mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Tidak ada data pemasangan</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                                {{ request('search') || request('start_date') ? 'Silakan ubah kata kunci atau rentang tanggal pada filter di atas.' : 'Teknisi belum mensubmit laporan pasang baru pada periode ini.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
    script.onload = function() {
        const startPicker = flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            allowInput: false,
            onChange: function(selectedDates, dateStr, instance) {
                if (endPicker) {
                    endPicker.set("minDate", dateStr);
                }
            }
        });

        const endPicker = flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            allowInput: false,
            onChange: function(selectedDates, dateStr, instance) {
                if (startPicker) {
                    startPicker.set("maxDate", dateStr);
                }
            }
        });

        const initialStart = document.getElementById('start_date').value;
        const initialEnd = document.getElementById('end_date').value;
        
        if (initialStart && endPicker) {
            endPicker.set("minDate", initialStart);
        }
        if (initialEnd && startPicker) {
            startPicker.set("maxDate", initialEnd);
        }
    };
    document.head.appendChild(script);

    // CSV Export
    function downloadCSV(csv, filename) {
        let csvFile;
        let downloadLink;
        csvFile = new Blob([csv], {type: "text/csv"});
        downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function exportTableToCSV(filename) {
        let csv = [];
        let rows = document.querySelectorAll("#laporanTable tr");
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) 
                row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
            csv.push(row.join(","));        
        }
        downloadCSV(csv.join("\n"), filename);
    }
</script>
@endpush
@endsection