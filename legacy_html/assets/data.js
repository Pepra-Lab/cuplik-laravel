// Data Asli CuplikCom (www.cuplik.com)
// Sesuai Spesifikasi Redesign: DM Sans Only, No Gradients, 10 Kategori, Card 1, Card 2, Keluh Kesah Rakyat

const T = ['#eaf3ec', '#f5ecec', '#edf2f0', '#f4f4ee', '#e9f0ea', '#f5ede6'];

const KANALS = [
    'Politik', 'Sosial', 'Hukum', 'Ekonomi', 'Ragam',
    'Luar Negeri', 'Iptek', 'Gaya Hidup', 'Bola', 'Video'
];

const TAGS = [
    'Pendidikan', 'Kuliner', 'PKS', 'Bumdesa', 'Liga Indonesia',
    'Timnas', 'Transfer Pemain', 'Liga Inggris', 'Liga Italia', 'Olahraga',
    'Pilkada 2024', 'Piala Dunia 2026', 'Indramayu', 'Majalengka', 'Cirebon', 'Lampung'
];

const TRENDING_TAGS = [
    { tag: 'GuruPAUDIndramayu', count: '12.4K Diskusi' },
    { tag: 'PilkadaIndramayu2024', count: '9.8K Diskusi' },
    { tag: 'MuktamarNUke35', count: '8.2K Diskusi' },
    { tag: 'BansosBapanas2026', count: '6.5K Diskusi' },
    { tag: 'TimnasGaruda', count: '15.1K Diskusi' },
    { tag: 'SedekahBumiMuntur', count: '4.3K Diskusi' }
];

const KELUH_KESAH = [
    {
        nama: 'Anonim (Guru PAUD)',
        lokasi: 'Bongas, Indramayu',
        pesan: 'Mohon kepastian pencairan insentif daerah Rp100 ribu per bulan. Jangan dibiarkan birokrasi berlarut-larut padahal kami sudah mengajar puluhan tahun.',
        waktu: '2 jam yang lalu'
    },
    {
        nama: 'Anonim (Petani Padi)',
        lokasi: 'Anjatan, Indramayu',
        pesan: 'Pembangunan jalan beton sawah sangat membantu kami. Harapan kami pasokan pupuk subsidi juga dipermudah saat masa tanam.',
        waktu: '4 jam yang lalu'
    },
    {
        nama: 'Anonim (Warga Pesisir)',
        lokasi: 'Karangsong, Indramayu',
        pesan: 'Fasilitas puskesmas pembantu di dermaga tolong ditambah tenaga medis piket malam hari untuk mengantisipasi kondisi darurat nelayan.',
        waktu: '1 hari yang lalu'
    },
    {
        nama: 'Anonim (Pengrajin Tempe)',
        lokasi: 'Cirebon',
        pesan: 'Stabilitas harga kedelai impor tolong dijaga agar produksi UMKM rumahan tidak gulung tikar.',
        waktu: '2 hari yang lalu'
    }
];

const A = [
    // --- POLITIK ---
    {
        id: 1,
        t: 'Kritik Muktamar Diancam Sanksi, Kang Eep: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU',
        c: 'Politik',
        d: '2026-10-03',
        ago: '15 menit yang lalu',
        v: 5120,
        author: 'Farhan Maksudi',
        loc: 'Cirebon',
        tags: ['Politik', 'NU', 'Muktamar', 'Demokrasi'],
        lead: 'Dinamika wacana Muktamar NU ke-35 kian memanas setelah muncul isu ancaman sanksi bagi kader yang bersuara kritis di ruang publik.',
        body: [
            'Tokoh muda Nahdlatul Ulama, Kang Eep, angkat bicara merespons berkembangnya polemik sanksi organisasi terhadap kader-kader yang menyuarakan aspirasi menjelang Muktamar.',
            'Menurutnya, tradisi permusyawaratan di tubuh NU sejak era pendiri (Mbah Hasyim Asy\'ari dan Gus Dur) selalu menjunjung tinggi keterbukaan dialog, tabayyun, dan kebebasan berpikir yang santun.',
            '"Jangan sampai ada anasir politik praktis atau kepentingan partai tertentu yang mencoba membungkam nurani warga nahdliyin. NU adalah jam\'iyyah diniyyah ijtima\'iyyah milik umat, bukan milik segelintir elite," tegas Kang Eep.',
            'Ia menyerukan agar seluruh cabang dan wilayah NU di tanah air tetap fokus pada agenda penguatan kemandirian ekonomi umat, pendidikan pesantren, dan pengayoman warga di akar rumput.'
        ]
    },
    {
        id: 2,
        t: 'Ada 17 Kadis Kosong, Lucky Hakim-Syaefudin Langsung Benahi Birokrasi di 100 Hari Pertama',
        c: 'Politik',
        d: '2026-10-02',
        ago: '1 jam yang lalu',
        v: 6240,
        author: 'Dalani',
        loc: 'Indramayu',
        tags: ['Politik', 'Pilkada', 'Birokrasi', 'Indramayu'],
        lead: 'Mengisi kekosongan belasan posisi Kepala Dinas dan merombak tata kelola birokrasi menjadi prioritas utama pemerintahan baru Indramayu.',
        body: [
            'Bupati dan Wakil Bupati Indramayu terpilih, Lucky Hakim dan Syaefudin, bergerak cepat memetakan pekerjaan rumah krusial di lingkungan birokrasi Pemkab Indramayu.',
            'Tercatat sebanyak 17 jabatan eselon II setingkat Kepala Dinas dan Kepala Badan saat ini masih berstatus pelaksana tugas (Plt).',
            'Tim transisi memastikan mekanisme seleksi terbuka (open bidding) berbasis meritokrasi akan segera digelar agar posisi strategis tersebut diisi oleh pejabat yang berintegritas dan kompeten di bidangnya.'
        ]
    },
    {
        id: 3,
        t: 'Dituduh Jual Beli Jabatan, Tim Transisi Lucky-Sae Tegaskan: Itu Hoax dan Fitnah Keji',
        c: 'Politik',
        d: '2026-10-01',
        ago: '4 jam yang lalu',
        v: 4780,
        author: 'Dalani',
        loc: 'Indramayu',
        tags: ['Politik', 'Klarifikasi', 'Hoax', 'Indramayu'],
        lead: 'Beredarnya isu jual beli kursi jabatan direspons tegas oleh tim transisi sebagai fitnah murahan yang bertujuan memperkeruh stabilitas daerah.',
        body: [
            'Juru bicara tim transisi Lucky Hakim-Syaefudin membantah keras isu dan rumor liar di media sosial yang menuduh adanya transaksi mahar jabatan.',
            '"Kami tegaskan bahwa isu tersebut 100 persen adalah hoax dan fitnah keji yang tidak berdasar. Komitmen bupati terpilih adalah mewujudkan pemerintahan yang bersih dan melayani tanpa setoran mahar satu rupiah pun," tegasnya.',
            'Pihaknya meminta aparat penegak hukum menindak akun-akun provokatif penyebar informasi bohong dan mengimbau ASN agar tetap fokus bekerja melayani rakyat.'
        ]
    },
    {
        id: 4,
        t: 'Resmi Berganti, Deddy Irawan Didaulat Jadi Plt Camat Anjatan Percepat Pelayanan Publik',
        c: 'Politik',
        d: '2026-10-01',
        ago: '6 jam yang lalu',
        v: 3120,
        author: 'Daman',
        loc: 'Indramayu',
        tags: ['Birokrasi', 'Anjatan', 'Pemkab Indramayu', 'Pemerintahan'],
        lead: 'Pemerintah Kabupaten Indramayu resmi menunjuk Deddy Irawan sebagai Pelaksana Tugas Camat Anjatan guna mempercepat efektivitas layanan publik.',
        body: [
            'Rotasi kepemimpinan di tingkat kecamatan kembali bergulir di lingkungan Pemkab Indramayu. Deddy Irawan, S.Sos., M.A.P. resmi mengemban tugas sebagai Plt Camat Anjatan.',
            'Penunjukan ini ditujukan untuk mengakselerasi program strategis daerah di wilayah barat Indramayu, khususnya terkait ketahanan pangan, pelayanan kependudukan, dan koordinasi pemerintahan desa.'
        ]
    },

    // --- SOSIAL ---
    {
        id: 5,
        t: 'Baru Sehari Menjabat, Plt Camat Anjatan Tinjau UPTD Puskesmas Bugis',
        c: 'Sosial',
        d: '2026-10-03',
        ago: '25 menit yang lalu',
        v: 2840,
        author: 'Daman',
        loc: 'Indramayu',
        tags: ['Desa', 'Indramayu', 'Kesehatan', 'Pelayanan Publik'],
        lead: 'Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas Camat Anjatan yang baru untuk memastikan layanan medis berjalan maksimal.',
        body: [
            'Langkah cepat dan responsif langsung ditunjukkan oleh Pelaksana Tugas (Plt) Camat Anjatan yang baru, Deddy Irawan, S.Sos., M.A.P. Tanpa membuang waktu, sehari pasca resmi mengemban amanah baru, ia turun langsung ke lapangan untuk memastikan seluruh instansi pelayanan publik berjalan maksimal dan prima.',
            'Fokus utama peninjauan perdana ini tertuju pada fasilitas pelayanan kesehatan masyarakat di UPTD Puskesmas Bugis dan UPTD Puskesmas Anjatan.',
            'Kunjungan mendadak ini dilakukan guna memastikan bahwa pelayanan kesehatan di wilayah Kecamatan Anjatan berjalan secara optimal, profesional, dan akuntabel.'
        ]
    },
    {
        id: 6,
        t: 'Kawal Singa Depok, Polsek Gabuswetan Pastikan Hajatan Warga Kondusif dan Meriah',
        c: 'Sosial',
        d: '2026-10-02',
        ago: '2 jam yang lalu',
        v: 1620,
        author: 'Ato Susanto',
        loc: 'Indramayu',
        tags: ['Seni Tradisi', 'Singa Depok', 'Gabuswetan', 'Kamtibmas'],
        lead: 'Antusiasme ribuan penonton dalam arak-arakan kesenian tradisional Singa Depok di Gabuswetan berjalan aman dan tertib berkat pengamanan humanis.',
        body: [
            'Kesenian tradisional arak-arakan Singa Depok selalu menjadi daya tarik hiburan utama dalam pesta hajatan warga di wilayah pesisir Jawa Barat.',
            'Guna mengantisipasi kemacetan jalan poros kecamatan dan gesekan antar-penonton, jajaran Polsek Gabuswetan diterjunkan langsung mengawal iring-iringan seni Singa Depok dari awal hingga selesai.',
            'Personel kepolisian berbaur secara humanis dengan warga sambil mengatur kelancaran arus lalu lintas.'
        ]
    },
    {
        id: 7,
        t: 'Cegah Hal Membahayakan, Tim Gabungan Bongas Evakuasi ODGJ ke RSUD Indramayu',
        c: 'Sosial',
        d: '2026-10-01',
        ago: '5 jam yang lalu',
        v: 2410,
        author: 'Daman',
        loc: 'Indramayu',
        tags: ['Sosial', 'Kesehatan Jiwa', 'Bongas', 'RSUD'],
        lead: 'Aksi cepat tanggap diperlihatkan tim gabungan kecamatan Bongas dalam mengevakuasi warga dengan gangguan jiwa demi keselamatan bersama.',
        body: [
            'Tim gabungan yang terdiri dari unsur Satpol PP, Puskesmas Bongas, aparat kepolisian, dan perangkat desa mengevakuasi seorang warga dengan disabilitas mental (ODGJ) yang sempat meresahkan di permukiman.',
            'Proses evakuasi dilakukan dengan pendekatan persuasif dan manusiawi tanpa kekerasan fisik, setelah berkoordinasi dengan pihak keluarga.',
            'Pasien kemudian dibawa menggunakan ambulans siaga menuju RSUD Indramayu untuk mendapatkan perawatan medis kejiwaan intensif secara gratis.'
        ]
    },
    {
        id: 8,
        t: 'Lakpesdam PCNU Indramayu Dorong Desa Siapkan Perdes Pencegahan Perkawinan Anak',
        c: 'Sosial',
        d: '2026-09-30',
        ago: '1 hari yang lalu',
        v: 2340,
        author: 'Farhan Maksudi',
        loc: 'Indramayu',
        tags: ['Sosial', 'PCNU', 'Perlindungan Anak', 'Regulasi'],
        lead: 'Upaya menekan angka dispensasi nikah dini terus digelorakan Lakpesdam NU melalui penguatan payung hukum Peraturan Desa.',
        body: [
            'Lembaga Kajian dan Pengembangan Sumber Daya Manusia (Lakpesdam) PCNU Kabupaten Indramayu secara intensif menggelar lokakarya penyusunan Peraturan Desa (Perdes) Perlindungan Anak.',
            'Direktur Lakpesdam menegaskan bahwa perkawinan di bawah umur memiliki dampak sistemik terhadap tingginya angka stunting, putus sekolah, dan kerentanan ekonomi keluarga baru.'
        ]
    },

    // --- HUKUM ---
    {
        id: 9,
        t: 'Polres Indramayu Terjunkan Agen Perlinsos untuk Awasi Penyaluran Bansos Beras',
        c: 'Hukum',
        d: '2026-10-02',
        ago: '17 jam yang lalu',
        v: 3410,
        author: 'Winanto',
        loc: 'Indramayu',
        tags: ['Hukum', 'Polres Indramayu', 'Bansos', 'Keamanan'],
        lead: 'Guna memastikan bantuan sosial tepat sasaran dan bebas pungli, Polres Indramayu menerjunkan agen Perlindungan Sosial di seluruh polsek.',
        body: [
            'Kepolisian Resor Indramayu mengambil langkah preventif strategis dalam pengawalan program bantuan sosial pemerintah pusat dan daerah dengan mengerahkan personel khusus Agen Perlinsos.',
            'Kapolres Indramayu menyatakan bahwa kehadiran personel kepolisian di titik-titik pembagian bansos bertujuan untuk mencegah potensi penyimpangan data penerima serta memberikan rasa aman bagi warga lansia.',
            'Petugas juga membuka posko aduan cepat bagi masyarakat yang menemukan indikasi potongan liar selama proses pencairan dana maupun bantuan pangan.'
        ]
    },
    {
        id: 10,
        t: 'Kurang Dua Hari, Tekab 308 Polsek Penengahan Bekuk Dua Terduga Pelaku Curat di Bakauheni',
        c: 'Hukum',
        d: '2026-10-02',
        ago: '18 jam yang lalu',
        v: 4120,
        author: 'Ismail',
        loc: 'Lampung',
        tags: ['Hukum', 'Kriminal', 'Tekab 308', 'Bakauheni'],
        lead: 'Kerja cepat Tim Khusus Anti Bandit (Tekab) 308 Presisi Polres Lampung Selatan berhasil mengungkap kasus pencurian dengan pemberatan di kawasan pelabuhan.',
        body: [
            'Dalam kurun waktu kurang dari 48 jam, Tekab 308 Polsek Penengahan berhasil membekuk dua tersangka sindikat pencurian dengan pemberatan (curat) yang beraksi di sekitar dermaga Bakauheni.',
            'Dari tangan tersangka, polisi mengamankan sejumlah barang bukti hasil curian serta peralatan kunci leter T. Kedua pelaku kini mendekam di tahanan dan dijerat Pasal 363 KUHP.'
        ]
    },
    {
        id: 11,
        t: 'Diduga Peras Perangkat Desa Rp3 Juta, Dua Pria Mengaku Wartawan Diamankan Polisi',
        c: 'Hukum',
        d: '2026-09-28',
        ago: '3 hari yang lalu',
        v: 5410,
        author: 'Daman',
        loc: 'Indramayu',
        tags: ['Hukum', 'Kriminal', 'Polres Indramayu', 'Perangkat Desa'],
        lead: 'Polisi mengingatkan agar aparat desa tidak ragu melapor dan menolak segala bentuk intimidasi dari oknum tak bertanggung jawab yang mencoreng profesi pers.',
        body: [
            'Aparat Satreskrim Polres Indramayu mengamankan dua orang pria berinisial S (42) dan W (38) setelah tertangkap tangan melakukan pemerasan terhadap sekretaris desa.',
            'Modus pelaku adalah mengancam akan memberitakan dugaan penyelewengan dana bantuan jika korban tidak menyerahkan uang tunai sebesar Rp3 juta.'
        ]
    },
    {
        id: 12,
        t: 'Tingkatkan Respon Cepat, Polsek Lusangi Pasang Stiker Layanan Kepolisian 110 di Desa Santing',
        c: 'Hukum',
        d: '2026-09-30',
        ago: '3 hari yang lalu',
        v: 1280,
        author: 'Winanto',
        loc: 'Indramayu',
        tags: ['Hukum', 'Layanan 110', 'Kamtibmas', 'Polsek'],
        lead: 'Pemasangan stiker layanan bebas pulsa Call Center 110 dimasifkan di rumah-rumah warga dan fasilitas umum.',
        body: [
            'Guna mempercepat deteksi dini gangguan kamtibmas, Bhabinkamtibmas Polsek Lusangi menempelkan stiker kontak layanan kepolisian langsung di rumah ketua RT dan pos ronda Desa Santing.'
        ]
    },

    // --- EKONOMI ---
    {
        id: 13,
        t: 'Sambal Petis Bunda Prabu Khas Indramayu Menembus E-Commerce Nasional',
        c: 'Ekonomi',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 3890,
        author: 'Lina Maulidiyah',
        loc: 'Indramayu',
        tags: ['Kuliner', 'UMKM', 'Indramayu', 'Ekonomi Digital'],
        lead: 'Kuliner tradisional sambal petis khas pesisir pantai utara Indramayu berhasil menembus pasar digital nasional dengan omzet jutaan rupiah per bulan.',
        body: [
            'Kekayaan kuliner khas Indramayu kembali menorehkan prestasi membanggakan. Produk olahan "Sambal Petis Bunda Prabu" yang diproduksi oleh perajin rumahan lokal sukses merambah berbagai platform lokapasar terkemuka tanah air.',
            'Dengan mempertahankan racikan petis udang alami tanpa bahan pengawet kimiawi dan dipadukan dengan cabai rawit segar lokal, produk ini digemari konsumen luar pulau.',
            'Dinas Koperasi dan UKM Kabupaten Indramayu memberikan apresiasi serta siap memberikan pendampingan sertifikasi halal dan fasilitasi ekspor.'
        ]
    },
    {
        id: 14,
        t: 'Pemerintah Tetapkan Prosedur Penggantian Penerima Bantuan Pangan Beras Periode 2026',
        c: 'Ekonomi',
        d: '2026-09-29',
        ago: '2 hari yang lalu',
        v: 3870,
        author: 'Ahmad Hanafi',
        loc: 'Jakarta',
        tags: ['Ekonomi', 'Bantuan Pangan', 'Kemensos', 'Beras'],
        lead: 'Mekanisme musyawarah desa (Musdes) menjadi syarat mutlak dalam penggantian data penerima manfaat beras cadangan pangan.',
        body: [
            'Badan Pangan Nasional (Bapanas) bersama Kementerian Sosial menerbitkan petunjuk teknis terbaru terkait verifikasi dan validasi Keluarga Penerima Manfaat (KPM) bantuan pangan cadangan beras pemerintah.',
            'Pemerintah desa diberikan kewenangan untuk mengganti KPM yang tidak lagi memenuhi syarat melalui berita acara Musdes yang transparan.'
        ]
    },
    {
        id: 15,
        t: 'PT RNN Produsen Pengemasan Minyak Goreng Raih Sertifikat SNI dan Izin Edar BPOM RI',
        c: 'Ekonomi',
        d: '2026-09-28',
        ago: '3 hari yang lalu',
        v: 2150,
        author: 'Pudin',
        loc: 'Indramayu',
        tags: ['Ekonomi', 'Industri', 'SNI', 'BPOM'],
        lead: 'Penguatan standar mutu minyak goreng kemasan lokal siap memperkuat pasokan pangan murah di kawasan Pantura.',
        body: [
            'Pabrik pengemasan minyak goreng PT RNN berhasil mengantongi sertifikat Standar Nasional Indonesia (SNI) dan izin edar resmi dari BPOM RI, menjamin keamanan konsumsi bagi masyarakat.'
        ]
    },
    {
        id: 16,
        t: 'BUMDes Bersama di Pantura Catat Laba Bersih Tertinggi dari Unit Usaha Pengeringan Gabah',
        c: 'Ekonomi',
        d: '2026-09-27',
        ago: '4 hari yang lalu',
        v: 1870,
        author: 'Lina Maulidiyah',
        loc: 'Indramayu',
        tags: ['BUMDes', 'Pertanian', 'Ekonomi Desa'],
        lead: 'Kolaborasi antar-desa dalam pengadaan mesin dryer gabah modern berhasil meningkatkan pendapatan asli desa (PADes) secara signifikan.',
        body: [
            'Unit usaha pengeringan gabah (dryer) yang dikelola BUMDes Bersama membuktikan bahwa sinergi ekonomi desa mampu memutus rantai ketergantungan petani pada tengkulak saat musim panen basah.'
        ]
    },

    // --- RAGAM ---
    {
        id: 17,
        t: 'Mewakili Kuwu, Lurah Muntur Apresiasi Kekompakan dan Ajak Warga Dukung Pembangunan Desa',
        c: 'Ragam',
        d: '2026-10-03',
        ago: '14 jam yang lalu',
        v: 2150,
        author: 'Baebudin',
        loc: 'Indramayu',
        tags: ['Desa', 'Sedekah Bumi', 'Muntur', 'Indramayu'],
        lead: 'Pemerintah Desa Muntur mengapresiasi tingginya antusiasme dan kebersamaan warga dalam melestarikan tradisi adat serta mendukung agenda pembangunan desa.',
        body: [
            'Mewakili Kuwu Desa Muntur, Lurah Muntur menyampaikan rasa terima kasih dan apresiasi setinggi-tingginya kepada segenap tokoh masyarakat, karang taruna, dan warga atas suksesnya penyelenggaraan adat desa tahunan.',
            'Kekompakan warga yang terjalin selama prosesi syukuran menjadi bukti nyata bahwa semangat gotong royong masih mengakar kuat di pedesaan Indramayu.',
            'Dalam sambutannya, pihak Pemdes mengajak seluruh elemen masyarakat untuk terus bersinergi mengawal program pembangunan infrastruktur jalan, sanitasi, dan pemberdayaan ekonomi tani.'
        ]
    },
    {
        id: 18,
        t: 'Kini Tak Perlu Bingung, Foto Kegiatan Pemkab Lampung Selatan Bisa Diunduh Gratis via QR Code',
        c: 'Ragam',
        d: '2026-10-02',
        ago: '18 jam yang lalu',
        v: 1890,
        author: 'Ismail',
        loc: 'Lampung Selatan',
        tags: ['Lampung Selatan', 'Inovasi', 'Diskominfo', 'Pelayanan'],
        lead: 'Dinas Kominfo Lampung Selatan menghadirkan kemudahan dokumentasi digital bagi masyarakat dan aparatur pemerintah melalui sistem QR Code terpusat.',
        body: [
            'Inovasi digital kembali dihadirkan oleh Pemerintah Kabupaten Lampung Selatan melalui Dinas Komunikasi dan Informatika (Diskominfo) setempat.',
            'Masyarakat, jurnalis, maupun peserta acara resmi Pemkab kini tidak perlu lagi kesulitan mencari dokumentasi foto resolusi tinggi pasca-kegiatan.',
            'Cukup dengan memindai QR Code yang disediakan di lokasi acara, seluruh galeri foto dapat diunduh secara gratis dan cepat.'
        ]
    },
    {
        id: 19,
        t: 'Wujud Syukur Pembangunan Jalan Selesai, Pemdes dan Warga Rancamulya Gelar Tasyakuran',
        c: 'Ragam',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 1980,
        author: 'Bakrodin',
        loc: 'Indramayu',
        tags: ['Infrastruktur', 'Desa', 'Rancamulya', 'Syukuran'],
        lead: 'Selesainya pengecoran jalan poros desa disambut suka cita oleh warga dan petani yang kini menikmati kelancaran mobilitas pengangkutan hasil bumi.',
        body: [
            'Rasa syukur mendalam dirasakan oleh warga Desa Rancamulya setelah proyek pembangunan jalan cor beton penghubung sentra persawahan tuntas dikerjakan.',
            'Sebagai bentuk ungkapan syukur, ratusan warga bersama perangkat desa menggelar doa bersama dan makan tumpeng bersama di sepanjang ruas jalan baru.'
        ]
    },
    {
        id: 20,
        t: 'Lestarikan Tradisi dan Bangkitkan Ekonomi, Pemdes Muntur Gelar Adat Sedekah Bumi Meriah',
        c: 'Ragam',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 2750,
        author: 'Baebudin',
        loc: 'Indramayu',
        tags: ['Sedekah Bumi', 'Budaya', 'Ekonomi Kerakyatan', 'Muntur'],
        lead: 'Perayaan adat sedekah bumi di Desa Muntur tidak hanya melestarikan warisan leluhur, tetapi juga menggerakkan perputaran ekonomi puluhan pedagang kecil.',
        body: [
            'Ratusan gunungan hasil bumi berupa padi, palawija, buah-buahan, dan aneka jajanan pasar diarak meriah melintasi jalan-jalan desa dalam gelaran Sedekah Bumi Muntur.',
            'Tradisi tahunan ini menjadi wujud rasa syukur para petani atas limpahan berkah panen sekaligus sarana memohon keselamatan menghadapi musim tanam berikutnya.'
        ]
    },

    // --- LUAR NEGERI ---
    {
        id: 21,
        t: 'SMSI Tandatangani Kerja Sama Strategis dengan Kedubes Iran Perkuat Jurnalisme Media Siber',
        c: 'Luar Negeri',
        d: '2026-09-29',
        ago: '2 hari yang lalu',
        v: 2890,
        author: 'Tim CMC',
        loc: 'Jakarta',
        tags: ['Luar Negeri', 'SMSI', 'Diplomasi', 'Media Siber'],
        lead: 'Serikat Media Siber Indonesia (SMSI) memperluas jejaring global melalui penandatanganan nota kesepahaman pertukaran informasi dengan Kedutaan Besar Iran.',
        body: [
            'Pengurus Pusat Serikat Media Siber Indonesia (SMSI) resmi menandatangani naskah kerja sama strategis dengan perwakilan Kedutaan Besar Republik Islam Iran di Jakarta.',
            'Kerja sama ini mencakup pertukaran konten jurnalistik, program magang reporter siber, serta penyelenggaraan seminar internasional terkait literasi media dan lanskap geopolitik dunia.'
        ]
    },
    {
        id: 22,
        t: 'Dampak Eskalasi Geopolitik Timur Tengah Terhadap Rantai Pasok Energi dan Pangan Global',
        c: 'Luar Negeri',
        d: '2026-09-27',
        ago: '4 hari yang lalu',
        v: 3180,
        author: 'Karina JM',
        loc: 'Internasional',
        tags: ['Luar Negeri', 'Geopolitik', 'Ekonomi Dunia', 'Energi'],
        lead: 'Ketegangan militer di jalur pelayaran strategis Selat Hormuz memicu kekhawatiran lonjakan inflasi dan biaya logistik antar-benua.',
        body: [
            'Situasi keamanan yang memanas di kawasan Timur Tengah menimbulkan efek domino terhadap stabilitas ekonomi global.',
            'Harga minyak mentah acuan Brent dan WTI tercatat mengalami fluktuasi tajam seiring risiko gangguan kapal tanker di jalur maritim internasional.'
        ]
    },
    {
        id: 23,
        t: 'KTT Iklim Global Sepakati Komitmen Pendanaan Transisi Energi Hijau untuk Negara Berkembang',
        c: 'Luar Negeri',
        d: '2026-09-26',
        ago: '5 hari yang lalu',
        v: 2100,
        author: 'Karina JM',
        loc: 'Jenewa',
        tags: ['Luar Negeri', 'Iklim', 'Transisi Energi'],
        lead: 'Delegasi negara-negara dunia menyetujui skema bantuan hibah teknologi ramah lingkungan bagi komunitas terdampak perubahan iklim.',
        body: [
            'Pertemuan puncak iklim menghasilkan konsensus penting mengenai pengalokasian dana darurat bagi negara kepulauan yang rentan terhadap kenaikan permukaan air laut.'
        ]
    },
    {
        id: 24,
        t: 'Organisasi Kesehatan Dunia (WHO) Rilis Panduan Kesiapsiagaan Menghadapi Potensi Pandemi Baru',
        c: 'Luar Negeri',
        d: '2026-09-25',
        ago: '6 hari yang lalu',
        v: 1950,
        author: 'Tim CMC',
        loc: 'Jenewa',
        tags: ['Luar Negeri', 'WHO', 'Kesehatan Dunia'],
        lead: 'Penguatan sistem surveilans genomik dan integrasi data kesehatan lintas negara ditekankan sebagai kunci deteksi dini patogen.',
        body: [
            'WHO mengingatkan seluruh kementerian kesehatan di dunia untuk terus memperkuat rantai pasok vaksin dan kapasitas laboratorium diagnostik lokal.'
        ]
    },

    // --- IPTEK ---
    {
        id: 25,
        t: 'Polindra Terapkan Teknologi IoT untuk Dukung Pengelolaan Sampah Berbasis Data Waktu-Nyata',
        c: 'Iptek',
        d: '2026-09-29',
        ago: '2 hari yang lalu',
        v: 3120,
        author: 'Hasan Ayih',
        loc: 'Indramayu',
        tags: ['Iptek', 'Polindra', 'IoT', 'Smart City'],
        lead: 'Tim peneliti Politeknik Negeri Indramayu menciptakan tempat sampah pintar berbasis sensor Internet of Things (IoT) untuk optimalisasi rute armada kebersihan.',
        body: [
            'Karya inovatif kembali dilahirkan oleh sivitas akademika Politeknik Negeri Indramayu (Polindra) melalui pengembangan sistem smart waste management berbasis IoT.',
            'Bak sampah pintar ini dilengkapi sensor ultrasonik dan modul mikrokontroler yang mengirimkan data volume sampah secara waktu-nyata ke dasbor dinas lingkungan hidup.',
            'Dengan data tersebut, rute penjemputan truk sampah dapat dioptimasi sehingga menghemat konsumsi BBM armada.'
        ]
    },
    {
        id: 26,
        t: 'Kombinasi Komben dan Grabag Warnai Panen Raya Padi Modern di Desa Kendayakan',
        c: 'Iptek',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 2190,
        author: 'Gustiawan',
        loc: 'Indramayu',
        tags: ['Pertanian', 'Alsintan', 'Inovasi Tani', 'Kendayakan'],
        lead: 'Harmonisasi teknologi mesin modern (combine harvester) dengan tenaga kerja tradisional (grabag) menjaga keseimbangan sosial-ekonomi petani.',
        body: [
            'Musim panen raya di Desa Kendayakan menampilkan pemandangan menarik: mesin pemanen modern bekerja berdampingan dengan kelompok pemanen tradisional.',
            'Hasil panen gabah musim ini tercatat mengalami peningkatan produktivitas mencapai 7,2 ton per hektare berkat perbaikan sistem irigasi dan benih unggul tahan hama.'
        ]
    },
    {
        id: 27,
        t: 'Mahasiswa Rekayasa Perangkat Lunak Luncurkan Aplikasi Deteksi Dini Hama Wereng Berbasis AI',
        c: 'Iptek',
        d: '2026-09-28',
        ago: '3 hari yang lalu',
        v: 1850,
        author: 'Hasan Ayih',
        loc: 'Cirebon',
        tags: ['Iptek', 'AI', 'Pertanian Digital', 'Aplikasi'],
        lead: 'Cukup dengan memotret daun padi yang terserang penyakit, aplikasi akan memberikan rekomendasi takaran pestisida nabati secara presisi.',
        body: [
            'Aplikasi mobile karya generasi muda ini diuji coba di lahan pertanian seluas 50 hektare dan terbukti menekan biaya pembasmian hama hingga 30 persen.'
        ]
    },
    {
        id: 28,
        t: 'Panel Surya Terapung di Waduk Rentang Mulai Pasok Listrik Ramah Lingkungan untuk Irigasi Pompanisasi',
        c: 'Iptek',
        d: '2026-09-27',
        ago: '4 hari yang lalu',
        v: 2400,
        author: 'Gustiawan',
        loc: 'Majalengka',
        tags: ['Iptek', 'Energi Surya', 'PLTS', 'Irigasi'],
        lead: 'Pemanfaatan energi baru terbarukan di sektor pengairan sawah menghemat biaya operasional mesin diesel kelompok tani.',
        body: [
            'Pembangkit Listrik Tenaga Surya (PLTS) terapung di kawasan bendung Rentang membuktikan efisiensi energi hijau untuk mendukung program ketahanan pangan nasional.'
        ]
    },

    // --- GAYA HIDUP ---
    {
        id: 29,
        t: 'Tradisi Temoan Warnai Kemeriahan Sedekah Bumi di Desa Muntur Penuh Kekeluargaan',
        c: 'Gaya Hidup',
        d: '2026-10-02',
        ago: '1 hari yang lalu',
        v: 1480,
        author: 'Baebudin',
        loc: 'Indramayu',
        tags: ['Kearifan Lokal', 'Temoan', 'Budaya Jawa', 'Muntur'],
        lead: 'Keunikan prosesi temu sesepuh (Temoan) memperkuat nilai silaturahmi antar-generasi di desa.',
        body: [
            'Salah satu ritual yang paling ditunggu dalam rangkaian Sedekah Bumi Desa Muntur adalah tradisi "Temoan", yakni prosesi pertemuan sakral antar-tetua adat, pamong desa, dan warga.',
            'Dalam tradisi ini, setiap keluarga membawa hantaran makanan khas untuk ditukar dan dinikmati bersama sebagai perlambang kesetaraan dan kerukunan.'
        ]
    },
    {
        id: 30,
        t: 'Kunjungan IWO Kota Tegal di Biliard 101: Membangun Citra Positif Olahraga Bola Sodok Prestasi',
        c: 'Gaya Hidup',
        d: '2026-09-28',
        ago: '3 hari yang lalu',
        v: 1540,
        author: 'Wurdiyanto',
        loc: 'Tegal',
        tags: ['Gaya Hidup', 'Olahraga', 'IWO Tegal', 'Biliar'],
        lead: 'Ikatan Wartawan Online (IWO) Tegal mendorong transformasi biliar menjadi cabang olahraga prestasi yang ramah generasi muda.',
        body: [
            'Jajaran pengurus Ikatan Wartawan Online (IWO) Kota Tegal melakukan kunjungan silaturahmi ke pusat latihan olahraga biliar 101 Steve.',
            'Pertemuan ini membahas sinergi publikasi dalam rangka menghapus stigma negatif dan mempromosikan biliar sebagai olahraga yang melatih konsentrasi dan sportivitas.'
        ]
    },
    {
        id: 31,
        t: 'Eksplorasi Jalur Sepeda Pesisir Pantai Glayem: Pilihan Sehat Menikmati Senja Pantura',
        c: 'Gaya Hidup',
        d: '2026-09-27',
        ago: '4 hari yang lalu',
        v: 1720,
        author: 'Ahmad Hanafi',
        loc: 'Indramayu',
        tags: ['Gaya Hidup', 'Gowes', 'Wisata Pantai', 'Kesehatan'],
        lead: 'Rute gowes tepi tambak dan pantai mangrove semakin diminati komunitas pesepeda dari berbagai kota tetangga.',
        body: [
            'Kombinasi udara segar laut dan kuliner ikan bakar khas pantai utara menjadikan gowes sore di Pantai Glayem agenda favorit akhir pekan warga.'
        ]
    },
    {
        id: 32,
        t: 'Tips Mengatur Keuangan Rumah Tangga di Tengah Tren Kenaikan Harga Kebutuhan Pokok',
        c: 'Gaya Hidup',
        d: '2026-09-26',
        ago: '5 hari yang lalu',
        v: 2190,
        author: 'Lina Maulidiyah',
        loc: 'Jakarta',
        tags: ['Gaya Hidup', 'Tips Finansial', 'Keluarga'],
        lead: 'Pakar perencana keuangan membagikan strategi alokasi pos belanja dapur dan dana darurat bulanan.',
        body: [
            'Menyusun menu makan mingguan dan memanfaatkan belanja grosir langsung ke pasar tradisional menjadi cara efektif menekan pengeluaran keluarga tanpa mengurangi nutrisi.'
        ]
    },

    // --- BOLA ---
    {
        id: 33,
        t: 'Shin Tae-yong Racik Formasi Baru Timnas Indonesia Jelang Babak Krusial Kualifikasi Piala Dunia 2026',
        c: 'Bola',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 7890,
        author: 'Haris Afandi',
        loc: 'Jakarta',
        tags: ['Timnas', 'Piala Dunia 2026', 'Shin Tae-yong', 'Garuda'],
        lead: 'Soliditas kombinasi pemain muda liga domestik dan pemain diaspora makin padu dalam sesi pemusatan latihan skuad Garuda.',
        body: [
            'Pelatih kepala Timnas Indonesia, Shin Tae-yong, mematangkan skema taktikal baru menjelang duel penentu di putaran ketiga Kualifikasi Piala Dunia 2026 Zona Asia.',
            'Fokus latihan difokuskan pada transisi bertahan ke menyerang secara kilat serta pemanfaatan situasi bola mati (set piece).',
            'Dukungan puluhan ribu suporter fanatik di stadion utama dipastikan akan menjadi suntikan energi ekstra bagi Jay Idzes dan kawan-kawan untuk merebut poin maksimal.'
        ]
    },
    {
        id: 34,
        t: 'Para Juara 4 Wilayah Bersaing Adu Kekuatan di Bupati Cup 2026, Panggung Terbaik Bola Voli Lamsel',
        c: 'Bola',
        d: '2026-09-30',
        ago: '2 hari yang lalu',
        v: 2430,
        author: 'M Ali Alnavian',
        loc: 'Lampung Selatan',
        tags: ['Bola Voli', 'Bupati Cup', 'Lampung Selatan', 'Olahraga'],
        lead: 'Turnamen akbar bola voli antar-kecamatan se-Kabupaten Lampung Selatan menyuguhkan pertarungan sengit para atlet berbakat daerah.',
        body: [
            'GOR Kalianda menjadi saksi antusiasme ribuan penonton dalam babak perempat final turnamen bola voli bergengsi Bupati Cup 2026.',
            'Sebanyak 16 tim putra dan putri terbaik yang lolos dari seleksi 4 wilayah bersaing memperebutkan piala bergilir dan total hadiah puluhan juta rupiah.'
        ]
    },
    {
        id: 35,
        t: 'Persindra Indramayu Matangkan Skuad U-19 Menuju Putaran Final Liga 3 Regional Jawa Barat',
        c: 'Bola',
        d: '2026-09-28',
        ago: '3 hari yang lalu',
        v: 3200,
        author: 'Haris Afandi',
        loc: 'Indramayu',
        tags: ['Bola', 'Persindra', 'Liga 3', 'PSSI'],
        lead: 'Laskar Singalodra mengintensifkan laga uji coba untuk menguji ketajaman lini serang dan kekompakan lini belakang.',
        body: [
            'Manajemen Persindra optimistis talenta-talenta muda binaan SSB lokal Indramayu mampu berbicara banyak dan menargetkan promosi musim ini.'
        ]
    },
    {
        id: 36,
        t: 'Hasil Pertandingan Sengit Derby Pantura: Persib vs Persija Berakhir Dramatis di Menit Akhir',
        c: 'Bola',
        d: '2026-09-27',
        ago: '4 hari yang lalu',
        v: 8450,
        author: 'Haris Afandi',
        loc: 'Bandung',
        tags: ['Bola', 'Liga 1', 'Persib', 'Persija'],
        lead: 'Gol spektakuler di masa injury time memastikan pertandingan sarat gengsi berakhir dengan skor imbang 2-2.',
        body: [
            'Kedua kesebelasan memperagakan sepak bola menyerang tempo tinggi sejak peluit babak pertama dibunyikan, disaksikan lebih dari 35.000 penonton di stadion.'
        ]
    },

    // --- VIDEO ---
    {
        id: 37,
        t: 'ALAMATE ANAK SHOLEH VOC.MUTIK NIDA | THE BEST OF LIVE MUSIC NEW CUPLIKA',
        c: 'Video',
        d: '2026-10-01',
        ago: '1 hari yang lalu',
        v: 8940,
        author: 'Tim Multimedia CMC',
        loc: 'Indramayu',
        tags: ['Video', 'Musik', 'Mutik Nida', 'Sholawat'],
        lead: 'Pertunjukan musik religi eksklusif persembahan orkes Cuplika menghadirkan lantunan syahdu Mutik Nida.',
        body: [
            'Saksikan tayangan lengkap pertunjukan musik langsung New Cuplika dengan aransemen modern yang memukau ribuan pemirsa di kanal resmi CuplikCom.'
        ]
    },
    {
        id: 38,
        t: 'Layakkah Bupati Lucky Hakim ke Jepang Disanksi? Ini Kata Anggota DPRD Indramayu',
        c: 'Video',
        d: '2026-10-02',
        ago: '2 hari yang lalu',
        v: 12400,
        author: 'Tim Investigasi CMC',
        loc: 'Indramayu',
        tags: ['Video', 'Politik', 'DPRD', 'Indramayu'],
        lead: 'Wawancara khusus tim redaksi mengupas pro-kontra kunjungan kerja kepala daerah ke luar negeri dan pandangan fraksi di parlemen.',
        body: [
            'Simak analisis mendalam bersama para politisi senior dan pengamat hukum tata negara mengenai tata kelola perizinan tugas dinas ke luar negeri.'
        ]
    },
    {
        id: 39,
        t: 'Baguna PDI Perjuangan Buka Dapur Umum Untuk Korban Banjir',
        c: 'Video',
        d: '2026-09-30',
        ago: '3 hari yang lalu',
        v: 3100,
        author: 'Tim Liputan CMC',
        loc: 'Jakarta',
        tags: ['Video', 'Bencana', 'Dapur Umum', 'Sosial'],
        lead: 'Aksi kemanusiaan mendistribusikan ribuan paket makanan hangat siap saji bagi warga terdampak luapan sungai.',
        body: [
            'Relawan tanggap bencana mendirikan posko logistik dan dapur darurat di titik evakuasi untuk memenuhi kebutuhan gizi balita dan lansia.'
        ]
    },
    {
        id: 40,
        t: 'Organ NEW ARIMBI | Live Wedding Of Hilmi & Indah di Tugu-Sliyeg',
        c: 'Video',
        d: '2026-09-29',
        ago: '4 hari yang lalu',
        v: 5600,
        author: 'Tim Multimedia CMC',
        loc: 'Indramayu',
        tags: ['Video', 'Organ Tunggal', 'Pesta Rakyat'],
        lead: 'Dokumentasi kesenian organ tarling dangdut khas Pantura dalam pesta hajatan warga yang meriah.',
        body: [
            'Alunan musik tarling klasik berpadu dangdut modern menghibur ribuan tamu undangan sepanjang hari di Tugu Sliyeg.'
        ]
    }
].map((item, idx) => ({
    ...item,
    tone: T[idx % T.length],
    readTime: Math.max(2, Math.ceil((item.body.join(' ').split(' ').length) / 180))
}));

const V = [
    {
        id: 'v1',
        t: 'ALAMATE ANAK SHOLEH VOC.MUTIK NIDA | THE BEST OF LIVE MUSIC NEW CUPLIKA',
        yt: 'dQw4w9WgXcQ',
        date: '2026-10-01',
        ago: '1 hari yang lalu',
        dur: '06:45',
        views: 8940
    },
    {
        id: 'v2',
        t: 'Layakkah Bupati Lucky Hakim ke Jepang Disanksi? Ini Kata Anggota DPRD Indramayu',
        yt: '',
        date: '2026-10-02',
        ago: '2 hari yang lalu',
        dur: '08:12',
        views: 12400
    },
    {
        id: 'v3',
        t: 'Baguna PDI Perjuangan Cabang Jakpus Buka Dapur Umum Untuk Korban Banjir',
        yt: '',
        date: '2026-09-30',
        ago: '3 hari yang lalu',
        dur: '04:20',
        views: 3100
    },
    {
        id: 'v4',
        t: 'Organ NEW ARIMBI | Wedding Of Hilmi & Indah | Tugu-Sliyeg',
        yt: '',
        date: '2026-09-29',
        ago: '4 hari yang lalu',
        dur: '11:35',
        views: 5600
    }
];

const POLL = {
    id: 'poll-2026-1',
    q: 'Menurut Anda, sektor prioritas apa yang paling mendesak dibenahi di daerah Anda saat ini?',
    o: [
        'Perbaikan Jalan Poros & Irigasi Pertanian Desa',
        'Kesejahteraan Guru PAUD & Honorer',
        'Peningkatan Layanan Puskesmas & Kesehatan',
        'Bantuan Modal & Akses Pasar Digital UMKM'
    ]
};

const INFO = {
    redaksi: {
        title: 'Susunan Redaksi CuplikCom',
        content: `
            <div class="space-y-4">
                <p><strong>PT. Cuplik Media Center (CMC)</strong><br>
                Berdiri sejak 2009 · Legalitas SK Kepmenkumham RI Nomor: <strong>AHU-0039651.AH.01.01.Tahun 2019</strong><br>
                Anggota Resmi <strong>Serikat Media Siber Indonesia (SMSI)</strong></p>

                <hr class="border-t border-gray-300 dark:border-zinc-800 my-4">

                <p><strong>Pemimpin Redaksi / Penanggung Jawab:</strong> Ali Ma'nawi</p>
                <p><strong>Dewan Redaksi:</strong> Khusni Mubarok, Farhan Maksudi, Dewo, Ade Lukman, Mundirun, Rando Gunter, Anan Felicio</p>
                <p><strong>Reporter / Kontributor:</strong> Baebudin, Daman, Farhan Maksudi, Lina Maulidiyah, Bakrodin, Winanto, Maulana Yusuf Rismawan, Gustiawan, Dalani, Hasan Ayih, Ato Susanto, Karina JM, Haris Afandi, Papoh Gupron, Fitriyah Jewellery Farsi, Ahmad Hanafi</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm my-4">
                    <div><strong>Biro Indramayu:</strong> Daman, Baebudin, Dulhalil, Adeng Widayah, Marsan, Nurdi, Ato Tolok</div>
                    <div><strong>Biro Majalengka:</strong> Sunarto Aryodinoto, Fatkhul Amin</div>
                    <div><strong>Biro Cirebon Raya:</strong> Ade Hamdani</div>
                    <div><strong>Biro Bandung Raya & Sumedang:</strong> Tb Chep Zulfikar Natanegara</div>
                    <div><strong>Biro Jabodetabek:</strong> Ade Lukman, Muhamad Riko Indrianto, Fanny Nurul Hotimah, Deny Sardika, Nabila Ebivalia</div>
                    <div><strong>Biro Tegal Raya:</strong> Wurdiyanto</div>
                    <div><strong>Biro D.I. Yogyakarta:</strong> Abdan Ghifari Atsqo</div>
                    <div><strong>Biro Lampung:</strong> Ismail, M Ali Alnavian, Zul Halim</div>
                    <div><strong>Biro Bengkulu:</strong> Neni Lestari</div>
                    <div><strong>Biro Jambi:</strong> Muhammad Ichsan</div>
                    <div><strong>Biro Kalimantan:</strong> Rando Gunter, Robi Sanjaya, Mulia Gumi, Regina Nurmitae, Irawan, Budi S Shindunata</div>
                    <div><strong>Biro NTT:</strong> Nur Muhammad Al Amin</div>
                    <div><strong>Biro Papua:</strong> Fajar Ibrahim</div>
                </div>

                <hr class="border-t border-gray-300 dark:border-zinc-800 my-4">

                <p><strong>Penasehat Hukum:</strong><br>
                Kantor Hukum Adi Iwan Mulyawan, SH. dan Rekan<br>
                (Adi Iwan Mulyawan, S.H.; Rustono, S.H.I.; Ayip Yuhadi, S.H.; Jefri Mulyana, S.H.; Ana Mulyana, S.H.)</p>

                <p><strong>Programmer & Designer:</strong> A Lubis Ghozali, M Ali Fikri</p>
                <p><strong>Iklan & Promosi:</strong> Pudin, Ahmad Hasan A</p>
                <p><strong>Administrasi & Keuangan:</strong> Fitriyani, Desi Amaliani</p>

                <div class="p-4 bg-gray-100 dark:bg-zinc-900 rounded my-4">
                    <h4 class="font-bold text-[#d60000] mb-2">Alamat Kantor Redaksi & Tata Usaha</h4>
                    <p class="text-sm">Jl. Samsu No. 42 Kelurahan Margadadi, Kabupaten Indramayu, Jawa Barat 45211<br>
                    <strong>Telp:</strong> (0234) 7126806 · <strong>CP/WhatsApp:</strong> 087727030115<br>
                    <strong>Email Redaksi:</strong> cuplikcom@gmail.com | info@cuplik.com<br>
                    <strong>Situs Web Resmi:</strong> www.cuplik.com | www.cuplik.id</p>
                </div>
            </div>
        `
    },
    pedoman: {
        title: 'Pedoman Pemberitaan Media Siber',
        content: `
            <div class="space-y-4">
                <p>Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Keberadaan media siber di Indonesia juga merupakan bagian dari kemerdekaan berpendapat, berekspresi, dan pers.</p>
                <p>Media siber memiliki karakter khusus sehingga memerlukan pedoman agar pengelolaannya dapat dilaksanakan secara profesional, memenuhi fungsi, hak, dan kewajibannya sesuai <strong>Undang-Undang Nomor 40 Tahun 1999 tentang Pers</strong> dan Kode Etik Jurnalistik. Untuk itu Dewan Pers bersama organisasi pers dan masyarakat menyusun Pedoman Pemberitaan Media Siber.</p>
                <p><em>(Pedoman ini disahkan Dewan Pers dan Komunitas Pers Nasional di Jakarta).</em></p>
            </div>
        `
    },
    disclaimer: {
        title: 'Pasal Sanggahan (Disclaimer)',
        content: `
            <div class="space-y-4">
                <p>Seluruh layanan dan sajian informasi yang diberikan oleh <strong>cuplikcom</strong> mengikuti aturan main yang berlaku serta tunduk pada ketentuan hukum pers Republik Indonesia.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>cuplikcom</strong> tidak bertanggung jawab atas tidak tersampaikannya data/informasi yang dikirimkan oleh pembaca melalui saluran komunikasi karena kendala teknis tak terduga.</li>
                    <li><strong>cuplikcom</strong> berhak untuk memuat, tidak memuat, mengedit, mengklarifikasi, dan/atau menghapus data maupun informasi yang disampaikan pembaca demi etika dan hukum.</li>
                    <li>Data dan/atau analisis yang disajikan di <strong>cuplikcom</strong> ditujukan sebagai rujukan informasi publik yang objektif dan edukatif.</li>
                </ul>
            </div>
        `
    },
    iklan: {
        title: 'Info Pemasangan Iklan & Advertorial',
        content: `
            <div class="space-y-4">
                <p>CuplikCom (PT Cuplik Media Center) melayani kemitraan strategis periklanan digital, advertorial institusi/perusahaan, publikasi rilis pers, dan banner promosi dengan jangkauan ratusan ribu pembaca loyal di seluruh Indonesia.</p>

                <h3 class="font-bold text-lg text-[#008a24]">Tarif Publikasi Artikel / Advertorial</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 dark:border-zinc-800 text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-zinc-800">
                                <th class="border border-gray-300 dark:border-zinc-800 p-3 text-left">Jenis Publikasi</th>
                                <th class="border border-gray-300 dark:border-zinc-800 p-3 text-left">Posisi / Penempatan</th>
                                <th class="border border-gray-300 dark:border-zinc-800 p-3 text-left">Tarif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3 font-semibold">Headline Utama</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Tampil di Banner Hero Utama</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Rp 2.500.000</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3 font-semibold">Headline Topik / Kanal</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Tampil di Puncak Kanal Kategori Pilihan</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Rp 1.500.000</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3 font-semibold">Publikasi Reguler</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Berita Terbaru & Google News</td>
                                <td class="border border-gray-300 dark:border-zinc-800 p-3">Rp 1.000.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-100 dark:bg-zinc-900 rounded mt-4">
                    <p class="text-sm"><strong>Kontak Hotline Pemasaran & Pengiriman Rilis:</strong><br>
                    WhatsApp: 087727030115 · Email: cuplikcom@gmail.com / redaksi@cuplik.com</p>
                </div>
            </div>
        `
    }
};
