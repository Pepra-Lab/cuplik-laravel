<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Video;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Curhat;
use App\Models\IklanGambar;
use App\Models\IklanBaris;
use App\Models\Pilbup;
use App\Models\Paslon;
use App\Models\Dpt;
use App\Models\SuaraPilbup;
use App\Models\IklanPosisi;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with authentic editorial content.
     */
    public function run(): void
    {
        // 1. Users / Editorial Team
        $users = [
            [
                'name' => 'Admin Cuplik',
                'email' => 'admin@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ali Ma\'nawi',
                'email' => 'redaksi@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Farhan Maksudi',
                'email' => 'farhan@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Redaktur',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Dalani',
                'email' => 'dalani@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Redaktur',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Baebudin',
                'email' => 'baebudin@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Redaktur',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Daman',
                'email' => 'daman@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Redaktur',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ato Susanto',
                'email' => 'atosusanto@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Redaktur',
                'status' => 'Aktif',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

        $userIds = User::pluck('id', 'name');

        // 2. Categories
        $categoriesData = [
            ['nama' => 'Politik', 'slug' => 'politik', 'urutan' => 1],
            ['nama' => 'Sosial', 'slug' => 'sosial', 'urutan' => 2],
            ['nama' => 'Hukum', 'slug' => 'hukum', 'urutan' => 3],
            ['nama' => 'Ekonomi', 'slug' => 'ekonomi', 'urutan' => 4],
            ['nama' => 'Ragam', 'slug' => 'ragam', 'urutan' => 5],
            ['nama' => 'Luar Negeri', 'slug' => 'luar-negeri', 'urutan' => 6],
            ['nama' => 'Iptek', 'slug' => 'iptek', 'urutan' => 7],
            ['nama' => 'Gaya Hidup', 'slug' => 'gaya-hidup', 'urutan' => 8],
            ['nama' => 'Bola', 'slug' => 'bola', 'urutan' => 9],
            ['nama' => 'Video', 'slug' => 'video', 'urutan' => 10],
        ];

        $categoriesMap = [];
        foreach ($categoriesData as $c) {
            $cat = Category::updateOrCreate(['slug' => $c['slug']], [
                'nama' => $c['nama'],
                'urutan' => $c['urutan'],
                'tampil' => 'Ya',
            ]);
            $categoriesMap[$c['nama']] = $cat;
        }

        // 3. Tags
        $tagsData = [
            ['nama' => 'Indramayu', 'slug' => 'indramayu', 'cat' => 'Sosial'],
            ['nama' => 'Cirebon', 'slug' => 'cirebon', 'cat' => 'Sosial'],
            ['nama' => 'Pilkada 2024', 'slug' => 'pilkada-2024', 'cat' => 'Politik'],
            ['nama' => 'Birokrasi', 'slug' => 'birokrasi', 'cat' => 'Politik'],
            ['nama' => 'Pertanian', 'slug' => 'pertanian', 'cat' => 'Ekonomi'],
            ['nama' => 'Nelayan', 'slug' => 'nelayan', 'cat' => 'Sosial'],
            ['nama' => 'Kuliner Pantura', 'slug' => 'kuliner-pantura', 'cat' => 'Ragam'],
            ['nama' => 'Budaya', 'slug' => 'budaya', 'cat' => 'Ragam'],
            ['nama' => 'Timnas', 'slug' => 'timnas', 'cat' => 'Bola'],
            ['nama' => 'Liga Indonesia', 'slug' => 'liga-indonesia', 'cat' => 'Bola'],
            ['nama' => 'Teknologi Terapan', 'slug' => 'teknologi-terapan', 'cat' => 'Iptek'],
            ['nama' => 'Kesehatan', 'slug' => 'kesehatan', 'cat' => 'Gaya Hidup'],
        ];

        $tagsMap = [];
        foreach ($tagsData as $t) {
            $catId = isset($t['cat']) && isset($categoriesMap[$t['cat']]) ? $categoriesMap[$t['cat']]->id : null;
            $tag = Tag::updateOrCreate(['slug' => $t['slug']], [
                'nama' => $t['nama'],
                'category_id' => $catId,
                'sub_tampil' => 'Ya',
            ]);
            $tagsMap[$t['nama']] = $tag;
        }

        // 4. Articles Data (Natural, Engaging, Authentic Indonesian Journalism)
        $articlesData = [
            // ==================== POLITIK ====================
            [
                'judul' => 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
                'slug' => 'kritik-muktamar-diancam-sanksi-kang-eep-jangan-sampai-partai-jadi-alat-membungkam-nurani-warga-nu',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-08',
                'dibaca' => 5420,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=1200&q=80',
                'tags' => ['Pilkada 2024', 'Birokrasi'],
                'lead' => 'Wacana sanksi organisasi terhadap kader kritis jelang Muktamar menuai reaksi keras dari tokoh muda Nahdlatul Ulama Jawa Barat.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Dinamika internal menjelang perhelatan akbar Muktamar kembali memanas. Tokoh muda Nahdlatul Ulama Jawa Barat, Kang Eep, secara terbuka mengingatkan agar struktur organisasi tidak digunakan oleh kekuatan partai politik tertentu untuk membungkam kebebasan berpendapat warga nahdliyin.</p><p>\"Tradisi NU sejak zaman Hadratussyekh Hasyim Asy'ari dan Gus Dur adalah musyawarah yang santun, terbuka, dan penuh keteladanan akhlak. Jangan ada ancaman sanksi sepihak hanya karena kader menyuarakan kegelisahan warga di bawah,\" ujar Kang Eep saat ditemui di Cirebon, Kamis (8/10/2026).</p><p>Menurutnya, konsentrasi utama seluruh jajaran pengurus semestinya ditujukan pada pemberdayaan ekonomi pesantren, advokasi petani gurem, dan pendidikan santri, bukan terseret dalam manuver kekuasaan sesaat.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Ada 17 Kursi Kepala Dinas Masih Kosong, Lucky Hakim-Syaefudin Siapkan Lelang Jabatan Terbuka',
                'slug' => 'ada-17-kursi-kepala-dinas-masih-kosong-lucky-hakim-syaefudin-siapkan-lelang-jabatan-terbuka',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-07',
                'dibaca' => 6840,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=1200&q=80',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Pemerintah Kabupaten Indramayu memastikan 17 jabatan eselon II yang kini dijabat Plt akan segera diisi pejabat definitif melalui open bidding murni.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Pekerjaan rumah besar menanti penataan birokrasi di lingkungan Pemkab Indramayu. Sebanyak 17 posisi Kepala Dinas dan Kepala Badan strategis tercatat masih berstatus Pelaksana Tugas (Plt).</p><p>Tim transisi kepemimpinan daerah menegaskan mekanisme seleksi terbuka (open bidding) berbasis kompetensi dan rekam jejak integritas tanpa mahar sepeser pun akan segera dibuka secara transparan kepada publik.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Dituduh Ada Jual Beli Jabatan ASN, Tim Transisi Indramayu Angkat Bicara: Itu Fitnah Keji Tak Berdasar',
                'slug' => 'dituduh-ada-jual-beli-jabatan-asn-tim-transisi-indramayu-angkat-bicara-itu-fitnah-keji-tak-berdasar',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-06',
                'dibaca' => 4910,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?w=1200&q=80',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Beredarnya pesan berantai di grup WhatsApp mengenai pungutan mutasi pejabat eselon III dan IV dibantah keras tim pemenangan.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Isu liar yang menyebut adanya transaksi uang dalam rotasi jabatan aparatur sipil negara di Indramayu direspons tegas. Pihak tim transisi menegaskan komitmen nol rupiah dalam penataan birokrasi dan meminta ASN tidak termakan hoaks provokatif.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'DPRD Desak Transparansi Anggaran Proyek Jalan Lingkar Luar Demi Cegah Kongkalikong Rekanan',
                'slug' => 'dprd-desak-transparansi-anggaran-proyek-jalan-lingkar-luar-demi-cegah-kongkalikong-rekanan',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-05',
                'dibaca' => 3650,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&q=80',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Komisi III DPRD meminta Dinas PUPR membeberkan dokumen perencanaan dan hasil uji kelayakan kontraktor pemenang tender fisik.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Pengawasan terhadap penggunaan APBD untuk pembangunan infrastruktur jalan raya terus diperketat guna menjamin kualitas jalan tidak cepat rusak dan bebas dari praktik mark-up anggaran.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== SOSIAL ====================
            [
                'judul' => 'Petani Padi Pantura Menjerit, Pasokan Air Irigasi Mandek Jelang Musim Tanam Gadu',
                'slug' => 'petani-padi-pantura-menjerit-pasokan-air-irigasi-mandek-jelang-musim-tanam-gadu',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-08',
                'dibaca' => 4320,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&q=80',
                'tags' => ['Indramayu', 'Pertanian'],
                'lead' => 'Ratusan hektare sawah di kawasan barat Indramayu terancam gagal semai akibat debit air saluran sekunder yang menyusut drastis.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Kekhawatiran membayangi para petani padi di Kecamatan Anjatan, Bongas, dan Kandanghaur. Memasuki jadwal olah tanah, pasokan air dari pintu bendung utama dilaporkan belum mengalir optimal ke petak-petak sawah warga.</p><p>Para petani terpaksa menyedot air sisa menggunakan mesin pompa berbahan bakar solar dengan biaya ekstra yang memberatkan modal tanam.</p>",
                'tone' => '#e9f0ea',
            ],
            [
                'judul' => 'Cuaca Ekstrem Hantam Pesisir Karangsong, Gelombang 3 Meter Rusak Belasan Perahu Nelayan Tradisional',
                'slug' => 'cuaca-ekstrem-hantam-pesisir-karangsong-gelombang-3-meter-rusak-belasan-perahu-nelayan-tradisional',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-07',
                'dibaca' => 3890,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&q=80',
                'tags' => ['Indramayu', 'Nelayan'],
                'lead' => 'Hantaman ombak tinggi di dermaga muara merusak cadik dan lambung kapal nelayan yang sedang sandar.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Angin kencang dan gelombang pasang setinggi 3 meter menerjang garis pantai utara Karangsong. Syahbandar mengeluarkan peringatan larangan melaut sementara bagi kapal motor di bawah 10 GT demi keselamatan jiwa para pelaut.</p>",
                'tone' => '#f5ede6',
            ],
            [
                'judul' => 'Kisah Gotong Royong Warga Sukra Selamatkan Tanggul Kritis dari Ancaman Banjir Luapan Sungai',
                'slug' => 'kisah-gotong-royong-warga-sukra-selamatkan-tanggul-kritis-dari-ancaman-banjir-luapan-sungai',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-06',
                'dibaca' => 2750,
                'editor' => 'Ato Susanto',
                'penulis' => 'Ato Susanto',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=1200&q=80',
                'tags' => ['Indramayu'],
                'lead' => 'Ratusan karung pasir disusun swadaya oleh warga bersama aparat TNI-Polri menyusul terkikisnya bibir tanggul penahan air.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Kebersamaan warga desa di perbatasan Sukra kembali membuktikan kekuatan solidaritas sosial. Tanpa menunggu bantuan alat berat, warga beramai-ramai menutup retakan tanggul tanah untuk mencegah limpasan air ke permukiman padat.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Cegah Stunting di Pelosok Desa, Kader Posyandu Gencarkan Pembagian Telur dan Susu Balita',
                'slug' => 'cegah-stunting-di-pelosok-desa-kader-posyandu-gencarkan-pembagian-telur-dan-susu-balita',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-05',
                'dibaca' => 2180,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Majalengka',
                'foto' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&q=80',
                'tags' => ['Kesehatan', 'Majalengka'],
                'lead' => 'Edukasi pemenuhan protein hewani dan pemeriksaan tumbuh kembang anak rutin digulirkan di pos-pos pelayanan terpadu desa.',
                'isi' => "<p><strong>MAJALENGKA, Cuplik.com</strong> — Upaya menekan angka gagal tumbuh pada balita terus dimaksimalkan para bidan desa dan sukarelawan posyandu melalui pemberian makanan tambahan bergizi seimbang.</p>",
                'tone' => '#edf2f0',
            ],

            // ==================== HUKUM ====================
            [
                'judul' => 'Diduga Peras Kuwu Rp3 Juta dengan Modus Ancaman Berita Miring, 2 Oknum LSM Diamankan Polisi',
                'slug' => 'diduga-peras-kuwu-rp3-juta-dengan-modus-ancaman-berita-miring-2-oknum-lsm-diamankan-polisi',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-08',
                'dibaca' => 5890,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1200&q=80',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Satreskrim Polres Indramayu menyita amplop berisi uang tunai dan kartu anggota identitas abal-abal dari tangan kedua pelaku.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Tindakan tegas diambil jajaran kepolisian terhadap oknum yang kerap meresahkan aparatur pemerintahan desa. Dua pria berinisial AR (42) dan SM (38) tertangkap tangan saat memeras seorang kepala desa (Kuwu) di wilayah Jatibarang.</p><p>Pelaku mengancam akan membuat laporan fiktif ke aparat penegak hukum terkait pengelolaan dana desa jika permintaannya tidak dipenuhi.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Kejari Sita Tanah dan Rumah Mewah Tersangka Korupsi Proyek Embung Senilai Rp1,4 Miliar',
                'slug' => 'kejari-sita-tanah-dan-rumah-mewah-tersangka-korupsi-proyek-embung-senilai-rp1-4-miliar',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-06',
                'dibaca' => 4120,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?w=1200&q=80',
                'tags' => ['Cirebon', 'Birokrasi'],
                'lead' => 'Penyitaan aset tanah dilakukan guna memulihkan kerugian keuangan negara akibat proyek penampung air fiktif.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Tim penyidik Pidsus Kejaksaan Negeri memasang plang sita eksekusi pada sejumlah aset properti milik mantan pejabat pembuat komitmen proyek irigasi embung pedesaan.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Sidang Sengketa Lahan Hibah Madrasah di PN Cirebon Diwarnai Tangis Haru Ratusan Santri',
                'slug' => 'sidang-sengketa-lahan-hibah-madrasah-di-pn-cirebon-diwarnai-tangis-haru-ratusan-santri',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-05',
                'dibaca' => 3100,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1436450412740-6b988f486c6b?w=1200&q=80',
                'tags' => ['Cirebon'],
                'lead' => 'Majelis hakim memeriksa dokumen letter C dan surat kesaksian wakaf yang digugat oleh salah seorang ahli waris.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Ruang sidang utama Pengadilan Negeri Cirebon dipadati para wali santri yang berharap status tanah tempat belajar anak-anak mereka tetap terlindungi secara hukum berkekuatan tetap.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Polres Sita Ratusan Knalpot Brong dan Bubarkan Aksi Balap Liar Jalur Pantura',
                'slug' => 'polres-sita-ratusan-knalpot-brong-dan-bubarkan-aksi-balap-liar-jalur-pantura',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-04',
                'dibaca' => 2450,
                'editor' => 'Ato Susanto',
                'penulis' => 'Ato Susanto',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=1200&q=80',
                'tags' => ['Indramayu'],
                'lead' => 'Operasi cipta kondisi malam akhir pekan mengamankan puluhan pemuda dan kendaraan roda dua tanpa kelengkapan surat resmi.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Razia gabungan Satlantas dan Sabhara menindak tegas aksi kebut-kebutan di jalur arteri yang kerap membahayakan pengguna jalan umum.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== EKONOMI ====================
            [
                'judul' => 'Harga Bawang Merah dan Cabai Rawit Meroket di Pasar Tradisional, Pedagang Keluhkan Pembeli Sepi',
                'slug' => 'harga-bawang-merah-dan-cabai-rawit-meroket-di-pasar-tradisional-pedagang-keluhkan-pembeli-sepi',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-08',
                'dibaca' => 3890,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1610348725531-843dff563e2c?w=1200&q=80',
                'tags' => ['Cirebon', 'Pertanian'],
                'lead' => 'Kenaikan harga bumbu dapur dipicu oleh penurunan suplai dari petani sentra produksi akibat faktor cuaca basah.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Lonjakan harga komoditas pangan kembali menekan daya beli masyarakat. Di Pasar Jagasatru Cirebon dan Pasar Baru Indramayu, harga cabai rawit merah menembus Rp75.000 per kilogram, membuat pedagang terpaksa mengurangi stok harian.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Kisah Sukses Koperasi Mangga Gedong Gincu Indramayu Tembus Ekspor ke Swalayan Jepang',
                'slug' => 'kisah-sukses-koperasi-mangga-gedong-gincu-indramayu-tembus-ekspor-ke-swalayan-jepang',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-07',
                'dibaca' => 4560,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=1200&q=80',
                'tags' => ['Indramayu', 'Pertanian'],
                'lead' => 'Penerapan standar budidaya organik dan sertifikasi Good Agricultural Practices membuka pintu pasar ekspor bernilai miliaran rupiah.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Buah mangga kebanggaan Wong Dermayu kini berjajar manis di rak-rak supermarket premium Tokyo. Koperasi petani lokal berhasil mengirimkan 10 ton mangga sortiran grade A dengan harga jual 4 kali lipat dibanding pasar lokal.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Petani Tambak Udang Vaname Nikmati Panen Melimpah Berkat Pemanfaatan Kincir Listrik PLN',
                'slug' => 'petani-tambak-udang-vaname-nikmati-panen-melimpah-berkat-pemanfaatan-kincir-listrik-pln',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-05',
                'dibaca' => 2940,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1200&q=80',
                'tags' => ['Indramayu', 'Nelayan'],
                'lead' => 'Pengalihan bahan bakar genset ke jaringan listrik andal menghemat biaya produksi pakan dan sirkulasi air tambak hingga 45 persen.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Program elektrifikasi tambak pesisir terbukti nyata meningkatkan efisiensi dan margin keuntungan petambak udang di wilayah Cantigi dan Kandanghaur.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Pemerintah Salurkan Bantuan Beras CPP 10 Kg untuk 120 Ribu Keluarga Penerima Manfaat',
                'slug' => 'pemerintah-salurkan-bantuan-beras-cpp-10-kg-untuk-120-ribu-keluarga-penerima-manfaat',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-04',
                'dibaca' => 3120,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=1200&q=80',
                'tags' => ['Indramayu', 'Pertanian'],
                'lead' => 'Penyaluran cadangan beras pemerintah digulirkan serentak di 31 kecamatan guna menjaga stabilitas harga beras medium.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Badan Pangan Nasional bersama Perum Bulog mendistribusikan ribuan ton beras berkualitas medium untuk meringankan beban pengeluaran pangan keluarga pra-sejahtera.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== RAGAM ====================
            [
                'judul' => 'Menelisik Filosofi Batik Paoman Indramayu: Cerita Ombak, Ikan Etong, dan Jiwa Bahari Wong Dermayu',
                'slug' => 'menelisik-filosofi-batik-paoman-indramayu-cerita-ombak-ikan-etong-dan-jiwa-bahari-wong-dermayu',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-08',
                'dibaca' => 4180,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=1200&q=80',
                'tags' => ['Budaya', 'Indramayu'],
                'lead' => 'Guratan canting para maestro batik pesisir menyimpan catatan sejarah ketangguhan masyarakat maritim tanah Jawa.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Tak seperti batik pedalaman yang sarat pakem aristokrat keraton, Batik Tulis Paoman lahir dari denyut nadi pesisir. Motif iwak etong, kapal kandas, hingga lumbu kencana digores dengan warna-warna berani yang mencerminkan kejujuran dan keterbukaan watak Wong Indramayu.</p><p>Di sanggar-sanggar tua Paoman, para perajin sepuh terus mewariskan ketelitian canting kepada anak-anak muda agar mahakarya warisan leluhur ini tetap abadi.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Nikmatnya Rumbah Kopek dan Pedasan Entog Khas Pantura, Kuliner Pedas Gurih yang Bikin Nagih',
                'slug' => 'nikmatnya-rumbah-kopek-dan-pedasan-entog-khas-pantura-kuliner-pedas-gurih-yang-bikin-nagih',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-07',
                'dibaca' => 3620,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=1200&q=80',
                'tags' => ['Kuliner Pantura', 'Indramayu'],
                'lead' => 'Perpaduan rebusan daun semanggi dengan petis ikan asam jawa menghadirkan sensasi rasa autentik di lidah penikmat kuliner.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Melintasi jalur pantura belum lengkap tanpa mencicipi kelezatan rumbah kopek dan pedasan entog. Kuah rempah pedas cabai rawit merah dan asam jawa berpadu sempurna menciptakan kenikmatan kuliner rakyat yang legendaris.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Pentas Musik Tarling Klasik Pikat Ribuan Generasi Z di Alun-Alun: Bukti Seni Tradisi Tak Pernah Mati',
                'slug' => 'pentas-musik-tarling-klasik-pikat-ribuan-generasi-z-di-alun-alun-bukti-seni-tradisi-tak-pernah-mati',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-05',
                'dibaca' => 3120,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1200&q=80',
                'tags' => ['Budaya', 'Cirebon'],
                'lead' => 'Petikan dawai gitar akustik dan tiupan suling bambu berpadu harmonis menyanyikan kidung-kidung cinta tanah pesisir.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Gelaran malam apresiasi tarling klasik berhasil memukau kawula muda. Aransemen segar tanpa menghilangkan pakem orisinal membuktikan kekayaan budaya daerah selalu relevan melintasi zaman.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Kisah Abah Casmita, 40 Tahun Mengabdi Hijaukan Hutan Mangrove Karangsong Demi Lindungi Pesisir',
                'slug' => 'kisah-abah-casmita-40-tahun-mengabdi-hijaukan-hutan-mangrove-karangsong-demi-lindungi-pesisir',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-04',
                'dibaca' => 3450,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80',
                'tags' => ['Budaya', 'Indramayu'],
                'lead' => 'Ketekunan menancapkan bibit bakau sejak dekade 1980 kini berbuah kawasan ekowisata hijau paru-paru bumi Indramayu.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Berawal dari kecemasan melihat abrasi laut yang menggerus tambak warga, Abah Casmita mendedikasikan hidupnya menanam mangrove. Kini kawasan tersebut menjadi benteng alami dari terjangan tsunami kecil dan rumah bagi aneka burung migran langka.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== LUAR NEGERI ====================
            [
                'judul' => 'PBB Desak Pembukaan Koridor Bantuan Kemanusiaan Mendesak dan Gencatan Senjata Permanen',
                'slug' => 'pbb-desak-pembukaan-koridor-bantuan-kemanusiaan-mendesak-dan-gencatan-senjata-permanen',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-08',
                'dibaca' => 4890,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'New York',
                'foto' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&q=80',
                'tags' => ['Indramayu'],
                'lead' => 'Sidang darurat Dewan Keamanan PBB menyerukan penghentian agresi militer demi menyelamatkan jutaan warga sipil tak berdosa.',
                'isi' => "<p><strong>NEW YORK, Cuplik.com</strong> — Sekretaris Jenderal PBB kembali menyuarakan peringatan keras terhadap krisis kemanusiaan yang kian parah. Seluruh pihak yang bertikai diwajibkan menghormati hukum internasional dan memberikan akses penuh bagi konvoi medis dan pasokan pangan PBB.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'KTT ASEAN 2026 Sepakati Kerja Sama Jaringan Listrik Bersih dan Interkoneksi Energi Hijau',
                'slug' => 'ktt-asean-2026-sepakati-kerja-sama-jaringan-listrik-bersih-dan-interkoneksi-energi-hijau',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-06',
                'dibaca' => 3120,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Kuala Lumpur',
                'foto' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=1200&q=80',
                'tags' => ['Teknologi Terapan'],
                'lead' => 'Negara-negara Asia Tenggara menyepakati integrasi transmisi daya listrik terbarukan guna mencapai target zero emisi karbon kawasan.',
                'isi' => "<p><strong>KUALA LUMPUR, Cuplik.com</strong> — Kesepakatan bersejarah dicapai dalam Konferensi Tingkat Tinggi ASEAN. Interkoneksi jaringan kabel bawah laut akan menghubungkan potensi pembangkit tenaga surya dan hidro antarnegara anggota.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Diaspora Indonesia di Tokyo Gelar Festival Budaya Nusantara, Tari Topeng Cirebon Hipnotis Warga Jepang',
                'slug' => 'diaspora-indonesia-di-tokyo-gelar-festival-budaya-nusantara-tari-topeng-cirebon-hipnotis-warga-jepang',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-05',
                'dibaca' => 3450,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Tokyo',
                'foto' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=1200&q=80',
                'tags' => ['Budaya'],
                'lead' => 'Pentas seni tradisional dan bazar kuliner rendang serta kopi nusantara sukses menyedot lebih dari 15 ribu pengunjung di taman Yoyogi.',
                'isi' => "<p><strong>TOKYO, Cuplik.com</strong> — Diplomasi budaya melalui pertunjukan Tari Topeng Kelana dan alunan gamelan Jawa Barat menuai decak kagum warga lokal Tokyo dalam festival tahunan Indonesia-Japan Friendship Day.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Konferensi Iklim COP31 Bahas Pendanaan Darurat Kerusakan Pesisir bagi Negara-Negara Kepulauan',
                'slug' => 'konferensi-iklim-cop31-bahas-pendanaan-darurat-kerusakan-pesisir-bagi-negara-negara-kepulauan',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-03',
                'dibaca' => 2180,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Jenewa',
                'foto' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&q=80',
                'tags' => ['Nelayan'],
                'lead' => 'Negara maju ditagih komitmen transfer teknologi adaptasi mitigasi naiknya permukaan air laut bagi wilayah pesisir rentan.',
                'isi' => "<p><strong>JENEWA, Cuplik.com</strong> — Delegasi Indonesia dan negara Pasifik menekankan pentingnya realisasi dana Loss and Damage Fund untuk membiayai relokasi pemukiman dan penguatan tanggul laut di wilayah pulau-pulau kecil.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== IPTEK ====================
            [
                'judul' => 'Dosen Polindra Ciptakan Alat Smart Farming IoT Bertenaga Surya untuk Optimalkan Irigasi Mangga',
                'slug' => 'dosen-polindra-ciptakan-alat-smart-farming-iot-bertenaga-surya-untuk-optimalkan-irigasi-mangga',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-08',
                'dibaca' => 3780,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&q=80',
                'tags' => ['Teknologi Terapan', 'Indramayu', 'Pertanian'],
                'lead' => 'Sensor tanah otomatis berbasis mikrokontroler mampu menyiram pohon mangga sesuai kadar kelembaban tanah tanpa intervensi manual.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Politeknik Negeri Indramayu (Polindra) kembali meluncurkan riset terapan inovatif. Perangkat smart farming rancangan tim dosen teknik mesin dan informatika ini dioperasikan menggunakan baterai panel surya ramah lingkungan.</p><p>Petani cukup memantau kondisi suhu, pH, dan kelembaban tanah kebun mangga melalui aplikasi ponsel secara real-time.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'BRIN Luncurkan Konstelasi Satelit Mikro Observasi Maritim untuk Deteksi Dini Cuaca Ekstrem Nelayan',
                'slug' => 'brin-luncurkan-konstelasi-satelit-mikro-observasi-maritim-untuk-deteksi-dini-cuaca-ekstrem-nelayan',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-06',
                'dibaca' => 2940,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&q=80',
                'tags' => ['Teknologi Terapan', 'Nelayan'],
                'lead' => 'Data citra radar satelit karya peneliti antariksa nasional dikirimkan langsung ke aplikasi BMKG untuk peringatan gelombang tinggi.',
                'isi' => "<p><strong>JAKARTA, Cuplik.com</strong> — Penguatan kedaulatan teknologi antariksa nasional melangkah maju dengan peluncuran satelit mikro generasi terbaru yang dirancang untuk memantau perairan nusantara dari potensi badai tropis.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Aplikasi Layanan Surat Desa Digital Mulai Diterapkan di 50 Balai Desa, Warga Tak Perlu Antre',
                'slug' => 'aplikasi-layanan-surat-desa-digital-mulai-diterapkan-di-50-balai-desa-warga-tak-perlu-antre',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-04',
                'dibaca' => 2480,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80',
                'tags' => ['Teknologi Terapan', 'Indramayu'],
                'lead' => 'Surat keterangan domisili dan pengantar nikah kini dapat diajukan via WhatsApp bot dan ditandatangani elektronik oleh Kuwu.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Digitalisasi administrasi desa memangkas birokrasi berbelit. Inovasi layanan online desa ini menjamin penerbitan dokumen kependudukan selesai dalam hitungan menit secara gratis.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Panel Surya Fleksibel Karya Mahasiswa Polindra Bantu Penuhi Listrik Kapal Nelayan Saat Melaut',
                'slug' => 'panel-surya-fleksibel-karya-mahasiswa-polindra-bantu-penuhi-listrik-kapal-nelayan-saat-melaut',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-02',
                'dibaca' => 2190,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=1200&q=80',
                'tags' => ['Teknologi Terapan', 'Nelayan'],
                'lead' => 'Pemasangan solar cell tahan air asin di atap kapal kayu menghemat aki dan memastikan radio komunikasi darurat selalu menyala.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Teknologi tepat guna mahasiswa vokasi ini sangat diapresiasi kelompok nelayan tradisional karena mampu menjaga pasokan listrik navigasi di tengah laut tanpa risiko mati mesin.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== GAYA HIDUP ====================
            [
                'judul' => 'Tren Kedai Kopi Manual Brew Menjamur di Indramayu-Cirebon, Jadi Ruang Kreatif Anak Muda',
                'slug' => 'tren-kedai-kopi-manual-brew-menjamur-di-indramayu-cirebon-jadi-ruang-kreatif-anak-muda',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-08',
                'dibaca' => 3620,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1200&q=80',
                'tags' => ['Kuliner Pantura', 'Kesehatan'],
                'lead' => 'Kombinasi biji kopi lokal lereng Gunung Ciremai dan suasana estetik minimalis mengubah kedai kopi jadi ruang diskusi produktif.',
                'isi' => "<p><strong>CIREBON, Cuplik.com</strong> — Budaya ngopi di kawasan pantura bertransformasi pesat. Bukan lagi sekadar warung kopi saset, kedai-kedai kopi artisan yang mengusung konsep seduh manual V60 dan Japanese ice drip kian digandrungi kalangan pekerja lepas, desainer, dan mahasiswa.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => '5 Tips Menjaga Imunitas dan Kebugaran Tubuh Menghadapi Cuaca Pancaroba yang Tak Menentu',
                'slug' => '5-tips-menjaga-imunitas-dan-kebugaran-tubuh-menghadapi-cuaca-pancaroba-yang-tak-menentu',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-06',
                'dibaca' => 2850,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Bandung',
                'foto' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1200&q=80',
                'tags' => ['Kesehatan'],
                'lead' => 'Dokter spesialis penyakit dalam membagikan panduan nutrisi seimbang, hidrasi cukup, dan olahraga ringan untuk hindari flu dan radang.',
                'isi' => "<p><strong>BANDUNG, Cuplik.com</strong> — Perubahan suhu ekstrem dari panas terik ke hujan lebat menuntut kewaspadaan ekstra terhadap daya tahan tubuh. Memperbanyak konsumsi vitamin C alami dari buah lokal dan tidur cukup minimal 7 jam sehari menjadi kunci utama.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Atasi Kecemasan di Era Medsos dengan Digital Detox: Cara Sederhana Kembalikan Ketenangan Jiwa',
                'slug' => 'atasi-kecemasan-di-era-medsos-dengan-digital-detox-cara-sederhana-kembalikan-ketenangan-jiwa',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-04',
                'dibaca' => 3120,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=1200&q=80',
                'tags' => ['Kesehatan'],
                'lead' => 'Menyisihkan waktu 1 jam sebelum tidur tanpa melihat layar gawai terbukti ampuh memperbaiki kualitas istirahat dan fokus kerja.',
                'isi' => "<p><strong>JAKARTA, Cuplik.com</strong> — Paparan informasi tanpa henti di media sosial kerap memicu gejala FoMO (Fear of Missing Out). Praktik pembatasan screen time di akhir pekan membantu merestart kesehatan mental dan menghadirkan kedekatan nyata bersama keluarga.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Inspirasi Menata Rumah Sejuk Hemat Energi dengan Konsep Ventilasi Silang dan Tanaman Tropis',
                'slug' => 'inspirasi-menata-rumah-sejuk-hemat-energi-dengan-konsep-ventilasi-silang-dan-tanaman-tropis',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-02',
                'dibaca' => 2410,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
                'tags' => ['Kesehatan'],
                'lead' => 'Optimalisasi pencahayaan alami dan roster tanah liat menjaga suhu ruangan tetap dingin di kawasan pesisir beriklim hangat.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Desain arsitektur tropis modern semakin digemari karena mampu memangkas tagihan listrik pendingin ruangan sekaligus menciptakan suasana asri di lahan terbatas.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== BOLA ====================
            [
                'judul' => 'Shin Tae-yong Siapkan Formasi Kejutan, Timnas Indonesia Bidik Kemenangan Krusial Kualifikasi Piala Dunia',
                'slug' => 'shin-tae-yong-siapkan-formasi-kejutan-timnas-indonesia-bidik-kemenangan-krusial-kualifikasi-piala-dunia',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-08',
                'dibaca' => 8940,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1200&q=80',
                'tags' => ['Timnas', 'Liga Indonesia'],
                'lead' => 'Disiplin zonal marking dan kecepatan transisi sayap menjadi senjata utama Skuad Garuda meredam dominasi lawan.',
                'isi' => "<p><strong>JAKARTA, Cuplik.com</strong> — Antusiasme suporter tanah air membakar semangat para penggawa Timnas Indonesia jelang laga penentuan putaran ketiga Kualifikasi Piala Dunia. Seluruh pemain dalam kondisi bugar dan siap bertarung habis-habisan demi membawa Merah Putih mengukir sejarah baru.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Persib Bandung vs Persija Jakarta: Duel Klasik Penuh Gengsi dan Adu Taktik Panas di Si Jalak Harupat',
                'slug' => 'persib-bandung-vs-persija-jakarta-duel-klasik-penuh-gengsi-dan-adu-taktik-panas-di-si-jalak-harupat',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-07',
                'dibaca' => 7620,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Bandung',
                'foto' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&q=80',
                'tags' => ['Liga Indonesia'],
                'lead' => 'Rivalitas abadi dua raksasa sepak bola nasional kembali tersaji dalam lanjutan Liga 1 dengan pengamanan ketat kepolisian.',
                'isi' => "<p><strong>BANDUNG, Cuplik.com</strong> — Pertemuan sarat gengsi antara Maung Bandung dan Macan Kemayoran dipastikan menyajikan laga bertempo cepat. Kedua pelatih menegaskan fokus pada raihan 3 poin demi menjaga asa perebutan gelar juara liga.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Final Bupati Cup 2026 Memanas, Tim Bola Voli Pesisir Berhasil Raih Gelar Juara Bergengsi',
                'slug' => 'final-bupati-cup-2026-memanas-tim-bola-voli-pesisir-berhasil-raih-gelar-juara-bergengsi',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-05',
                'dibaca' => 4120,
                'editor' => 'Almak',
                'penulis' => 'Baebudin',
                'lokasi' => 'Lampung',
                'foto' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=1200&q=80',
                'tags' => ['Liga Indonesia'],
                'lead' => 'Spike tajam dan pertahanan rapat mengantar tim unggulan merebut piala bergilir di hadapan ribuan penonton yang memadati GOR.',
                'isi' => "<p><strong>KALIANDA, Cuplik.com</strong> — Partai puncak turnamen bola voli Bupati Cup 2026 menyajikan drama 5 set yang mendebarkan. Atmosfer sportivitas dan kemeriahan suporter antarkecamatan membuktikan gairah olahraga rakyat yang sangat tinggi.</p>",
                'tone' => '#f4f4ee',
            ],
            [
                'judul' => 'Akademi Sepak Bola Usia Dini Pantura Terus Lahirkan Bibit Unggul Masuk Seleksi Nasional',
                'slug' => 'akademi-sepak-bola-usia-dini-pantura-terus-lahirkan-bibit-unggul-masuk-seleksi-nasional',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-03',
                'dibaca' => 2890,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?w=1200&q=80',
                'tags' => ['Indramayu', 'Liga Indonesia'],
                'lead' => 'Pembinaan bakat muda berlisensi resmi di Indramayu membekali anak-anak pesisir dengan disiplin mental dan keterampilan teknik modern.',
                'isi' => "<p><strong>INDRAMAYU, Cuplik.com</strong> — Tiga pemain muda berbakat asal Indramayu dipanggil mengikuti pemusatan latihan akademi profesional di Jakarta, membuktikan potensi besar talenta pesisir di kancah persepakbolaan nasional.</p>",
                'tone' => '#edf2f0',
            ],
        ];

        $createdArticles = [];
        foreach ($articlesData as $ad) {
            $cat = $categoriesMap[$ad['kategori']] ?? null;
            if (!$cat) continue;

            $art = Article::updateOrCreate(['slug' => $ad['slug']], [
                'user_id' => $userIds[$ad['penulis']] ?? null,
                'judul' => $ad['judul'],
                'category_id' => $cat->id,
                'editor_nama' => $ad['editor'],
                'penulis_nama' => $ad['penulis'],
                'lokasi' => $ad['lokasi'],
                'foto' => $ad['foto'] ?? null,
                'lead' => $ad['lead'],
                'isi' => $ad['isi'],
                'tone' => $ad['tone'],
                'dibaca' => $ad['dibaca'],
                'status' => 'Terbit',
                'tanggal' => $ad['tanggal'],
            ]);

            $createdArticles[$ad['slug']] = $art;

            $tagIds = [];
            foreach ($ad['tags'] as $tn) {
                if (isset($tagsMap[$tn])) {
                    $tagIds[] = $tagsMap[$tn]->id;
                }
            }
            $art->tags()->sync($tagIds);
        }

        // 5. Comments on Top Articles
        $sampleComments = [
            [
                'nama' => 'H. Mamat Sutarman',
                'email' => 'mamat@gmail.com',
                'komentar' => 'Sangat setuju dengan pandangan ini. Pemimpin daerah harus benar-benar berpihak pada kesejahteraan rakyat dan birokrasi yang bersih tanpa mahar.',
                'status' => 'Tampil',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@yahoo.com',
                'komentar' => 'Semoga saluran irigasi di Anjatan segera terairi normal. Petani kita sudah lama menanti air demi kelangsungan tanam padi.',
                'status' => 'Tampil',
            ],
            [
                'nama' => 'Ahmad Junaedi',
                'email' => 'junaedi@gmail.com',
                'komentar' => 'Cuplik.com beritanya selalu cepat, berani mengungkap fakta lapangan, dan dekat dengan suara wong cilik!',
                'status' => 'Tampil',
            ],
        ];

        foreach ($createdArticles as $slug => $articleObj) {
            foreach ($sampleComments as $sc) {
                Comment::firstOrCreate([
                    'article_id' => $articleObj->id,
                    'nama' => $sc['nama'],
                ], [
                    'email' => $sc['email'],
                    'komentar' => $sc['komentar'],
                    'status' => $sc['status'],
                ]);
            }
            break;
        }

        // 6. Multimedia Videos
        $videosData = [
            [
                'judul' => 'Liputan Khusus: Suasana Kemeriahan Pesta Laut Nelayan Karangsong 2026',
                'slug' => 'liputan-kemeriahan-pesta-laut-karangsong-2026',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '08:22',
                'dibaca' => 5200,
                'tanggal' => '2026-10-08',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Istri Calon Bupati Indramayu nomor urut 3 Kunjungi Ketua Srikandi Brigade 08',
                'slug' => 'istri-calon-bupati-indramayu-kunjungi-ketua-srikandi-brigade-08',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '04:15',
                'dibaca' => 3420,
                'tanggal' => '2026-10-07',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Organ NEW ARIMBI | Pentas Musik Tradisional Tarling Klasik Pantura',
                'slug' => 'organ-new-arimbi-pentas-musik-tradisional-tarling-klasik-pantura',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '12:40',
                'dibaca' => 8910,
                'tanggal' => '2026-10-06',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Dokumenter: Menjaga Hutan Mangrove Karangsong Bersama Warga Lokal',
                'slug' => 'dokumenter-menjaga-hutan-mangrove-karangsong-bersama-warga-lokal',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '15:10',
                'dibaca' => 4120,
                'tanggal' => '2026-10-05',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Inovasi Smart Farming Politeknik Negeri Indramayu untuk Petani Mangga',
                'slug' => 'inovasi-smart-farming-politeknik-negeri-indramayu-untuk-petani-mangga',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '06:30',
                'dibaca' => 2980,
                'tanggal' => '2026-10-04',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Highlights Babak Final Turnamen Bola Voli Bupati Cup 2026',
                'slug' => 'highlights-babak-final-turnamen-bola-voli-bupati-cup-2026',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '09:45',
                'dibaca' => 4560,
                'tanggal' => '2026-10-03',
                'status' => 'Tayang',
            ],
        ];

        foreach ($videosData as $vd) {
            Video::updateOrCreate(['slug' => $vd['slug']], $vd);
        }

        // 7. Polls
        $poll = Poll::updateOrCreate(
            ['pertanyaan' => 'Menurut Anda, sektor prioritas apa yang paling mendesak dibenahi pemerintah daerah di tahun 2026 ini?'],
            ['status' => 'Aktif']
        );

        $pollOptions = [
            ['opsi' => 'Perbaikan Jalan Poros Desa & Irigasi Pertanian', 'suara' => 524, 'urutan' => 1],
            ['opsi' => 'Peningkatan Insentif Guru PAUD, Madrasah & Honorer', 'suara' => 312, 'urutan' => 2],
            ['opsi' => 'Layanan Puskesmas 24 Jam & Obat Gratis', 'suara' => 245, 'urutan' => 3],
            ['opsi' => 'Permudahan Akses Pupuk Subsidi & Modal UMKM', 'suara' => 189, 'urutan' => 4],
        ];

        foreach ($pollOptions as $po) {
            PollOption::updateOrCreate([
                'poll_id' => $poll->id,
                'opsi' => $po['opsi'],
            ], [
                'suara' => $po['suara'],
                'urutan' => $po['urutan'],
            ]);
        }

        // Akun demo Member dibuat setelah berita agar seeding tidak mengirim email notifikasi.
        User::updateOrCreate(['email' => 'member@cuplik.com'], [
            'name' => 'Member Cuplik',
            'password' => Hash::make('password'),
            'role' => 'Member',
            'status' => 'Aktif',
        ]);

        // 8. Curhat Rakyat / Keluh Kesah Warga
        $curhatsData = [
            [
                'pengirim' => 'Guru Honorer PAUD',
                'lokasi' => 'Bongas, Indramayu',
                'pesan' => 'Pak Bupati, mohon kepastian pencairan insentif daerah Rp100 ribu per bulan. Kami sudah mengabdi puluhan tahun mendidik anak-anak desa dengan penuh keikhlasan.',
                'tanggal' => '2026-10-08',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Pak Carim (Petani Padi)',
                'lokasi' => 'Anjatan, Indramayu',
                'pesan' => 'Jalan cor sawah sudah bagus, tapi tolong pintu air sekunder dibersihkan dari lumpur sedimentasi agar air irigasi sampai ke petak sawah ujung barat.',
                'tanggal' => '2026-10-08',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Keluarga Nelayan',
                'lokasi' => 'Karangsong, Indramayu',
                'pesan' => 'Fasilitas posko kesehatan di pelabuhan tolong disiagakan petugas medis malam hari untuk pertolongan pertama ABK kapal yang cedera di laut.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Pedagang Pasar Kanci',
                'lokasi' => 'Astanajapura, Cirebon',
                'pesan' => 'Mohon penerangan lampu pasar dan penataan lapak diperbaiki agar pembeli nyaman dan tidak becek saat musim hujan.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Warga Jatibarang',
                'lokasi' => 'Jatibarang, Indramayu',
                'pesan' => 'Lampu PJU jalan raya Jatibarang arah Kertasemaya banyak yang mati, mohon Dishub segera cek demi keselamatan pengguna motor malam hari.',
                'tanggal' => '2026-10-06',
                'status' => 'Tampil',
            ],
        ];

        foreach ($curhatsData as $cd) {
            Curhat::create($cd);
        }

        // 10. Real Count Pilbup Indramayu
        $pilbup = Pilbup::updateOrCreate(
            ['judul' => 'Pemilihan Bupati dan Wakil Bupati Indramayu 2020'],
            ['tahun' => 2020, 'status' => 'Aktif']
        );

        $paslonsData = [
            ['no_urut' => 1, 'nama' => 'SHOLIHIN - RATNA', 'usungan' => 'PKB, Demokrat, PKS, Hanura', 'warna' => '#0b5d3b'],
            ['no_urut' => 2, 'nama' => 'TOTO - DEIS', 'usungan' => 'Independen / Perseorangan', 'warna' => '#00d4c8'],
            ['no_urut' => 3, 'nama' => 'DANIEL - TAUFIK', 'usungan' => 'Golkar, Gerindra, PAN', 'warna' => '#f2e600'],
            ['no_urut' => 4, 'nama' => 'NINA - LUCKY', 'usungan' => 'PDI Perjuangan, Gerindra, NasDem, Perindo', 'warna' => '#e51c23'],
        ];

        $paslonsMap = [];
        foreach ($paslonsData as $pd) {
            $p = Paslon::updateOrCreate([
                'pilbup_id' => $pilbup->id,
                'no_urut' => $pd['no_urut'],
            ], [
                'nama' => $pd['nama'],
                'usungan' => $pd['usungan'],
                'warna' => $pd['warna'],
            ]);
            $paslonsMap[$pd['no_urut']] = $p;
        }

        $dptRaw = [
            ['Anjatan', 'Anjatan', 10, 3763, 2, 40, 58],
            ['Anjatan', 'Anjatan Baru', 11, 4833, 2, 73, 55],
            ['Anjatan', 'Anjatan Utara', 14, 5826, 0, 39, 83],
            ['Anjatan', 'Bugis', 13, 5695, 9, 64, 59],
            ['Anjatan', 'Bugis Tua', 12, 4673, 0, 67, 53],
            ['Anjatan', 'Cilandak', 9, 3110, 1, 23, 48],
            ['Anjatan', 'Cilandak Lor', 9, 3827, 0, 41, 42],
            ['Anjatan', 'Kedungwungu', 15, 6589, 12, 58, 64],
            ['Anjatan', 'Kopyah', 11, 4886, 1, 60, 51],
            ['Anjatan', 'Lempuyang', 11, 4382, 3, 15, 32],
            ['Arahan', 'Arahan Lor', 12, 4100, 1, 30, 40],
            ['Arahan', 'Arahan Kidul', 10, 3500, 0, 22, 35],
            ['Balongan', 'Balongan', 13, 4400, 1, 28, 38],
            ['Balongan', 'Rawadalem', 11, 3900, 0, 20, 33],
        ];

        foreach ($dptRaw as $row) {
            $dpt = Dpt::updateOrCreate([
                'pilbup_id' => $pilbup->id,
                'kecamatan' => $row[0],
                'desa' => $row[1],
            ], [
                'tps' => $row[2],
                'dpt' => $row[3],
                'dpph' => $row[4],
                'dptb' => $row[5],
                'ts' => $row[6],
            ]);

            $validVotes = (int)round($row[3] * 0.76) - $row[6];
            $weights = [0.24, 0.10, 0.28, 0.38];
            $sumWeight = array_sum($weights);

            foreach ($paslonsMap as $no => $paslon) {
                $suara = (int)round($validVotes * ($weights[$no - 1] / $sumWeight));
                SuaraPilbup::updateOrCreate([
                    'dpt_id' => $dpt->id,
                    'paslon_id' => $paslon->id,
                ], [
                    'suara' => $suara,
                ]);
            }
        }

        // 12. Posisi Iklan (master data slot iklan gambar)
        $posisiData = [
            ['nama' => 'Header Top', 'ukuran' => '728x90', 'keterangan' => 'Slot di bagian atas header'],
            ['nama' => 'Sidebar Right', 'ukuran' => '300x250', 'keterangan' => 'Slot sidebar kanan konten'],
            ['nama' => 'Sidebar Sticky', 'ukuran' => '300x600', 'keterangan' => 'Slot sidebar menempel saat scroll'],
            ['nama' => 'Article In-Read', 'ukuran' => '728x90', 'keterangan' => 'Slot di tengah isi artikel'],
            ['nama' => 'Footer Banner', 'ukuran' => '970x90', 'keterangan' => 'Slot banner bagian footer'],
            ['nama' => 'Popup Overlay', 'ukuran' => null, 'keterangan' => 'Slot popup saat halaman dibuka'],
        ];
        foreach ($posisiData as $pos) {
            IklanPosisi::updateOrCreate(['nama' => $pos['nama']], $pos);
        }

        // 13. Pengaturan Situs (Profil Situs)
        Setting::updateOrCreate(['id' => 1], [
            'site_name' => 'Cuplik.com',
            'tagline' => 'Kabar Terkini Wong Pantura',
            'deskripsi' => 'Portal berita lokal Indramayu, Cirebon, dan sekitarnya.',
            'alamat' => 'Jl. Pahlawan No. 1, Indramayu, Jawa Barat',
            'email' => 'redaksi@cuplik.com',
            'telepon' => '0234-123456',
            'footer_text' => '&copy; ' . date('Y') . ' Cuplik.com. Seluruh hak cipta dilindungi.',
        ]);
    }
}
