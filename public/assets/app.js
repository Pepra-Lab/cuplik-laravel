// CuplikCom - Pure Vanilla JS Engine
// Spesifikasi: DM Sans only, No Gradients, 10 Kategori, Banner 10s auto-slide, Card 1 & Card 2, Keluh Kesah Rakyat

const $ = (s, e = document) => e.querySelector(s);
const $$ = (s, e = document) => [...e.querySelectorAll(s)];
const Q = new URLSearchParams(location.search);
const P = document.body.dataset.page || 'home';

// Storage Helper
const ls = (k, v) => {
    try {
        if (v === undefined) return JSON.parse(localStorage.getItem(k));
        localStorage.setItem(k, JSON.stringify(v));
    } catch (e) {
        return null;
    }
};

// Date Formatter
const tglIndo = d => new Date(d).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
});

// Theme Initialization
const initTheme = () => {
    const saved = ls('theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    if (saved === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
        document.documentElement.classList.remove('dark');
    }
};
initTheme();

// Localization State
let currentLang = ls('lang') || 'ID';

// Shared Components
const thImg = (a, aspect = 'aspect-[16/10]') => `
    <div class="img-zoom-wrap ${aspect} bg-[${a.tone || '#eaf3ec'}] dark:bg-zinc-800">
        ${a.img ? `<img src="${a.img}" alt="${a.t}" loading="lazy" onerror="this.remove()">` : ''}
        <div class="th-art">${(a.c || 'C')[0]}</div>
    </div>
`;

// Card Image 1 (Vertical Card)
// Ketentuan: title, kategori (bg hijau), tanggal, x waktu yang lalu, image
// Kategori dan tanggal dibungkus div kosong di sebelah kiri (flex space-between / gap),
// x waktu yang lalu di sebelah kanan menggunakan div kosong lagi, ditaruh di ATAS title.
// Vertikal, truncate 2 line dengan ..., sedikit border radius.
const cardImage1 = (a, invertBadge = false) => `
    <a href="artikel.html?id=${a.id}" class="card-hover flex flex-col group cursor-pointer block">
        ${thImg(a, 'aspect-[16/10]')}
        <div class="mt-3 flex flex-col">
            <div class="flex items-center justify-between text-xs mb-2 gap-2">
                <div class="flex items-center gap-2">
                    <div class="${invertBadge ? 'badge-cat-invert' : 'badge-cat'}">${a.c}</div>
                    <div class="${invertBadge ? 'text-white/80' : 'text-gray-500 dark:text-gray-400'}">${tglIndo(a.d)}</div>
                </div>
                <div>
                    <div class="${invertBadge ? 'text-white/70' : 'text-gray-400 dark:text-gray-500'} font-medium">${a.ago || 'Baru saja'}</div>
                </div>
            </div>
            <h3 class="font-bold text-base leading-snug line-clamp-2 ${invertBadge ? 'text-white group-hover:text-green-200' : 'text-[#111111] dark:text-[#f3f4f6] group-hover:text-[#008a24]'} transition-colors">
                ${a.t}
            </h3>
        </div>
    </a>
`;

// Card Image 2 (Horizontal Card)
// Ketentuan: title dan imagenya.
// Kategori (bg hijau) dan tanggal dibungkus div kosong di sebelah kiri dan ditaruh di ATAS title (flex space-between).
// x waktu yang lalu ditaruh di BAWAH titlenya.
// Horizontal, truncate 2 line dengan ..., sedikit border radius.
const cardImage2 = (a) => `
    <a href="artikel.html?id=${a.id}" class="card-hover grid grid-cols-[110px_1fr] sm:grid-cols-[130px_1fr] gap-3 items-center group cursor-pointer py-2 block">
        ${thImg(a, 'aspect-[16/10]')}
        <div class="flex flex-col justify-center">
            <div class="flex items-center justify-between text-xs mb-1.5 gap-2">
                <div class="flex items-center gap-2">
                    <div class="badge-cat">${a.c}</div>
                    <div class="text-gray-500 dark:text-gray-400">${tglIndo(a.d)}</div>
                </div>
                <div></div>
            </div>
            <h3 class="font-bold text-sm sm:text-base leading-snug line-clamp-2 text-[#111111] dark:text-[#f3f4f6] group-hover:text-[#008a24] transition-colors">
                ${a.t}
            </h3>
            <div class="mt-1 text-xs text-gray-400 dark:text-gray-500 font-medium">
                ${a.ago || 'Baru saja'}
            </div>
        </div>
    </a>
`;

// Banner Component (10s auto-slide, DM Sans title, low-opacity black solid overlay, bottom-right dots outside)
const bannerComponent = () => {
    const bannerItems = A.slice(0, 5);
    return `
        <div>
            <div class="banner-wrap aspect-[16/8] sm:aspect-[21/9] bg-zinc-800">
                <div class="banner-track flex transition-transform duration-700 ease-in-out h-full">
                    ${bannerItems.map(a => `
                        <a href="artikel.html?id=${a.id}" class="banner-slide flex-[0_0_100%] h-full relative block group">
                            <div class="w-full h-full bg-[${a.tone || '#1a2920'}] flex items-center justify-center font-bold text-6xl text-white/10">
                                ${(a.c || 'C')[0]}
                            </div>
                            <div class="banner-overlay">
                                <div class="badge-cat w-max mb-2">${a.c}</div>
                                <h2 class="text-xl sm:text-3xl md:text-4xl font-extrabold leading-tight text-white mb-2 line-clamp-2 group-hover:text-green-300 transition-colors">
                                    ${a.t}
                                </h2>
                                <div class="text-xs sm:text-sm text-gray-300 flex items-center gap-3">
                                    <span>${a.author || 'Redaksi Cuplik'}</span>
                                    <span>•</span>
                                    <span>${tglIndo(a.d)}</span>
                                    <span>•</span>
                                    <span>${a.ago || 'Baru saja'}</span>
                                </div>
                            </div>
                        </a>
                    `).join('')}
                </div>
            </div>
            <!-- Node/Titik di bawah banner sebelah kanan luar container -->
            <div class="banner-dots-wrap">
                ${bannerItems.map((_, i) => `
                    <button class="banner-dot ${i === 0 ? 'active' : ''}" data-idx="${i}" aria-label="Slide ${i + 1}"></button>
                `).join('')}
            </div>
        </div>
    `;
};

// Top Navigation & Masthead
const navigationComponent = () => {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    return `
        <!-- Mobile Sidebar Drawer -->
        <div class="mobile-drawer-backdrop" id="drawerBackdrop"></div>
        <aside class="mobile-drawer" id="mobileDrawer">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-zinc-800">
                <a href="index.html" class="flex items-center">
                    <img src="assets/logo.svg" alt="CuplikCom" class="h-8">
                </a>
                <button id="closeDrawer" class="text-2xl text-gray-500 hover:text-black dark:hover:text-white">&times;</button>
            </div>
            <div class="flex flex-col gap-2">
                <a href="index.html" class="font-bold py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-zinc-800 ${P === 'home' ? 'text-[#008a24]' : ''}">Beranda</a>
                ${KANALS.map(k => `
                    <a href="kanal.html?c=${encodeURIComponent(k)}" class="font-semibold py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-zinc-800 ${Q.get('c') === k ? 'text-[#008a24]' : ''}">${k}</a>
                `).join('')}
            </div>
            <div class="pt-4 border-t border-gray-200 dark:border-zinc-800 flex flex-col gap-3">
                <a href="masuk.html" class="bg-[#008a24] hover:bg-[#006f1c] text-white py-2.5 px-4 rounded text-center font-bold flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
                <a href="info.html?p=iklan" class="border border-[#008a24] text-[#008a24] hover:bg-[#008a24] hover:text-white py-2 px-4 rounded text-center font-bold transition-colors">
                    Langganan
                </a>
            </div>
        </aside>

        <!-- Navigation Bar -->
        <nav class="site-container py-4">
            <!-- Row 1: Logo & Right Tools -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button id="openDrawer" class="lg:hidden p-2 rounded hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-700 dark:text-gray-200" aria-label="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <a href="index.html" class="block">
                        <img src="assets/logo.svg" alt="CuplikCom" class="h-10 sm:h-12">
                    </a>
                </div>

                <div class="flex items-center justify-between gap-3 sm:gap-5">
                    <!-- Search Input with Popup -->
                    <div class="search-input-wrap hidden md:block">
                        <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="mainSearchInput" class="search-input w-48 lg:w-64" placeholder="Cari berita terkini…">
                        <div class="search-dropdown hidden" id="searchDropdown"></div>
                    </div>

                    <!-- Localization Bahasa -->
                    <div class="flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300">
                        <span class="text-base">🇮🇩</span>
                        <select id="langSelect" class="bg-transparent border-0 font-bold outline-none cursor-pointer">
                            <option value="ID" class="text-black">Indonesia</option>
                            <option value="EN" class="text-black">English</option>
                        </select>
                    </div>

                    <!-- Theme Mode Toggle -->
                    <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-600 dark:text-gray-300 text-sm font-medium flex items-center gap-1" title="Ubah Mode">
                        ${isDark ? '☀' : '🌙'}
                    </button>

                    <!-- Button Masuk -->
                    <a href="masuk.html" class="bg-[#008a24] hover:bg-[#006f1c] text-white text-xs sm:text-sm font-bold py-2 px-3.5 sm:px-4 rounded flex items-center gap-1.5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Masuk</span>
                    </a>
                </div>
            </div>

            <!-- Horizontal Line -->
            <hr class="border-t border-gray-200 dark:border-zinc-800 my-3.5">

            <!-- Row 2: Navigation List -->
            <div>
                <div class="hidden lg:flex items-center justify-between gap-6 text-sm font-bold overflow-x-auto py-1">
                    <a href="index.html" class="hover:text-[#008a24] whitespace-nowrap ${P === 'home' ? 'text-[#008a24] border-b-2 border-[#008a24] pb-1' : ''}">Beranda</a>
                    ${KANALS.map(k => `
                        <a href="kanal.html?c=${encodeURIComponent(k)}" class="hover:text-[#008a24] whitespace-nowrap ${Q.get('c') === k ? 'text-[#008a24] border-b-2 border-[#008a24] pb-1' : ''}">${k}</a>
                    `).join('')}
                </div>
            </div>
        </nav>
    `;
};

// Footer Component
// Spesifikasi: hitam sedikit campuran hijau, 3 kolom 2 row
// Row 1: Col 1 logo, Col 2 navigasi, Col 3 Button Langganan
// Row 2: 1 kolom (Privacy policy, hak cipta)
const footerComponent = () => `
    <footer class="site-footer mt-16 pt-12 pb-8">
        <div class="site-container">
            <!-- Row 1: 3 Grid Columns -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-10 border-b border-white/10">
                <!-- Col 1: Logo Cuplik -->
                <div>
                    <a href="index.html" class="inline-block mb-3">
                        <img src="assets/logo.svg" alt="CuplikCom" class="h-10">
                    </a>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        <strong>CuplikCom</strong> adalah portal yang menyediakan sumber-sumber berita unik, tajam, dan menggelitik di kawasan Pantura dan Nasional.
                    </p>
                </div>

                <!-- Col 2: Navigation Menus -->
                <div>
                    <h4 class="font-bold text-white mb-3 uppercase text-xs tracking-wider">Kategori Berita</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        ${KANALS.map(k => `
                            <a href="kanal.html?c=${encodeURIComponent(k)}" class="text-gray-400 hover:text-white transition-colors">${k}</a>
                        `).join('')}
                    </div>
                </div>

                <!-- Col 3: Additional (Button Langganan) -->
                <div class="flex flex-col items-start gap-3">
                    <h4 class="font-bold text-white uppercase text-xs tracking-wider">Layanan Premium</h4>
                    <p class="text-sm text-gray-400">Dapatkan buletin harian dan akses liputan investigasi eksklusif.</p>
                    <a href="info.html?p=iklan" class="bg-[#008a24] hover:bg-[#006f1c] text-white font-bold py-2.5 px-6 rounded text-sm transition-colors">
                        Langganan Sekarang
                    </a>
                </div>
            </div>

            <!-- Row 2: 1 Full Column -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
                <div class="flex flex-wrap gap-4">
                    <a href="info.html?p=redaksi" class="hover:text-white">Redaksi</a>
                    <a href="info.html?p=pedoman" class="hover:text-white">Pedoman Media Siber</a>
                    <a href="info.html?p=disclaimer" class="hover:text-white">Privacy Policy & Disclaimer</a>
                    <a href="info.html?p=iklan" class="hover:text-white">Info Iklan</a>
                </div>
                <div>
                    PT. Cuplik Media Center © 2009–2026. Hak Cipta Dilindungi Undang-Undang.
                </div>
            </div>
        </div>
    </footer>
`;

// Render Router Pages
const pages = {
    // 1. Home Page (Index)
    home: () => {
        const topPilihan = A.slice(0, 3);

        return `
            <div class="site-container my-6 space-y-10">
                <!-- Hero Container / Header: Banner -->
                <div>
                    ${bannerComponent()}

                    <!-- Box Container Berita Pilihan (Background color green memenuhi lebar layar, teks putih, badge kategori putih hijau) -->
                    <div class="box-green-pilihan">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-black tracking-tight text-white">Berita Pilihan</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            ${topPilihan.map(a => cardImage1(a, true)).join('')}
                        </div>
                    </div>
                </div>

                <!-- Main Content: 2 Grid Columns (Left & Right) -->
                <div>
                    <div class="main-grid-layout grid grid-cols-[1fr_320px] gap-10">
                        <!-- Grid 1 (Left Column): Category Summaries -->
                        <div class="space-y-10">
                            ${KANALS.map((cat, idx) => {
                                const catArticles = A.filter(a => a.c.toLowerCase() === cat.toLowerCase());
                                const headline = catArticles[0] || A[idx % A.length];
                                const subItems = catArticles.slice(1, 4).length === 3 
                                    ? catArticles.slice(1, 4) 
                                    : A.filter(a => a.id !== headline.id).slice(0, 3);

                                let intermediateBox = '';
                                // Di sela-sela antara Hukum (idx 2) dan Ekonomi (idx 3): Newsletter with image
                                if (cat === 'Hukum') {
                                    intermediateBox = `
                                        <div class="my-8 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-800">
                                            <a href="info.html?p=iklan" class="block">
                                                <img src="./ChatGPT Image Oct 1, 2026, 12_21_56 PM.png" alt="Newsletter Subscription" class="w-full h-auto block" onerror="this.src='assets/newsletter.png'">
                                            </a>
                                        </div>
                                    `;
                                }

                                // Di sela-sela Ekonomi (idx 3) dan Ragam (idx 4): Space Iklan
                                if (cat === 'Ekonomi') {
                                    intermediateBox = `
                                        <div class="my-8">
                                            <div class="space-iklan">
                                                SPACE IKLAN LEADERBOARD 728 × 90 PIXELS
                                            </div>
                                        </div>
                                    `;
                                }

                                return `
                                    <div>
                                        <!-- Category Header with Title and Selengkapnya -->
                                        <div class="flex items-center justify-between pb-2 mb-4 border-b-2 border-gray-200 dark:border-zinc-800">
                                            <h2 class="text-xl font-bold text-[#111111] dark:text-white">${cat}</h2>
                                            <a href="kanal.html?c=${encodeURIComponent(cat)}" class="text-xs font-bold text-[#008a24] hover:text-[#006f1c] flex items-center gap-1">
                                                <span>Selengkapnya</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </div>

                                        <!-- 2 Rows of Content: Row 1 is Card Image 1, Row 2 is 3 items of Card Image 2 -->
                                        <div class="space-y-4">
                                            <div>
                                                ${cardImage1(headline)}
                                            </div>
                                            <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                                                ${subItems.map(item => cardImage2(item)).join('')}
                                            </div>
                                        </div>
                                    </div>
                                    ${intermediateBox}
                                `;
                            }).join('')}
                        </div>

                        <!-- Grid 2 (Right Column): Sidebar -->
                        <div class="space-y-8">
                            <!-- 1. Tagar yang sedang trending -->
                            <div>
                                <h3 class="font-bold text-lg mb-3 pb-2 border-b border-gray-200 dark:border-zinc-800 text-[#111111] dark:text-white">
                                    Tagar Trending
                                </h3>
                                <div class="space-y-2.5">
                                    ${TRENDING_TAGS.map(t => `
                                        <a href="cari.html?q=${encodeURIComponent(t.tag)}" class="flex items-center justify-between p-2 rounded hover:bg-gray-50 dark:hover:bg-zinc-900 group">
                                            <span class="font-bold text-sm text-[#111111] dark:text-gray-200 group-hover:text-[#008a24]">#${t.tag}</span>
                                            <span class="text-xs text-gray-400">${t.count}</span>
                                        </a>
                                    `).join('')}
                                </div>
                            </div>

                            <!-- 2. Keluh Kesah Rakyat (Avatar Anonim + Pesan) -->
                            <div>
                                <h3 class="font-bold text-lg mb-3 pb-2 border-b border-gray-200 dark:border-zinc-800 text-[#111111] dark:text-white">
                                    Keluh Kesah Rakyat
                                </h3>
                                <div class="space-y-3">
                                    ${KELUH_KESAH.map(k => `
                                        <div class="p-3 rounded-lg border border-gray-200 dark:border-zinc-800 flex items-start gap-3 bg-white dark:bg-zinc-900">
                                            <div class="avatar-anon">?</div>
                                            <div class="text-xs space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <strong class="text-gray-900 dark:text-white">${k.nama}</strong>
                                                    <span class="text-gray-400">${k.waktu}</span>
                                                </div>
                                                <p class="text-gray-600 dark:text-gray-300 italic">“${k.pesan}”</p>
                                                <div class="text-gray-400 font-medium">${k.lokasi}</div>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>

                            <!-- 3. Space Iklan Sidebar -->
                            <div>
                                <div class="space-iklan aspect-[6/5] flex items-center justify-center">
                                    SPACE IKLAN 300 × 250 PIXELS
                                </div>
                            </div>

                            <!-- 4. Tags -->
                            <div>
                                <h3 class="font-bold text-lg mb-3 pb-2 border-b border-gray-200 dark:border-zinc-800 text-[#111111] dark:text-white">
                                    Jelajah Tagar
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    ${TAGS.map(t => `
                                        <a href="cari.html?q=${encodeURIComponent(t)}" class="text-xs font-semibold px-2.5 py-1.5 rounded border border-gray-200 dark:border-zinc-800 hover:border-[#008a24] hover:text-[#008a24] bg-white dark:bg-zinc-900 transition-colors">
                                            #${t}
                                        </a>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    },

    // 2. News Detail (artikel.html)
    // Spesifikasi: 2 grid col
    // Col 1: Judul, di bawahnya Nama Author & tanggal publish Indonesia format (space between),
    // di bawahnya gambar & teks berita detail, di bawahnya icon box share (WA, IG, Twitter, Copy URL, TikTok),
    // di bawahnya lagi Suggestion berita (3 item dari kiri ke kanan menggunakan Card Image 1).
    // Col 2: Tag, Trending, Space Iklan.
    artikel: () => {
        const id = parseInt(Q.get('id'), 10);
        const a = A.find(x => x.id === id) || A[0];
        const suggestions = A.filter(x => x.id !== a.id).slice(0, 3);
        const shareUrl = encodeURIComponent(window.location.href);
        const shareText = encodeURIComponent(`${a.t} - CuplikCom`);

        document.title = `${a.t} — CuplikCom`;

        return `
            <div class="site-container my-8">
                <div class="main-grid-layout grid grid-cols-[1fr_320px] gap-10">
                    <!-- Col 1: News Detail -->
                    <article class="space-y-6">
                        <!-- Judul -->
                        <h1 class="text-2xl sm:text-4xl font-black text-[#111111] dark:text-white leading-tight">
                            ${a.t}
                        </h1>

                        <!-- Author & Tanggal Publish (format Indonesia, space between) -->
                        <div class="flex items-center justify-between py-3 border-y border-gray-200 dark:border-zinc-800 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-[#008a24]">${a.author || 'Pewarta CMC'}</span>
                                ${a.loc ? `<span class="text-gray-400">• ${a.loc}</span>` : ''}
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 font-medium">
                                ${tglIndo(a.d)}
                            </div>
                        </div>

                        <!-- Gambar Berita -->
                        ${thImg(a, 'aspect-[16/9]')}

                        <!-- Teks Berita Detail -->
                        <div class="space-y-4 text-base sm:text-lg leading-relaxed text-[#111111] dark:text-[#f3f4f6]">
                            ${a.body ? a.body.map(p => `<p>${p}</p>`).join('') : `<p>${a.lead || ''}</p>`}
                        </div>

                        <!-- Icon Box Share (Company brand colors: WA, IG, Twitter, Copy URL, TikTok) -->
                        <div class="pt-6 border-t border-gray-200 dark:border-zinc-800">
                            <h4 class="font-bold text-sm mb-3 uppercase tracking-wider text-gray-500">Bagikan Berita:</h4>
                            <div class="flex flex-wrap items-center gap-2.5">
                                <a href="https://api.whatsapp.com/send?text=${shareText}%20${shareUrl}" target="_blank" rel="noopener" class="share-wa px-4 py-2 rounded text-xs font-bold flex items-center gap-1.5">
                                    <span>WhatsApp</span>
                                </a>
                                <a href="https://instagram.com/cuplikcom" target="_blank" rel="noopener" class="share-ig px-4 py-2 rounded text-xs font-bold flex items-center gap-1.5">
                                    <span>Instagram</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=${shareText}&url=${shareUrl}" target="_blank" rel="noopener" class="share-tw px-4 py-2 rounded text-xs font-bold flex items-center gap-1.5">
                                    <span>X (Twitter)</span>
                                </a>
                                <a href="https://tiktok.com/@cuplikcom" target="_blank" rel="noopener" class="share-tt px-4 py-2 rounded text-xs font-bold flex items-center gap-1.5">
                                    <span>TikTok</span>
                                </a>
                                <button id="copyShareBtn" class="share-cp px-4 py-2 rounded text-xs font-bold flex items-center gap-1.5">
                                    <span>Salin URL</span>
                                </button>
                            </div>
                        </div>

                        <!-- Suggestion Berita (3 item dari kiri ke kanan menggunakan Card Image 1) -->
                        <div class="pt-10 border-t border-gray-200 dark:border-zinc-800">
                            <h3 class="text-xl font-bold mb-5 text-[#111111] dark:text-white">Berita Pilihan Lainnya</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                                ${suggestions.map(s => cardImage1(s)).join('')}
                            </div>
                        </div>
                    </article>

                    <!-- Col 2: Sidebar (Tag, Trending, Space Iklan) -->
                    <div class="space-y-8">
                        <!-- Tag -->
                        <div>
                            <h3 class="font-bold text-lg mb-3 pb-2 border-b border-gray-200 dark:border-zinc-800 text-[#111111] dark:text-white">
                                Tag Terkait
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                ${(a.tags || TAGS.slice(0, 5)).map(t => `
                                    <a href="cari.html?q=${encodeURIComponent(t)}" class="text-xs font-semibold px-2.5 py-1.5 rounded border border-gray-200 dark:border-zinc-800 hover:border-[#008a24] hover:text-[#008a24] bg-white dark:bg-zinc-900 transition-colors">
                                        #${t}
                                    </a>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Trending -->
                        <div>
                            <h3 class="font-bold text-lg mb-3 pb-2 border-b border-gray-200 dark:border-zinc-800 text-[#111111] dark:text-white">
                                Berita Trending
                            </h3>
                            <div class="space-y-3">
                                ${A.slice(0, 4).map(item => cardImage2(item)).join('')}
                            </div>
                        </div>

                        <!-- Space Iklan -->
                        <div>
                            <div class="space-iklan aspect-[6/5] flex items-center justify-center">
                                SPACE IKLAN 300 × 250 PIXELS
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    },

    // 3. Kanal Page
    kanal: () => {
        const cat = Q.get('c') || 'Politik';
        const list = cat === 'Index' ? A : A.filter(a => a.c.toLowerCase() === cat.toLowerCase());
        return `
            <div class="site-container my-8">
                <div class="pb-4 mb-6 border-b-2 border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-[#111111] dark:text-white">Kanal: ${cat}</h1>
                        <p class="text-sm text-gray-500 mt-1">${list.length} arsip berita terindeks</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${list.map(a => cardImage1(a)).join('')}
                </div>
                ${list.length === 0 ? '<p class="text-center py-12 text-gray-400">Belum ada berita di kanal ini.</p>' : ''}
            </div>
        `;
    },

    // 4. Cari Page
    cari: () => {
        const q = (Q.get('q') || '').trim().toLowerCase();
        const matches = q ? A.filter(a => (a.t + ' ' + a.c + ' ' + (a.tags || []).join(' ')).toLowerCase().includes(q)) : [];
        return `
            <div class="site-container my-8">
                <h1 class="text-2xl sm:text-3xl font-black mb-2 text-[#111111] dark:text-white">Hasil Pencarian</h1>
                <p class="text-sm text-gray-500 mb-6">${q ? `${matches.length} berita ditemukan untuk "${q}"` : 'Ketik kata kunci untuk mencari berita.'}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    ${matches.map(a => cardImage1(a)).join('')}
                </div>
            </div>
        `;
    },

    // 5. Video Page
    video: () => `
        <div class="site-container my-8">
            <h1 class="text-3xl font-black mb-6 text-[#111111] dark:text-white">Galeri Video Cuplik</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                ${V.map(v => `
                    <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-3 space-y-3">
                        <div class="aspect-video bg-zinc-800 rounded flex items-center justify-center text-white font-bold text-2xl">
                            ${v.yt ? `<iframe src="https://www.youtube-nocookie.com/embed/${v.yt}" class="w-full h-full rounded" allowfullscreen></iframe>` : '▶ Video'}
                        </div>
                        <h3 class="font-bold text-sm leading-snug line-clamp-2">${v.t}</h3>
                        <div class="text-xs text-gray-400">${v.dur} • ${v.ago}</div>
                    </div>
                `).join('')}
            </div>
        </div>
    `,

    // 6. Polling Page
    polling: () => `
        <div class="site-container my-8 max-w-xl">
            <h1 class="text-2xl font-black mb-4 text-[#111111] dark:text-white">Polling Pembaca</h1>
            <div class="p-6 rounded-lg border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 space-y-4">
                <p class="font-bold text-base">${POLL.q}</p>
                <div class="space-y-2.5">
                    ${POLL.o.map((o, i) => `
                        <button class="w-full p-3 text-left rounded border border-gray-200 dark:border-zinc-800 hover:border-[#008a24] font-medium text-sm transition-colors block">
                            ${o}
                        </button>
                    `).join('')}
                </div>
            </div>
        </div>
    `,

    // 7. Masuk Page
    masuk: () => `
        <div class="site-container my-12 max-w-md">
            <div class="p-6 rounded-lg border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 space-y-4">
                <h1 class="text-2xl font-black text-center text-[#111111] dark:text-white">Masuk ke CuplikCom</h1>
                <form class="space-y-3" onsubmit="event.preventDefault(); alert('Fitur autentikasi aktif.'); location.href='index.html';">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Email</label>
                        <input type="email" required class="w-full p-2.5 rounded border border-gray-200 dark:border-zinc-800 bg-transparent text-sm mt-1 outline-none focus:border-[#008a24]">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Kata Sandi</label>
                        <input type="password" required minlength="6" class="w-full p-2.5 rounded border border-gray-200 dark:border-zinc-800 bg-transparent text-sm mt-1 outline-none focus:border-[#008a24]">
                    </div>
                    <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white font-bold py-2.5 rounded text-sm transition-colors mt-2">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    `,

    // 8. Info Pages (Redaksi, Pedoman, Disclaimer, Iklan)
    info: () => {
        const p = Q.get('p') || 'redaksi';
        const item = INFO[p] || INFO.redaksi;
        return `
            <div class="site-container my-8 max-w-3xl">
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="info.html?p=redaksi" class="px-3 py-1.5 rounded text-xs font-bold ${p === 'redaksi' ? 'bg-[#008a24] text-white' : 'border border-gray-200 dark:border-zinc-800'}">Redaksi</a>
                    <a href="info.html?p=pedoman" class="px-3 py-1.5 rounded text-xs font-bold ${p === 'pedoman' ? 'bg-[#008a24] text-white' : 'border border-gray-200 dark:border-zinc-800'}">Pedoman Siber</a>
                    <a href="info.html?p=disclaimer" class="px-3 py-1.5 rounded text-xs font-bold ${p === 'disclaimer' ? 'bg-[#008a24] text-white' : 'border border-gray-200 dark:border-zinc-800'}">Disclaimer</a>
                    <a href="info.html?p=iklan" class="px-3 py-1.5 rounded text-xs font-bold ${p === 'iklan' ? 'bg-[#008a24] text-white' : 'border border-gray-200 dark:border-zinc-800'}">Info Iklan</a>
                </div>
                <h1 class="text-3xl font-black mb-4 text-[#111111] dark:text-white">${item.title}</h1>
                <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed">
                    ${item.content}
                </div>
            </div>
        `;
    },

    // 404
    nf: () => `
        <div class="site-container my-16 text-center space-y-4">
            <h1 class="text-6xl font-black text-[#008a24]">404</h1>
            <h2 class="text-2xl font-bold">Halaman Tidak Ditemukan</h2>
            <p class="text-gray-500 text-sm">Halaman yang Anda cari tidak tersedia.</p>
            <a href="index.html" class="inline-block bg-[#008a24] text-white font-bold py-2 px-4 rounded text-sm">Kembali ke Beranda</a>
        </div>
    `
};

// Render Main
$('#app').innerHTML = navigationComponent() + '<main>' + (pages[P] || pages.nf)() + '</main>' + footerComponent();

// Banner Auto-Slide Logic (10 Detik Otomatis)
const bannerTrack = $('.banner-track');
const bannerDots = $$('.banner-dot');
if (bannerTrack && bannerDots.length > 0) {
    let currentSlide = 0;
    const totalSlides = bannerDots.length;

    const showSlide = (idx) => {
        currentSlide = (idx + totalSlides) % totalSlides;
        bannerTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
        bannerDots.forEach((d, i) => d.classList.toggle('active', i === currentSlide));
    };

    bannerDots.forEach(d => {
        d.onclick = () => showSlide(+d.dataset.idx);
    });

    // Otomatis berganti setiap 10 detik (10000ms)
    setInterval(() => {
        showSlide(currentSlide + 1);
    }, 10000);
}

// Search Pop-up Dropdown Engine
const searchInput = $('#mainSearchInput');
const searchDropdown = $('#searchDropdown');
if (searchInput && searchDropdown) {
    searchInput.oninput = () => {
        const val = searchInput.value.trim().toLowerCase();
        if (!val) {
            searchDropdown.classList.add('hidden');
            searchDropdown.innerHTML = '';
            return;
        }

        const hits = A.filter(a => (a.t + ' ' + a.c + ' ' + (a.tags || []).join(' ')).toLowerCase().includes(val)).slice(0, 6);
        if (hits.length === 0) {
            searchDropdown.innerHTML = '<div class="p-3 text-xs text-gray-400">Tidak ada berita yang cocok.</div>';
        } else {
            searchDropdown.innerHTML = hits.map(h => `
                <a href="artikel.html?id=${h.id}" class="flex items-center gap-2.5 p-2 rounded hover:bg-gray-100 dark:hover:bg-zinc-800 group block">
                    <span class="badge-cat text-[10px]">${h.c}</span>
                    <span class="text-xs font-bold line-clamp-1 group-hover:text-[#008a24]">${h.t}</span>
                </a>
            `).join('');
        }
        searchDropdown.classList.remove('hidden');
    };

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.add('hidden');
        }
    });
}

// Mobile Drawer Interaction
const openDrawerBtn = $('#openDrawer');
const closeDrawerBtn = $('#closeDrawer');
const mobileDrawer = $('#mobileDrawer');
const drawerBackdrop = $('#drawerBackdrop');

const toggleDrawer = (open) => {
    if (mobileDrawer && drawerBackdrop) {
        mobileDrawer.classList.toggle('open', open);
        drawerBackdrop.classList.toggle('open', open);
    }
};

if (openDrawerBtn) openDrawerBtn.onclick = () => toggleDrawer(true);
if (closeDrawerBtn) closeDrawerBtn.onclick = () => toggleDrawer(false);
if (drawerBackdrop) drawerBackdrop.onclick = () => toggleDrawer(false);

// Theme Toggle Button
const themeBtn = $('#themeToggle');
if (themeBtn) {
    themeBtn.onclick = () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        if (isDark) {
            document.documentElement.removeAttribute('data-theme');
            document.documentElement.classList.remove('dark');
            ls('theme', 'light');
            themeBtn.textContent = '🌙';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.documentElement.classList.add('dark');
            ls('theme', 'dark');
            themeBtn.textContent = '☀';
        }
    };
}

// Copy Share URL Tool
const copyBtn = $('#copyShareBtn');
if (copyBtn) {
    copyBtn.onclick = () => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(location.href);
            copyBtn.firstElementChild.textContent = 'Tersalin ✓';
            setTimeout(() => {
                copyBtn.firstElementChild.textContent = 'Salin URL';
            }, 2500);
        }
    };
}

// ===== Sesi login (hook kecil untuk auth & CMS) =====
// Tidak mengubah tampilan guest. Hanya berjalan jika user sudah login (localStorage 'u').
(() => {
    const u = ls('u');
    if (!u) return;
    const staff = u.r && u.r !== 'Pembaca';
    document.querySelectorAll('a[href="masuk.html"]').forEach(a => {
        const label = a.querySelector('span');
        if (label) label.textContent = 'Keluar'; else a.lastChild.textContent = ' Keluar';
        a.title = 'Halo, ' + String(u.n).replace(/[<>&"]/g, '');
        a.href = '#';
        a.onclick = e => { e.preventDefault(); localStorage.removeItem('u'); location.reload(); };
        if (staff) {
            const p = a.cloneNode(true);
            p.href = 'admin/index.html';
            p.onclick = null;
            p.title = 'Panel Redaksi';
            const l = p.querySelector('span');
            if (l) l.textContent = 'Panel'; else p.lastChild.textContent = ' Panel Redaksi';
            a.parentNode.insertBefore(p, a);
        }
    });
})();
