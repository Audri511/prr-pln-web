@extends('layouts.app')

@section('title', 'Scan Barcode - PLN ULP Sukabumi')

@section('content')
<div class="bg-white dark:bg-slate-800 md:shadow-md md:rounded-2xl overflow-hidden w-full max-w-4xl mx-auto min-h-[80vh] flex flex-col">
    
    {{-- Header --}}
    <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gradient-to-r from-[#0a1f44] to-[#1a365d] text-white">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="p-2 bg-white text-[#0a1f44] hover:bg-gray-100 rounded-full transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold tracking-wide">Scanner Kamera</h1>
        </div>
    </div>

    {{-- Scanner Area --}}
    <div class="flex-1 flex flex-col items-center p-4 md:p-8 bg-gray-50 dark:bg-slate-900">
        <p class="text-gray-500 dark:text-slate-400 text-center text-sm mb-6 max-w-md">
            Arahkan kamera ke Barcode atau QR Code pada tiang listrik, gardu, atau meteran pelanggan.
        </p>

        {{-- Custom Scanner UI --}}
        <div class="w-full max-w-sm relative mx-auto">
            
            {{-- Camera Container --}}
            <div class="bg-black rounded-3xl overflow-hidden shadow-2xl relative aspect-[3/4] w-full">
                <div id="reader" class="w-full h-full flex items-center justify-center">
                    {{-- Default text before camera starts --}}
                    <div id="camera-loading" class="text-white/70 flex flex-col items-center gap-2">
                        <svg class="animate-spin w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium">Memulai Kamera...</span>
                    </div>
                </div>

                {{-- Overlay UI (Scanning Box) - Hidden initially until camera starts --}}
                <div id="scanner-overlay" class="absolute inset-0 pointer-events-none z-10 hidden flex-col items-center justify-center">
                    <div class="w-[220px] h-[220px] sm:w-[250px] sm:h-[250px] relative">
                        {{-- Scanning Line Animation --}}
                        <div class="absolute top-0 left-0 w-full h-1 bg-[#00a2e9] shadow-[0_0_15px_#00a2e9] rounded-full animate-scan-line z-20"></div>
                        
                        {{-- Corner Markers --}}
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white rounded-tl-xl opacity-80"></div>
                        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white rounded-tr-xl opacity-80"></div>
                        <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white rounded-bl-xl opacity-80"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white rounded-br-xl opacity-80"></div>
                    </div>
                </div>

                {{-- Action overlay while loading result --}}
                <div id="loading-overlay" class="absolute inset-0 bg-white dark:bg-slate-800/90 flex flex-col items-center justify-center z-30 hidden">
                    <svg class="animate-spin w-10 h-10 text-[#0a1f44] dark:text-blue-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#0a1f44] dark:text-blue-300">Data Terdeteksi! Memproses...</span>
                </div>
            </div>

            {{-- Permission Error State --}}
            <div id="permission-error" class="hidden mt-4 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 text-sm text-center">
                Izin kamera ditolak. Silakan izinkan akses kamera di pengaturan browser Anda.
            </div>

            {{-- Upload from Gallery Button --}}
            <div class="mt-6">
                <input type="file" id="file-upload" accept="image/*" class="hidden">
                <button id="gallery-btn" class="w-full py-4 bg-white dark:bg-slate-800 text-[#0a1f44] dark:text-blue-300 rounded-2xl font-bold border border-gray-200 dark:border-slate-700 shadow-sm flex items-center justify-center gap-3 hover:bg-gray-50 dark:hover:bg-slate-700 dark:bg-slate-900 transition-all active:scale-95">
                    <svg class="w-6 h-6 text-gray-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Scan dari Galeri (Penyimpanan)
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
{{-- Include html5-qrcode library --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loading-overlay');
        const scannerOverlay = document.getElementById('scanner-overlay');
        const cameraLoading = document.getElementById('camera-loading');
        const permissionError = document.getElementById('permission-error');
        const fileUpload = document.getElementById('file-upload');
        const galleryBtn = document.getElementById('gallery-btn');

        // Use the lower-level API for custom UI
        const html5QrCode = new Html5Qrcode("reader");

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
            
            // Stop scanning and show loading overlay
            html5QrCode.stop().then((ignore) => {
                loadingOverlay.classList.remove('hidden');
                scannerOverlay.classList.add('hidden');
                window.location.href = `/search?query=${encodeURIComponent(decodedText)}`;
            }).catch((err) => {
                console.error("Failed to stop scanner", err);
                loadingOverlay.classList.remove('hidden');
                window.location.href = `/search?query=${encodeURIComponent(decodedText)}`;
            });
        }

        // Start Camera Scanning
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Use environment facing camera (back camera)
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        // We do NOT use qrbox here because we built our own overlay in HTML/CSS
                        // This allows the video stream to fill the container nicely without the library's built-in ugly shaded regions.
                    },
                    onScanSuccess,
                    (errorMessage) => {
                        // ignore background errors
                    }
                ).then(() => {
                    cameraLoading.classList.add('hidden');
                    scannerOverlay.classList.remove('hidden');
                    scannerOverlay.classList.add('flex');
                }).catch((err) => {
                    console.error(err);
                    cameraLoading.classList.add('hidden');
                    permissionError.classList.remove('hidden');
                });
            }
        }).catch(err => {
            console.error("Camera permission error", err);
            cameraLoading.classList.add('hidden');
            permissionError.classList.remove('hidden');
        });

        // Handle Gallery Upload
        galleryBtn.addEventListener('click', () => {
            fileUpload.click();
        });

        fileUpload.addEventListener('change', e => {
            if (e.target.files.length == 0) {
                return;
            }
            const imageFile = e.target.files[0];
            
            // Show loading state
            galleryBtn.innerHTML = `<svg class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses Gambar...`;
            
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    onScanSuccess(decodedText, null);
                })
                .catch(err => {
                    alert('Tidak menemukan Barcode/QR Code di gambar ini. Silakan coba gambar lain yang lebih jelas.');
                    galleryBtn.innerHTML = `<svg class="w-6 h-6 text-gray-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg> Scan dari Galeri (Penyimpanan)`;
                    fileUpload.value = ''; // reset input
                });
        });
    });
</script>
<style>
    /* Styling to ensure the video scales correctly inside our rounded container */
    #reader video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 1.5rem; /* 24px matches rounded-3xl */
    }
    
    @keyframes scan {
        0% { transform: translateY(0); }
        50% { transform: translateY(220px); } /* or 250px depending on screen */
        100% { transform: translateY(0); }
    }
    @media (min-width: 640px) {
        @keyframes scan {
            0% { transform: translateY(0); }
            50% { transform: translateY(250px); }
            100% { transform: translateY(0); }
        }
    }
    .animate-scan-line {
        animation: scan 2.5s ease-in-out infinite;
    }
</style>
@endpush
@endsection
