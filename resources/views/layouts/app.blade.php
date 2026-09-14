<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Pengecekan PRR - PLN')</title>
    
    {{-- PWA Meta Tags --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0a1f44">
    <link rel="apple-touch-icon" href="{{ asset('app-icon.svg') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Plus Jakarta Sans"', 'monospace'], 
                    }
                }
            }
        }
        // Init dark mode immediately to prevent flash
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        /* Custom scrollbar for desktop */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#f8fafc] dark:bg-slate-900 min-h-screen font-sans text-gray-800 dark:text-slate-100">

    
    <div class="flex flex-col min-h-screen">
        
        

        

        {{-- Sidebar --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
        <aside id="desktop-sidebar" class="flex flex-col bg-white dark:bg-slate-800 border-r border-gray-100 dark:border-slate-700 min-h-screen fixed left-0 top-0 z-50 shadow-sm transition-all duration-300 transform -translate-x-full md:translate-x-0 md:w-20 w-64">
                        <div id="sidebar-header" class="p-4 md:p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between relative">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo-pln.png') }}" alt="Logo PLN" class="w-8 h-8 md:w-10 md:h-10 object-contain flex-shrink-0" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png'">
                    <div class="sidebar-text opacity-0 hidden transition-opacity duration-300 whitespace-nowrap">
                        <p class="font-black text-[#0a1f44] dark:text-white text-sm leading-tight tracking-wide">PLN ULP</p>
                        <p class="text-[10px] text-gray-500 dark:text-slate-400 font-semibold tracking-wider">SUKABUMI KOTA</p>
                    </div>
                </div>
                <!-- Absolute toggle button sticking out or on the right edge -->
                <button id="sidebar-toggle" class="hidden md:flex absolute -right-3.5 top-8 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full text-gray-400 hover:text-[#0a1f44] shadow-sm hover:shadow-md transition-all z-50 flex items-center justify-center w-7 h-7 flex">
                    <svg class="w-4 h-4 transition-transform duration-300 rotate-180" id="sidebar-toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            
            <nav id="sidebar-nav" class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard', 'search.results', 'bangunan.detail') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50 hover:text-[#0a1f44] border-l-4 border-transparent dark:hover:bg-slate-700 transition-all' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z" /></svg>
                    <span class="font-medium text-sm sidebar-text whitespace-nowrap">Pencarian Aset</span>
                </a>
                <a href="{{ route('riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('riwayat') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50 hover:text-[#0a1f44] border-l-4 border-transparent dark:hover:bg-slate-700 transition-all' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm sidebar-text whitespace-nowrap">Riwayat</span>
                </a>

                @if(Auth::user()->role === 'teknisi')
                <a href="{{ route('laporan.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.create') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50 hover:text-[#0a1f44] border-l-4 border-transparent dark:hover:bg-slate-700 transition-all' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span class="font-medium text-sm sidebar-text whitespace-nowrap">Lapor Pasang</span>
                </a>
                @endif

                @if(Auth::user()->role === 'manager')
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.index') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50 hover:text-[#0a1f44] border-l-4 border-transparent dark:hover:bg-slate-700 transition-all' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span class="font-medium text-sm sidebar-text whitespace-nowrap">Rekap Laporan</span>
                </a>
                @endif
            </nav>

                        <div id="sidebar-footer" class="p-4 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-[#0a1f44] dark:hover:text-blue-300 transition-all border-l-4 border-transparent group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div class="sidebar-text opacity-0 hidden transition-opacity duration-300">
                        <p class="text-sm font-semibold">Settings</p>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 transition-all border-l-4 border-transparent group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <div class="sidebar-text opacity-0 hidden transition-opacity duration-300 text-left">
                            <p class="text-sm font-semibold">Log Out</p>
                        </div>
                    </button>
                </form>
            </div>
        </aside>

                <main id="main-content" class="flex-1 transition-all duration-300 ml-0 md:ml-20 min-h-screen flex flex-col">
            {{-- Unified Top Header --}}
            <header class="w-full flex items-center justify-between p-4 md:px-8 md:py-4 z-30 shrink-0">
                {{-- Left Side: Mobile Hamburger & Logo (hidden on desktop) --}}
                <div class="flex items-center gap-3 md:hidden">
                    <button id="mobile-hamburger" class="p-1.5 bg-white dark:bg-slate-800 text-[#0a1f44] dark:text-white rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('image/logo-pln.png') }}" alt="Logo PLN" class="w-8 h-8 object-contain" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png'">
                        <span class="text-sm font-black text-[#0a1f44] dark:text-white tracking-widest hidden sm:block">PLN</span>
                    </div>
                </div>

                {{-- Right Side: Profile Button & Notifications --}}
                <div class="flex items-center gap-4 ml-auto">
                    {{-- Notifications Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-[#0a1f44] dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 rounded-full transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-slate-900 rounded-full animate-ping"></span>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-slate-900 rounded-full"></span>
                            @endif
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden z-50"
                             style="display: none;">
                             
                             <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                                 <h3 class="text-sm font-bold text-gray-800 dark:text-white">Notifikasi</h3>
                                 @if(auth()->user()->unreadNotifications->count() > 0)
                                 <form action="{{ route('notifications.read') }}" method="POST" class="inline">
                                     @csrf
                                     <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium focus:outline-none">Tandai dibaca</button>
                                 </form>
                                 @endif
                             </div>
                             
                             <div class="max-h-80 overflow-y-auto">
                                 @forelse(auth()->user()->notifications->take(5) as $notification)
                                 <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 border-b border-gray-50 dark:border-slate-700/50 last:border-0 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/30 dark:bg-blue-900/10' }}">
                                     <div class="flex items-start gap-3">
                                         <div class="mt-0.5 flex-shrink-0">
                                            @if(($notification->data['type'] ?? '') == 'success')
                                                <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                            @endif
                                         </div>
                                         <div class="flex-1 min-w-0">
                                             <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $notification->data['title'] ?? 'Info' }}</p>
                                             <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                                             <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                                         </div>
                                     </div>
                                 </a>
                                 @empty
                                 <div class="px-4 py-8 text-center text-gray-500 dark:text-slate-400">
                                     <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-slate-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                     <p class="text-sm font-medium">Belum ada notifikasi baru</p>
                                 </div>
                                 @endforelse
                             </div>
                             
                             <div class="px-4 py-2 text-center border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                                 <a href="#" class="text-xs font-bold text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors">Lihat Semua Notifikasi</a>
                             </div>
                        </div>
                    </div>
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 bg-white dark:bg-slate-800 p-1.5 pr-4 rounded-full shadow-sm border border-gray-100 dark:border-slate-700 cursor-pointer hover:shadow-md transition-shadow">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0a1f44] to-blue-600 text-white flex items-center justify-center text-xs font-bold">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-bold text-[#0a1f44] dark:text-blue-300 leading-tight">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-gray-500 font-medium">ID: {{ Auth::id() ?? '123' }}</p>
                        </div>
                    </a>
                </div>
            </header>
            

            {{-- Dynamic Content --}}
            <div class="w-full mx-auto p-0 pb-8 md:px-8 md:pt-0 md:pb-8">
                
                {{-- Flash Messages --}}
                @if(session('error'))
                    <div class="m-4 md:m-0 md:mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium leading-relaxed">{{ session('error') }}</p>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="m-4 md:m-0 md:mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-700 font-medium leading-relaxed">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>

        </main>

        

    </div>

        @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('desktop-sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const toggleIcon = document.getElementById('sidebar-toggle-icon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mobileHamburger = document.getElementById('mobile-hamburger');
            
            let isMobile = window.innerWidth < 768;
            let sidebarOpen = false;

            window.addEventListener('resize', () => {
                let newIsMobile = window.innerWidth < 768;
                if (newIsMobile !== isMobile) {
                    isMobile = newIsMobile;
                    updateSidebarState();
                }
            });
            
            function updateSidebarState() {
                if (isMobile) {
                    sidebar.classList.remove('md:w-64', 'md:w-20', 'translate-x-0');
                    sidebar.classList.add('w-64', '-translate-x-full');
                    mainContent.classList.remove('md:ml-64', 'md:ml-20');
                    mainContent.classList.add('ml-0');
                    sidebarTexts.forEach(el => {
                        el.classList.remove('hidden', 'opacity-0');
                    });
                    if(toggleIcon) toggleIcon.classList.add('rotate-180');
                    sidebarOpen = false;
                    if(sidebarOverlay) sidebarOverlay.classList.add('hidden', 'opacity-0');
                } else {
                    sidebar.classList.remove('-translate-x-full', 'w-64');
                    sidebar.classList.add('md:w-20', 'translate-x-0');
                    mainContent.classList.remove('ml-0');
                    mainContent.classList.add('md:ml-20');
                    sidebarTexts.forEach(el => el.classList.add('hidden', 'opacity-0'));
                    if(toggleIcon) toggleIcon.classList.add('rotate-180');
                    sidebarOpen = false;
                    if(sidebarOverlay) sidebarOverlay.classList.add('hidden', 'opacity-0');
                }
            }

            updateSidebarState();

            function toggleSidebar() {
                sidebarOpen = !sidebarOpen;
                
                if (isMobile) {
                    if (sidebarOpen) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        if(sidebarOverlay) {
                            sidebarOverlay.classList.remove('hidden');
                            setTimeout(() => sidebarOverlay.classList.remove('opacity-0'), 10);
                        }
                    } else {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('-translate-x-full');
                        if(sidebarOverlay) {
                            sidebarOverlay.classList.add('opacity-0');
                            setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
                        }
                    }
                } else {
                    if (sidebarOpen) {
                        sidebar.classList.remove('md:w-20');
                        sidebar.classList.add('md:w-64');
                        mainContent.classList.remove('md:ml-20');
                        mainContent.classList.add('md:ml-64');
                        if(toggleIcon) toggleIcon.classList.remove('rotate-180');
                        sidebarTexts.forEach(el => {
                            el.classList.remove('hidden');
                            setTimeout(() => el.classList.remove('opacity-0'), 50);
                        });
                    } else {
                        sidebar.classList.remove('md:w-64');
                        sidebar.classList.add('md:w-20');
                        mainContent.classList.remove('md:ml-64');
                        mainContent.classList.add('md:ml-20');
                        if(toggleIcon) toggleIcon.classList.add('rotate-180');
                        sidebarTexts.forEach(el => el.classList.add('opacity-0', 'hidden'));
                    }
                }
            }

            if(toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            if(mobileHamburger) {
                mobileHamburger.addEventListener('click', toggleSidebar);
            }
            if(sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    if(isMobile && sidebarOpen) toggleSidebar();
                });
            }
        });
        
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        window.BookmarkSystem = {
            tasks: [],
            initialized: false,
            async init() {
                try {
                    const res = await fetch('/bookmarks/data');
                    if (res.ok) {
                        this.tasks = await res.json();
                        this.initialized = true;
                        window.dispatchEvent(new Event('bookmarksUpdated'));
                    }
                } catch(e) {}
            },
            getTasks() {
                return this.tasks;
            },
            async toggle(task) {
                const exists = this.tasks.findIndex(t => t.id == task.id);
                
                // Optimistic UI Update
                if (exists >= 0) {
                    this.tasks.splice(exists, 1);
                    this.showToast(`Dihapus dari Daftar Tugas`);
                } else {
                    this.tasks.push(task);
                    this.showToast(`Disimpan ke Daftar Tugas`);
                }
                window.dispatchEvent(new Event('bookmarksUpdated'));

                // Sync with Server Database
                try {
                    await fetch('/bookmarks/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(task)
                    });
                } catch(e) {
                    console.error('Failed to sync bookmark to DB');
                }
                
                return exists < 0; 
            },
            isBookmarked(id) {
                return this.tasks.some(t => t.id == id);
            },
            showToast(message) {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-full text-sm font-bold shadow-2xl z-50 transition-opacity duration-300 opacity-0';
                toast.innerHTML = `<span class="mr-2">✨</span>${message}`;
                document.body.appendChild(toast);
                setTimeout(() => toast.classList.remove('opacity-0'), 10);
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            window.BookmarkSystem.init();
        });
    </script>
</body>
</html>