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
use App\Models\Banner;
use App\Models\NewsletterSubscriber;
use App\Models\Pilbup;
use App\Models\Paslon;
use App\Models\Dpt;
use App\Models\SuaraPilbup;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users / Editorial Team
        $users = [
            [
                'name' => 'Admin Cuplik',
                'email' => 'admin@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Alghoz',
                'email' => 'alghoz@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Farhan Maksudi',
                'email' => 'farhan@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Editor',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Dalani',
                'email' => 'dalani@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Editor',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ismail',
                'email' => 'ismail@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Editor',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Baebudin',
                'email' => 'baebudin@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Editor',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Almak',
                'email' => 'almak@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Editor',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Daman',
                'email' => 'daman@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Reporter',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Ato Susanto',
                'email' => 'atosusanto@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Reporter',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Opini Redaksi',
                'email' => 'opini@cuplik.com',
                'password' => Hash::make('password'),
                'role' => 'Penulis',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Rani Putri',
                'email' => 'member1@example.com',
                'password' => Hash::make('password'),
                'role' => 'Member',
                'status' => 'Aktif',
            ],
            [
                'name' => 'Dimas Aji Pratama',
                'email' => 'member2@example.com',
                'password' => Hash::make('password'),
                'role' => 'Member',
                'status' => 'Aktif',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

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
            ['nama' => 'Pendidikan', 'slug' => 'pendidikan', 'cat' => null],
            ['nama' => 'Kuliner', 'slug' => 'kuliner', 'cat' => 'Gaya Hidup'],
            ['nama' => 'PKS', 'slug' => 'pks', 'cat' => 'Politik'],
            ['nama' => 'Bumdesa', 'slug' => 'bumdesa', 'cat' => 'Sosial'],
            ['nama' => 'Liga Indonesia', 'slug' => 'liga-indonesia', 'cat' => 'Bola'],
            ['nama' => 'Timnas', 'slug' => 'timnas', 'cat' => 'Bola'],
            ['nama' => 'Transfer Pemain', 'slug' => 'transfer-pemain', 'cat' => 'Bola'],
            ['nama' => 'Liga Inggris', 'slug' => 'liga-inggris', 'cat' => 'Bola'],
            ['nama' => 'Liga Italia', 'slug' => 'liga-italia', 'cat' => 'Bola'],
            ['nama' => 'Olahraga', 'slug' => 'olahraga', 'cat' => 'Bola'],
            ['nama' => 'Pilkada 2024', 'slug' => 'pilkada-2024', 'cat' => 'Politik'],
            ['nama' => 'Piala Dunia 2026', 'slug' => 'piala-dunia-2026', 'cat' => 'Bola'],
            ['nama' => 'Indramayu', 'slug' => 'indramayu', 'cat' => 'Sosial'],
            ['nama' => 'Majalengka', 'slug' => 'majalengka', 'cat' => 'Sosial'],
            ['nama' => 'Cirebon', 'slug' => 'cirebon', 'cat' => 'Sosial'],
            ['nama' => 'Lampung', 'slug' => 'lampung', 'cat' => 'Sosial'],
            ['nama' => 'NU', 'slug' => 'nu', 'cat' => 'Politik'],
            ['nama' => 'Birokrasi', 'slug' => 'birokrasi', 'cat' => 'Politik'],
            ['nama' => 'Kesehatan', 'slug' => 'kesehatan', 'cat' => 'Sosial'],
            ['nama' => 'Pelayanan Publik', 'slug' => 'pelayanan-publik', 'cat' => 'Sosial'],
            ['nama' => 'Teknologi', 'slug' => 'teknologi', 'cat' => 'Iptek'],
            ['nama' => 'Budaya', 'slug' => 'budaya', 'cat' => 'Ragam'],
            ['nama' => 'Internasional', 'slug' => 'internasional', 'cat' => 'Luar Negeri'],
            ['nama' => 'Kesehatan Jiwa', 'slug' => 'kesehatan-jiwa', 'cat' => 'Gaya Hidup'],
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

        // 4. Articles Data (Rich coverage for ALL 9 content categories: 4-5 articles each)
        $articlesData = [
            // ==================== POLITIK ====================
            [
                'judul' => 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
                'slug' => 'kritik-muktamar-diancam-sanksi-kang-eep-jangan-sampai-partai-jadi-alat-membungkam-nurani-warga-nu',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-07',
                'dibaca' => 5120,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=1000&q=80',
                'tags' => ['Politik', 'NU', 'Pendidikan'],
                'lead' => 'Dinamika wacana Muktamar NU ke-35 kian memanas setelah muncul isu ancaman sanksi bagi kader yang bersuara kritis di ruang publik.',
                'isi' => "<p>Tokoh muda Nahdlatul Ulama, Kang Eep, angkat bicara merespons berkembangnya polemik sanksi organisasi terhadap kader-kader yang menyuarakan aspirasi menjelang Muktamar.</p><p>Menurutnya, tradisi permusyawaratan di tubuh NU sejak era pendiri (Mbah Hasyim Asy'ari dan Gus Dur) selalu menjunjung tinggi keterbukaan dialog, tabayyun, dan kebebasan berpikir yang santun.</p><p>\"Jangan sampai ada anasir politik praktis atau kepentingan partai tertentu yang mencoba membungkam nurani warga nahdliyin. NU adalah jam'iyyah diniyyah ijtima'iyyah milik umat, bukan milik segelintir elite,\" tegas Kang Eep.</p><p>Ia menyerukan agar seluruh cabang dan wilayah NU di tanah air tetap fokus pada agenda penguatan kemandirian ekonomi umat, pendidikan pesantren, dan pengayoman warga di akar rumput.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Ada 17 Kadis Kosong, Lucky Hakim-Syaefudin Langsung Benahi Birokrasi di 100 Hari Pertama',
                'slug' => 'ada-17-kadis-kosong-lucky-hakim-syaefudin-langsung-benahi-birokrasi-di-100-hari-pertama',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-06',
                'dibaca' => 6240,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=1000&q=80',
                'tags' => ['Politik', 'Indramayu', 'Birokrasi'],
                'lead' => 'Mengisi kekosongan belasan posisi Kepala Dinas dan merombak tata kelola birokrasi menjadi prioritas utama pemerintahan baru Indramayu.',
                'isi' => "<p>Bupati dan Wakil Bupati Indramayu terpilih, Lucky Hakim dan Syaefudin, bergerak cepat memetakan pekerjaan rumah krusial di lingkungan birokrasi Pemkab Indramayu.</p><p>Tercatat sebanyak 17 jabatan eselon II setingkat Kepala Dinas dan Kepala Badan saat ini masih berstatus pelaksana tugas (Plt).</p><p>Tim transisi memastikan mekanisme seleksi terbuka (open bidding) berbasis meritokrasi akan segera digelar agar posisi strategis tersebut diisi oleh pejabat yang berintegritas dan kompeten di bidangnya.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Dituduh Jual Beli Jabatan, Tim Transisi Lucky-Sae Tegaskan: Itu Hoax dan Fitnah Keji',
                'slug' => 'dituduh-jual-beli-jabatan-tim-transisi-lucky-sae-tegaskan-itu-hoax-dan-fitnah-keji',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-05',
                'dibaca' => 4780,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?w=1000&q=80',
                'tags' => ['Politik', 'Indramayu', 'Pelayanan Publik'],
                'lead' => 'Beredarnya isu jual beli kursi jabatan direspons tegas oleh tim transisi sebagai fitnah murahan yang bertujuan memperkeruh stabilitas daerah.',
                'isi' => "<p>Juru bicara tim transisi Lucky Hakim-Syaefudin membantah keras isu dan rumor liar di media sosial yang menuduh adanya transaksi mahar jabatan.</p><p>\"Kami tegaskan bahwa isu tersebut 100 persen adalah hoax dan fitnah keji yang tidak berdasar. Komitmen bupati terpilih adalah mewujudkan pemerintahan yang bersih dan melayani tanpa setoran mahar satu rupiah pun,\" tegasnya.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Resmi Berganti, Deddy Irawan Didaulat Jadi Plt Camat Anjatan Percepat Pelayanan Publik',
                'slug' => 'resmi-berganti-deddy-irawan-didaulat-jadi-plt-camat-anjatan-percepat-pelayanan-publik',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-04',
                'dibaca' => 3120,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1000&q=80',
                'tags' => ['Birokrasi', 'Indramayu', 'Pelayanan Publik'],
                'lead' => 'Pemerintah Kabupaten Indramayu resmi menunjuk Deddy Irawan sebagai Pelaksana Tugas Camat Anjatan guna mempercepat efektivitas layanan publik.',
                'isi' => "<p>Rotasi kepemimpinan di tingkat kecamatan kembali bergulir di lingkungan Pemkab Indramayu. Deddy Irawan, S.Sos., M.A.P. resmi mengemban tugas sebagai Plt Camat Anjatan.</p><p>Penunjukan ini ditujukan untuk mengakselerasi program strategis daerah di wilayah barat Indramayu, khususnya terkait ketahanan pangan, pelayanan kependudukan, dan koordinasi pemerintahan desa.</p>",
                'tone' => '#f4f4ee',
            ],
            [
                'judul' => 'KPU Matangkan Persiapan Debat Publik Calon Kepala Daerah Serentak 2026',
                'slug' => 'kpu-matangkan-persiapan-debat-publik-calon-kepala-daerah-serentak-2026',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-03',
                'dibaca' => 2940,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1000&q=80',
                'tags' => ['Pilkada 2024', 'Politik'],
                'lead' => 'Komisi Pemilihan Umum menyusun tema-tema debat publik yang fokus pada penyelesaian problem riil masyarakat bawah.',
                'isi' => "<p>KPU memastikan materi debat antar pasangan calon akan mengupas tuntas isu strategis mulai dari reformasi birokrasi, peningkatan mutu pendidikan, hingga pengentasan kemiskinan di desa-desa.</p>",
                'tone' => '#eaf3ec',
            ],

            // ==================== SOSIAL ====================
            [
                'judul' => 'Baru Sehari Menjabat, Plt Camat Anjatan Tinjau UPTD Puskesmas Bugis',
                'slug' => 'baru-sehari-menjabat-plt-camat-anjatan-tinjau-uptd-puskesmas-bugis',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-07',
                'dibaca' => 2840,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1000&q=80',
                'tags' => ['Indramayu', 'Kesehatan', 'Pelayanan Publik'],
                'lead' => 'Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas Camat Anjatan yang baru untuk memastikan layanan medis berjalan maksimal.',
                'isi' => "<p>Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas (Plt) Camat Anjatan yang baru, Deddy Irawan, S.Sos., M.A.P. Tanpa membuang waktu, sehari pasca resmi mengemban amanah baru, ia turun langsung ke lapangan untuk memastikan seluruh instansi pelayanan publik berjalan maksimal dan prima.</p><p>Fokus utama peninjauan perdana ini tertuju pada fasilitas pelayanan kesehatan masyarakat di UPTD Puskesmas Bugis dan UPTD Puskesmas Anjatan.</p>",
                'tone' => '#e9f0ea',
            ],
            [
                'judul' => 'Kawal Singa Depok, Polsek Gabuswetan Pastikan Hajatan Warga Kondusif dan Meriah',
                'slug' => 'kawal-singa-depok-polsek-gabuswetan-pastikan-hajatan-warga-kondusif-dan-meriah',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-06',
                'dibaca' => 1620,
                'editor' => 'Ato Susanto',
                'penulis' => 'Ato Susanto',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1000&q=80',
                'tags' => ['Indramayu', 'Pelayanan Publik'],
                'lead' => 'Kesenian tradisional Singa Depok yang memeriahkan pesta hajatan warga di Desa Gabuswetan mendapatkan pengawalan ketat dari kepolisian.',
                'isi' => "<p>Aparat Polsek Gabuswetan terjun langsung mengamankan jalannya arak-arakan kesenian tradisional Singa Depok dalam rangka hajatan khitanan salah satu warga.</p><p>Kapolsek Gabuswetan menyatakan kehadiran polisi bertujuan untuk menjamin keamanan, ketertiban, serta kelancaran arus lalu lintas di sepanjang rute pawai.</p>",
                'tone' => '#f5ede6',
            ],
            [
                'judul' => 'Tradisi Nadran Nelayan Pesisir Cirebon-Indramayu Tetap Lestari Ditengah Arus Modernisasi',
                'slug' => 'tradisi-nadran-nelayan-pesisir-cirebon-indramayu-tetap-lestari-ditengah-arus-modernisasi',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-05',
                'dibaca' => 3100,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1000&q=80',
                'tags' => ['Indramayu', 'Cirebon'],
                'lead' => 'Pesta laut dan tradisi larung sesaji Nadran menjadi simbol kerukunan serta ungkapan rasa syukur nelayan atas rezeki laut.',
                'isi' => "<p>Ratusan kapal nelayan berhias aneka bendera warna-warni memadati muara laut Karangsong dalam gelaran tahunan pesta laut Nadran.</p><p>Kegiatan ini menjadi wadah silaturahmi ribuan keluarga nelayan sekaligus melestarikan kearifan lokal maritim yang telah diwariskan turun-temurun.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Komunitas Literasi Bagikan Ribuan Buku Gratis ke Pelosok Desa Jawa Barat',
                'slug' => 'komunitas-literasi-bagikan-ribuan-buku-gratis-ke-pelosok-desa-jawa-barat',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-04',
                'dibaca' => 2180,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Majalengka',
                'foto' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=1000&q=80',
                'tags' => ['Pendidikan', 'Majalengka'],
                'lead' => 'Gerakan sukarelawan literasi membuka lapak baca gratis untuk mendekatkan anak-anak pedesaan pada bacaan bermutu.',
                'isi' => "<p>Komunitas anak muda penggerak literasi mendirikan posko baca terbuka di beberapa balai desa kawasan Majalengka dan Indramayu selatan.</p><p>Program ini menyasar anak-anak usia sekolah dasar agar terbiasa gemar membaca dan mengurangi ketergantungan gawai.</p>",
                'tone' => '#edf2f0',
            ],

            // ==================== HUKUM ====================
            [
                'judul' => 'Diduga Peras Perangkat Desa Rp3 Juta, Dua Pria yang Mengaku Wartawan Diamankan Polisi',
                'slug' => 'diduga-peras-perangkat-desa-rp3-juta-dua-pria-yang-mengaku-wartawan-diamankan-polisi',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-07',
                'dibaca' => 4200,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1000&q=80',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Polres Indramayu berhasil mengamankan dua oknum pria yang mengaku sebagai jurnalis setelah diduga memeras perangkat desa.',
                'isi' => "<p>Satreskrim Polres Indramayu mengamankan dua orang terduga pelaku pemerasan terhadap salah seorang kepala urusan keuangan desa di wilayah Jatibarang.</p><p>Pelaku mengancam akan memberitakan dugaan penyelewengan dana desa jika korban tidak menyerahkan uang sebesar Rp3 juta.</p><p>Polisi menyita barang bukti berupa uang tunai, tanda pengenal media abal-abal, dan dua unit telepon genggam.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Kejari Sita Aset Tersangka Korupsi Dana Bantuan Desa Senilai Rp1,2 Miliar',
                'slug' => 'kejari-sita-aset-tersangka-korupsi-dana-bantuan-desa-senilai-rp1-2-miliar',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-05',
                'dibaca' => 3800,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1505664194779-8beaceb93744?w=1000&q=80',
                'tags' => ['Cirebon', 'Birokrasi'],
                'lead' => 'Penyidik Tindak Pidana Khusus Kejaksaan Negeri menyita sejumlah tanah dan kendaraan milik mantan kades yang tersandung kasus korupsi.',
                'isi' => "<p>Langkah penyitaan aset ini dilakukan dalam rangka pemulihan kerugian keuangan negara akibat penyalahgunaan anggaran infrastruktur desa tahun anggaran 2024-2025.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Sidang Gugatan Sengketa Tanah Wakaf Digelar Terbuka di Pengadilan Agama',
                'slug' => 'sidang-gugatan-sengketa-tanah-wakaf-digelar-terbuka-di-pengadilan-agama',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-04',
                'dibaca' => 2500,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1436450412740-6b988f486c6b?w=1000&q=80',
                'tags' => ['Indramayu'],
                'lead' => 'Majelis hakim mendengarkan keterangan saksi ahli waris dan nadzir terkait keabsahan dokumen ikrar wakaf.',
                'isi' => "<p>Pengadilan Agama menggelar sidang pemeriksaan saksi kunci terkait sengketa tanah fasilitas umum masjid yang diklaim oleh ahli waris.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Satlantas Polres Razia Knalpot Brong Demi Kenyamanan dan Ketertiban Warga',
                'slug' => 'satlantas-polres-razia-knalpot-brong-demi-kenyamanan-dan-ketertiban-warga',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-02',
                'dibaca' => 1950,
                'editor' => 'Ato Susanto',
                'penulis' => 'Ato Susanto',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=1000&q=80',
                'tags' => ['Indramayu', 'Pelayanan Publik'],
                'lead' => 'Puluhan knalpot tidak standar yang memekakkan telinga disita dalam operasi penertiban lalu lintas terpadu.',
                'isi' => "<p>Razia ini menyasar pengendara motor yang melanggar aturan kebisingan suara di jalur protokol dan pemukiman padat penduduk.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== EKONOMI ====================
            [
                'judul' => 'Pemerintah Tetapkan Prosedur Penggantian Penerima Bantuan Pangan Beras Periode Juli–September 2026',
                'slug' => 'pemerintah-tetapkan-prosedur-penggantian-penerima-bantuan-pangan-beras-periode-juli-september-2026',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-07',
                'dibaca' => 3890,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1000&q=80',
                'tags' => ['Ekonomi', 'Pelayanan Publik', 'Indramayu'],
                'lead' => 'Badan Pangan Nasional merilis juknis baru penyaluran cadangan beras pemerintah untuk memastikan ketepatan sasaran keluarga penerima manfaat.',
                'isi' => "<p>Badan Pangan Nasional (Bapanas) bersama Perum Bulog menetapkan mekanisme pemutakhiran data bagi penerima bantuan beras seberat 10 kg per bulan.</p><p>Pemerintah desa diberikan kewenangan melakukan musyawarah desa khusus (Musdessus) guna mengganti KPM yang telah meninggal dunia, pindah domisili, atau dinilai telah mampu secara ekonomi.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Harga Cabai dan Bawang Merah di Pasar Tradisional Berangsur Stabil Usai Pasokan Melimpah',
                'slug' => 'harga-cabai-dan-bawang-merah-di-pasar-tradisional-berangsur-stabil-usai-pasokan-melimpah',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-06',
                'dibaca' => 2400,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1610348725531-843dff563e2c?w=1000&q=80',
                'tags' => ['Cirebon', 'Ekonomi'],
                'lead' => 'Keluarnya panen raya dari sentra produksi Brebes dan Majalengka menekan lonjakan harga bumbu dapur di pasar induk.',
                'isi' => "<p>Pantauan dinas perdagangan menunjukkan harga cabai merah keriting turun dari Rp60.000 menjadi Rp35.000 per kilogram, memberikan kelegaan bagi para pedagang dan ibu rumah tangga.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'UMKM Olahan Mangga Gedong Gincu Indramayu Tembus Pasar Ekspor Asia Timur',
                'slug' => 'umkm-olahan-mangga-gedong-gincu-indramayu-tembus-pasar-ekspor-asia-timur',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-04',
                'dibaca' => 3200,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=1000&q=80',
                'tags' => ['Indramayu', 'Ekonomi'],
                'lead' => 'Produk olahan sari buah dan keripik mangga kemasan higienis berhasil mengantongi sertifikat ekspor ke Jepang dan Korea Selatan.',
                'isi' => "<p>Koperasi produsen mangga binaan Pemkab Indramayu sukses mengirimkan kontainer perdana produk olahan buah lokal bernilai tambah tinggi.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Petani Tambak Udang Vaname Nikmati Panen Melimpah Berkat Pemanfaatan Kincir Listrik',
                'slug' => 'petani-tambak-udang-vaname-nikmati-panen-melimpah-berkat-pemanfaatan-kincir-listrik',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-10-02',
                'dibaca' => 2100,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1000&q=80',
                'tags' => ['Indramayu', 'Ekonomi'],
                'lead' => 'Elektrifikasi tambak pesisir mampu menghemat biaya operasional solar hingga 40 persen dan mendongkrak tingkat kelangsungan hidup benih udang.',
                'isi' => "<p>Petani tambak di wilayah Kandanghaur menyambut antusias program pasokan listrik andal PLN yang mempercepat sirkulasi oksigen tambak modern.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== RAGAM ====================
            [
                'judul' => 'Menelisik Jejak Sejarah Batik Paoman, Mahakarya Pesisir Jawa yang Sarat Makna Filosofis',
                'slug' => 'menelisik-jejak-sejarah-batik-paoman-mahakarya-pesisir-jawa-yang-sarat-makna-filosofis',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-07',
                'dibaca' => 3450,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=1000&q=80',
                'tags' => ['Budaya', 'Indramayu'],
                'lead' => 'Motif iwak etong, kapal kandas, hingga lumbu kencana menyimpan kisah ketangguhan masyarakat maritim tanah Jawa.',
                'isi' => "<p>Batik Paoman memiliki kekhasan corak flora-fauna pesisir yang tegas dan warna-warna cerah berani, berbeda dengan pakem batik keraton pedalaman.</p><p>Para perajin sepuh di sanggar Paoman terus membimbing generasi muda agar seni membatik tulis tradisional tidak tergerus mesin cetak modern.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Mengenal Kuliner Khas Rumbah Kopek, Sensasi Pedas Asam Penggugah Selera Warga Pantura',
                'slug' => 'mengenal-kuliner-khas-rumbah-kopek-sensasi-pedas-asam-penggugah-selera-warga-pantura',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-06',
                'dibaca' => 2800,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=1000&q=80',
                'tags' => ['Kuliner', 'Indramayu'],
                'lead' => 'Kombinasi sayuran rebus segar berpadu sambal asam jawa dan petis ikan membuat hidangan rumbah selalu dirindukan pemudik.',
                'isi' => "<p>Rumbah kopek menjadi salah satu warisan kuliner rakyat yang mudah ditemui di sudut-sudut pasar tradisional sepanjang jalur pantai utara.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Festival Seni Tarling Klasik Pikat Antusiasme Ribuan Generasi Muda di Panggung Terbuka',
                'slug' => 'festival-seni-tarling-klasik-pikat-antusiasme-ribuan-generasi-muda-di-panggung-terbuka',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-04',
                'dibaca' => 2920,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1000&q=80',
                'tags' => ['Budaya', 'Cirebon'],
                'lead' => 'Petikan gitar dan tiupan suling bambu berpadu harmonis dalam pagelaran musik tradisional khas pantura.',
                'isi' => "<p>Pentas seni tarling klasik membuktikan bahwa kesenian daerah tetap mampu memikat hati anak muda di tengah gempuran musik pop internasional.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Kisah Abah Casmita, 40 Tahun Menjaga Kelestarian Hutan Mangrove Pantai Utara',
                'slug' => 'kisah-abah-casmita-40-tahun-menjaga-kelestarian-hutan-mangrove-pantai-utara',
                'kategori' => 'Ragam',
                'tanggal' => '2026-10-02',
                'dibaca' => 3100,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1000&q=80',
                'tags' => ['Indramayu', 'Budaya'],
                'lead' => 'Ketekunan menanam bibit bakau berhasil menyelamatkan garis pantai dari ancaman abrasi dahsyat air laut.',
                'isi' => "<p>Perjuangan seorang diri yang dimulai empat dekade lalu kini bertransformasi menjadi kawasan ekowisata mangrove yang asri dan memberi manfaat ekonomi bagi warga sekitar.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== LUAR NEGERI ====================
            [
                'judul' => 'PBB Serukan Gencatan Senjata Permanen dan Bantuan Kemanusiaan Mendesak di Timur Tengah',
                'slug' => 'pbb-serukan-gencatan-senjata-permanen-dan-bantuan-kemanusiaan-mendesak-di-timur-tengah',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-07',
                'dibaca' => 4500,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'New York',
                'foto' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1000&q=80',
                'tags' => ['Internasional'],
                'lead' => 'Sidang Dewan Keamanan PBB mendesak pembukaan koridor bantuan medis dan pangan darurat bagi jutaan warga sipil yang terdampak konflik.',
                'isi' => "<p>Sekretaris Jenderal PBB menegaskan penderitaan warga sipil harus segera diakhiri melalui kepatuhan penuh terhadap hukum humaniter internasional dan resolusi perdamaian.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'KTT ASEAN 2026 Tekankan Kolaborasi Transisi Energi Bersih dan Ketahanan Digital',
                'slug' => 'ktt-asean-2026-tekankan-kolaborasi-transisi-energi-bersih-dan-ketahanan-digital',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-05',
                'dibaca' => 2700,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Kuala Lumpur',
                'foto' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=1000&q=80',
                'tags' => ['Internasional', 'Ekonomi'],
                'lead' => 'Para pemimpin negara Asia Tenggara menyepakati kerangka kerja interkoneksi jaringan listrik hijau regional.',
                'isi' => "<p>Kerja sama ini ditargetkan mampu mempercepat target net-zero emission kawasan serta memperkuat stabilitas pasokan energi terbarukan antarnegara anggota.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'WNI di Tokyo Rayakan Festival Budaya Nusantara dengan Pentas Gamelan dan Reog',
                'slug' => 'wni-di-tokyo-rayakan-festival-budaya-nusantara-dengan-pentas-gamelan-dan-reog',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-03',
                'dibaca' => 3150,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Tokyo',
                'foto' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=1000&q=80',
                'tags' => ['Internasional', 'Budaya'],
                'lead' => 'Pagelaran seni tradisional Indonesia memukau ribuan warga Jepang di pusat kota Tokyo.',
                'isi' => "<p>Acara diplomasi budaya yang diinisiasi oleh diaspora Indonesia menyuguhkan kekayaan kuliner rendang, sate, dan keindahan gerak tari tradisional tanah air.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'KTT Iklim Global Sepakati Dana Bantuan Mitigasi Bencana untuk Negara Kepulauan',
                'slug' => 'ktt-iklim-global-sepakati-dana-bantuan-mitigasi-bencana-untuk-negara-kepulauan',
                'kategori' => 'Luar Negeri',
                'tanggal' => '2026-10-01',
                'dibaca' => 1980,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Jenewa',
                'foto' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1000&q=80',
                'tags' => ['Internasional'],
                'lead' => 'Negara-negara maju menyalurkan pendanaan adaptasi iklim guna memperkuat tanggul laut dan mitigasi kenaikan permukaan air laut.',
                'isi' => "<p>Komitmen pendanaan ini difokuskan pada perlindungan wilayah pesisir rentan di kawasan Pasifik dan Asia Tenggara dari ancaman cuaca ekstrem.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== IPTEK ====================
            [
                'judul' => 'Polindra Kembangkan Sistem Smart Farming Berbasis Internet of Things untuk Petani Mangga',
                'slug' => 'polindra-kembangkan-sistem-smart-farming-berbasis-internet-of-things-untuk-petani-mangga',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-07',
                'dibaca' => 3450,
                'editor' => 'Almak',
                'penulis' => 'Opini Redaksi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1000&q=80',
                'tags' => ['Pendidikan', 'Indramayu', 'Teknologi'],
                'lead' => 'Inovasi teknologi sensor tanah dan otomasi penyiraman berbasis tenaga surya hasil riset dosen Polindra siap diterapkan di perkebunan mangga Gedong Gincu.',
                'isi' => "<p>Politeknik Negeri Indramayu (Polindra) kembali menelurkan inovasi teknologi terapan berupa sistem smart farming berbasis IoT yang dirancang khusus untuk meningkatkan produktivitas mangga varietas unggul.</p><p>Sistem ini memantau kelembaban tanah, suhu udara, dan pH tanah secara real-time melalui aplikasi smartphone petani.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'BRIN Luncurkan Satelit Mikro Generasi Terbaru untuk Pemantauan Cuaca Maritim dan Kebakaran Hutan',
                'slug' => 'brin-luncurkan-satelit-mikro-generasi-terbaru-untuk-pemantauan-cuaca-maritim-dan-kebakaran-hutan',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-05',
                'dibaca' => 2800,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1000&q=80',
                'tags' => ['Teknologi'],
                'lead' => 'Kemandirian teknologi antariksa nasional diperkuat dengan beroperasinya konstelasi satelit observasi bumi buatan anak bangsa.',
                'isi' => "<p>Data citra satelit beresolusi tinggi ini akan dimanfaatkan BMKG dan BNPB untuk memberikan peringatan dini gelombang tinggi bagi nelayan tradisional.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Aplikasi Digital Layanan Desa Smart Desaku Permudah Warga Urus Surat Administrasi',
                'slug' => 'aplikasi-digital-layanan-desa-smart-desaku-permudah-warga-urus-surat-administrasi',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-03',
                'dibaca' => 2150,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1000&q=80',
                'tags' => ['Teknologi', 'Pelayanan Publik'],
                'lead' => 'Transformasi digital desa menghadirkan kemudahan pembuatan surat domisili dan keterangan usaha langsung dari gawai pintar.',
                'isi' => "<p>Warga tidak perlu lagi antre berjam-jam di kantor desa berkat integrasi sistem tanda tangan digital dan validasi barcode instan.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Peneliti Kembangkan Panel Surya Fleksibel Murah untuk Kapal Nelayan Skala Kecil',
                'slug' => 'peneliti-kembangkan-panel-surya-fleksibel-murah-untuk-kapal-nelayan-skala-kecil',
                'kategori' => 'Iptek',
                'tanggal' => '2026-10-01',
                'dibaca' => 1920,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=1000&q=80',
                'tags' => ['Teknologi', 'Indramayu'],
                'lead' => 'Pemanfaatan sel surya generasi baru mampu menyuplai kebutuhan lampu navigasi dan GPS nelayan saat melaut malam hari.',
                'isi' => "<p>Teknologi energi terbarukan ini menekan ketergantungan aki konvensional dan mengurangi risiko kapal mati mesin di tengah lautan.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== GAYA HIDUP ====================
            [
                'judul' => 'Tren Minum Kopi Artisan di Kedai Lokal Meningkat Drastis di Kalangan Generasi Muda',
                'slug' => 'tren-minum-kopi-artisan-di-kedai-lokal-meningkat-drastis-di-kalangan-generasi-muda',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-07',
                'dibaca' => 3120,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'foto' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1000&q=80',
                'tags' => ['Kuliner', 'Gaya Hidup'],
                'lead' => 'Biji kopi lokal Arabika Gunung Ciremai dan Robusta Lampung kian digemari berkat teknik seduh manual dan konsep kedai estetik.',
                'isi' => "<p>Kedai kopi kini tidak hanya menjadi tempat kongko santai, melainkan juga ruang kolaborasi kreatif para pekerja lepas dan mahasiswa.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => '5 Tips Menjaga Kebugaran Tubuh dan Pola Makan Sehat di Tengah Perubahan Cuaca Tak Menentu',
                'slug' => '5-tips-menjaga-kebugaran-tubuh-dan-pola-makan-sehat-di-tengah-perubahan-cuaca-tak-menentu',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-05',
                'dibaca' => 2450,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Bandung',
                'foto' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1000&q=80',
                'tags' => ['Kesehatan', 'Gaya Hidup'],
                'lead' => 'Kecukupan cairan, konsumsi buah tinggi vitamin C, dan istirahat berkualitas menjadi benteng utama menjaga daya tahan tubuh.',
                'isi' => "<p>Dokter spesialis gizi klinik menyarankan masyarakat membatasi konsumsi makanan olahan tinggi gula dan memperbanyak asupan sayuran hijau lokal.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Menjaga Kesehatan Mental di Era Digital: Batasi Konsumsi Medsos dan Rutin Olahraga Pagi',
                'slug' => 'menjaga-kesehatan-mental-di-era-digital-batasi-konsumsi-medsos-dan-rutin-olahraga-pagi',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-03',
                'dibaca' => 2900,
                'editor' => 'Almak',
                'penulis' => 'Almak',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=1000&q=80',
                'tags' => ['Kesehatan Jiwa', 'Gaya Hidup'],
                'lead' => 'Praktik digital detox sederhana di akhir pekan terbukti efektif menurunkan tingkat kecemasan dan memperbaiki kualitas tidur.',
                'isi' => "<p>Berjalan kaki 30 menit di ruang terbuka hijau tanpa memeriksa notifikasi smartphone membantu mengembalikan fokus dan kejernihan berpikir.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Inspirasi Desain Rumah Minimalis Sejuk dengan Taman Mini Tropis Hemat Biaya',
                'slug' => 'inspirasi-desain-rumah-minimalis-sejuk-dengan-taman-mini-tropis-hemat-biaya',
                'kategori' => 'Gaya Hidup',
                'tanggal' => '2026-10-01',
                'dibaca' => 2100,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1000&q=80',
                'tags' => ['Gaya Hidup'],
                'lead' => 'Optimalisasi ventilasi silang dan tanaman pot hias mampu menghadirkan suasana hunian yang asri tanpa boros listrik AC.',
                'isi' => "<p>Pemanfaatan material alami seperti bambu dan roster tanah liat semakin diminati untuk menciptakan sirkulasi udara alami di kawasan beriklim panas.</p>",
                'tone' => '#f4f4ee',
            ],

            // ==================== BOLA ====================
            [
                'judul' => 'Para Juara 4 Wilayah Bersaing Adu Kekuatan di Bupati Cup 2026, Panggung Terbaik Bola Voli Lamsel',
                'slug' => 'para-juara-4-wilayah-bersaing-adu-kekuatan-di-bupati-cup-2026-panggung-terbaik-bola-voli-lamsel',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-07',
                'dibaca' => 3980,
                'editor' => 'Almak',
                'penulis' => 'Baebudin',
                'lokasi' => 'Lampung',
                'foto' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=1000&q=80',
                'tags' => ['Olahraga', 'Lampung'],
                'lead' => 'Turnamen bergengsi bola voli Bupati Cup 2026 memasuki babak puncak yang mempertemukan tim-tim tangguh dari empat zona wilayah.',
                'isi' => "<p>Atmosfer persaingan sengit tersaji di GOR Way Handak saat babak final kejuaraan bola voli Bupati Cup 2026 resmi dimulai.</p><p>Ribuan penonton memadati arena untuk menyaksikan laga bergengsi yang memperebutkan piala bergilir dan total hadiah puluhan juta rupiah.</p>",
                'tone' => '#f4f4ee',
            ],
            [
                'judul' => 'Timnas Indonesia Matangkan Taktik Serangan Balik Cepat Jelang Laga Kualifikasi Piala Dunia 2026',
                'slug' => 'timnas-indonesia-matangkan-taktik-serangan-balik-cepat-jelang-laga-kualifikasi-piala-dunia-2026',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-06',
                'dibaca' => 7420,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1000&q=80',
                'tags' => ['Timnas', 'Piala Dunia 2026', 'Olahraga'],
                'lead' => 'Pelatih Shin Tae-yong menekankan disiplin lini pertahanan rapat dan transisi kilat dalam sesi latihan tertutup.',
                'isi' => "<p>Skuad Garuda bertekad tampil habis-habisan guna mengamankan poin penuh demi menjaga peluang lolos ke putaran final Piala Dunia.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Persib Bandung vs Persija Jakarta: Duel Klasik Penuh Gengsi Warnai Lanjutan Liga Indonesia',
                'slug' => 'persib-bandung-vs-persija-jakarta-duel-klasik-penuh-gengsi-warnai-lanjutan-liga-indonesia',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-04',
                'dibaca' => 6100,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Bandung',
                'foto' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1000&q=80',
                'tags' => ['Liga Indonesia', 'Olahraga'],
                'lead' => 'Laga sarat tensi tinggi El Clasico Indonesia diprediksi berlangsung ketat dengan adu taktik lini tengah kedua tim.',
                'isi' => "<p>Pihak panpel mengimbau seluruh suporter menjaga ketertiban dan sportivitas tinggi demi kelancaran jalannya pertandingan akbar tersebut.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Akademi Sepak Bola Usia Dini Pantura Gembleng Talenta Muda Menuju Panggung Nasional',
                'slug' => 'akademi-sepak-bola-usia-dini-pantura-gembleng-talenta-muda-menuju-panggung-nasional',
                'kategori' => 'Bola',
                'tanggal' => '2026-10-02',
                'dibaca' => 2280,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'foto' => 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?w=1000&q=80',
                'tags' => ['Olahraga', 'Indramayu'],
                'lead' => 'Pembinaan usia dini berlisensi AFC mulai membuahkan hasil dengan terpilihnya talenta lokal masuk seleksi Elite Pro Academy.',
                'isi' => "<p>Pendidikan karakter, gizi atlet muda, dan pematangan teknik dasar menjadi kurikulum utama di akademi sepak bola pesisir.</p>",
                'tone' => '#edf2f0',
            ],
        ];

        $createdArticles = [];
        foreach ($articlesData as $ad) {
            $cat = $categoriesMap[$ad['kategori']] ?? null;
            if (!$cat) continue;

            $art = Article::updateOrCreate(['slug' => $ad['slug']], [
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

        // 5. Comments on Articles
        $sampleComments = [
            [
                'nama' => 'H. Mamat Sutarman',
                'email' => 'mamat@gmail.com',
                'komentar' => 'Sangat setuju dengan pandangan ini. Pemimpin baru harus benar-benar berpihak pada kesejahteraan rakyat dan birokrasi yang bersih.',
                'status' => 'Tampil',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@yahoo.com',
                'komentar' => 'Semoga program pelayanan kesehatan di puskesmas desa terus ditingkatkan. Pelayanan ramah dokter sangat dirasakan masyarakat.',
                'status' => 'Tampil',
            ],
            [
                'nama' => 'Ahmad Junaedi',
                'email' => 'junaedi@gmail.com',
                'komentar' => 'Bravo Cuplik.com selalu menyajikan berita yang aktual, kritis, dan berimbang!',
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
            break; // Seed comments for top article
        }

        // 6. Videos
        $videosData = [
            [
                'judul' => 'Liputan Khusus: Suasana Kemeriahan Pesta Laut Nelayan Karangsong 2026',
                'slug' => 'liputan-kemeriahan-pesta-laut-karangsong-2026',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '08:22',
                'dibaca' => 5200,
                'tanggal' => '2026-10-06',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Istri Calon Bupati Indramayu nomor urut 3, Kunjungi Ketua Srikandi Brigade 08',
                'slug' => 'istri-calon-bupati-indramayu-kunjungi-ketua-srikandi-brigade-08',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '04:15',
                'dibaca' => 3420,
                'tanggal' => '2026-10-05',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Organ NEW ARIMBI | Pentas Musik Tradisional Tarling Klasik Pantura',
                'slug' => 'organ-new-arimbi-pentas-musik-tradisional-tarling-klasik-pantura',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '12:40',
                'dibaca' => 8910,
                'tanggal' => '2026-10-04',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Dokumenter: Menjaga Hutan Mangrove Karangsong Bersama Warga Lokal',
                'slug' => 'dokumenter-menjaga-hutan-mangrove-karangsong-bersama-warga-lokal',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '15:10',
                'dibaca' => 4120,
                'tanggal' => '2026-10-03',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Inovasi Smart Farming Politeknik Negeri Indramayu untuk Petani Mangga',
                'slug' => 'inovasi-smart-farming-politeknik-negeri-indramayu-untuk-petani-mangga',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '06:30',
                'dibaca' => 2980,
                'tanggal' => '2026-10-02',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Highlights Babak Final Turnamen Bola Voli Bupati Cup 2026',
                'slug' => 'highlights-babak-final-turnamen-bola-voli-bupati-cup-2026',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '09:45',
                'dibaca' => 4560,
                'tanggal' => '2026-10-01',
                'status' => 'Tayang',
            ],
        ];

        foreach ($videosData as $vd) {
            Video::updateOrCreate(['slug' => $vd['slug']], $vd);
        }

        // 7. Polls
        $poll = Poll::updateOrCreate(
            ['pertanyaan' => 'Menurut Anda, sektor prioritas apa yang paling mendesak dibenahi di daerah Anda saat ini?'],
            ['status' => 'Aktif']
        );

        $pollOptions = [
            ['opsi' => 'Perbaikan Jalan Poros & Irigasi Pertanian Desa', 'suara' => 482, 'urutan' => 1],
            ['opsi' => 'Kesejahteraan Guru PAUD, Madrasah & Honorer', 'suara' => 294, 'urutan' => 2],
            ['opsi' => 'Peningkatan Layanan Puskesmas 24 Jam & Obat Gratis', 'suara' => 215, 'urutan' => 3],
            ['opsi' => 'Bantuan Modal & Akses Pasar Digital UMKM Desa', 'suara' => 167, 'urutan' => 4],
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

        // Past Poll (Nonaktif)
        $pastPoll = Poll::updateOrCreate(
            ['pertanyaan' => 'Apakah Anda puas dengan keterbukaan informasi publik di pemerintahan daerah Anda?'],
            ['status' => 'Nonaktif']
        );

        $pastPollOptions = [
            ['opsi' => 'Sangat Puas & Transparan', 'suara' => 320, 'urutan' => 1],
            ['opsi' => 'Cukup Puas tapi Perlu Ditingkatkan', 'suara' => 610, 'urutan' => 2],
            ['opsi' => 'Kurang Puas / Tertutup', 'suara' => 450, 'urutan' => 3],
        ];

        foreach ($pastPollOptions as $ppo) {
            PollOption::updateOrCreate([
                'poll_id' => $pastPoll->id,
                'opsi' => $ppo['opsi'],
            ], [
                'suara' => $ppo['suara'],
                'urutan' => $ppo['urutan'],
            ]);
        }

        // 8. Curhat Rakyat / Keluh Kesah Warga
        $curhatsData = [
            [
                'pengirim' => 'Anonim (Guru PAUD)',
                'lokasi' => 'Bongas, Indramayu',
                'pesan' => 'Mohon kepastian pencairan insentif daerah Rp100 ribu per bulan. Jangan dibiarkan birokrasi berlarut-larut padahal kami sudah mengabdi puluhan tahun demi anak bangsa.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Petani Padi)',
                'lokasi' => 'Anjatan, Indramayu',
                'pesan' => 'Pembangunan jalan beton usaha tani sangat membantu kami mengangkut gabah. Harapan kami pasokan pupuk subsidi juga dipermudah saat musim tanam tiba.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Warga Pesisir)',
                'lokasi' => 'Karangsong, Indramayu',
                'pesan' => 'Fasilitas puskesmas pembantu di dermaga tolong ditambah tenaga medis piket malam hari untuk mengantisipasi kondisi darurat nelayan yang baru bersandar.',
                'tanggal' => '2026-10-06',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Pengrajin Tempe)',
                'lokasi' => 'Plered, Cirebon',
                'pesan' => 'Stabilitas harga kedelai impor tolong dijaga pemerintah agar produksi UMKM rumahan tidak terus tergerus biaya bahan baku tinggi.',
                'tanggal' => '2026-10-06',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Warga Jatibarang',
                'lokasi' => 'Jatibarang, Indramayu',
                'pesan' => 'Lampu penerangan jalan umum di jalan raya Jatibarang-Kertasemaya mati di beberapa titik, mohon dinas terkait segera memperbaikinya demi keselamatan berkendara malam.',
                'tanggal' => '2026-10-05',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Pedagang Pasar)',
                'lokasi' => 'Kadipaten, Majalengka',
                'pesan' => 'Penataan saluran drainase di dalam pasar tolong dibenahi agar saat musim hujan tiba tidak terjadi genangan becek yang mengganggu pembeli.',
                'tanggal' => '2026-10-04',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Warga Sukra',
                'lokasi' => 'Sukra, Indramayu',
                'pesan' => 'Terima kasih atas respons cepat perbaikan tanggul sungai yang sempat longsor. Semoga peninggian tanggul permanen segera dilanjutkan.',
                'tanggal' => '2026-10-03',
                'status' => 'Tampil',
            ],
        ];

        foreach ($curhatsData as $cd) {
            Curhat::create($cd);
        }

        // 9. Banners with Real Editorial Images & Valid Article Links
        $bannersData = [
            [
                'judul' => 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
                'gambar' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=1600&q=80',
                'tautan' => '/artikel/kritik-muktamar-diancam-sanksi-kang-eep-jangan-sampai-partai-jadi-alat-membungkam-nurani-warga-nu',
                'urutan' => 1,
                'tampil' => 'Ya',
            ],
            [
                'judul' => 'Ada 17 Kadis Kosong, Lucky Hakim-Syaefudin Langsung Benahi Birokrasi di 100 Hari Pertama',
                'gambar' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=1600&q=80',
                'tautan' => '/artikel/ada-17-kadis-kosong-lucky-hakim-syaefudin-langsung-benahi-birokrasi-di-100-hari-pertama',
                'urutan' => 2,
                'tampil' => 'Ya',
            ],
            [
                'judul' => 'Polindra Kembangkan Sistem Smart Farming Berbasis Internet of Things untuk Petani Mangga',
                'gambar' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1600&q=80',
                'tautan' => '/artikel/polindra-kembangkan-sistem-smart-farming-berbasis-internet-of-things-untuk-petani-mangga',
                'urutan' => 3,
                'tampil' => 'Ya',
            ],
            [
                'judul' => 'Timnas Indonesia Matangkan Taktik Serangan Balik Cepat Jelang Laga Kualifikasi Piala Dunia 2026',
                'gambar' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1600&q=80',
                'tautan' => '/artikel/timnas-indonesia-matangkan-taktik-serangan-balik-cepat-jelang-laga-kualifikasi-piala-dunia-2026',
                'urutan' => 4,
                'tampil' => 'Ya',
            ],
        ];

        foreach ($bannersData as $bd) {
            Banner::updateOrCreate(['judul' => $bd['judul']], $bd);
        }

        // 10. Iklan Gambar & Iklan Baris
        IklanGambar::updateOrCreate(
            ['judul' => 'Banner Header CuplikCom'],
            [
                'posisi' => 'Header 728×90',
                'ukuran' => '728 × 90 px',
                'gambar' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&q=80',
                'link' => '#',
                'mulai' => '2026-09-01',
                'selesai' => '2026-12-31',
                'status' => 'Tayang',
            ]
        );

        IklanGambar::updateOrCreate(
            ['judul' => 'Banner Sidebar Advertorial'],
            [
                'posisi' => 'Sidebar 300×250',
                'ukuran' => '300 × 250 px',
                'gambar' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&q=80',
                'link' => '#',
                'mulai' => '2026-09-01',
                'selesai' => '2026-12-31',
                'status' => 'Tayang',
            ]
        );

        IklanGambar::updateOrCreate(
            ['judul' => 'Space Iklan Antara Kategori'],
            [
                'posisi' => 'Antara Kategori 728×90',
                'ukuran' => '728 × 90 px',
                'gambar' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&q=80',
                'link' => '#',
                'mulai' => '2026-09-01',
                'selesai' => '2026-12-31',
                'status' => 'Tayang',
            ]
        );

        $iklanBarisData = [
            [
                'pemasang' => 'H. Suwandi',
                'kategori' => 'Kendaraan',
                'isi' => 'Dijual Toyota Avanza Veloz 2022 Silver, tangan pertama KM rendah, surat lengkap STNK/BPKB. Hubungi 081234567890.',
                'tanggal' => '2026-10-06',
                'status' => 'Disetujui',
            ],
            [
                'pemasang' => 'Ibu Ratna',
                'kategori' => 'Properti',
                'isi' => 'Dikontrakkan rumah 3 KT 2 KM lokasi strategis dekat Alun-alun Indramayu, bebas banjir, air PDAM lancar. Minat hubungi 087712345678.',
                'tanggal' => '2026-10-05',
                'status' => 'Disetujui',
            ],
            [
                'pemasang' => 'CV Mandiri Karya',
                'kategori' => 'Lowongan',
                'isi' => 'Dibutuhkan segera staf administrasi dan akuntansi, min. D3/S1, domisili Cirebon/Indramayu. Kirim CV ke hrd@mandiri.co.id.',
                'tanggal' => '2026-10-07',
                'status' => 'Disetujui',
            ],
            [
                'pemasang' => 'Bengkel Las Barokah',
                'kategori' => 'Jasa',
                'isi' => 'Melayani pembuatan kanopi, pagar minimalis, teralis jendela harga bersahabat dan bergaransi. WA 085812349999.',
                'tanggal' => '2026-10-04',
                'status' => 'Disetujui',
            ],
        ];

        foreach ($iklanBarisData as $ib) {
            IklanBaris::create($ib);
        }

        // 11. Real Count Pilbup Indramayu
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

        // 12. Newsletter Subscribers
        $newsletterEmails = ['rani.putri@example.com', 'dimas.aji@example.com', 'sinta.w@example.com', 'budi.santoso@example.com'];
        foreach ($newsletterEmails as $em) {
            NewsletterSubscriber::updateOrCreate(['email' => $em], ['tanggal' => '2026-10-01']);
        }
    }
}
