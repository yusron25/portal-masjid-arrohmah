<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──
        $categories = [
            'Berita Desa' => 'berita-desa',
            'Pembangunan' => 'pembangunan',
            'Kegiatan Sosial' => 'kegiatan-sosial',
            'Kesehatan' => 'kesehatan',
            'Pendidikan' => 'pendidikan',
        ];

        $catModels = [];
        foreach ($categories as $name => $slug) {
            $catModels[$name] = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        // ── Posts ──
        $posts = [
            [
                'title' => 'Profil Desa Mukti Jaya — Kecamatan Cikarang Pusat, Kabupaten Bekasi',
                'category' => 'Berita Desa',
                'content' => '<p>Desa Mukti Jaya merupakan salah satu desa yang terletak di Kecamatan Cikarang Pusat, Kabupaten Bekasi, Provinsi Jawa Barat. Desa ini dikenal sebagai kawasan yang terus berkembang seiring dengan pertumbuhan industri di kawasan Cikarang.</p>
<h2>Letak Geografis</h2>
<p>Desa Mukti Jaya berbatasan dengan beberapa desa di Kecamatan Cikarang Pusat dan memiliki akses yang strategis ke kawasan industri serta pusat pemerintahan kabupaten. Dengan luas wilayah yang mencakup beberapa RW dan RT, desa ini dihuni oleh masyarakat yang beragam latar belakang.</p>
<h2>Potensi Desa</h2>
<p>Sebagai desa yang berada di pusat kegiatan ekonomi Kabupaten Bekasi, Mukti Jaya memiliki potensi besar dalam sektor perdagangan, jasa, dan industri kecil menengah. Masyarakat desa juga aktif dalam kegiatan pertanian urban dan budidaya tanaman hias.</p>
<h2>Visi & Misi</h2>
<p>Pemerintah Desa Mukti Jaya berkomitmen untuk mewujudkan desa yang maju, mandiri, dan sejahtera melalui pelayanan publik yang transparan, akuntabel, serta partisipatif. Melalui portal digital ini, kami berupaya menyajikan informasi desa secara terbuka untuk seluruh warga.</p>',
            ],
            [
                'title' => 'Program Pembangunan Infrastruktur Jalan dan Drainase Tahun 2026',
                'category' => 'Pembangunan',
                'content' => '<p>Pemerintah Desa Mukti Jaya melalui dana desa tahun anggaran 2026 telah memprioritaskan pembangunan infrastruktur jalan lingkungan dan perbaikan sistem drainase di beberapa titik yang rawan banjir.</p>
<h2>Rincian Program</h2>
<ul>
<li><strong>Perbaikan Jalan RT 03/RW 02</strong> — Pengaspalan jalan sepanjang 500 meter yang sebelumnya rusak parah akibat genangan air.</li>
<li><strong>Pembangunan Drainase RW 04</strong> — Konstruksi saluran air baru untuk mengatasi genangan saat musim hujan, panjang 300 meter.</li>
<li><strong>Pemasangan PJU (Penerangan Jalan Umum)</strong> — Instalasi 25 titik lampu LED hemat energi di jalan utama desa.</li>
</ul>
<h2>Anggaran</h2>
<p>Total anggaran untuk program ini sebesar Rp 850.000.000,- yang bersumber dari Dana Desa dan Alokasi Dana Desa (ADD). Pelaksanaan dilakukan secara swakelola dengan melibatkan warga setempat sebagai tenaga kerja.</p>
<p>Diharapkan pembangunan ini akan meningkatkan kenyamanan dan keselamatan warga dalam beraktivitas sehari-hari.</p>',
            ],
            [
                'title' => 'Kegiatan Posyandu Balita dan Lansia Bulan Februari 2026',
                'category' => 'Kesehatan',
                'content' => '<p>Posyandu Desa Mukti Jaya kembali menggelar kegiatan rutin bulanan yang diikuti oleh puluhan ibu dan balita serta warga lansia. Kegiatan ini dilaksanakan di Balai Desa Mukti Jaya pada hari Kamis, 20 Februari 2026.</p>
<h2>Kegiatan yang Dilaksanakan</h2>
<ul>
<li><strong>Penimbangan Balita</strong> — Pemantauan tumbuh kembang anak usia 0-5 tahun dengan pencatatan di buku KIA.</li>
<li><strong>Pemberian Vitamin A</strong> — Distribusi vitamin A untuk balita sebagai bagian dari program nasional.</li>
<li><strong>Pemeriksaan Tensi Lansia</strong> — Cek tekanan darah dan konsultasi kesehatan gratis untuk warga lansia.</li>
<li><strong>Penyuluhan Gizi</strong> — Edukasi tentang makanan bergizi seimbang dan pencegahan stunting oleh petugas Puskesmas.</li>
</ul>
<p>Kader Posyandu dan Bidan Desa bekerja sama dalam memberikan pelayanan terbaik bagi warga. Kegiatan ini rutin dilaksanakan setiap bulan dan terbuka untuk seluruh warga Desa Mukti Jaya.</p>',
            ],
            [
                'title' => 'Program Bimbingan Belajar Gratis untuk Anak-Anak Desa',
                'category' => 'Pendidikan',
                'content' => '<p>Karang Taruna Desa Mukti Jaya bersama Pemerintah Desa menyelenggarakan program bimbingan belajar gratis yang ditujukan bagi anak-anak usia sekolah dasar dan menengah.</p>
<h2>Detail Program</h2>
<ul>
<li><strong>Jadwal:</strong> Setiap Senin, Rabu, dan Jumat pukul 15.30 — 17.00 WIB</li>
<li><strong>Lokasi:</strong> Aula Balai Desa Mukti Jaya</li>
<li><strong>Mata Pelajaran:</strong> Matematika, Bahasa Indonesia, Bahasa Inggris, dan IPA</li>
<li><strong>Pengajar:</strong> Relawan dari mahasiswa dan guru honorer setempat</li>
</ul>
<h2>Tujuan</h2>
<p>Program ini bertujuan untuk meningkatkan prestasi akademik anak-anak desa dan mengurangi kesenjangan pendidikan. Selain bimbingan belajar, juga diadakan kegiatan literasi dan pengembangan karakter pada setiap sesi.</p>
<p>Pendaftaran dibuka sepanjang tahun dan tidak dipungut biaya. Hubungi sekretariat desa untuk informasi lebih lanjut.</p>',
            ],
            [
                'title' => 'Gotong Royong Bersih Lingkungan dan Penanaman Pohon',
                'category' => 'Kegiatan Sosial',
                'content' => '<p>Warga Desa Mukti Jaya mengadakan kegiatan gotong royong bersih lingkungan yang diikuti oleh ratusan warga dari berbagai RT dan RW. Kegiatan ini merupakan bagian dari program rutin bulanan yang diinisiasi oleh Pemerintah Desa.</p>
<h2>Rangkaian Kegiatan</h2>
<ul>
<li><strong>Bersih-Bersih Selokan</strong> — Pembersihan saluran air dan gorong-gorong untuk mencegah genangan saat musim hujan.</li>
<li><strong>Pengecatan Fasilitas Umum</strong> — Perawatan taman desa, pos kamling, dan pagar balai desa.</li>
<li><strong>Penanaman Pohon</strong> — Penanaman 100 bibit pohon peneduh di sepanjang jalan utama desa, bekerja sama dengan Dinas Lingkungan Hidup Kabupaten Bekasi.</li>
<li><strong>Kerja Bakti Sampah</strong> — Pengumpulan dan pemilahan sampah di area pemukiman dan ruang terbuka.</li>
</ul>
<p>Kegiatan ini menunjukkan semangat kebersamaan dan kepedulian warga Mukti Jaya terhadap kebersihan dan kelestarian lingkungan. Kepala Desa berharap kegiatan serupa dapat dilaksanakan secara konsisten setiap bulan.</p>',
            ],
            [
                'title' => 'Musyawarah Desa: Penetapan Prioritas Pembangunan Tahun 2026',
                'category' => 'Berita Desa',
                'content' => '<p>Pemerintah Desa Mukti Jaya menyelenggarakan Musyawarah Desa (Musdes) untuk membahas dan menetapkan prioritas pembangunan tahun anggaran 2026. Musdes ini dihadiri oleh perangkat desa, BPD, tokoh masyarakat, dan perwakilan warga dari seluruh RW.</p>
<h2>Hasil Musyawarah</h2>
<p>Beberapa prioritas yang disepakati dalam musyawarah antara lain:</p>
<ol>
<li>Pembangunan Taman Baca Masyarakat di RW 03</li>
<li>Rehabilitasi Gedung PAUD Tunas Harapan</li>
<li>Peningkatan Jalan Lingkungan RT 05/RW 01</li>
<li>Pengadaan Ambulance Desa</li>
<li>Program Pelatihan Keterampilan Digital untuk Pemuda</li>
</ol>
<p>Seluruh program akan dilaksanakan secara bertahap dengan mengutamakan transparansi anggaran dan partisipasi aktif masyarakat.</p>',
            ],
        ];

        foreach ($posts as $i => $postData) {
            Post::firstOrCreate(
                ['slug' => Str::slug($postData['title'])],
                [
                    'title' => $postData['title'],
                    'content' => $postData['content'],
                    'category_id' => $catModels[$postData['category']]->id,
                    'is_active' => true,
                    'published_at' => now()->subDays(count($posts) - $i),
                ]
            );
        }

        // ── Sliders ──
        $sliders = [
            [
                'title' => 'Selamat Datang di Portal Desa Mukti Jaya',
                'description' => 'Portal informasi resmi Desa Mukti Jaya, Kecamatan Cikarang Pusat, Kabupaten Bekasi. Akses layanan desa, berita, dan pengaduan secara online.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Program Pembangunan Desa 2026',
                'description' => 'Pembangunan infrastruktur jalan, drainase, dan fasilitas umum untuk kenyamanan warga Desa Mukti Jaya.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Layanan Pengaduan Online',
                'description' => 'Sampaikan aspirasi atau keluhan Anda secara mudah dan transparan melalui fitur pengaduan daring.',
                'link_url' => '/pengaduan',
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $sliderData) {
            Slider::firstOrCreate(
                ['title' => $sliderData['title']],
                array_merge($sliderData, [
                    'image_path' => '',
                    'is_active' => true,
                ])
            );
        }

        // ── Galleries ──
        $galleries = [
            [
                'title' => 'Gotong Royong Bersih Lingkungan Februari 2026',
                'description' => 'Dokumentasi kegiatan gotong royong warga Desa Mukti Jaya.',
            ],
            [
                'title' => 'Pembangunan Infrastruktur Jalan',
                'description' => 'Proses pembangunan dan perbaikan jalan lingkungan desa.',
            ],
            [
                'title' => 'Kegiatan Posyandu Balita',
                'description' => 'Pelayanan kesehatan rutin untuk ibu dan balita di Desa Mukti Jaya.',
            ],
        ];

        foreach ($galleries as $galleryData) {
            Gallery::firstOrCreate(
                ['title' => $galleryData['title']],
                array_merge($galleryData, [
                    'published_at' => now(),
                ])
            );
        }
    }
}
