# Inventory App

Inventory App adalah aplikasi manajemen inventaris berbasis Laravel 12 untuk mengelola barang, kategori, stok, lokasi, dan gambar barang.

## Fitur Utama

- Login dan logout pengguna.
- Dashboard ringkasan jumlah barang dan kategori.
- CRUD barang.
- CRUD kategori.
- Relasi barang dengan kategori.
- Pencarian barang berdasarkan nama.
- Filter barang berdasarkan kategori.
- Pagination daftar barang dan kategori.
- Upload dan penghapusan gambar barang.
- Indikator barang dengan stok rendah.
- Seeder data admin, kategori, dan barang contoh.

## Teknologi

- Laravel 12
- PHP 8.2
- Apache
- MySQL 8
- Blade dan Bootstrap
- Docker Engine + Docker Compose
- WSL2 Ubuntu pada Windows (tanpa Docker Desktop)

## Quick Start

Dokumentasi lengkap tersedia di [documentation.md](documentation.md).

1. Pastikan Docker Engine berjalan di WSL2.
2. Buka terminal Ubuntu/WSL.
3. Masuk ke folder proyek. Untuk performa terbaik, gunakan filesystem Linux WSL:

   ```bash
   mkdir -p ~/projects
   cd /mnt/c/Users/LEVINST/Documents/coding-project/Laravel_docker
   cp -a ./. ~/projects/Laravel_docker/
   cd ~/projects/Laravel_docker
   ```

   Source di `~/projects` lebih cepat daripada `/mnt/c` saat Laravel membaca
   banyak file PHP.

4. Jalankan aplikasi:

   ```bash
   docker compose up -d --build
   ```

5. Pastikan semua container aktif:

   ```bash
   docker compose ps
   ```

6. Migration dan seeder dijalankan otomatis oleh `init.sh` ketika container
   aplikasi mulai. Periksa log untuk memastikan proses selesai:

   ```bash
   docker compose logs -f app
   ```

   Seeder aman dijalankan ulang jika diperlukan:

   ```bash
   docker compose exec app php artisan db:seed --force
   ```

7. Buka aplikasi:

   - Aplikasi: http://localhost:8000
   - phpMyAdmin: http://localhost:8001

## Akun Demo

```text
Email    : imam123@gmail.com
Password : admin123
```

## Perintah Penting

```bash
# Menjalankan container
docker compose up -d

# Menghentikan container tanpa menghapus volume
docker compose down

# Melihat status dan log
docker compose ps
docker compose logs -f app

# Menjalankan migration dan seeder
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force

# Reset database dan isi ulang data contoh
docker compose exec app php artisan migrate:fresh --seed

# Membersihkan cache Laravel
docker compose exec app php artisan optimize:clear
```

## Catatan Data

Data MySQL disimpan pada named volume Docker `mysql-data`. Folder `mysql_data` lama tidak digunakan oleh konfigurasi final. Jangan menghapus volume Docker jika ingin mempertahankan data aplikasi.
