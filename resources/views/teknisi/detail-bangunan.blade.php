@extends('layouts.app')

@section('title', 'Detail Bangunan - PLN ULP Sukabumi')

@section('content')
    <div class="bg-white dark:bg-slate-800 md:shadow-md md:rounded-2xl overflow-hidden w-full max-w-4xl border border-gray-100 dark:border-slate-700 mx-auto">

        {{-- Header dengan Status PRR --}}
        <div
            class="p-6 md:p-10 border-b border-gray-100 dark:border-slate-700 {{ $bangunan->status_prr ? 'bg-gradient-to-br from-red-50 to-white dark:from-red-900/30 dark:to-slate-800' : 'bg-gradient-to-br from-green-50 to-white dark:from-green-900/30 dark:to-slate-800' }}">

            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 text-gray-500 dark:text-slate-400 text-sm mb-6 hover:text-[#0a1f44] dark:hover:text-blue-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="uppercase tracking-wider text-[10px] font-bold">Kembali</span>
            </a>

            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span
                            class="text-xs font-bold px-3 py-1 rounded-md bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 shadow-sm uppercase tracking-wider border border-gray-200 dark:border-slate-700">
                            {{ $bangunan->id_bangunan }}
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider
                                     {{ $bangunan->status_prr ? 'bg-red-600 text-white shadow-sm shadow-red-200' : 'bg-green-600 text-white shadow-sm shadow-green-200' }}">
                            @if($bangunan->status_prr)
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                PRR
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                AMAN
                            @endif
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-slate-100 leading-tight mb-2">
                        {{ $bangunan->alamat_lengkap }}</h1>
                </div>

                @if($bangunan->status_prr)
                    <div
                        class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30 flex-shrink-0 md:w-64 text-center md:text-right">
                        <p class="text-xs text-gray-500 dark:text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tunggakan</p>
                        <p class="text-2xl font-black text-red-600">Rp
                            {{ number_format($bangunan->total_tunggakan, 0, ',', '.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Detail Informasi Grid --}}
        <div class="p-6 md:p-10 bg-gray-50 dark:bg-slate-900/30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">

                {{-- Data Perbandingan Kiri & Kanan --}}
                <div class="space-y-6 md:col-span-2">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2 mb-4 uppercase tracking-wider">
                        Rincian Data Aset & Pelanggan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- KIRI: DATA LAPANGAN / APLIKASI --}}
                        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-1 h-full {{ $bangunan->status_prr ? 'bg-red-500' : 'bg-green-500' }}">
                            </div>
                            <h4 class="text-xs font-bold text-gray-500 dark:text-slate-400 mb-4 uppercase tracking-wider ml-2">Informasi Status
                                & Lapangan</h4>

                            <div class="space-y-3 ml-2">
                                <div class="flex justify-between border-b border-gray-50 pb-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Status PRR</span>
                                    <span
                                        class="text-xs font-bold {{ $bangunan->status_prr ? 'text-red-600' : 'text-green-600' }} uppercase">
                                        {{ $bangunan->status_prr ? 'Tunggakan' : 'Aman' }}
                                    </span>
                                </div>
                                @if($bangunan->status_prr)
                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-500 dark:text-slate-400">Tunggakan</span>
                                        <span class="text-xs font-bold text-red-600">Rp
                                            {{ number_format($bangunan->total_tunggakan, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between border-b border-gray-50 pb-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Nomor Tiang</span>
                                    <span class="text-xs font-bold text-gray-800 dark:text-slate-100">{{ $bangunan->no_tiang ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Titik Koordinat</span>
                                    <span
                                        class="text-[10px] font-mono text-gray-800 dark:text-slate-100 block text-right">{{ $bangunan->latitude ?? '-' }}<br>{{ $bangunan->longitude ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- KANAN: DATA MASTER MDB --}}
                        <div class="bg-blue-50/30 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100 dark:border-blue-900/30 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                            <h4 class="text-xs font-bold text-blue-800 mb-4 uppercase tracking-wider ml-2">Data Pelanggan
                                (Master)</h4>

                            <div class="space-y-3 ml-2">
                                <div class="flex justify-between border-b border-blue-50 pb-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Nama Pelanggan</span>
                                    <span class="text-xs font-bold text-gray-800 dark:text-slate-100 truncate max-w-[150px]"
                                        title="{{ $dataInduk->nama ?? '-' }}">{{ $dataInduk->nama ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-blue-50 pb-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Tarif / Daya</span>
                                    <span class="text-xs font-bold text-gray-800 dark:text-slate-100">{{ $dataInduk->tarif ?? '-' }} /
                                        {{ $dataInduk->daya ?? '-' }} VA</span>
                                </div>
                                <div class="flex justify-between border-b border-blue-50 pb-2">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">ID Gardu</span>
                                    <span
                                        class="text-xs font-bold text-gray-800 dark:text-slate-100">{{ $dataInduk->nomor_gardu ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">Status DIL</span>
                                    <span
                                        class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 uppercase">{{ $dataInduk->status_dil ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Tambahan / Action --}}
                <div class="space-y-6 md:col-span-2">
                    @if($bangunan->status_prr)
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 rounded-xl p-5">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-bold text-red-800 mb-1">Instruksi Lapangan</h4>
                                    <p class="text-xs text-red-700 leading-relaxed">
                                        Bangunan ini tercatat memiliki tunggakan (PRR). Penambahan daya atau pasang baru
                                        <b>tidak dapat diproses</b> sebelum kewajiban diselesaikan oleh pelanggan terkait.
                                    </p>

                                    @php
                                        $statusText = $bangunan->status_prr ? 'PRR (Ada Tunggakan Rp ' . number_format($bangunan->total_tunggakan, 0, ',', '.') . ')' : 'Normal (Aman)';
                                        $template = "*[LAPORAN ASET PLN]*\n"
                                                  . "ID Bangunan: {$bangunan->id_bangunan}\n"
                                                  . "No Tiang: {$bangunan->no_tiang}\n"
                                                  . "Alamat: {$bangunan->alamat_lengkap}\n"
                                                  . "Status: {$statusText}\n"
                                                  . "Koordinat: {$bangunan->latitude}, {$bangunan->longitude}\n\n"
                                                  . "*Keluhan / Catatan Petugas:*\n"
                                                  . "- ";
                                        $waText = rawurlencode($template);
                                    @endphp
                                    <a href="https://wa.me/?text={{ $waText }}" target="_blank"
                                        class="mt-4 inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1ebd5c] text-white px-4 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z" />
                                        </svg>
                                        Lapor via WhatsApp
                                    </a>

                                    <button type="button"
                                        class="bookmark-btn-detail mt-4 ml-2 inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-200 px-4 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm"
                                        data-id="{{ $bangunan->id_bangunan }}" data-idpel="{{ $bangunan->id_bangunan }}"
                                        data-alamat="{{ $bangunan->alamat_lengkap }}"
                                        data-prr="{{ $bangunan->status_prr ? 1 : 0 }}"
                                        data-nominal="{{ $bangunan->total_tunggakan }}"
                                        onclick="window.BookmarkSystem.toggle({id: this.dataset.id, idpel: this.dataset.idpel, alamat: this.dataset.alamat, prr: this.dataset.prr == '1', nominal: this.dataset.nominal}); window.dispatchEvent(new Event('bookmarksUpdated'));">
                                        <svg class="w-4 h-4 star-icon text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                        </svg>
                                        <span class="btn-text">Simpan ke Tugas</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-900/30 rounded-xl p-5">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-bold text-green-800 mb-1">Status Clear</h4>
                                    <p class="text-xs text-green-700 leading-relaxed">
                                        Tidak ada catatan PRR pada bangunan ini. Proses pasang baru atau tambah daya dapat
                                        dilanjutkan sesuai SOP.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            {{-- Peta Lokasi --}}
            <div class="mt-8">
                <h3 class="text-sm font-bold text-gray-800 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2 mb-4 uppercase tracking-wider">
                    Lokasi di Peta</h3>
                <div class="relative w-full h-64 md:h-80 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700 shadow-sm">
                    @php
                        $lat = $bangunan->latitude ?? '-6.92718';
                        $long = $bangunan->longitude ?? '106.93005';
                    @endphp

                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $lat }},{{ $long }}&hl=id&z=15&amp;output=embed">
                    </iframe>

                    {{-- Tombol Overlay Arahkan --}}
                    <div class="absolute bottom-4 right-4">
                        <a href="https://maps.google.com/?q={{ $lat }},{{ $long }}" target="_blank"
                            class="flex items-center gap-2 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg shadow-md border border-gray-100 dark:border-slate-700 text-sm font-bold text-gray-800 dark:text-slate-100 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Lihat Peta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateDetailBookmarkButton() {
            const btn = document.querySelector('.bookmark-btn-detail');
            if (btn && window.BookmarkSystem) {
                const id = btn.dataset.id;
                const icon = btn.querySelector('.star-icon');
                const text = btn.querySelector('.btn-text');

                if (window.BookmarkSystem.isBookmarked(id)) {
                    icon.classList.add('text-yellow-400');
                    icon.classList.remove('text-gray-400');
                    btn.classList.add('border-yellow-300', 'bg-yellow-50');
                    btn.classList.remove('border-gray-200 dark:border-slate-700', 'bg-white dark:bg-slate-800');
                    text.textContent = 'Disimpan di Tugas';
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-gray-400');
                    btn.classList.remove('border-yellow-300', 'bg-yellow-50');
                    btn.classList.add('border-gray-200 dark:border-slate-700', 'bg-white dark:bg-slate-800');
                    text.textContent = 'Simpan ke Tugas';
                }
            }
        }

        if (window.BookmarkSystem) {
            updateDetailBookmarkButton();
        } else {
            window.addEventListener('load', updateDetailBookmarkButton);
        }

        window.addEventListener('bookmarksUpdated', updateDetailBookmarkButton);
    </script>
@endsection