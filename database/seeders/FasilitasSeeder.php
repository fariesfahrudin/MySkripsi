<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            [1, 'Cungkup Makam Utama', 'Area Makam', 'Cungkup pelindung makam Sunan Drajat'],
            [2, 'Pagar Pembatas Makam', 'Area Makam', 'Pagar keliling area makam'],
            [3, 'Karpet Doa Utama', 'Area Makam', 'Karpet sajadah untuk jamaah dan peziarah'],
            [4, 'Lampu Penerangan Makam', 'Area Makam', 'Lampu gantung di dalam cungkup makam'],
            [5, 'Papan Informasi Sejarah', 'Area Makam', 'Papan silsilah dan sejarah perjuangan Sunan Drajat'],
            [6, 'Tempat Wudhu Pria Barat', 'Area Wudhu & Sanitasi', 'Kran wudhu jamaah pria bagian barat'],
            [7, 'Tempat Wudhu Pria Timur', 'Area Wudhu & Sanitasi', 'Kran wudhu jamaah pria bagian timur'],
            [8, 'Tempat Wudhu Wanita Barat', 'Area Wudhu & Sanitasi', 'Kran wudhu jamaah wanita bagian barat'],
            [9, 'Tempat Wudhu Wanita Timur', 'Area Wudhu & Sanitasi', 'Kran wudhu jamaah wanita bagian timur'],
            [10, 'Toilet Pria Blok A', 'Area Wudhu & Sanitasi', 'Kamar mandi dan toilet pria blok A'],
            [11, 'Toilet Pria Blok B', 'Area Wudhu & Sanitasi', 'Kamar mandi dan toilet pria blok B'],
            [12, 'Toilet Wanita Blok A', 'Area Wudhu & Sanitasi', 'Kamar mandi dan toilet wanita blok A'],
            [13, 'Toilet Wanita Blok B', 'Area Wudhu & Sanitasi', 'Kamar mandi dan toilet wanita blok B'],
            [14, 'Tandon Air Utama', 'Area Wudhu & Sanitasi', 'Penampungan air sentral kompleks makam'],
            [15, 'Pompa Air Distribusi', 'Area Wudhu & Sanitasi', 'Pompa booster untuk toilet dan tempat wudhu'],
            [16, 'Museum Gedung Utama', 'Area Museum', 'Ruang pamer artefak dan peninggalan bersejarah'],
            [17, 'Etalase Naskah Kuno', 'Area Museum', 'Lemari kaca penyimpan manuskrip'],
            [18, 'Etalase Gamelan Singo Mengkok', 'Area Museum', 'Etalase pelindung gamelan pusaka'],
            [19, 'AC Sentral Museum', 'Area Museum', 'Pengatur suhu dan kelembaban artefak museum'],
            [20, 'Lampu Sorot Pameran', 'Area Museum', 'Pencahayaan galeri peninggalan bersejarah'],
            [21, 'Pintu Masuk Museum', 'Area Museum', 'Pintu kaca otomatis museum'],
            [22, 'Gazebo Istirahat 1', 'Taman & Jalur Pejalan', 'Gazebo kayu santai peziarah'],
            [23, 'Gazebo Istirahat 2', 'Taman & Jalur Pejalan', 'Gazebo santai peziarah zona utara'],
            [24, 'Gazebo Istirahat 3', 'Taman & Jalur Pejalan', 'Gazebo santai peziarah dekat gapura'],
            [25, 'Bangku Taman Beton', 'Taman & Jalur Pejalan', 'Bangku duduk peziarah sepanjang pedestrian'],
            [26, 'Kanopi Jalur Pejalan Kaki', 'Taman & Jalur Pejalan', 'Atap pelindung panas dan hujan bagi peziarah'],
            [27, 'Tempat Sampah Organik & Non-Organik', 'Taman & Jalur Pejalan', 'Tempat sampah terpilah zona taman'],
            [28, 'Lampu Taman Jalur Utama', 'Taman & Jalur Pejalan', 'Penerangan jalur menuju kompleks makam'],
            [29, 'Paving Block Jalur Peziarah', 'Taman & Jalur Pejalan', 'Akses jalan kaki peziarah'],
            [30, 'Tanaman Lanskap & Rumput', 'Taman & Jalur Pejalan', 'Area hijau penghijauan kompleks'],
            [31, 'Tempat Parkir Bus Pariwisata', 'Area Parkir', 'Lahan parkir bus rombongan ziarah'],
            [32, 'Tempat Parkir Mobil Pribadi', 'Area Parkir', 'Lahan parkir kendaraan roda 4'],
            [33, 'Tempat Parkir Sepeda Motor', 'Area Parkir', 'Lahan parkir kendaraan roda 2'],
            [34, 'Pos Retribusi Tiket Masuk', 'Area Parkir', 'Loket karcis dan retribusi pengunjung'],
            [35, 'Palang Pintu Masuk Otomatis', 'Area Parkir', 'Barrier gate kendaraan roda 4'],
            [36, 'Palang Pintu Keluar Otomatis', 'Area Parkir', 'Barrier gate kendaraan keluar'],
            [37, 'Lampu Sorot Parkir Timur', 'Area Parkir', 'Penerangan lapangan parkir timur'],
            [38, 'Lampu Sorot Parkir Barat', 'Area Parkir', 'Penerangan lapangan parkir barat'],
            [39, 'Pos Pengamanan & CCTV Parkir', 'Area Parkir', 'Pos satpam penjagaan area parkir'],
            [40, 'Kios Cinderamata Blok A', 'Sentra Kuliner & UMKM', 'Deretan kios oleh-oleh khas Sunan Drajat blok A'],
            [41, 'Kios Cinderamata Blok B', 'Sentra Kuliner & UMKM', 'Deretan kios oleh-oleh khas Sunan Drajat blok B'],
            [42, 'Kios Kuliner Tradisional 1', 'Sentra Kuliner & UMKM', 'Warung makan peziarah zona 1'],
            [43, 'Kios Kuliner Tradisional 2', 'Sentra Kuliner & UMKM', 'Warung makan peziarah zona 2'],
            [44, 'Tempat Cuci Tangan UMKM', 'Sentra Kuliner & UMKM', 'Wastafel cuci tangan pengunjung sentra kuliner'],
            [45, 'Pusat Informasi & Pengaduan', 'Pelayanan Pengunjung', 'Pusat layanan informasi makam'],
            [46, 'Sound System & Pengeras Suara', 'Pelayanan Pengunjung', 'Pengeras suara informasi dan adzan'],
            [47, 'Kotak P3K & Ruang Medis', 'Pelayanan Pengunjung', 'Layanan pertolongan pertama pengunjung'],
            [48, 'Kursi Roda Difabel', 'Pelayanan Pengunjung', 'Fasilitas kursi roda lansia dan difabel'],
            [49, 'Ramp Akses Kursi Roda', 'Pelayanan Pengunjung', 'Jalur miring untuk kursi roda masuk makam'],
            [50, 'Gapura Paduraksa Utama', 'Akses Masuk', 'Gapura candi bentar gerbang utama'],
            [51, 'Papan Denah Kawasan Wisata', 'Akses Masuk', 'Peta petunjuk navigasi kawasan makam'],
        ];

        foreach ($fasilitas as $item) {
            DB::table('fasilitas')->updateOrInsert(
                ['id_fasilitas' => $item[0]],
                [
                    'nama_fasilitas' => $item[1],
                    'lokasi'         => $item[2],
                    'deskripsi'      => $item[3],
                    'qr_code'        => 'qrcode/qr-sample-' . $item[0] . '.svg',
                    'foto'           => null,
                ]
            );
        }
    }
}
