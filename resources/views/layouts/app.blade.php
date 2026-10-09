<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CuplikCom — Beritanya Unik dan Menggelitik')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Berita Online CuplikCom — Menyajikan berita unik, politik, sosial, hukum, dan suara rakyat terkini.')">

    <!-- Fonts: Single Font DM Sans (URL: https://fonts.google.com/specimen/DM+Sans) -->
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

    <!-- Custom CSS (Strictly DM Sans, No Gradients, Solid Colors) -->
    <style>
        * {
            font-family: 'DM Sans', sans-serif !important;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #ffffff;
            color: #111111;
        }
        [data-theme="dark"] body,
        .dark body {
            background-color: #121212;
            color: #f3f4f6;
        }

        /* Card Image Zoom Hover Effect */
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
        .group:hover .img-zoom-wrap img,
        .img-zoom-wrap:hover img {
            transform: scale(1.04);
        }

        /* Category Badges */
        .badge-cat-green {
            background-color: #008a24;
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.15rem 0.5rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
        }
        .badge-cat-white {
            background-color: #ffffff;
            color: #008a24;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.15rem 0.5rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
        }

        /* Search input hover green */
        .input-search-hover {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .input-search-hover:hover,
        .input-search-hover:focus {
            border-color: #008a24 !important;
            outline: none;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white dark:bg-[#121212] text-[#111111] dark:text-[#f3f4f6] min-h-screen flex flex-col transition-colors duration-200">
    
    <!-- Top Utility Bar (Real Newspaper Header Bar) -->
    <div class="bg-gray-50 dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 text-[11px] text-gray-600 dark:text-gray-400 py-1.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-bold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
                <span class="hidden sm:inline text-gray-300 dark:text-zinc-700">|</span>
                <span class="hidden sm:inline font-medium">Edisi Pantura &amp; Nasional</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="hidden md:inline text-gray-500">Legalitas SK Kemenkumham AHU-0039651.AH.01.01.2019</span>
                <span class="text-xs font-extrabold text-[#008a24] uppercase">SMSI Terverifikasi</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Section -->
    <header class="bg-white dark:bg-[#121212] sticky top-0 z-40 shadow-sm border-b border-gray-100 dark:border-zinc-800">
        
        <!-- Main Top Bar: Logo & Right Controls with space-between -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
            
            <!-- Left: Logo Cuplik -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                <div class="w-10 h-10 rounded-lg bg-[#008a24] text-white flex items-center justify-center font-black text-2xl shadow-sm tracking-tighter">
                    C
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl sm:text-3xl font-black tracking-tight leading-none text-[#111111] dark:text-white">
                        Cuplik<span class="text-[#008a24]">.com</span>
                    </span>
                    <span class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold tracking-wide">
                        Beritanya Unik &amp; Menggelitik
                    </span>
                </div>
            </a>

            <!-- Center Search Bar (Desktop) with Live Search Dropdown -->
            <div class="hidden md:flex flex-1 max-w-md mx-4 relative" id="searchContainerDesktop">
                <form action="{{ route('search') }}" method="GET" class="w-full relative">
                    <input type="text" id="liveSearchInput" name="q" value="{{ request('q') }}" autocomplete="off" placeholder="Cari berita terkini, topik, tokoh..." class="w-full bg-gray-50 dark:bg-zinc-800/80 border border-gray-200 dark:border-zinc-700 rounded-lg py-2 pl-9 pr-16 text-xs text-gray-900 dark:text-white input-search-hover">
                    
                    <!-- Search Icon -->
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-[#008a24] hover:bg-[#006f1c] text-white text-[11px] font-bold rounded">
                        Cari
                    </button>
                </form>

                <!-- Live Search Dropdown Results Container -->
                <div id="liveSearchResults" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg shadow-2xl max-h-80 overflow-y-auto z-50 divide-y divide-gray-100 dark:divide-zinc-800">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            <!-- Right: Div containing Language, Theme mode, and Masuk button (with Login icon) -->
            <div class="flex items-center gap-3 shrink-0">
                
                <!-- 1. Localization Bahasa (Default: Indonesia) -->
                <div class="relative hidden sm:block">
                    <select id="langSelect" class="bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 focus:outline-none focus:border-[#008a24] cursor-pointer">
                        <option value="id" selected>🇮🇩 ID</option>
                        <option value="en">🇬🇧 EN</option>
                    </select>
                </div>

                <!-- 2. Theme Mode Toggle -->
                <button id="themeToggleBtn" type="button" class="px-2.5 py-1.5 rounded-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 hover:border-[#008a24] text-xs font-bold transition-colors flex items-center gap-1.5" title="Ganti Mode Tampilan">
                    <span id="themeToggleText">Gelap</span>
                </button>

                <!-- 3. Button Masuk with Icon -->
                @auth
                    <div class="flex items-center gap-2">
                        @if(auth()->user()->canAccessCms())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white rounded-lg text-xs font-bold transition-colors">
                                CMS
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors shadow-sm">
                        <!-- Login Icon -->
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Masuk</span>
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button id="mobileSidebarOpenBtn" type="button" class="md:hidden p-2 rounded-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 hover:text-[#008a24]" aria-label="Buka Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Horizontal Line separating logo/buttons and navigation list -->
        <hr class="border-gray-200 dark:border-zinc-800">

        <!-- Horizontal Navigation List: Politik, Sosial, Hukum, Ekonomi, Ragam, Luar Negeri, Iptek, Gaya Hidup, Bola, Video -->
        <nav class="bg-white dark:bg-[#121212] overflow-x-auto scrollbar-none">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-1 text-xs sm:text-sm font-extrabold tracking-tight whitespace-nowrap py-1">
                <a href="{{ route('home') }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->routeIs('home') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-900 dark:text-gray-100' }}">
                    HOME
                </a>
                
                @php
                    $mainNavCategories = [
                        ['nama' => 'POLITIK', 'slug' => 'politik'],
                        ['nama' => 'SOSIAL', 'slug' => 'sosial'],
                        ['nama' => 'HUKUM', 'slug' => 'hukum'],
                        ['nama' => 'EKONOMI', 'slug' => 'ekonomi'],
                        ['nama' => 'RAGAM', 'slug' => 'ragam'],
                        ['nama' => 'LUAR NEGERI', 'slug' => 'luar-negeri'],
                        ['nama' => 'IPTEK', 'slug' => 'iptek'],
                        ['nama' => 'GAYA HIDUP', 'slug' => 'gaya-hidup'],
                        ['nama' => 'BOLA', 'slug' => 'bola'],
                    ];
                @endphp

                @foreach($mainNavCategories as $cat)
                    <a href="{{ route('category.show', $cat['slug']) }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->is('kanal/'.$cat['slug'].'*') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-900 dark:text-gray-100' }}">
                        {{ $cat['nama'] }}
                    </a>
                @endforeach
                
                <a href="{{ route('video.index') }}" class="py-2.5 px-3 hover:text-[#008a24] transition-colors {{ request()->routeIs('video.*') ? 'text-[#008a24] border-b-2 border-[#008a24]' : 'text-gray-900 dark:text-gray-100' }}">
                    VIDEO
                </a>
            </div>
        </nav>
        <hr class="border-gray-200 dark:border-zinc-800">
    </header>

    <!-- Mobile Responsive Slide-Out Sidebar / Drawer -->
    <div id="mobileSidebarDrawer" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop Overlay -->
        <div id="mobileSidebarBackdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Drawer Panel -->
        <div class="fixed top-0 bottom-0 left-0 w-4/5 max-w-sm bg-white dark:bg-[#181818] shadow-2xl z-50 flex flex-col justify-between overflow-y-auto">
            
            <div class="p-5 space-y-5">
                <!-- Header with Logo and Close Button -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-zinc-800">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded bg-[#008a24] text-white flex items-center justify-center font-black text-xl">
                            C
                        </div>
                        <span class="text-xl font-black text-gray-900 dark:text-white">
                            Cuplik<span class="text-[#008a24]">.com</span>
                        </span>
                    </a>
                    <button id="mobileSidebarCloseBtn" class="text-gray-400 hover:text-gray-700 dark:hover:text-white p-1 text-lg font-bold">
                        &times;
                    </button>
                </div>

                <!-- Mobile Search -->
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Cari berita..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg py-2 pl-9 pr-3 text-xs dark:text-white input-search-hover">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>

                <!-- Navigation Links List -->
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Kanal Berita</span>
                    <div class="grid grid-cols-2 gap-1.5 mt-2 text-xs font-bold">
                        <a href="{{ route('home') }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">Home</a>
                        @foreach($mainNavCategories as $cat)
                            <a href="{{ route('category.show', $cat['slug']) }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">{{ $cat['nama'] }}</a>
                        @endforeach
                        <a href="{{ route('video.index') }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">Video</a>
                        <a href="{{ route('curhat.index') }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">Curhat Rakyat</a>
                        <a href="{{ route('poll.index') }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">Polling</a>
                        <a href="{{ route('realcount.index') }}" class="py-2 px-3 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-lg">Real Count</a>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions in Drawer: Masuk & Langganan -->
            <div class="p-5 border-t border-gray-100 dark:border-zinc-800 space-y-2.5 bg-gray-50 dark:bg-zinc-900/60">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="w-full py-2.5 bg-gray-900 text-white rounded-lg text-xs font-bold text-center block">
                        Buka Dashboard CMS
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Masuk ke Akun</span>
                    </a>
                @endauth

                <a href="#newsletterSection" onclick="document.getElementById('mobileSidebarDrawer').classList.add('hidden')" class="w-full py-2.5 border border-[#008a24] text-[#008a24] rounded-lg text-xs font-bold text-center block">
                    Langganan Berita
                </a>
            </div>

        </div>
    </div>

    <!-- Flash Messages (Clean Notification) -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-3 w-full">
            <div class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-base">&times;</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-3 w-full">
            <div class="bg-red-50 dark:bg-red-950/50 border border-red-300 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-base">&times;</button>
            </div>
        </div>
    @endif

    <!-- Main Body Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer: Black with slight green tint (#0e1711), 3 cols on row 1, 1 col on row 2, No Gradients -->
    @php($siteSetting = \App\Models\Setting::current())
    <footer class="bg-[#0e1711] text-gray-300 border-t border-zinc-800 mt-14 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Row 1: 3 Grid Columns (Col 1: Logo, Col 2: Navigation menus, Col 3: Additional / Langganan) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-10 border-b border-zinc-800">
                
                <!-- Col 1: Logo Cuplik & Description -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded bg-[#008a24] text-white font-extrabold text-xl flex items-center justify-center">
                            C
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">{{ $siteSetting->site_name ?? 'Cuplik.com' }}</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        {{ $siteSetting->deskripsi ?? 'PT. Cuplik Media Center (CMC), Anggota Resmi Serikat Media Siber Indonesia (SMSI).' }}
                    </p>
                    <div class="text-xs text-gray-400">
                        <p>{{ $siteSetting->alamat ?? 'Jl. Samsu No. 42 Margadadi, Indramayu, Jawa Barat 45211' }}</p>
                        @if($siteSetting->telepon)
                            <p class="mt-1 font-medium text-gray-300">Hotline Redaksi: {{ $siteSetting->telepon }}</p>
                        @endif
                        @if($siteSetting->facebook || $siteSetting->twitter || $siteSetting->instagram || $siteSetting->youtube)
                            <div class="flex items-center gap-2.5 pt-3">
                                @if($siteSetting->facebook)
                                    <a href="{{ $siteSetting->facebook }}" target="_blank" rel="noopener" aria-label="Facebook" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-gray-300 hover:bg-[#008a24] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M22 12.06C22 6.49 17.52 2 12 2S2 6.49 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>
                                    </a>
                                @endif
                                @if($siteSetting->twitter)
                                    <a href="{{ $siteSetting->twitter }}" target="_blank" rel="noopener" aria-label="Twitter / X" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-gray-300 hover:bg-[#008a24] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M18.9 2H22l-7.53 8.6L23.3 22h-6.93l-5.43-7.1L4.7 22H1.58l8.06-9.2L1 2h7.1l4.9 6.49L18.9 2Zm-1.22 18.17h1.7L6.4 3.73H4.57l13.11 16.44Z"/></svg>
                                    </a>
                                @endif
                                @if($siteSetting->instagram)
                                    <a href="{{ $siteSetting->instagram }}" target="_blank" rel="noopener" aria-label="Instagram" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-gray-300 hover:bg-[#008a24] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.15.55.55.9 1.11 1.15 1.77.25.64.42 1.37.47 2.43.05 1.06.06 1.4.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 0 1-1.15 1.77 4.9 4.9 0 0 1-1.77 1.15c-.64.25-1.37.42-2.43.47-1.06.05-1.4.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 0 1-1.77-1.15 4.9 4.9 0 0 1-1.15-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.15-1.77A4.9 4.9 0 0 1 5.45.53C6.09.28 6.82.11 7.88.06 8.94.01 9.28 0 12 0Zm0 5a7 7 0 1 0 0 14 7 7 0 0 0 0-14Zm0 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm7.25-.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0Z"/></svg>
                                    </a>
                                @endif
                                @if($siteSetting->youtube)
                                    <a href="{{ $siteSetting->youtube }}" target="_blank" rel="noopener" aria-label="YouTube" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-gray-300 hover:bg-[#008a24] hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.51 3.5 12 3.5 12 3.5s-7.51 0-9.38.55A3.02 3.02 0 0 0 .5 6.19 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14C4.49 20.5 12 20.5 12 20.5s7.51 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.81ZM9.6 15.5V8.5L15.8 12 9.6 15.5Z"/></svg>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Menu-menu yang ada di navigasi -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3.5 border-b border-zinc-800 pb-1.5">
                        Kanal Navigasi
                    </h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <a href="{{ route('home') }}" class="hover:text-[#008a24] transition-colors">Home</a>
                        @foreach($mainNavCategories as $cat)
                            <a href="{{ route('category.show', $cat['slug']) }}" class="hover:text-[#008a24] transition-colors">
                                {{ $cat['nama'] }}
                            </a>
                        @endforeach
                        <a href="{{ route('video.index') }}" class="hover:text-[#008a24] transition-colors">Video</a>
                    </div>
                </div>

                <!-- Col 3: Additional (Button Langganan / Form Newsletter) -->
                <div id="newsletterSection" class="space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3.5 border-b border-zinc-800 pb-1.5">
                        Langganan Berita
                    </h4>
                    @if($siteSetting->newsletter_aktif ?? true)
                        <p class="text-xs text-gray-400 leading-relaxed">
                            Dapatkan kurasi berita terkini dan investigasi eksklusif setiap pagi langsung di kotak masuk email Anda.
                        </p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="email" name="email" required placeholder="Alamat email Anda..." class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-[#008a24]">
                            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2 rounded-lg text-xs font-bold transition-colors">
                                Langganan Sekarang
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-gray-500 leading-relaxed">Form langganan newsletter sedang tidak aktif.</p>
                    @endif
                </div>

            </div>

            <!-- Row 2: 1 Full-width Column (Privacy Policy, Pedoman, Disclaimer, Hak Cipta) -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-3">
                <p>{!! $siteSetting->footer_text ?? '&copy; '.date('Y').' PT. Cuplik Media Center. Seluruh hak cipta dilindungi undang-undang.' !!}</p>
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    <a href="{{ route('info.pedoman') }}" class="hover:text-white transition-colors">Pedoman Media Siber</a>
                    <span>·</span>
                    <a href="{{ route('info.disclaimer') }}" class="hover:text-white transition-colors">Disclaimer</a>
                    <span>·</span>
                    <a href="{{ route('info.redaksi') }}" class="hover:text-white transition-colors">Susunan Redaksi</a>
                    <span>·</span>
                    <a href="{{ route('info.iklan') }}" class="hover:text-white transition-colors">Info Iklan</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Scripts: Live Search, Theme Switcher, Mobile Sidebar -->
    <script>
        // 1. Theme Mode Switcher
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeToggleText = document.getElementById('themeToggleText');

        const applyTheme = (theme) => {
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                if (themeToggleText) themeToggleText.textContent = 'Terang';
            } else {
                document.documentElement.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                if (themeToggleText) themeToggleText.textContent = 'Gelap';
            }
        };

        const currentTheme = localStorage.getItem('cuplik_theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(currentTheme);

        themeToggleBtn?.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';
            localStorage.setItem('cuplik_theme', newTheme);
            applyTheme(newTheme);
        });

        // 2. Mobile Responsive Sidebar Drawer
        const mobileSidebarOpenBtn = document.getElementById('mobileSidebarOpenBtn');
        const mobileSidebarCloseBtn = document.getElementById('mobileSidebarCloseBtn');
        const mobileSidebarDrawer = document.getElementById('mobileSidebarDrawer');
        const mobileSidebarBackdrop = document.getElementById('mobileSidebarBackdrop');

        const openSidebar = () => mobileSidebarDrawer?.classList.remove('hidden');
        const closeSidebar = () => mobileSidebarDrawer?.classList.add('hidden');

        mobileSidebarOpenBtn?.addEventListener('click', openSidebar);
        mobileSidebarCloseBtn?.addEventListener('click', closeSidebar);
        mobileSidebarBackdrop?.addEventListener('click', closeSidebar);

        // 3. Live Search Dropdown
        const liveSearchInput = document.getElementById('liveSearchInput');
        const liveSearchResults = document.getElementById('liveSearchResults');
        let searchTimeout = null;

        liveSearchInput?.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                liveSearchResults.classList.add('hidden');
                liveSearchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/api/search-live?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            liveSearchResults.innerHTML = `
                                <div class="p-4 text-center text-xs text-gray-400">
                                    Tidak ada berita yang cocok dengan "${query}"
                                </div>
                            `;
                        } else {
                            let html = '';
                            data.forEach(item => {
                                html += `
                                    <a href="${item.url}" class="p-3 flex items-start gap-3 hover:bg-gray-50 dark:hover:bg-zinc-800/60 transition-colors">
                                        <div class="w-12 h-10 rounded bg-gray-100 dark:bg-zinc-800 overflow-hidden shrink-0">
                                            ${item.foto ? `<img src="${item.foto}" alt="" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold">C</div>`}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 text-[10px] text-gray-400 mb-0.5">
                                                <span class="text-[#008a24] font-bold">${item.kategori}</span>
                                                <span>·</span>
                                                <span>${item.time_ago}</span>
                                            </div>
                                            <h4 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-1">
                                                ${item.judul}
                                            </h4>
                                        </div>
                                    </a>
                                `;
                            });
                            liveSearchResults.innerHTML = html;
                        }
                        liveSearchResults.classList.remove('hidden');
                    })
                    .catch(() => {
                        liveSearchResults.classList.add('hidden');
                    });
            }, 250);
        });

        // Close search dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const searchContainer = document.getElementById('searchContainerDesktop');
            if (searchContainer && !searchContainer.contains(e.target)) {
                liveSearchResults?.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
