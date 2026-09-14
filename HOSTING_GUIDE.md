# 🚀 Panduan Hosting — Sistem Fasilitas (cPanel Shared Hosting)

> Panduan ini berlaku untuk **Niagahoster, Hostinger, IDCloudHost**, dan hosting cPanel lainnya.

---

## 📋 Checklist Sebelum Upload

- [ ] Akun hosting sudah aktif
- [ ] Domain / subdomain sudah diarahkan ke hosting
- [ ] Akses File Manager atau FTP tersedia
- [ ] Akses phpMyAdmin tersedia

---

## LANGKAH 1 — Buat Database di cPanel

1. Login ke **cPanel** → cari menu **MySQL Databases**
2. Buat database baru, misalnya: `userhosting_fasilitas`
3. Buat user database baru dengan password yang kuat
4. Tambahkan user ke database → centang **ALL PRIVILEGES**
5. **Catat** nama database, username, dan password (dibutuhkan di langkah 4)

---

## LANGKAH 2 — Import Database

1. Di cPanel → buka **phpMyAdmin**
2. Pilih database yang baru dibuat
3. Klik tab **Import**
4. Upload file: `db_fasilitas_export.sql`
5. Klik **Go** / **Kirim**
6. Tunggu hingga proses selesai (biasanya < 1 menit)

---

## LANGKAH 3 — Upload File Proyek

### Via File Manager cPanel

1. Di cPanel → buka **File Manager**
2. Masuk ke folder `public_html` (atau subdomain kamu)
3. Upload file `sistem-fasilitas.zip`
4. Klik kanan → **Extract** di dalam `public_html`
5. Hasilnya folder `public_html/sistem-fasilitas/` berisi semua file

> **PENTING untuk cPanel Shared Hosting:**
> Karena kita tidak bisa mengubah document root, semua file proyek
> diupload ke `public_html/nama-folder/` dan `.htaccess` di root
> akan redirect traffic ke subfolder `public/`

---

## LANGKAH 4 — Konfigurasi File `.env`

1. Di File Manager, masuk ke `public_html/sistem-fasilitas/`
2. Edit file `.env`
3. Ubah bagian berikut:

```env
APP_NAME="Sistem Fasilitas"
APP_ENV=production
APP_KEY=base64:y2rEa4Pls2WMEb5qs2vHrUBBOGdGzelSxEsLhib+O6E=
APP_DEBUG=false
APP_URL=https://DOMAIN_KAMU.com     <- ganti dengan domain asli

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=userhosting_fasilitas   <- nama database dari langkah 1
DB_USERNAME=userhosting_dbuser      <- username DB dari langkah 1
DB_PASSWORD=PASSWORD_KUAT_KAMU      <- password DB dari langkah 1
```

---

## LANGKAH 5 — Set Permission Folder Storage

Di File Manager, set permission (CHMOD) folder berikut menjadi **755**:

- `storage/`
- `storage/app/`
- `storage/app/public/`
- `storage/framework/`
- `storage/framework/cache/`
- `storage/framework/sessions/`
- `storage/framework/views/`
- `bootstrap/cache/`

**Cara:** Klik kanan folder → Change Permissions → isi `755` → OK

---

## LANGKAH 6 — Buat Symbolic Link Storage

1. Upload file `storage_link.php` ke dalam folder `public/` proyek
2. Akses via browser: `https://DOMAIN_KAMU.com/storage_link.php`
3. Kalau berhasil muncul "Storage link created!", **hapus file tersebut**

---

## LANGKAH 7 — Test Aplikasi

| Test | Yang Diharapkan |
|------|----------------|
| `https://domain.com` | Redirect ke halaman login |
| Login `admin` / `123456` | Masuk ke dashboard admin |
| Login `petugas1` / `123456` | Masuk ke dashboard petugas |
| Foto fasilitas tampil | Gambar muncul di halaman fasilitas |
| QR Code tampil | QR code muncul di halaman scan |
| Export PDF Rekap | File PDF berhasil didownload |

---

## Troubleshooting

### Error 500
- Cek file `.env` sudah benar (DB credentials, APP_KEY)
- Set `APP_DEBUG=true` sementara untuk lihat error detail
- Cek permission folder `storage/` dan `bootstrap/cache/`

### Foto tidak tampil
- Pastikan symbolic link storage sudah dibuat (Langkah 6)
- Cek folder `public/storage` sudah ada dan mengarah ke `storage/app/public/`

### Halaman tidak ditemukan (404)
- Pastikan `mod_rewrite` aktif di hosting
- Cek file `.htaccess` di folder `public/` ada

### Error database
- Cek nama DB, username, password di `.env`
- Di hosting cPanel, `DB_HOST` biasanya `localhost`

### Session/Login tidak berfungsi
- Set `SESSION_DRIVER=file` di `.env`
- Cek permission folder `storage/framework/sessions/` 755

---

*Dibuat untuk: Sistem Fasilitas — Laravel 12 | cPanel Shared Hosting*
