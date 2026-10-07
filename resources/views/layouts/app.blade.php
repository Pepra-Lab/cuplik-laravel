<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CuplikCom — Beritanya Unik dan Menggelitik')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Berita Online CuplikCom — Menyajikan berita unik, politik, sosial, hukum, dan suara rakyat terkini.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: ['class', '[data-theme="dark"]'],
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#008a24',
                            greenHover: '#006f1c',
                            black: '#111111',
                            footer: '#0e1711',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
        .badge-cat {
            background-color: #008a24;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
        }
        .badge-cat-invert {
            background-color: #ffffff;
            color: #008a24;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
        }
        .img-zoom-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 0.375rem;
        }
        .img-zoom-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .img-zoom-wrap:hover img {
            transform: scale(1.05);
        }
        .th-art {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: rgba(0, 138, 36, 0.2);
            pointer-events: none;
            text-transform: uppercase;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white dark:bg-[#121212] text-[#111111] dark:text-[#f3f4f6] min-h-screen flex flex-col transition-colors duration-200">
    
    <!-- Top Bar / Breaking Ticker -->
    <div class="bg-gray-100 dark:bg-[#1a1a1a] border-b border-gray-200 dark:border-zinc-800 text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="bg-[#008a24] text-white px-2 py-0.5 rounded font-bold uppercase tracking-wider text-[10px]">Terkini</span>
                <span id="currentDate" class="text-gray-500 dark:text-gray-400"></span>
            </div>
            
            <div class="flex items-center gap-4 text-gray-600 dark:text-gray-300">
                <a href="{{ route('realcount.index') }}" class="hover:text-[#008a24] font-medium transition-colors">🗳️ Real Count Pilbup</a>
                <a href="{{ route('curhat.index') }}" class="hover:text-[#008a24] font-medium transition-colors">🗣️ Suara Rakyat</a>
                <a href="{{ route('poll.index') }}" class="hover:text-[#008a24] font-medium transition-colors">📊 Polling</a>
                
                @auth
                    <div class="flex items-center gap-2 pl-2 border-l border-gray-300 dark:border-zinc-700">
                        <span class="font-semibold text-[#008a24]">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->isStaff())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-[#008a24] text-white px-2 py-0.5 rounded hover:bg-[#006f1c]">CMS</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-red-500 text-xs">Keluar</button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2 pl-2 border-l border-gray-300 dark:border-zinc-700">
                        <a href="{{ route('login') }}" class="hover:text-[#008a24] font-medium">Masuk</a>
                        <span>·</span>
                        <a href="{{ route('register') }}" class="hover:text-[#008a24] font-medium">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="border-b border-gray-200 dark:border-zinc-800 bg-white dark:bg-[#121212] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
                <div class="w-10 h-10 rounded-lg bg-[#008a24] flex items-center justify-center text-white font-extrabold text-2xl shadow-sm">
                    C
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black tracking-tight leading-none text-[#111111] dark:text-white">
                        Cuplik<span class="text-[#008a24]">.com</span>
                    </span>
                    <span class="text-[10px] text-gray-400 font-medium tracking-wide">Beritanya Unik & Menggelitik</span>
                </div>
            </a>

            <!-- Search Bar Desktop -->
            <div class="hidden md:flex flex-1 max-w-md mx-6">
                <form action="{{ route('search') }}" method="GET" class="relative w-full">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita terkini, topik, tokoh..." class="w-full bg-gray-100 dark:bg-zinc-800/80 border border-gray-200 dark:border-zinc-700/80 rounded-full py-1.5 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#008a24] focus:border-transparent dark:text-white transition-all">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#008a24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Controls (Theme toggle & Mobile menu) -->
            <div class="flex items-center gap-2">
                <button id="themeToggle" class="p-2 rounded-lg bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:text-[#008a24] transition-colors" title="Toggle Tema">
                    <svg id="moonIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg id="sunIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Navigation Bar (10 Kategori) -->
        <nav class="border-t border-gray-100 dark:border-zinc-800/60 bg-white/95 dark:bg-[#121212]/95 backdrop-blur overflow-x-auto scrollbar-none">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between gap-1 text-sm font-semibold tracking-tight whitespace-nowrap">
                <a href="{{ route('home') }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->routeIs('home') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-700 dark:text-gray-300' }}">Home</a>
                
                @php
                    $navCategories = \App\Models\Category::where('tampil', 'Ya')->orderBy('urutan')->get();
                @endphp
                @foreach($navCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->is('kanal/'.$cat->slug.'*') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-700 dark:text-gray-300' }}">
                        {{ $cat->nama }}
                    </a>
                @endforeach
                
                <a href="{{ route('video.index') }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->routeIs('video.*') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-700 dark:text-gray-300' }}">
                    Video
                </a>
            </div>
        </nav>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 dark:border-zinc-800 bg-white dark:bg-[#181818] p-4">
            <form action="{{ route('search') }}" method="GET" class="relative mb-3">
                <input type="text" name="q" placeholder="Cari berita..." class="w-full bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg py-2 px-3 text-sm dark:text-white">
            </form>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <a href="{{ route('home') }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">Home</a>
                @foreach($navCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">{{ $cat->nama }}</a>
                @endforeach
                <a href="{{ route('video.index') }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">Video</a>
                <a href="{{ route('curhat.index') }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">Curhat Rakyat</a>
                <a href="{{ route('poll.index') }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">Polling</a>
                <a href="{{ route('realcount.index') }}" class="py-1.5 px-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded">Real Count</a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg text-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-red-50 dark:bg-red-950/40 border border-red-300 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0e1711] text-gray-300 border-t border-zinc-800 mt-12 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                
                <!-- Brand Info -->
                <div class="md:col-span-1 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded bg-[#008a24] flex items-center justify-center text-white font-extrabold text-xl">
                            C
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">Cuplik<span class="text-[#008a24]">.com</span></span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        PT. Cuplik Media Center (CMC)<br>
                        Legalitas SK Kepmenkumham RI: <strong>AHU-0039651.AH.01.01.2019</strong><br>
                        Anggota Resmi <strong>Serikat Media Siber Indonesia (SMSI)</strong>.
                    </p>
                    <div class="text-xs text-gray-400">
                        <p>Jl. Samsu No. 42 Margadadi, Indramayu, Jawa Barat 45211</p>
                        <p class="mt-1 font-medium text-gray-300">Hotline: 087727030115</p>
                    </div>
                </div>

                <!-- Kanal / Kategori -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-3 border-b border-zinc-700 pb-1">Kanal Populer</h4>
                    <ul class="space-y-1.5 text-xs">
                        @foreach($navCategories->take(6) as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->slug) }}" class="hover:text-[#008a24] transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#008a24]"></span>
                                    {{ $cat->nama }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Layanan & Info Legalitas -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-3 border-b border-zinc-700 pb-1">Tentang Kami</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="{{ route('info.redaksi') }}" class="hover:text-[#008a24] transition-colors">Susunan Redaksi</a></li>
                        <li><a href="{{ route('info.pedoman') }}" class="hover:text-[#008a24] transition-colors">Pedoman Media Siber</a></li>
                        <li><a href="{{ route('info.disclaimer') }}" class="hover:text-[#008a24] transition-colors">Pasal Sanggahan (Disclaimer)</a></li>
                        <li><a href="{{ route('info.iklan') }}" class="hover:text-[#008a24] transition-colors">Info Pemasangan Iklan & Tarif</a></li>
                        <li><a href="{{ route('curhat.index') }}" class="hover:text-[#008a24] transition-colors">Kirim Keluh Kesah Rakyat</a></li>
                        <li><a href="{{ route('realcount.index') }}" class="hover:text-[#008a24] transition-colors">Hasil Real Count Pilbup</a></li>
                    </ul>
                </div>

                <!-- Newsletter Subscription -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-3 border-b border-zinc-700 pb-1">Langganan Berita</h4>
                    <p class="text-xs text-gray-400 mb-3">Dapatkan rangkuman berita dan investigasi eksklusif setiap pagi langsung di email Anda.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <input type="email" name="email" required placeholder="Masukkan alamat email Anda" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-xs text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2 px-3 rounded text-xs font-bold uppercase tracking-wider transition-colors">
                            Langganan Gratis
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="border-t border-zinc-800/80 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
                <p>&copy; {{ date('Y') }} PT. Cuplik Media Center. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('info.pedoman') }}" class="hover:underline">Kode Etik</a>
                    <span>·</span>
                    <a href="{{ route('info.disclaimer') }}" class="hover:underline">Disclaimer</a>
                    <span>·</span>
                    <a href="{{ route('login') }}" class="hover:underline text-gray-400">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Theme & Global Scripts -->
    <script>
        // Real-time Date Formatter
        const d = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = d.toLocaleDateString('id-ID', options);

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');

        const initTheme = () => {
            const savedTheme = localStorage.getItem('cuplik_theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                document.documentElement.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        };
        initTheme();

        themeToggle?.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                localStorage.setItem('cuplik_theme', 'light');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                localStorage.setItem('cuplik_theme', 'dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
        });

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenuBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
