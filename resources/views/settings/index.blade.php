@extends('layouts.app')
@section('title', 'Pengaturan Aplikasi - PRR PLN')

@section('content')
    <div class="px-4 py-8 max-w-4xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Pengaturan Aplikasi</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Sesuaikan preferensi tampilan dan hubungi pusat
                bantuan.</p>
        </div>

        {{-- Main Settings Group --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-10">
            <div class="divide-y divide-gray-100 dark:divide-slate-700">

                {{-- Mode Tampilan (Dark Mode Toggle) --}}
                <div
                    class="p-5 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"
                                    class="hidden dark:block" />
                                <path
                                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"
                                    class="block dark:hidden" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Mode Tampilan (Dark Mode)</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Ubah tema aplikasi menjadi gelap.
                            </p>
                        </div>
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="darkModeToggle" class="sr-only peer"
                                onchange="toggleThemeCheckbox(this)">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#0a1f44]">
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Notifikasi --}}
                <div
                    class="p-5 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Push Notifikasi</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Terima pemberitahuan laporan baru.
                            </p>
                        </div>
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#0a1f44]">
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Sinkronisasi Data Offline --}}
                <div
                    class="p-5 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0014.228-4.049.75.75 0 00-.53-.918z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Sinkronisasi Data Lapangan</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Download aset untuk akses offline.
                            </p>
                        </div>
                    </div>
                    <button type="button" onclick="alert('Mensinkronisasi data aset terbaru... (Demo)')"
                        class="px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Sync Now
                    </button>
                </div>

                {{-- Pusat Bantuan IT --}}
                <div
                    class="p-5 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex items-center justify-center text-green-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pusat Bantuan (Helpdesk)</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Kendala aplikasi atau error sistem.
                            </p>
                        </div>
                    </div>
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-bold transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z">
                            </path>
                        </svg>
                        Hubungi
                    </a>
                </div>
            </div>
        </div>

        {{-- Daftar Tugas (Bookmark) --}}
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                Tugas Tersimpan
            </h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Aset yang Anda tandai dari halaman pencarian.</p>
        </div>

        <div
            class="bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden mb-12">
            <ul id="bookmark-list" class="divide-y divide-gray-100 dark:divide-slate-700/50">
                <!-- JS will populate this -->
            </ul>
            <div id="bookmark-empty" class="p-12 text-center hidden">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Belum Ada Tugas</h3>
                <p class="text-sm text-gray-500 mt-1">Gunakan fitur bookmark di halaman pencarian untuk menyimpan data
                    pelanggan di sini.</p>
            </div>
        </div>

        {{-- App Version Footer --}}
        <div class="text-center pb-8">
            <p class="text-xs font-medium text-gray-400">PRR PLN App v1.0.0 (Beta)</p>
            <p class="text-[10px] text-gray-300 mt-0.5">&copy; 2026 PT PLN (Persero). All rights reserved.</p>
        </div>

    </div>

    @push('scripts')
        <script>
            // Set initial toggle state based on html class
            document.addEventListener('DOMContentLoaded', () => {
                const isDark = document.documentElement.classList.contains('dark');
                const toggle = document.getElementById('darkModeToggle');
                if (toggle) toggle.checked = isDark;

                // Hide floating dark mode button from header if it exists
                const floatingThemeBtn = document.getElementById('theme-toggle');
                if (floatingThemeBtn) floatingThemeBtn.style.display = 'none';
            });

            function toggleThemeCheckbox(checkbox) {
                // Call the original toggleTheme from layout, or replicate it
                const html = document.documentElement;
                if (checkbox.checked) {
                    html.classList.add('dark');
                    localStorage.theme = 'dark';
                } else {
                    html.classList.remove('dark');
                    localStorage.theme = 'light';
                }
            }

            function renderBookmarks() {
                const list = document.getElementById('bookmark-list');
                const empty = document.getElementById('bookmark-empty');
                if (!list || !empty) return;

                const tasks = window.BookmarkSystem ? window.BookmarkSystem.getTasks() : [];

                list.innerHTML = '';
                if (tasks.length === 0) {
                    list.classList.add('hidden');
                    empty.classList.remove('hidden');
                } else {
                    list.classList.remove('hidden');
                    empty.classList.add('hidden');

                    tasks.forEach(task => {
                        const li = document.createElement('li');
                        li.className = "p-5 hover:bg-white dark:hover:bg-slate-800 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4 group";

                        const detailUrl = `/bangunan/${task.idpel}`;

                        const prrBadge = (task.prr || task.prr === '1' || task.prr === 1)
                            ? `<span class="inline-flex items-center gap-1 bg-red-50 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase border border-red-100">PRR</span>`
                            : `<span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase border border-green-100">AMAN</span>`;

                        li.innerHTML = `
                                            <div class="flex items-start gap-4">
                                                <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l7-3.5L19 21z"></path></svg>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2 mb-1.5">
                                                        <a href="${detailUrl}" class="text-base font-bold text-gray-900 dark:text-white group-hover:text-[#0a1f44] dark:group-hover:text-blue-400 transition-colors tracking-wide">${task.idpel}</a>
                                                        ${prrBadge}
                                                    </div>
                                                    <p class="text-sm text-gray-500 dark:text-slate-400 line-clamp-1">${task.alamat || 'Alamat tidak tersedia'}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 w-full sm:w-auto sm:ml-auto pt-2 sm:pt-0">
                                                <a href="${detailUrl}" class="flex-1 sm:flex-none text-center px-4 py-2 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-bold rounded-lg transition-all shadow-sm">
                                                    Lihat Detail
                                                </a>
                                                <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menghapus pelanggan ${task.idpel} dari daftar tugas?')) { window.BookmarkSystem.toggle({id: '${task.id}'}); renderBookmarks(); window.dispatchEvent(new Event('bookmarksUpdated')); }" class="p-2 bg-white dark:bg-slate-700 hover:bg-red-50 dark:hover:bg-red-900/30 text-gray-400 hover:text-red-600 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 hover:border-red-200 shadow-sm" title="Hapus dari daftar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        `;
                        list.appendChild(li);
                    });
                }
            }

            if (window.BookmarkSystem) {
                renderBookmarks();
                window.addEventListener('bookmarksUpdated', renderBookmarks);
            } else {
                window.addEventListener('load', () => {
                    renderBookmarks();
                    window.addEventListener('bookmarksUpdated', renderBookmarks);
                });
            }
        </script>
    @endpush
@endsection