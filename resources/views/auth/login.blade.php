<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Petugas PLN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Plus Jakarta Sans"', 'monospace'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Card utama --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-[#0a1f44]">

            {{-- Logo & Header --}}
            <div class="pt-10 pb-6 px-8 text-center">
                <img src="{{ asset('image/logo-pln.png') }}" alt="Logo PLN"
                    class="w-20 h-20 mx-auto mb-4 object-contain"
                    onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png'">
                <h1 class="text-xl font-semibold text-gray-800">Portal Petugas</h1>
                <p class="text-sm text-gray-500 mt-1">Otentikasi akses ke Web Pengecekan</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="px-8 pb-8">
                @csrf

                {{-- Error message --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Username --}}
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Username
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        placeholder="Masukkan username" required autofocus
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0a1f44] focus:border-transparent placeholder-gray-400">
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-11 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0a1f44] focus:border-transparent">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            aria-label="Tampilkan/sembunyikan password">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit button --}}
                <button type="submit"
                    class="w-full bg-[#0a1f44] hover:bg-[#0c2a5e] text-white font-medium py-3.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Bantuan Dummy Credential --}}
        {{-- Bantuan Dummy Credential --}}
        <div class="mt-6 bg-blue-50/50 border border-blue-200 rounded-xl p-5 shadow-sm space-y-4">
            <div>
                <p class="text-[13px] text-blue-800 font-bold mb-2 uppercase tracking-wide">Login Teknisi</p>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xs text-blue-600 font-medium w-16">Username:</span>
                    <div class="flex flex-wrap gap-2">
                        <code
                            class="text-sm font-bold bg-white px-3 py-1.5 rounded-md shadow-sm text-gray-800 select-all border border-blue-100">audri</code>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-blue-600 font-medium w-16">Password:</span>
                    <code
                        class="text-sm font-bold bg-white px-3 py-1.5 rounded-md shadow-sm text-gray-800 select-all border border-blue-100">password123</code>
                </div>
            </div>

            <div class="pt-4 border-t border-blue-200/60">
                <p class="text-[13px] text-blue-800 font-bold mb-2 uppercase tracking-wide">Login Manager</p>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xs text-blue-600 font-medium w-16">Username:</span>
                    <code
                        class="text-sm font-bold bg-white px-3 py-1.5 rounded-md shadow-sm text-gray-800 select-all border border-blue-100">manager</code>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-blue-600 font-medium w-16">Password:</span>
                    <code
                        class="text-sm font-bold bg-white px-3 py-1.5 rounded-md shadow-sm text-gray-800 select-all border border-blue-100">password</code>
                </div>
            </div>
        </div>

        {{-- Footer text --}}
        <p class="text-center text-xs text-gray-400 mt-6">
            Sistem Internal PLN ULP Kota Sukabumi
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
        }
    </script>
</body>

</html>