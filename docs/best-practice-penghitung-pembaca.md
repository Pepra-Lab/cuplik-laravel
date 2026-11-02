# Best practice: penghitung pembaca & perlindungan server

## Yang sudah diterapkan di kode
1. **Halaman berita tidak menulis ke database.** `ArticleController@show` hanya membaca.
2. **Penghitungan lewat JavaScript.** Setelah halaman terlihat >= 1 detik, JS memanggil
   `POST /artikel/{slug}/dibaca` (`ArticleController@countView`). Bot yang tidak menjalankan JS tidak terhitung.
3. **Satu perangkat = satu hitungan per 24 jam** (token acak di cookie `cuplik_device`, hash disimpan
   di tabel `article_views`). Dua hp di wifi yang sama dihitung 2. Ubah durasi di `ArticleView::WINDOW_HOURS`.
4. **Rate limit (throttle):** halaman berita 120 request/menit/IP, endpoint penghitung 30 request/menit/IP.
5. **Cache 5 menit** untuk query berat di halaman berita (berita terkait, populer, tag trending).
6. **Pembersihan otomatis** tabel `article_views` (`model:prune` harian).

## Yang perlu diatur di server (tidak bisa lewat kode)
1. **Cloudflare / reverse proxy** di depan situs: bot fight mode, rate limiting, mode "under attack".
   Jika memakai Cloudflare/Nginx, atur `trustProxies` di `bootstrap/app.php` supaya IP asli terbaca
   (penting agar throttle per IP bekerja benar).
2. **Cron scheduler Laravel:** `* * * * * cd /path/projek && php artisan schedule:run >> /dev/null 2>&1`
3. **Jalankan migrasi:** `php artisan migrate`
4. **Cache driver:** `CACHE_STORE=file` cukup untuk awal. Untuk trafik besar pakai Redis.
5. **Cache halaman penuh** (di Cloudflare/Nginx) hanya aman jika halaman berita tidak memuat data per-pengguna.
   Saat ini halaman memuat token CSRF dan status login, jadi cache penuh sebaiknya diuji dulu.
   Karena penghitungan sudah lewat JavaScript, cache halaman tidak akan merusak angka "dibaca" selama
   token CSRF di halaman masih valid.

## Catatan angka
- Pembaca yang menutup halaman sebelum 1 detik, atau memblokir JavaScript, tidak terhitung.
- Browser yang menolak cookie dihitung sebagai perangkat baru di setiap kunjungan.
