<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — Cuplik CMS</title>

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
                        }
                    }
                }
            }
        }
    </script>

    <!-- ApexCharts CDN for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3"></script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
        .badge-status-ok {
            background-color: #eaf3ec;
            color: #008a24;
            border: 1px solid #c9e2cf;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
        }
        .badge-status-wt {
            background-color: #fef8ec;
            color: #d97706;
            border: 1px solid #fde68a;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
        }
        .badge-status-no {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
        }
        [data-theme="dark"] .badge-status-ok {
            background-color: rgba(0, 138, 36, 0.2);
            color: #4ade80;
            border-color: rgba(0, 138, 36, 0.4);
        }
        [data-theme="dark"] .badge-status-wt {
            background-color: rgba(217, 119, 6, 0.2);
            color: #fbbf24;
            border-color: rgba(217, 119, 6, 0.4);
        }
        [data-theme="dark"] .badge-status-no {
            background-color: rgba(220, 38, 38, 0.2);
            color: #f87171;
            border-color: rgba(220, 38, 38, 0.4);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#f4f7f5] dark:bg-[#0d120e] text-[#111111] dark:text-[#e5e7eb] min-h-screen flex transition-colors duration-200">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-[#121914] border-r border-gray-200 dark:border-zinc-800 flex flex-col shrink-0 min-h-screen">
        
        <!-- Sidebar Brand -->
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-[#d60000] text-white font-black text-xl flex items-center justify-center">
                    C
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-lg leading-none"><span class="text-[#d60000]">Cuplik</span> <span class="text-[#008a24]">CMS</span></span>
                    <span class="text-[10px] text-gray-400">Content Management System</span>
                </div>
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-xs font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Dashboard
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Konten Portal</div>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Kelola Berita
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Kategori Berita
            </a>

            <a href="{{ route('admin.tags.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.tags.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Tag Berita
            </a>

            <a href="{{ route('admin.videos.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Kelola Video
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Interaksi Publik</div>

            <a href="{{ route('admin.polls.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.polls.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Kelola Polling
            </a>

            <a href="{{ route('admin.curhats.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.curhats.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Curhat Rakyat
            </a>

            <a href="{{ route('admin.realcount.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.realcount.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Real Count Pilbup
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Iklan & Tampilan</div>

            <a href="{{ route('admin.banners.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Banner Beranda
            </a>

            <a href="{{ route('admin.iklan-gambar.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.iklan-gambar.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Iklan Gambar
            </a>

            <a href="{{ route('admin.iklan-baris.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.iklan-baris.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Iklan Baris
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengaturan</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                Pengguna & Redaksi
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center px-3 py-2.5 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-zinc-800 transition-colors mt-4">
                Lihat Portal Publik &rarr;
            </a>
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 border-t border-gray-200 dark:border-zinc-800 bg-gray-50/50 dark:bg-zinc-900/50 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2 truncate">
                <div class="w-7 h-7 rounded-full bg-[#008a24] text-white flex items-center justify-center font-bold text-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="truncate">
                    <div class="font-bold text-gray-900 dark:text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-gray-400 truncate">{{ auth()->user()->role ?? 'Super Admin' }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-gray-400 hover:text-red-500 font-semibold px-2 py-1" title="Keluar">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Topbar -->
        <header class="h-16 bg-white dark:bg-[#121914] border-b border-gray-200 dark:border-zinc-800 px-6 flex items-center justify-between gap-4 sticky top-0 z-30">
            <div>
                <h1 class="text-base font-extrabold text-gray-900 dark:text-white">@yield('title', 'Dashboard')</h1>
                <p class="text-xs text-gray-400">CuplikCom Administrative Control Center</p>
            </div>

            <div class="flex items-center gap-3">
                <button id="cmsThemeToggle" class="px-2.5 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:text-[#008a24] text-xs font-bold transition-colors" title="Toggle Tema">
                    <span id="cmsThemeText">Tema</span>
                </button>

                <div class="text-xs text-gray-500 bg-gray-100 dark:bg-zinc-800 px-3 py-1.5 rounded-lg font-mono">
                    PostgreSQL · Laravel {{ app()->version() }}
                </div>
            </div>
        </header>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="px-6 pt-4">
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="px-6 pt-4">
                <div class="bg-red-50 dark:bg-red-950/40 border border-red-300 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
                </div>
            </div>
        @endif

        <!-- Main Body -->
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <!-- Theme Switch Script -->
    <script>
        const cmsThemeToggle = document.getElementById('cmsThemeToggle');
        const cmsThemeText = document.getElementById('cmsThemeText');

        const initCmsTheme = () => {
            const saved = localStorage.getItem('cuplik_theme') || 'light';
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                if (cmsThemeText) cmsThemeText.textContent = 'Terang';
            } else {
                document.documentElement.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                if (cmsThemeText) cmsThemeText.textContent = 'Gelap';
            }
        };
        initCmsTheme();

        cmsThemeToggle?.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                localStorage.setItem('cuplik_theme', 'light');
                if (cmsThemeText) cmsThemeText.textContent = 'Gelap';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                localStorage.setItem('cuplik_theme', 'dark');
                if (cmsThemeText) cmsThemeText.textContent = 'Terang';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
