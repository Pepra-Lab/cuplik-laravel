<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
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
            [
                'name' => 'Sinta Wijaya',
                'email' => 'member3@example.com',
                'password' => Hash::make('password'),
                'role' => 'Member',
                'status' => 'Diblokir',
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

        // 4. Articles
        $articlesData = [
            [
                'judul' => 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
                'slug' => 'kritik-muktamar-diancam-sanksi-kang-eep-jangan-sampai-partai-jadi-alat-membungkam-nurani-warga-nu',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-03',
                'dibaca' => 5120,
                'editor' => 'Farhan Maksudi',
                'penulis' => 'Farhan Maksudi',
                'lokasi' => 'Cirebon',
                'tags' => ['Politik', 'NU', 'Pendidikan'],
                'lead' => 'Dinamika wacana Muktamar NU ke-35 kian memanas setelah muncul isu ancaman sanksi bagi kader yang bersuara kritis di ruang publik.',
                'isi' => "<p>Tokoh muda Nahdlatul Ulama, Kang Eep, angkat bicara merespons berkembangnya polemik sanksi organisasi terhadap kader-kader yang menyuarakan aspirasi menjelang Muktamar.</p><p>Menurutnya, tradisi permusyawaratan di tubuh NU sejak era pendiri (Mbah Hasyim Asy'ari dan Gus Dur) selalu menjunjung tinggi keterbukaan dialog, tabayyun, dan kebebasan berpikir yang santun.</p><p>\"Jangan sampai ada anasir politik praktis atau kepentingan partai tertentu yang mencoba membungkam nurani warga nahdliyin. NU adalah jam'iyyah diniyyah ijtima'iyyah milik umat, bukan milik segelintir elite,\" tegas Kang Eep.</p><p>Ia menyerukan agar seluruh cabang dan wilayah NU di tanah air tetap fokus pada agenda penguatan kemandirian ekonomi umat, pendidikan pesantren, dan pengayoman warga di akar rumput.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Ada 17 Kadis Kosong, Lucky Hakim-Syaefudin Langsung Benahi Birokrasi di 100 Hari Pertama',
                'slug' => 'ada-17-kadis-kosong-lucky-hakim-syaefudin-langsung-benahi-birokrasi-di-100-hari-pertama',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-02',
                'dibaca' => 6240,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'tags' => ['Politik', 'Indramayu', 'Birokrasi'],
                'lead' => 'Mengisi kekosongan belasan posisi Kepala Dinas dan merombak tata kelola birokrasi menjadi prioritas utama pemerintahan baru Indramayu.',
                'isi' => "<p>Bupati dan Wakil Bupati Indramayu terpilih, Lucky Hakim dan Syaefudin, bergerak cepat memetakan pekerjaan rumah krusial di lingkungan birokrasi Pemkab Indramayu.</p><p>Tercatat sebanyak 17 jabatan eselon II setingkat Kepala Dinas dan Kepala Badan saat ini masih berstatus pelaksana tugas (Plt).</p><p>Tim transisi memastikan mekanisme seleksi terbuka (open bidding) berbasis meritokrasi akan segera digelar agar posisi strategis tersebut diisi oleh pejabat yang berintegritas dan kompeten di bidangnya.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Dituduh Jual Beli Jabatan, Tim Transisi Lucky-Sae Tegaskan: Itu Hoax dan Fitnah Keji',
                'slug' => 'dituduh-jual-beli-jabatan-tim-transisi-lucky-sae-tegaskan-itu-hoax-dan-fitnah-keji',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-01',
                'dibaca' => 4780,
                'editor' => 'Dalani',
                'penulis' => 'Dalani',
                'lokasi' => 'Indramayu',
                'tags' => ['Politik', 'Indramayu', 'Pelayanan Publik'],
                'lead' => 'Beredarnya isu jual beli kursi jabatan direspons tegas oleh tim transisi sebagai fitnah murahan yang bertujuan memperkeruh stabilitas daerah.',
                'isi' => "<p>Juru bicara tim transisi Lucky Hakim-Syaefudin membantah keras isu dan rumor liar di media sosial yang menuduh adanya transaksi mahar jabatan.</p><p>\"Kami tegaskan bahwa isu tersebut 100 persen adalah hoax dan fitnah keji yang tidak berdasar. Komitmen bupati terpilih adalah mewujudkan pemerintahan yang bersih dan melayani tanpa setoran mahar satu rupiah pun,\" tegasnya.</p><p>Pihaknya meminta aparat penegak hukum menindak akun-akun provokatif penyebar informasi bohong dan mengimbau ASN agar tetap fokus bekerja melayani rakyat.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Resmi Berganti, Deddy Irawan Didaulat Jadi Plt Camat Anjatan Percepat Pelayanan Publik',
                'slug' => 'resmi-berganti-deddy-irawan-didaulat-jadi-plt-camat-anjatan-percepat-pelayanan-publik',
                'kategori' => 'Politik',
                'tanggal' => '2026-10-01',
                'dibaca' => 3120,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'tags' => ['Birokrasi', 'Indramayu', 'Pelayanan Publik'],
                'lead' => 'Pemerintah Kabupaten Indramayu resmi menunjuk Deddy Irawan sebagai Pelaksana Tugas Camat Anjatan guna mempercepat efektivitas layanan publik.',
                'isi' => "<p>Rotasi kepemimpinan di tingkat kecamatan kembali bergulir di lingkungan Pemkab Indramayu. Deddy Irawan, S.Sos., M.A.P. resmi mengemban tugas sebagai Plt Camat Anjatan.</p><p>Penunjukan ini ditujukan untuk mengakselerasi program strategis daerah di wilayah barat Indramayu, khususnya terkait ketahanan pangan, pelayanan kependudukan, dan koordinasi pemerintahan desa.</p>",
                'tone' => '#f4f4ee',
            ],
            [
                'judul' => 'Baru Sehari Menjabat, Plt Camat Anjatan Tinjau UPTD Puskesmas Bugis',
                'slug' => 'baru-sehari-menjabat-plt-camat-anjatan-tinjau-uptd-puskesmas-bugis',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-03',
                'dibaca' => 2840,
                'editor' => 'Daman',
                'penulis' => 'Daman',
                'lokasi' => 'Indramayu',
                'tags' => ['Indramayu', 'Kesehatan', 'Pelayanan Publik'],
                'lead' => 'Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas Camat Anjatan yang baru untuk memastikan layanan medis berjalan maksimal.',
                'isi' => "<p>Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas (Plt) Camat Anjatan yang baru, Deddy Irawan, S.Sos., M.A.P. Tanpa membuang waktu, sehari pasca resmi mengemban amanah baru, ia turun langsung ke lapangan untuk memastikan seluruh instansi pelayanan publik berjalan maksimal dan prima.</p><p>Fokus utama peninjauan perdana ini tertuju pada fasilitas pelayanan kesehatan masyarakat di UPTD Puskesmas Bugis dan UPTD Puskesmas Anjatan.</p><p>Kunjungan mendadak ini dilakukan guna memastikan bahwa pelayanan kesehatan di wilayah Kecamatan Anjatan berjalan secara optimal, profesional, dan akuntabel.</p>",
                'tone' => '#e9f0ea',
            ],
            [
                'judul' => 'Kawal Singa Depok, Polsek Gabuswetan Pastikan Hajatan Warga Kondusif dan Meriah',
                'slug' => 'kawal-singa-depok-polsek-gabuswetan-pastikan-hajatan-warga-kondusif-dan-meriah',
                'kategori' => 'Sosial',
                'tanggal' => '2026-10-02',
                'dibaca' => 1620,
                'editor' => 'Ato Susanto',
                'penulis' => 'Ato Susanto',
                'lokasi' => 'Indramayu',
                'tags' => ['Indramayu', 'Pelayanan Publik'],
                'lead' => 'Kesenian tradisional Singa Depok yang memeriahkan pesta hajatan warga di Desa Gabuswetan mendapatkan pengawalan ketat dari kepolisian.',
                'isi' => "<p>Aparat Polsek Gabuswetan terjun langsung mengamankan jalannya arak-arakan kesenian tradisional Singa Depok dalam rangka hajatan khitanan salah satu warga.</p><p>Kapolsek Gabuswetan menyatakan kehadiran polisi bertujuan untuk menjamin keamanan, ketertiban, serta kelancaran arus lalu lintas di sepanjang rute pawai.</p>",
                'tone' => '#f5ede6',
            ],
            [
                'judul' => 'Diduga Peras Perangkat Desa Rp3 Juta, Dua Pria yang Mengaku Wartawan Diamankan Polisi',
                'slug' => 'diduga-peras-perangkat-desa-rp3-juta-dua-pria-yang-mengaku-wartawan-diamankan-polisi',
                'kategori' => 'Hukum',
                'tanggal' => '2026-10-01',
                'dibaca' => 4200,
                'editor' => 'Baebudin',
                'penulis' => 'Baebudin',
                'lokasi' => 'Indramayu',
                'tags' => ['Indramayu', 'Birokrasi'],
                'lead' => 'Polres Indramayu berhasil mengamankan dua oknum pria yang mengaku sebagai jurnalis setelah diduga memeras perangkat desa.',
                'isi' => "<p>Satreskrim Polres Indramayu mengamankan dua orang terduga pelaku pemerasan terhadap salah seorang kepala urusan keuangan desa di wilayah Jatibarang.</p><p>Pelaku mengancam akan memberitakan dugaan penyelewengan dana desa jika korban tidak menyerahkan uang sebesar Rp3 juta.</p><p>Polisi menyita barang bukti berupa uang tunai, tanda pengenal media abal-abal, dan dua unit telepon genggam.</p>",
                'tone' => '#eaf3ec',
            ],
            [
                'judul' => 'Pemerintah Tetapkan Prosedur Penggantian Penerima Bantuan Pangan Beras Periode Juli–September 2026',
                'slug' => 'pemerintah-tetapkan-prosedur-penggantian-penerima-bantuan-pangan-beras-periode-juli-september-2026',
                'kategori' => 'Ekonomi',
                'tanggal' => '2026-09-29',
                'dibaca' => 3890,
                'editor' => 'Ismail',
                'penulis' => 'Ismail',
                'lokasi' => 'Jakarta',
                'tags' => ['Ekonomi', 'Pelayanan Publik', 'Indramayu'],
                'lead' => 'Badan Pangan Nasional merilis juknis baru penyaluran cadangan beras pemerintah untuk memastikan ketepatan sasaran keluarga penerima manfaat.',
                'isi' => "<p>Badan Pangan Nasional (Bapanas) bersama Perum Bulog menetapkan mekanisme pemutakhiran data bagi penerima bantuan beras seberat 10 kg per bulan.</p><p>Pemerintah desa diberikan kewenangan melakukan musyawarah desa khusus (Musdessus) guna mengganti KPM yang telah meninggal dunia, pindah domisili, atau dinilai telah mampu secara ekonomi.</p>",
                'tone' => '#f5ecec',
            ],
            [
                'judul' => 'Polindra Kembangkan Sistem Smart Farming Berbasis Internet of Things untuk Petani Mangga',
                'slug' => 'polindra-kembangkan-sistem-smart-farming-berbasis-internet-of-things-untuk-petani-mangga',
                'kategori' => 'Iptek',
                'tanggal' => '2026-09-28',
                'dibaca' => 2450,
                'editor' => 'Almak',
                'penulis' => 'Opini Redaksi',
                'lokasi' => 'Indramayu',
                'tags' => ['Pendidikan', 'Indramayu'],
                'lead' => 'Inovasi teknologi sensor tanah dan otomasi penyiraman berbasis tenaga surya hasil riset dosen Polindra siap diterapkan di perkebunan mangga Gedong Gincu.',
                'isi' => "<p>Politeknik Negeri Indramayu (Polindra) kembali menelurkan inovasi teknologi terapan berupa sistem smart farming berbasis IoT yang dirancang khusus untuk meningkatkan produktivitas mangga varietas unggul.</p><p>Sistem ini memantau kelembaban tanah, suhu udara, dan pH tanah secara real-time melalui aplikasi smartphone petani.</p>",
                'tone' => '#edf2f0',
            ],
            [
                'judul' => 'Para Juara 4 Wilayah Bersaing Adu Kekuatan di Bupati Cup 2026, Panggung Terbaik Bola Voli Lamsel',
                'slug' => 'para-juara-4-wilayah-bersaing-adu-kekuatan-di-bupati-cup-2026-panggung-terbaik-bola-voli-lamsel',
                'kategori' => 'Bola',
                'tanggal' => '2026-09-27',
                'dibaca' => 1980,
                'editor' => 'Almak',
                'penulis' => 'Baebudin',
                'lokasi' => 'Lampung',
                'tags' => ['Olahraga', 'Lampung'],
                'lead' => 'Turnamen bergengsi bola voli Bupati Cup 2026 memasuki babak puncak yang mempertemukan tim-tim tangguh dari empat zona wilayah.',
                'isi' => "<p>Atmosfer persaingan sengit tersaji di GOR Way Handak saat babak final kejuaraan bola voli Bupati Cup 2026 resmi dimulai.</p><p>Ribuan penonton memadati arena untuk menyaksikan laga bergengsi yang memperebutkan piala bergilir dan total hadiah puluhan juta rupiah.</p>",
                'tone' => '#f4f4ee',
            ],
        ];

        foreach ($articlesData as $ad) {
            $cat = $categoriesMap[$ad['kategori']] ?? null;
            if (!$cat) continue;

            $art = Article::updateOrCreate(['slug' => $ad['slug']], [
                'judul' => $ad['judul'],
                'category_id' => $cat->id,
                'editor_nama' => $ad['editor'],
                'penulis_nama' => $ad['penulis'],
                'lokasi' => $ad['lokasi'],
                'lead' => $ad['lead'],
                'isi' => $ad['isi'],
                'tone' => $ad['tone'],
                'dibaca' => $ad['dibaca'],
                'status' => 'Terbit',
                'tanggal' => $ad['tanggal'],
            ]);

            $tagIds = [];
            foreach ($ad['tags'] as $tn) {
                if (isset($tagsMap[$tn])) {
                    $tagIds[] = $tagsMap[$tn]->id;
                }
            }
            $art->tags()->sync($tagIds);
        }

        // 5. Videos
        $videosData = [
            [
                'judul' => 'Istri Calon Bupati Indramayu nomor urut 3, Kunjungi Ketua Srikandi Brigade 08',
                'slug' => 'istri-calon-bupati-indramayu-kunjungi-ketua-srikandi-brigade-08',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '04:15',
                'dibaca' => 3420,
                'tanggal' => '2026-10-02',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Organ NEW ARIMBI | Wedding Of Hilmi & Indah | Tugu-Sliyeg',
                'slug' => 'organ-new-arimbi-wedding-hilmi-indah-tugu-sliyeg',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '12:40',
                'dibaca' => 8910,
                'tanggal' => '2026-10-01',
                'status' => 'Tayang',
            ],
            [
                'judul' => 'Liputan Khusus: Suasana Kemeriahan Pesta Laut Nelayan Karangsong 2026',
                'slug' => 'liputan-kemeriahan-pesta-laut-karangsong-2026',
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'durasi' => '08:22',
                'dibaca' => 5200,
                'tanggal' => '2026-09-28',
                'status' => 'Tayang',
            ],
        ];

        foreach ($videosData as $vd) {
            Video::updateOrCreate(['slug' => $vd['slug']], $vd);
        }

        // 6. Polls
        $poll = Poll::updateOrCreate(
            ['pertanyaan' => 'Menurut Anda, sektor prioritas apa yang paling mendesak dibenahi di daerah Anda saat ini?'],
            ['status' => 'Aktif']
        );

        $pollOptions = [
            ['opsi' => 'Perbaikan Jalan Poros & Irigasi Pertanian Desa', 'suara' => 342, 'urutan' => 1],
            ['opsi' => 'Kesejahteraan Guru PAUD & Honorer', 'suara' => 189, 'urutan' => 2],
            ['opsi' => 'Peningkatan Layanan Puskesmas & Kesehatan', 'suara' => 145, 'urutan' => 3],
            ['opsi' => 'Bantuan Modal & Akses Pasar Digital UMKM', 'suara' => 98, 'urutan' => 4],
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

        // 7. Curhat Rakyat / Keluh Kesah
        $curhatsData = [
            [
                'pengirim' => 'Anonim (Guru PAUD)',
                'lokasi' => 'Bongas, Indramayu',
                'pesan' => 'Mohon kepastian pencairan insentif daerah Rp100 ribu per bulan. Jangan dibiarkan birokrasi berlarut-larut padahal kami sudah mengajar puluhan tahun.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Petani Padi)',
                'lokasi' => 'Anjatan, Indramayu',
                'pesan' => 'Pembangunan jalan beton sawah sangat membantu kami. Harapan kami pasokan pupuk subsidi juga dipermudah saat masa tanam.',
                'tanggal' => '2026-10-07',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Warga Pesisir)',
                'lokasi' => 'Karangsong, Indramayu',
                'pesan' => 'Fasilitas puskesmas pembantu di dermaga tolong ditambah tenaga medis piket malam hari untuk mengantisipasi kondisi darurat nelayan.',
                'tanggal' => '2026-10-06',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Anonim (Pengrajin Tempe)',
                'lokasi' => 'Cirebon',
                'pesan' => 'Stabilitas harga kedelai impor tolong dijaga agar produksi UMKM rumahan tidak gulung tikar.',
                'tanggal' => '2026-10-05',
                'status' => 'Tampil',
            ],
            [
                'pengirim' => 'Warga Jatibarang',
                'lokasi' => 'Jatibarang, Indramayu',
                'pesan' => 'Lampu penerangan jalan umum di jalan raya Jatibarang-Kertasemaya mati di beberapa titik, mohon perbaikan.',
                'tanggal' => '2026-10-07',
                'status' => 'Baru',
            ],
        ];

        foreach ($curhatsData as $cd) {
            Curhat::create($cd);
        }

        // 8. Banners
        $bannersData = [
            [
                'judul' => 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
                'tautan' => '/artikel/kritik-muktamar-diancam-sanksi-kang-eep-jangan-sampai-partai-jadi-alat-membungkam-nurani-warga-nu',
                'urutan' => 1,
                'tampil' => 'Ya',
            ],
            [
                'judul' => 'Ada 17 Kadis Kosong, Lucky Hakim-Syaefudin Langsung Benahi Birokrasi di 100 Hari Pertama',
                'tautan' => '/artikel/ada-17-kadis-kosong-lucky-hakim-syaefudin-langsung-benahi-birokrasi-di-100-hari-pertama',
                'urutan' => 2,
                'tampil' => 'Ya',
            ],
            [
                'judul' => 'Polindra Kembangkan Sistem Smart Farming Berbasis Internet of Things untuk Petani Mangga',
                'tautan' => '/artikel/polindra-kembangkan-sistem-smart-farming-berbasis-internet-of-things-untuk-petani-mangga',
                'urutan' => 3,
                'tampil' => 'Ya',
            ],
        ];

        foreach ($bannersData as $bd) {
            Banner::updateOrCreate(['judul' => $bd['judul']], $bd);
        }

        // 9. Iklan Gambar & Iklan Baris
        IklanGambar::updateOrCreate(
            ['judul' => 'Banner Header CuplikCom'],
            [
                'posisi' => 'Header 728×90',
                'ukuran' => '728 × 90 px',
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
                'isi' => 'Dijual Toyota Avanza Veloz 2022 Silver, tangan pertama KM rendah, surat lengkap. Hubungi 081234567890.',
                'tanggal' => '2026-10-06',
                'status' => 'Disetujui',
            ],
            [
                'pemasang' => 'Ibu Ratna',
                'kategori' => 'Properti',
                'isi' => 'Dikontrakkan rumah 3 KT 2 KM lokasi strategis dekat Alun-alun Indramayu. Minat hubungi 087712345678.',
                'tanggal' => '2026-10-05',
                'status' => 'Disetujui',
            ],
            [
                'pemasang' => 'CV Mandiri Karya',
                'kategori' => 'Lowongan',
                'isi' => 'Dibutuhkan segera staf administrasi dan akuntansi, min. D3/S1, domisili Cirebon/Indramayu. Kirim CV ke hrd@mandiri.co.id.',
                'tanggal' => '2026-10-07',
                'status' => 'Menunggu',
            ],
        ];

        foreach ($iklanBarisData as $ib) {
            IklanBaris::create($ib);
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

        // 11. Newsletter Subscribers
        $newsletterEmails = ['rani.putri@example.com', 'dimas.aji@example.com', 'sinta.w@example.com', 'budi.santoso@example.com'];
        foreach ($newsletterEmails as $em) {
            NewsletterSubscriber::updateOrCreate(['email' => $em], ['tanggal' => '2026-10-01']);
        }
    }
}
