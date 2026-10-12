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

<body class="bg-[#f4f7f5] dark:bg-[#0d120e] text-[#111111] dark:text-[#e5e7eb] min-h-screen transition-colors duration-200">

    <!-- Backdrop (mobile only, shown while sidebar is open) -->
    <div id="cmsSidebarBackdrop" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" aria-hidden="true"></div>

    <!-- Sidebar -->
    <aside id="cmsSidebar" class="fixed inset-y-0 left-0 z-50 w-64 max-w-[85vw] bg-white dark:bg-[#121914] border-r border-gray-200 dark:border-zinc-800 flex flex-col shrink-0 h-screen -translate-x-full transition-transform duration-300 ease-in-out">
        
        <!-- Sidebar Brand -->
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between gap-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
                <div class="w-8 h-8 rounded bg-[#008a24] text-white font-black text-xl flex items-center justify-center shrink-0">
                    C
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-extrabold text-lg text-gray-900 dark:text-white leading-none truncate">Cuplik <span class="text-[#008a24]">CMS</span></span>
                    <span class="text-[10px] text-gray-400 truncate">Content Management System</span>
                </div>
            </a>
            <button id="cmsSidebarClose" type="button" class="md:hidden shrink-0 p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" title="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        @php
            $authUser = auth()->user();
            $isAdmin = $authUser->isAdmin();

            // Item tautan tunggal di sidebar.
            $navLink = fn (string $route, string $pattern, string $label, bool $visible) => [
                'type' => 'link',
                'route' => $route,
                'pattern' => $pattern,
                'label' => $label,
                'visible' => $visible,
            ];

            // Item submenu (grup) berisi beberapa tautan anak, menggantikan pola tabs.
            $navGroup = fn (string $pattern, string $label, bool $visible, array $children) => [
                'type' => 'group',
                'pattern' => $pattern,
                'label' => $label,
                'visible' => $visible,
                'children' => $children,
            ];

            // Tautan anak di dalam submenu.
            $navChild = fn (string $route, string $label) => [
                'route' => $route,
                'label' => $label,
            ];

            $menu = [
                ['title' => null, 'items' => [
                    $navLink('admin.dashboard', 'admin.dashboard', 'Dashboard', $isAdmin),
                ]],
                ['title' => 'Konten Portal', 'items' => [
                    $navLink('admin.articles.index', 'admin.articles.*', $authUser->isMember() ? 'Berita Saya' : 'Kelola Berita', true),
                    $navLink('admin.categories.index', 'admin.categories.*', 'Kategori Berita', $isAdmin),
                    $navLink('admin.tags.index', 'admin.tags.*', 'Tag & Submenu', $isAdmin),
                    $navLink('admin.videos.index', 'admin.videos.*', 'Kelola Video', $isAdmin || $authUser->isRedaktur()),
                ]],
                ['title' => 'Interaksi Publik', 'items' => [
                    $navLink('admin.polls.index', 'admin.polls.*', 'Kelola Polling', $isAdmin),
                    $navLink('admin.curhats.index', 'admin.curhats.*', 'Curhat Rakyat', $isAdmin),
                    $navGroup('admin.realcount.*', 'Real Count Pilbup', $isAdmin, [
                        $navChild('admin.realcount.index', 'Tabulasi Suara'),
                        $navChild('admin.realcount.calon', 'Pasangan Calon'),
                        $navChild('admin.realcount.wilayah', 'Data Wilayah'),
                        $navChild('admin.realcount.rekap', 'Rekapitulasi'),
                        $navChild('admin.realcount.pengaturan', 'Pengaturan Pemilihan'),
                    ]),
                ]],
                ['title' => 'Iklan & Tampilan', 'items' => [
                    $navLink('admin.iklan-gambar.index', 'admin.iklan-gambar.*', 'Iklan Gambar', $isAdmin),
                    $navLink('admin.iklan-baris.index', 'admin.iklan-baris.*', 'Iklan Baris', $isAdmin),
                    $navLink('admin.iklan-saya.index', 'admin.iklan-saya.*', 'Iklan Saya', $authUser->isMember()),
                ]],
                ['title' => 'Pengaturan', 'items' => [
                    $navLink('admin.users.index', 'admin.users.*', 'Pengguna', $isAdmin),
                    $navLink('admin.settings.profil', 'admin.settings.profil', 'Profil Situs', $isAdmin),
                    $navLink('admin.iklan-posisi.index', 'admin.iklan-posisi.*', 'Posisi Iklan', $isAdmin),
                    $navLink('admin.info-pages.index', 'admin.info-pages.*', 'Halaman Info', $isAdmin),
                ]],
            ];
        @endphp
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-xs font-semibold">
            @foreach($menu as $section)
                @if(collect($section['items'])->contains(fn ($item) => $item['visible']))
                    @if($section['title'])
                        <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $section['title'] }}</div>
                    @endif

                    @foreach($section['items'] as $item)
                        @continue(! $item['visible'])

                        @if($item['type'] === 'group')
                            @php($isGroupActive = request()->routeIs($item['pattern']))
                            <details class="group" @if($isGroupActive) open @endif>
                                <summary class="flex items-center justify-between px-3 py-2.5 rounded-lg cursor-pointer list-none select-none transition-colors {{ $isGroupActive ? 'text-[#008a24]' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                                    <span>{{ $item['label'] }}</span>
                                    <svg class="w-3.5 h-3.5 shrink-0 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="mt-1 ml-3 pl-3 border-l border-gray-200 dark:border-zinc-800 space-y-1">
                                    @foreach($item['children'] as $child)
                                        <a href="{{ route($child['route']) }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs($child['route']) ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </details>
                        @else
                            <a href="{{ route($item['route']) }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs($item['pattern']) ? 'bg-[#008a24] text-white shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                                {{ $item['label'] }}
                                @if(($pendingCounts[$item['route']] ?? 0) > 0)
                                    <span class="bg-red-600 text-white text-[10px] rounded-full px-1.5 py-0.5">{{ $pendingCounts[$item['route']] }}</span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

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
    <div id="cmsMainWrapper" class="flex flex-col min-h-screen min-w-0 transition-[margin-left] duration-300 ease-in-out">
        
        <!-- Topbar -->
        <header class="h-16 bg-white dark:bg-[#121914] border-b border-gray-200 dark:border-zinc-800 px-4 md:px-6 flex items-center justify-between gap-3 sticky top-0 z-30">
            <div class="flex items-center gap-3 min-w-0">
                <button id="cmsSidebarToggle" type="button" class="shrink-0 p-2 rounded-lg text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-[#008a24] transition-colors" title="Buka/Tutup Menu" aria-label="Buka/Tutup Menu" aria-controls="cmsSidebar" aria-expanded="false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-sm md:text-base font-extrabold text-gray-900 dark:text-white truncate">@yield('title', 'Dashboard')</h1>
                    <p class="hidden sm:block text-xs text-gray-400 truncate">CuplikCom Administrative Control Center</p>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-3 shrink-0">
                <button id="cmsThemeToggle" class="px-2.5 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:text-[#008a24] text-xs font-bold transition-colors" title="Toggle Tema">
                    <span id="cmsThemeText">Tema</span>
                </button>
            </div>
        </header>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="px-4 md:px-6 pt-4">
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between gap-3">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 shrink-0">&times;</button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="px-4 md:px-6 pt-4">
                <div class="bg-red-50 dark:bg-red-950/40 border border-red-300 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-xs flex items-center justify-between gap-3">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 shrink-0">&times;</button>
                </div>
            </div>
        @endif

        <!-- Main Body -->
        <main class="flex-1 p-4 md:p-6 overflow-x-hidden overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        const cmsSidebar = document.getElementById('cmsSidebar');
        const cmsSidebarBackdrop = document.getElementById('cmsSidebarBackdrop');
        const cmsMainWrapper = document.getElementById('cmsMainWrapper');
        const cmsSidebarToggle = document.getElementById('cmsSidebarToggle');
        const cmsSidebarClose = document.getElementById('cmsSidebarClose');

        const isDesktopViewport = () => window.matchMedia('(min-width: 768px)').matches;

        const setSidebarState = (isOpen, { persist = true } = {}) => {
            cmsSidebar.classList.toggle('-translate-x-full', !isOpen);
            cmsSidebarBackdrop.classList.toggle('hidden', !isOpen);
            cmsMainWrapper.classList.toggle('md:ml-64', isOpen);
            cmsSidebarToggle?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            if (persist) {
                localStorage.setItem('cuplik_sidebar', isOpen ? 'open' : 'closed');
            }
        };

        const initCmsSidebar = () => {
            const saved = localStorage.getItem('cuplik_sidebar');
            const isOpen = saved ? saved === 'open' : isDesktopViewport();
            setSidebarState(isOpen, { persist: false });
        };
        initCmsSidebar();

        cmsSidebarToggle?.addEventListener('click', () => {
            const isCurrentlyOpen = !cmsSidebar.classList.contains('-translate-x-full');
            setSidebarState(!isCurrentlyOpen);
        });

        cmsSidebarClose?.addEventListener('click', () => setSidebarState(false));
        cmsSidebarBackdrop?.addEventListener('click', () => setSidebarState(false));

        // Tutup sidebar otomatis setelah memilih menu di layar kecil (mobile/tablet).
        cmsSidebar.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (!isDesktopViewport()) {
                    setSidebarState(false);
                }
            });
        });
    </script>

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
