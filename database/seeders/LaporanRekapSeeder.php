<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanRekapSeeder extends Seeder
{
    /**
     * Seed 100 laporan kerusakan lengkap dengan alur nyata:
     *   Laporan (selesai) → Penugasan (selesai) → Perbaikan (disetujui)
     *   + Notifikasi untuk Admin & Petugas di setiap tahapan.
     *
     * Rentang waktu: 1 bulan terakhir s.d. sekarang (14 Juni – 14 Juli 2026).
     */
    public function run(): void
    {
        // ── Bersihkan data lama ──────────────────────────────────────────────
        // Urutan penting: anak tabel dulu baru induk
        DB::table('perbaikans')->truncate();
        DB::table('penugasans')->truncate();
        DB::table('laporan')->truncate();
        DB::table('notifikasis')->truncate();

        // ── Data referensi ───────────────────────────────────────────────────
        $fasilitasIds = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26, 28, 29, 30, 31,
            32, 33, 34, 35, 36, 37, 38, 39, 40, 41,
            42, 43, 44, 45, 46, 47, 48, 49, 50, 51,
        ];

        // ID admin (role = 'admin') – hanya 1 admin di UserSeeder
        $adminId = DB::table('users')->where('role', 'admin')->value('id');

        // ID petugas (role = 'petugas')
        $petugasIds = DB::table('users')
            ->where('role', 'petugas')
            ->pluck('id')
            ->toArray();

        $namaPelapor = [
            'Ahmad Fauzi', 'Siti Aisyah', 'Budi Santoso', 'Dewi Rahayu', 'Eko Prasetyo',
            'Fatimah Zahra', 'Galih Wicaksono', 'Hana Pertiwi', 'Irfan Maulana', 'Joko Susilo',
            'Kartika Sari', 'Luki Firmansyah', 'Mariana Safitri', 'Nanang Setiawan', 'Opik Hidayat',
            'Putri Rahmawati', 'Qoirul Anam', 'Rini Andriani', 'Suryadi', 'Tuti Handayani',
            'Umar Faruq', 'Vina Kusuma', 'Wahyu Nugroho', 'Yusuf Hakim', 'Zainab Arrofi',
            'Agus Purnomo', 'Bagas Adi', 'Cahyono', 'Diana Lestari', 'Endro Wibowo',
            'Fitriani', 'Guntur Saputra', 'Hesti Nurvita', 'Indra Kusuma', 'Jannah Safira',
        ];

        $deskripsiKerusakan = [
            'Lampu mati dan tidak menyala sama sekali, perlu penggantian segera.',
            'Kran air bocor dan mengalirkan air terus-menerus menyebabkan pemborosan.',
            'Pintu rusak, engselnya lepas dan tidak bisa menutup dengan sempurna.',
            'Atap bocor saat hujan, air menetes ke area pengunjung.',
            'Lantai retak dan berbahaya bagi pejalan kaki.',
            'Tempat sampah rusak dan baunya menyengat, perlu penggantian.',
            'Kipas angin tidak berfungsi, ruangan menjadi sangat panas.',
            'Papan petunjuk arah terjatuh dan tidak terpasang dengan baik.',
            'Bangku kayu patah pada bagian penopangnya, berbahaya untuk diduduki.',
            'Keran toilet macet dan tidak dapat dibuka atau ditutup.',
            'Dinding berlumut dan kotor, perlu pengecatan ulang.',
            'Wastafel cuci tangan tersumbat, air tidak bisa mengalir.',
            'Pagar pembatas rusak, ada bagian yang miring dan hampir roboh.',
            'Selang air putus sehingga fasilitas wudhu tidak dapat digunakan.',
            'Cermin di toilet retak dan pecah di beberapa bagian.',
            'Tangga licin dan berbahaya, perlu dipasang anti-slip.',
            'Saluran pembuangan air tersumbat, menyebabkan genangan air.',
            'Cat dinding mengelupas dan terlihat tidak terawat.',
            'Lampu taman tidak menyala di malam hari, area menjadi gelap.',
            'Papan informasi rusak dan tulisannya sudah tidak terbaca.',
            'Bak penampungan air bocor, air habis dalam waktu singkat.',
            'Toilet tidak bisa disiram karena mekanisme gelontor rusak.',
            'Kotak amal rusak, kuncinya hilang dan tidak aman.',
            'Paving blok jalur pejalan kaki terangkat dan berbahaya.',
            'Pompa air tidak berfungsi sehingga pasokan air terhenti.',
            'Kursi plastik banyak yang pecah dan tidak layak pakai.',
            'Spanduk/banner petunjuk robek terkena angin kencang.',
            'Saluran got tersumbat sampah, menimbulkan bau tidak sedap.',
            'Pintu kamar mandi tidak bisa dikunci dari dalam.',
            'Lampu teras mati, area gelap dan tidak aman di malam hari.',
        ];

        $keteranganPerbaikan = [
            'Lampu telah diganti dengan yang baru, berfungsi normal kembali.',
            'Kran air telah diperbaiki, tidak ada kebocoran lagi.',
            'Pintu dan engsel telah diperbaiki, sudah bisa menutup dengan baik.',
            'Atap telah ditambal dengan bahan waterproof, kebocoran teratasi.',
            'Lantai retak telah dicor ulang dan diratakan.',
            'Tempat sampah lama diganti dengan yang baru.',
            'Kipas angin telah diservis dan berfungsi normal kembali.',
            'Papan petunjuk telah dipasang kembali dengan baut tambahan.',
            'Bangku telah diperbaiki, penopang diganti dan sudah aman.',
            'Keran toilet telah diganti, berfungsi dengan baik.',
            'Dinding telah dibersihkan dari lumut dan dicat ulang.',
            'Saluran wastafel telah dibersihkan, air mengalir lancar.',
            'Pagar pembatas telah diperbaiki dan diperkuat dengan las.',
            'Selang air telah diganti, fasilitas wudhu dapat digunakan kembali.',
            'Cermin yang retak telah diganti dengan yang baru.',
            'Anti-slip telah dipasang di anak tangga.',
            'Saluran pembuangan telah dibersihkan, tidak ada genangan air.',
            'Dinding telah dicat ulang dan terlihat rapi.',
            'Lampu taman telah diganti dan menyala di malam hari.',
            'Papan informasi telah diganti dengan yang baru dan terbaca jelas.',
            'Bak penampungan air telah diperbaiki, tidak bocor lagi.',
            'Mekanisme gelontor toilet telah diperbaiki, berfungsi normal.',
            'Kotak amal telah diperbaiki dan dikunci dengan gembok baru.',
            'Paving blok yang terangkat telah dipasang ulang dan rata.',
            'Pompa air telah diperbaiki, pasokan air kembali normal.',
            'Kursi yang rusak telah diganti dengan kursi plastik baru.',
            'Spanduk/banner yang robek telah diganti dengan yang baru.',
            'Saluran got telah dibersihkan, tidak ada bau lagi.',
            'Kunci pintu kamar mandi telah diperbaiki.',
            'Lampu teras telah diganti, area kembali terang.',
        ];

        $now       = Carbon::now();           // 14 Juli 2026
        $startDate = $now->copy()->subMonth(); // 14 Juni 2026

        // ── Buffer bulk insert ───────────────────────────────────────────────
        $notifikasiBulk = [];

        for ($i = 0; $i < 100; $i++) {

            // ── Waktu tiap tahapan ───────────────────────────────────────────
            $tLapor     = Carbon::createFromTimestamp(rand($startDate->timestamp, $now->copy()->subDays(6)->timestamp));
            $tValidasi  = $tLapor->copy()->addHours(rand(2, 12));           // Admin validasi
            $tTugaskan  = $tValidasi->copy()->addHours(rand(1, 6));         // Admin tugaskan
            $tPerbaikan = $tTugaskan->copy()->addDays(rand(1, 4))->addHours(rand(1, 8)); // Petugas kirim bukti
            $tSetujui   = $tPerbaikan->copy()->addHours(rand(2, 24));       // Admin setujui

            // Pastikan tidak melebihi hari ini
            foreach ([$tValidasi, $tTugaskan, $tPerbaikan, $tSetujui] as &$t) {
                if ($t->gt($now)) $t = $now->copy()->subMinutes(rand(10, 120));
            }
            unset($t);

            $fasilitasId   = $fasilitasIds[array_rand($fasilitasIds)];
            $petugasId     = $petugasIds[array_rand($petugasIds)];
            $deskripsiIdx  = array_rand($deskripsiKerusakan);
            $keteranganIdx = array_rand($keteranganPerbaikan);

            // ── 1. Laporan (status: selesai) ─────────────────────────────────
            $laporanId = DB::table('laporan')->insertGetId([
                'id_fasilitas' => $fasilitasId,
                'nama_pelapor' => $namaPelapor[array_rand($namaPelapor)],
                'deskripsi'    => $deskripsiKerusakan[$deskripsiIdx],
                'foto'         => null,
                'status'       => 'selesai',
                'created_at'   => $tLapor,
                'updated_at'   => $tSetujui,
            ]);

            // ── 2. Penugasan (status: selesai) ───────────────────────────────
            $penugasanId = DB::table('penugasans')->insertGetId([
                'id_laporan' => $laporanId,
                'id_user'    => $petugasId,
                'status'     => 'selesai',
                'created_at' => $tTugaskan,
                'updated_at' => $tSetujui,
            ]);

            // ── 3. Perbaikan (status_validasi: disetujui) ────────────────────
            DB::table('perbaikans')->insert([
                'id_penugasan'    => $penugasanId,
                'foto_bukti'      => null,
                'keterangan'      => $keteranganPerbaikan[$keteranganIdx],
                'status_validasi' => 'disetujui',
                'tgl_selesai'     => $tSetujui,
                'created_at'      => $tPerbaikan,
                'updated_at'      => $tSetujui,
            ]);

            // ── 4. Notifikasi sesuai alur ────────────────────────────────────

            // Tahap 1 → Admin: ada laporan baru masuk (dibuat saat laporan masuk)
            $notifikasiBulk[] = [
                'id_user'    => $adminId,
                'judul'      => 'Laporan Baru Menunggu Validasi',
                'pesan'      => 'Ada laporan kerusakan baru dari pengunjung yang perlu divalidasi',
                'tipe'       => 'laporan_baru',
                'is_read'    => true,   // sudah dibaca (laporan sudah diproses)
                'created_at' => $tLapor,
                'updated_at' => $tLapor,
            ];

            // Tahap 2 → Petugas: mendapat tugas perbaikan
            $notifikasiBulk[] = [
                'id_user'    => $petugasId,
                'judul'      => 'Tugas Baru',
                'pesan'      => 'Anda mendapatkan tugas perbaikan fasilitas, segera tindak lanjuti.',
                'tipe'       => 'tugas_baru',
                'is_read'    => true,   // sudah dibaca (tugas sudah dikerjakan)
                'created_at' => $tTugaskan,
                'updated_at' => $tTugaskan,
            ];

            // Tahap 3 → Admin: petugas kirim bukti perbaikan
            $notifikasiBulk[] = [
                'id_user'    => $adminId,
                'judul'      => 'Validasi Perbaikan',
                'pesan'      => 'Petugas mengirim bukti perbaikan, silakan lakukan validasi.',
                'tipe'       => 'validasi_perbaikan',
                'is_read'    => true,   // sudah dibaca (sudah divalidasi)
                'created_at' => $tPerbaikan,
                'updated_at' => $tPerbaikan,
            ];

            // Tahap 4 → Petugas: perbaikan disetujui admin
            $notifikasiBulk[] = [
                'id_user'    => $petugasId,
                'judul'      => 'Perbaikan Disetujui',
                'pesan'      => 'Bukti perbaikan yang Anda kirimkan telah disetujui oleh Admin.',
                'tipe'       => 'disetujui',
                'is_read'    => rand(0, 1) === 1, // sebagian sudah dibaca, sebagian belum
                'created_at' => $tSetujui,
                'updated_at' => $tSetujui,
            ];

            // Flush setiap 20 iterasi untuk efisiensi memori
            if (count($notifikasiBulk) >= 80) {
                DB::table('notifikasis')->insert($notifikasiBulk);
                $notifikasiBulk = [];
            }
        }

        // Insert sisa notifikasi
        if (!empty($notifikasiBulk)) {
            DB::table('notifikasis')->insert($notifikasiBulk);
        }

        $this->command->info('✅ 100 laporan rekap + 400 notifikasi (alur lengkap) berhasil diseed!');

        // ── Laporan aktif (simulasi alur berjalan) ───────────────────────────
        $this->seedLaporanAktif($fasilitasIds, $adminId, $petugasIds, $namaPelapor, $deskripsiKerusakan, $keteranganPerbaikan, $now);
    }

    /**
     * Seed laporan yang sedang berjalan agar aplikasi terlihat hidup.
     * Total: 20 laporan aktif dengan berbagai tahapan.
     */
    private function seedLaporanAktif(
        array $fasilitasIds,
        int $adminId,
        array $petugasIds,
        array $namaPelapor,
        array $deskripsiKerusakan,
        array $keteranganPerbaikan,
        Carbon $now
    ): void {

        // ── 5 Laporan: menunggu_validasi (baru masuk, belum divalidasi admin) ──
        for ($i = 0; $i < 5; $i++) {
            $tLapor = $now->copy()->subHours(rand(1, 48));
            $fasilitasId = $fasilitasIds[array_rand($fasilitasIds)];

            DB::table('laporan')->insert([
                'id_fasilitas' => $fasilitasId,
                'nama_pelapor' => $namaPelapor[array_rand($namaPelapor)],
                'deskripsi'    => $deskripsiKerusakan[array_rand($deskripsiKerusakan)],
                'foto'         => null,
                'status'       => 'menunggu_validasi',
                'created_at'   => $tLapor,
                'updated_at'   => $tLapor,
            ]);

            // Notifikasi ke admin: ada laporan baru
            DB::table('notifikasis')->insert([
                'id_user'    => $adminId,
                'judul'      => 'Laporan Baru Menunggu Validasi',
                'pesan'      => 'Ada laporan kerusakan baru dari pengunjung yang perlu divalidasi',
                'tipe'       => 'laporan_baru',
                'is_read'    => false,  // belum dibaca admin
                'created_at' => $tLapor,
                'updated_at' => $tLapor,
            ]);
        }

        // ── 5 Laporan: pending (sudah divalidasi, menunggu penugasan) ──────────
        for ($i = 0; $i < 5; $i++) {
            $tLapor = $now->copy()->subHours(rand(6, 72));
            $fasilitasId = $fasilitasIds[array_rand($fasilitasIds)];

            DB::table('laporan')->insert([
                'id_fasilitas' => $fasilitasId,
                'nama_pelapor' => $namaPelapor[array_rand($namaPelapor)],
                'deskripsi'    => $deskripsiKerusakan[array_rand($deskripsiKerusakan)],
                'foto'         => null,
                'status'       => 'pending',
                'created_at'   => $tLapor,
                'updated_at'   => $tLapor->copy()->addHours(rand(1, 5)),
            ]);
            // (tidak ada notifikasi baru - admin sudah validasi, menunggu ditugaskan)
        }

        // ── 5 Laporan: diproses (sudah ditugaskan ke petugas) ─────────────────
        for ($i = 0; $i < 5; $i++) {
            $tLapor    = $now->copy()->subDays(rand(2, 5));
            $tTugaskan = $tLapor->copy()->addHours(rand(3, 12));
            $petugasId = $petugasIds[array_rand($petugasIds)];
            $fasilitasId = $fasilitasIds[array_rand($fasilitasIds)];

            $laporanId = DB::table('laporan')->insertGetId([
                'id_fasilitas' => $fasilitasId,
                'nama_pelapor' => $namaPelapor[array_rand($namaPelapor)],
                'deskripsi'    => $deskripsiKerusakan[array_rand($deskripsiKerusakan)],
                'foto'         => null,
                'status'       => 'diproses',
                'created_at'   => $tLapor,
                'updated_at'   => $tTugaskan,
            ]);

            DB::table('penugasans')->insert([
                'id_laporan' => $laporanId,
                'id_user'    => $petugasId,
                'status'     => 'diproses',
                'created_at' => $tTugaskan,
                'updated_at' => $tTugaskan,
            ]);

            // Notifikasi ke petugas: ada tugas baru
            DB::table('notifikasis')->insert([
                'id_user'    => $petugasId,
                'judul'      => 'Tugas Baru',
                'pesan'      => 'Anda mendapatkan tugas perbaikan fasilitas, segera tindak lanjuti.',
                'tipe'       => 'tugas_baru',
                'is_read'    => rand(0, 1) === 1,
                'created_at' => $tTugaskan,
                'updated_at' => $tTugaskan,
            ]);
        }

        // ── 5 Laporan: menunggu_validasi perbaikan (petugas sudah kirim bukti) ─
        for ($i = 0; $i < 5; $i++) {
            $tLapor     = $now->copy()->subDays(rand(4, 7));
            $tTugaskan  = $tLapor->copy()->addHours(rand(3, 12));
            $tPerbaikan = $tTugaskan->copy()->addDays(rand(1, 3))->addHours(rand(1, 6));
            $petugasId  = $petugasIds[array_rand($petugasIds)];
            $fasilitasId = $fasilitasIds[array_rand($fasilitasIds)];

            $laporanId = DB::table('laporan')->insertGetId([
                'id_fasilitas' => $fasilitasId,
                'nama_pelapor' => $namaPelapor[array_rand($namaPelapor)],
                'deskripsi'    => $deskripsiKerusakan[array_rand($deskripsiKerusakan)],
                'foto'         => null,
                'status'       => 'diproses',
                'created_at'   => $tLapor,
                'updated_at'   => $tPerbaikan,
            ]);

            $penugasanId = DB::table('penugasans')->insertGetId([
                'id_laporan' => $laporanId,
                'id_user'    => $petugasId,
                'status'     => 'menunggu_validasi',
                'created_at' => $tTugaskan,
                'updated_at' => $tPerbaikan,
            ]);

            DB::table('perbaikans')->insert([
                'id_penugasan'    => $penugasanId,
                'foto_bukti'      => null,
                'keterangan'      => $keteranganPerbaikan[array_rand($keteranganPerbaikan)],
                'status_validasi' => 'menunggu_validasi',
                'tgl_selesai'     => $tPerbaikan,
                'created_at'      => $tPerbaikan,
                'updated_at'      => $tPerbaikan,
            ]);

            // Notifikasi ke admin: ada bukti perbaikan menunggu validasi
            DB::table('notifikasis')->insert([
                'id_user'    => $adminId,
                'judul'      => 'Validasi Perbaikan',
                'pesan'      => 'Petugas mengirim bukti perbaikan, silakan lakukan validasi.',
                'tipe'       => 'validasi_perbaikan',
                'is_read'    => false,  // belum dibaca admin
                'created_at' => $tPerbaikan,
                'updated_at' => $tPerbaikan,
            ]);
        }

        $this->command->info('✅ 20 laporan aktif (berbagai tahapan) berhasil diseed!');
    }
}
