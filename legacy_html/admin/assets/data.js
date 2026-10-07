// Data contoh. Semua data disimpan di localStorage (awalan cms_). Ganti dengan API server.
const CATS = ['Politik', 'Sosial', 'Hukum', 'Ekonomi', 'Ragam', 'Luar Negeri', 'Iptek', 'Gaya Hidup', 'Bola', 'Video'];
const dt = n => new Date(Date.now() - n * 864e5).toISOString().slice(0, 10);
const SEED = {
    berita: [
        ['Lakpesdam PCNU Indramayu Dorong Siapkan Perdes Pencegahan dan Penanganan Perkawinan Anak', 'Sosial', 'Ismail', 'Baebudin', 0, 'Terbit', 980],
        ['Kritik Muktamar Diancam Sanksi, Kang Ejat: Jangan Sampai Partai Jadi Alat Membungkam Nurani Warga NU', 'Politik', 'Almak', 'Opini', 1, 'Terbit', 860],
        ['Diduga Peras Perangkat Desa Rp3 Juta, Dua Pria yang Mengaku Wartawan Diamankan Polisi', 'Hukum', 'Baebudin', 'Baebudin', 1, 'Terbit', 1200],
        ['Pemkab Lampung Selatan Terapkan Sidak Acak, ASN Mangkir Apel Terancam Sanksi', 'Ragam', 'Baebudin', 'Ismail', 2, 'Terbit', 640],
        ['Lampung Selatan Raih Peringkat Ketiga PPD 2026 Tingkat Nasional', 'Ragam', 'Ismail', 'Baebudin', 2, 'Review', 720],
        ['Para Juara 4 Wilayah Bersaing Adu Kekuatan di Bupati Cup 2026, Panggung Terbaik Bola Voli Lamsel', 'Bola', 'Almak', 'Baebudin', 3, 'Terbit', 530],
        ['Tingkatkan Respon Cepat, Polsek Lusangi Pasang Stiker Layanan Kepolisian di Desa Santing', 'Hukum', 'Baebudin', 'Baebudin', 3, 'Draft', 380],
        ['Pemerintah Tetapkan Prosedur Penggantian Penerima Bantuan Pangan Beras Periode Juli–September 2026', 'Ekonomi', 'Ismail', 'Ismail', 4, 'Terbit', 1500],
        ['Polindra Terapkan Teknologi IoT', 'Iptek', 'Almak', 'Opini', 5, 'Terbit', 330]
    ].map((a, i) => ({ id: i + 1, judul: a[0], kategori: a[1], editor: a[2], penulis: a[3], tanggal: dt(a[4]), status: a[5], dibaca: a[6], foto: '', isi: '' })),
    video: [['Istri Calon Bupati Indramayu nomor urut 3, Kunjungi Ketua Sikandi Brigade 08', 0, 'Tayang'], ['Organ NEW ARIMBI | Wedding Of Hilmi & Indah | Tugu-Sliyeg', 2, 'Tayang'], ['[Contoh] Liputan Bupati Cup 2026', 3, 'Tayang'], ['[Contoh] Profil Desa Santing', 6, 'Draft'], ['[Contoh] Dokumentasi Karang Taruna Got Talent', 8, 'Tayang']].map((a, i) => ({ id: i + 1, judul: a[0], link: 'https://youtu.be/ID_VIDEO', tanggal: dt(a[1]), status: a[2] })),
    polling: [{ id: 1, pertanyaan: 'Contoh polling: berita apa yang paling kamu tunggu minggu ini?', opsi: 'Sosial\nPolitik\nBola\nRagam', status: 'Aktif', suara: '18,9,24,11' }, { id: 2, pertanyaan: 'Contoh polling lama: kanal favoritmu?', opsi: 'Hukum\nEkonomi\nIptek', status: 'Nonaktif', suara: '5,3,2' }],
    'iklan-gambar': [['[Contoh] Banner Header', 'Header 728×90', 10, -20, 'Tayang'], ['[Contoh] Banner Sidebar', 'Sidebar 300×250', 5, -25, 'Tayang'], ['[Contoh] Banner Dalam Artikel', 'Artikel 640×200', 40, 10, 'Berakhir']].map((a, i) => ({ id: i + 1, judul: a[0], posisi: a[1], link: '#', mulai: dt(a[2]), selesai: dt(a[3]), status: a[4] })),
    'iklan-baris': [['Pemasang A', '[Contoh] Dijual motor bekas, kondisi terawat, hubungi pemasang.', 'Kendaraan', 0, 'Menunggu'], ['Pemasang B', '[Contoh] Dikontrakkan rumah dekat pusat kota.', 'Properti', 1, 'Menunggu'], ['Pemasang C', '[Contoh] Dibutuhkan admin toko, kirim lamaran.', 'Lowongan', 2, 'Disetujui'], ['Pemasang D', '[Contoh] Jual beli perabot rumah tangga.', 'Jual Beli', 3, 'Disetujui'], ['Pemasang E', '[Contoh] Iklan tidak sesuai ketentuan.', 'Jual Beli', 4, 'Ditolak'], ['Pemasang F', '[Contoh] Sewa ruko strategis.', 'Properti', 5, 'Menunggu']].map((a, i) => ({ id: i + 1, pemasang: a[0], isi: a[1], kategori: a[2], tanggal: dt(a[3]), status: a[4] })),
    curhat: [['[Contoh] Jalan desa rusak dan belum diperbaiki sejak lama.', 0, 'Baru'], ['[Contoh] Mohon lampu jalan di pertigaan diperbaiki.', 1, 'Baru'], ['[Contoh] Layanan puskesmas pagi hari sangat ramai.', 2, 'Tampil'], ['[Contoh] Terima kasih untuk program bantuan pangan.', 3, 'Tampil'], ['[Contoh] Pesan tidak pantas ditampilkan.', 4, 'Disembunyikan'], ['[Contoh] Saluran air tersumbat saat hujan.', 5, 'Baru']].map((a, i) => ({ id: i + 1, pengirim: 'Anonim', pesan: a[0], tanggal: dt(a[1]), status: a[2] })),
    covid: [0, 1, 2, 3, 4].map(i => ({ id: i + 1, tanggal: dt(i), wilayah: 'Indramayu', positif: 2 + i, sembuh: 3 + i, meninggal: i % 2 })),
    'berita-kategori': CATS.map((n, i) => ({ id: i + 1, nama: n, urutan: i + 1, tampil: 'Ya' })),
    'pengguna': [['Alghoz', 'Admin'], ['Ismail', 'Editor'], ['Almak', 'Editor'], ['Baebudin', 'Editor'], ['Opini', 'Penulis']].map((a, i) => ({ id: i + 1, nama: a[0], email: a[0].toLowerCase() + '@example.com', peran: a[1], status: 'Aktif' }))
};

// ---- Setting, Real Count (contoh) ----
const lcg = s => () => (s = (s * 1664525 + 1013904223) % 4294967296) / 4294967296;
Object.assign(SEED, {
    'set-banner': SEED.berita.slice(0, 3).map((b, i) => ({ id: i + 1, judul: b.judul, gambar: '', tautan: 'artikel.html?id=' + b.id, urutan: i + 1, tampil: 'Ya' })),
    'newsletter-sub': ['rani.putri', 'dimas.aji', 'sinta.w', 'budi.santoso', 'laras.ayu'].map((n, i) => ({ id: i + 1, email: n + '@example.com', tanggal: dt(i * 3 + 1) })),
    'set-tag': ['Pendidikan', 'Kuliner', 'Bumdesa', 'Timnas', 'Liga Inggris', 'Olahraga', 'Pilkada', 'Piala Dunia 2026'].map((n, i) => ({ id: i + 1, nama: n, slug: n.toLowerCase().replace(/\s+/g, '-'), induk: ({ Bumdesa: 'Sosial', Timnas: 'Bola', Kuliner: 'Gaya Hidup' })[n] || '-', sub_tampil: 'Ya' })),
    'set-posisi': [['Header 728×90', '728 × 90 px', 'Di bawah ticker, semua halaman'], ['Sidebar 300×250', '300 × 250 px', 'Kolom kanan beranda'], ['Artikel 640×200', '640 × 200 px', 'Di dalam isi berita']].map((a, i) => ({ id: i + 1, nama: a[0], ukuran: a[1], keterangan: a[2] })),
    'set-editor': [['Ismail', 'Editor'], ['Almak', 'Editor'], ['Baebudin', 'Editor'], ['Opini', 'Reporter']].map((a, i) => ({ id: i + 1, nama: a[0], peran: a[1], email: a[0].toLowerCase() + '@example.com', status: 'Aktif' })),
    'set-member': [['Member Contoh 1', 4], ['Member Contoh 2', 9], ['Member Contoh 3', 15]].map((a, i) => ({ id: i + 1, nama: a[0], email: 'member' + (i + 1) + '@example.com', tanggal: dt(a[1]), status: i == 2 ? 'Diblokir' : 'Aktif' })),
    'rc-pilbup': [{ id: 1, judul: 'Pemilihan Bupati dan Wakil Bupati Indramayu 2020', tahun: 2020, status: 'Aktif' }],
    'rc-calon': [['SHOLIHIN-RATNA', '#0b5d3b'], ['TOTO-DEIS', '#00d4c8'], ['DANIEL-TAUFIK', '#f2e600'], ['NINA-LUCKY', '#e51c23']].map((a, i) => ({ id: i + 1, pilbup: 1, no: i + 1, nama: a[0], usungan: '', warna: a[1] }))
});
(function () {
    const raw = [['Anjatan', 'Anjatan', 10, 3763, 2, 40, 58], ['Anjatan', 'Anjatan Baru', 11, 4833, 2, 73, 55], ['Anjatan', 'Anjatan Utara', 14, 5826, 0, 39, 83], ['Anjatan', 'Bugis', 13, 5695, 9, 64, 59], ['Anjatan', 'Bugis Tua', 12, 4673, 0, 67, 53], ['Anjatan', 'Cilandak', 9, 3110, 1, 23, 48], ['Anjatan', 'Cilandak Lor', 9, 3827, 0, 41, 42], ['Anjatan', 'Kedungwungu', 15, 6589, 12, 58, 64], ['Anjatan', 'Kopyah', 11, 4886, 1, 60, 51], ['Anjatan', 'Lempuyang', 11, 4382, 3, 15, 32], ['Arahan', '[Contoh] Desa A', 12, 4100, 1, 30, 40], ['Arahan', '[Contoh] Desa B', 10, 3500, 0, 22, 35], ['Arahan', '[Contoh] Desa C', 9, 3000, 2, 18, 30], ['Balongan', '[Contoh] Desa A', 13, 4400, 1, 28, 38], ['Balongan', '[Contoh] Desa B', 11, 3900, 0, 20, 33], ['Balongan', '[Contoh] Desa C', 8, 2800, 1, 14, 25]], R = lcg(7), dpt = [], su = {};
    raw.forEach((a, i) => { dpt.push({ id: i + 1, pilbup: 1, kec: a[0], desa: a[1], tps: a[2], dpt: a[3], dpph: a[4], dptb: a[5], ts: a[6] }); const v = Math.round(a[3] * .78) - a[6], w = [.26, .09, .28, .37].map(x => x * (.7 + R() * .6)), t = w.reduce((x, y) => x + y); su[i + 1] = {};[1, 2, 3, 4].forEach((c, j) => su[i + 1][c] = Math.round(v * w[j] / t)) }); SEED['rc-dpt'] = dpt; SEED['rc-suara'] = su
})();
