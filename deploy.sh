#!/bin/bash
# ============================================================
# DEPLOY HELPER - Sistem Fasilitas
# Jalankan setelah file diupload ke server hosting
# (Jika hosting mendukung SSH / Terminal cPanel)
# ============================================================

echo "=== Sistem Fasilitas - Post Deploy Script ==="
echo ""

# Pastikan berada di root proyek
# cd /home/USERNAME/public_html/sistem-fasilitas

# 1. Clear cache lama
echo "[1/5] Membersihkan cache lama..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Cache untuk production
echo "[2/5] Membuat cache production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Set permission storage
echo "[3/5] Set permission storage..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 4. Storage link
echo "[4/5] Membuat storage link..."
php artisan storage:link

# 5. Optimasi composer
echo "[5/5] Optimasi autoload..."
composer dump-autoload --optimize --no-dev

echo ""
echo "=== Deploy selesai! Buka browser dan test aplikasi. ==="
