@extends('layouts.app')
@section('title', 'Profil Pengguna - PLN ULP Sukabumi')
@section('content')
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Pengaturan Akun</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Kelola informasi profil dan pantau statistik
                    kinerja Anda.</p>
            </div>
        </div>

        @if(session('success'))
            <div
                class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-xl font-medium flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Profil Card & Statistik --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Profile Card --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="h-24 bg-gradient-to-r from-[#0a1f44] to-blue-600"></div>
                    <div class="px-6 pb-6 relative flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full bg-white dark:bg-slate-800 p-1.5 -mt-12 mb-3 shadow-lg relative">
                            <div
                                class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-3xl font-black">
                                {{ substr(Auth::user()->nama_petugas ?: 'P', 0, 1) }}
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ Auth::user()->nama_petugas ?: 'User ' . Auth::id() }}
                        </h2>
                        <span
                            class="inline-flex items-center gap-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-md text-xs font-bold border border-blue-100 dark:border-blue-800/50">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            ID Petugas: {{ Auth::id() }}
                        </span>
                    </div>
                </div>

                {{-- Statistik Kinerja --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Statistik Lapangan
                    </h3>
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Laporan Selesai</p>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ $laporanCount ?? 0 }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Edit & Logout --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="border-b border-gray-100 dark:border-slate-700 px-6 py-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
                        <p class="text-sm text-gray-500 mt-1">Ubah nama lengkap sesuai identitas kepegawaian.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">ID Petugas
                                    (User ID)</label>
                                <input type="text" value="{{ Auth::id() }}" disabled
                                    class="w-full bg-gray-100 dark:bg-slate-900/80 border border-gray-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-gray-500 cursor-not-allowed">
                                <p class="text-[11px] text-gray-400 mt-1">*ID bersifat permanen dari sistem</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="nama_petugas" value="{{ Auth::user()->nama_petugas }}" required
                                    class="w-full bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 focus:border-[#0a1f44] focus:ring-1 focus:ring-[#0a1f44] rounded-lg px-4 py-2.5 text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-slate-700">
                            <button type="submit"
                                class="bg-[#0a1f44] hover:bg-blue-900 text-white px-6 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        
@endsection