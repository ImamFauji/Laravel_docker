# Dokumentasi Lengkap Inventory App

## 1. Gambaran Umum

Inventory App adalah aplikasi web untuk mengelola inventaris barang. Aplikasi menyediakan autentikasi pengguna, dashboard, pengelolaan barang dan kategori, pencarian, filter, pagination, upload gambar, serta informasi stok rendah.

Aplikasi dijalankan menggunakan Docker Engine dan Docker Compose. Pada Windows, Docker Engine dijalankan melalui WSL2 Ubuntu sehingga Docker Desktop tidak diperlukan.

## 2. Fitur Aplikasi

### 2.1 Autentikasi

- Halaman login.
- Validasi email dan password.
- Regenerasi session setelah login.
- Logout dan invalidasi session.
- Halaman dashboard dan modul CRUD hanya dapat diakses setelah login.

### 2.2 Dashboard

Dashboard menampilkan:

- Jumlah seluruh barang.
- Jumlah kategori.
- Daftar barang dengan stok kurang dari 5.
- Kategori dari setiap barang stok rendah.

### 2.3 Manajemen Barang

Data barang memiliki:

- Kode barang.
- Nama barang.
- Kategori.
- Jumlah stok.
- Lokasi.
- Tanggal kategori.
- Gambar barang.

Operasi yang tersedia:

- Melihat daftar barang.
- Menambah barang.
- Mengubah barang.
- Menghapus barang.
- Mencari berdasarkan nama.
- Memfilter berdasarkan kategori.
- Menampilkan data dengan pagination.
- Upload gambar JPEG, PNG, JPG, atau GIF dengan ukuran maksimum 2 MB.

### 2.4 Manajemen Kategori

Operasi yang tersedia:

- Melihat kategori.
- Menambah kategori.
- Mengubah kategori.
- Menghapus kategori.
- Pagination kategori.

Nama kategori harus unik.

### 2.5 Seeder

Seeder utama menjalankan:

- `UserSeeder`: membuat akun admin.
- `KategoriSeeder`: membuat 10 kategori contoh.
- `BarangSeeder`: membuat 10 barang contoh.

Seeder kategori menggunakan `updateOrCreate`, sedangkan `UserSeeder` dan `BarangSeeder` membuat record baru. Hindari menjalankan seeder berulang kali jika data duplikat tidak diinginkan.

## 3. Struktur Proyek

```text
Laravel_docker/
├── docker/
│   └── php/
│       ├── Dockerfile
│       ├── apache.conf
│       └── init.sh
├── laravel_app/
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Repositories/
│   │   └── Services/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── resources/views/
│   ├── routes/web.php
│   ├── .env
│   └── composer.json
├── docker-compose.yml
├── readme.md
└── documentation.md
```

### Pola Layer Aplikasi

- `Models/`: model Eloquent, relasi, dan konfigurasi persistence.
- `Repositories/`: interface repository, query, dan operasi persistence terhadap model.
- `Services/`: interface service dan business logic seperti proses CRUD dan pengelolaan gambar.
- `Http/Controllers/`: validasi input HTTP, pemanggilan service/repository, dan response/view.

Controller tidak melakukan query Eloquent atau pengelolaan file secara langsung. Controller bergantung pada interface, bukan implementasi konkret. Binding interface ke implementasi didefinisikan di `app/Providers/AppServiceProvider.php` dan diselesaikan oleh service container Laravel. Controller dibuat sebagai class biasa karena proyek ini tidak menggunakan base `Controller.php`.

Interface sengaja ditempatkan langsung di layer yang memilikinya:

```text
app/Repositories/
├── Interfaces/
│   ├── IBarangRepository.php
│   └── IKategoriRepository.php
├── BarangRepository.php
└── KategoriRepository.php

app/Services/
├── Interfaces/
│   ├── IBarangService.php
│   └── IKategoriService.php
├── BarangService.php
└── KategoriService.php
```

Nama interface menggunakan awalan `I` sesuai konvensi yang saat ini digunakan proyek, misalnya `IBarangRepository` dan `IBarangService`. Interface repository berada di `app/Repositories/Interfaces` dengan namespace `App\Repositories\Interfaces`, sedangkan interface service berada di `app/Services/Interfaces` dengan namespace `App\Services\Interfaces`.

## 4. Arsitektur Docker

### 4.1 Service `app`

- Image dasar: PHP 8.2 Apache.
- Document root Apache: `/var/www/html/public`.
- Port host: `8000`.
- Source Laravel: `./laravel_app:/var/www/html`.
- Storage Laravel: named volume `laravel-storage`.
- Cache bootstrap Laravel: named volume `laravel-bootstrap-cache`.

### 4.2 Service `mysql`

- Image: MySQL 8.
- Port host: `3307`.
- Port internal Docker: `3306`.
- Database: `laravel_db`.
- User: `laravel`.
- Password: `secret`.
- Data: named volume `mysql-data`.

### 4.3 Service `phpmyadmin`

- Image: `phpmyadmin/phpmyadmin`.
- Port host: `8001`.
- Host database internal Docker: `mysql`.

### 4.4 Network dan volume

Semua service berada di network Docker `laravel`. Data database tidak lagi dipasang langsung dari folder Windows `mysql_data`, karena mount filesystem Windows dapat menyebabkan masalah permission MySQL. Konfigurasi menggunakan named volume Docker agar permission Linux berjalan normal.

## 5. Persyaratan Sistem

### Windows

- Windows dengan dukungan WSL2.
- Ubuntu pada WSL2.
- VS Code.
- Extension VS Code WSL.
- Koneksi internet saat build image pertama kali.

### Ubuntu WSL

- Docker Engine.
- Docker Compose Plugin.
- Git, jika proyek akan di-clone.

Docker Desktop tidak diperlukan.

## 6. Instalasi Docker Engine Tanpa Docker Desktop

### 6.1 Instal WSL2 dan Ubuntu

Buka PowerShell sebagai Administrator:

```powershell
wsl --install -d Ubuntu
```

Restart Windows jika diminta. Buka Ubuntu dan buat username serta password Linux.

Periksa versi WSL:

```powershell
wsl --status
wsl -l -v
```

Pastikan Ubuntu menggunakan versi `2`. Jika belum:

```powershell
wsl --set-version Ubuntu 2
```

### 6.2 Aktifkan systemd

Di terminal Ubuntu:

```bash
sudo nano /etc/wsl.conf
```

Isi file:

```ini
[boot]
systemd=true
```

Simpan dengan `Ctrl+O`, Enter, lalu keluar dengan `Ctrl+X`. Dari PowerShell:

```powershell
wsl --shutdown
```

Buka Ubuntu lagi dan periksa:

```bash
systemctl is-system-running
```

### 6.3 Instal Docker Engine

Jalankan di terminal Ubuntu:

```bash
sudo apt update
sudo apt install -y ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc
```

```bash
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}") stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

```bash
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
sudo systemctl enable --now docker
sudo usermod -aG docker "$USER"
newgrp docker
```

Verifikasi:

```bash
docker --version
docker compose version
docker run hello-world
```

Jika muncul `Hello from Docker!`, Docker Engine siap digunakan.

## 7. Membuka Proyek di VS Code

### Opsi 1: proyek berada di drive Windows

```bash
cd /mnt/c/Users/LEVINST/Documents/coding-project/Laravel_docker
code .
```

### Opsi 2: performa terbaik dari filesystem WSL

Filesystem Linux WSL lebih cepat untuk Laravel daripada `/mnt/c`, terutama ketika Composer dan Laravel membaca banyak file PHP.

```bash
mkdir -p ~/projects
cp -r /mnt/c/Users/LEVINST/Documents/coding-project/Laravel_docker ~/projects/
cd ~/projects/Laravel_docker
code .
```

Gunakan VS Code yang terhubung ke WSL melalui extension **WSL**. Jalankan semua perintah Docker dari terminal Ubuntu.

## 8. Menjalankan Aplikasi dari Awal

Masuk ke folder proyek:

```bash
cd /mnt/c/Users/LEVINST/Documents/coding-project/Laravel_docker
```

Jika proyek sudah dipindahkan ke filesystem WSL, gunakan:

```bash
cd ~/projects/Laravel_docker
```

### 8.1 Periksa konfigurasi

```bash
docker compose config
```

Pastikan file berikut tersedia:

```text
docker-compose.yml
docker/php/Dockerfile
docker/php/apache.conf
docker/php/init.sh
laravel_app/.env
```

### 8.2 Build dan jalankan container

```bash
docker compose up -d --build
```

Build pertama dapat memerlukan waktu karena image PHP, Composer, dan dependency harus diproses.

### 8.3 Periksa status

```bash
docker compose ps
```

Status yang diharapkan:

```text
laravel_app          Up
laravel_mysql        Up
laravel_phpmyadmin   Up
```

Jika aplikasi baru selesai start, tunggu sampai log menampilkan Apache telah berjalan:

```text
Apache/... configured -- resuming normal operations
```

### 8.4 Jalankan migration dan seeder

`init.sh` menjalankan migration ketika container start, tetapi migration dapat terjadi sebelum MySQL benar-benar siap. Karena itu, jalankan perintah berikut setelah container aktif:

```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

### 8.5 Buka aplikasi

- Aplikasi: http://localhost:8000
- Halaman login: http://localhost:8000/login
- phpMyAdmin: http://localhost:8001

Jika `localhost` bermasalah di browser VS Code, gunakan:

```text
http://127.0.0.1:8000/login
```

## 9. Konfigurasi Environment

File utama adalah `laravel_app/.env`. Gunakan `laravel_app/.env.example` sebagai template. Salin template tersebut sebelum menjalankan aplikasi baru:

```bash
cp laravel_app/.env.example laravel_app/.env
docker compose exec app php artisan key:generate
```

Sesuaikan placeholder `your_database_name`, `your_database_user`, dan `your_database_password` jika menjalankan database di luar konfigurasi Docker Compose. Untuk konfigurasi Compose proyek ini, nilai koneksi database akan disediakan oleh environment service `app`.

Konfigurasi database di dalam container:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

`DB_HOST` harus bernilai `mysql`, bukan `localhost`, karena `mysql` adalah nama service Docker.

Konfigurasi development:

```env
APP_ENV=local
APP_DEBUG=true
SESSION_DRIVER=file
CACHE_STORE=array
```

Jangan memasukkan file `.env` atau password production ke repository publik.

## 10. Akun Demo

```text
Email    : imam123@gmail.com
Password : admin123
```

Ganti password tersebut untuk lingkungan selain development.

## 11. Perintah Operasional

### Container

```bash
docker compose up -d
docker compose up -d --build
docker compose down
docker compose ps
docker compose logs -f
docker compose logs -f app
docker compose restart app
```

`docker compose down` tidak menghapus named volume. Data database tetap tersimpan.

### Artisan

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

`migrate:fresh --seed` menghapus semua tabel dan data aplikasi. Gunakan hanya jika memang ingin reset database.

### Composer dan shell container

```bash
docker compose exec app composer install
docker compose exec app composer validate
docker compose exec app bash
```

### Database

Masuk ke MySQL:

```bash
docker compose exec mysql mysql -ularavel -psecret laravel_db
```

Informasi phpMyAdmin:

```text
URL      : http://localhost:8001
Server   : mysql
Username : laravel
Password : secret
```

## 12. Siklus Startup `init.sh`

File `docker/php/init.sh` dijalankan sebagai entrypoint container aplikasi. Prosesnya:

1. Memastikan source Laravel tersedia.
2. Menyesuaikan `.env` dengan environment Docker.
3. Menyiapkan folder storage dan cache.
4. Memasang dependency Composer.
5. Menjalankan migration.
6. Membuat link storage.
7. Membersihkan cache pada mode development.
8. Menjalankan Apache foreground.

Seeder tidak dijalankan otomatis oleh script. Jalankan secara eksplisit:

```bash
docker compose exec app php artisan db:seed --force
```

Hal ini mencegah data contoh dibuat ulang setiap kali container restart.

## 13. Struktur Database

### Tabel `users`

Digunakan untuk login pengguna Laravel.

### Tabel `kategori`

Kolom utama:

- `id`
- `nama_kategori`
- `created_at`
- `updated_at`

### Tabel `barang`

Kolom utama:

- `id`
- `kode_barang`
- `nama`
- `kategori_id`
- `jumlah_stock`
- `lokasi`
- `tanggal_kategori`
- `gambar`
- `created_at`
- `updated_at`

`kategori_id` memiliki foreign key ke tabel `kategori` dan menggunakan cascade delete.

## 14. Route Aplikasi

Route publik:

```text
GET  /          Redirect ke /login
GET  /login     Form login
POST /login     Proses login
POST /logout    Proses logout
```

Route yang memerlukan login:

```text
GET|... /dashboard
GET|... /barang
GET|... /kategori
```

Detail route dapat diperiksa dengan:

```bash
docker compose exec app php artisan route:list
```

## 15. Troubleshooting

### 15.1 Container aplikasi berhenti dengan `init.sh: no such file or directory`

Pastikan `docker/php/init.sh` menggunakan line ending Linux (`LF`), bukan Windows (`CRLF`). File `.gitattributes` proyek sudah menetapkan:

```text
*.sh text eol=lf
```

Kemudian rebuild:

```bash
docker compose down
docker compose up -d --build
```

### 15.2 MySQL berhenti dengan error permission

Jangan gunakan mount langsung `./mysql_data:/var/lib/mysql` pada Windows. Konfigurasi final sudah memakai named volume `mysql-data`.

Periksa:

```bash
docker compose ps -a
docker compose logs mysql
```

### 15.3 `ERR_EMPTY_RESPONSE`

Periksa container:

```bash
docker compose ps -a
docker compose logs --tail=100 app
docker compose logs --tail=100 mysql
```

Pastikan Apache sudah berjalan dan MySQL berstatus `Up`. Uji dari WSL:

```bash
curl -I http://127.0.0.1:8000/login
```

Gunakan `http://127.0.0.1:8000/login` jika `localhost` pada browser tertentu bermasalah.

### 15.4 Database kosong

Jalankan:

```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

### 15.5 Error koneksi `getaddrinfo for mysql failed`

Pastikan container MySQL aktif:

```bash
docker compose ps
docker compose logs mysql
```

Tunggu sampai MySQL siap, kemudian ulangi migration:

```bash
docker compose exec app php artisan migrate --force
```

### 15.6 Error `chmod(): Operation not permitted`

Error ini biasanya terjadi jika `storage` atau `bootstrap/cache` dipasang langsung dari filesystem Windows. Konfigurasi final sudah menggunakan:

```yaml
- laravel-storage:/var/www/html/storage
- laravel-bootstrap-cache:/var/www/html/bootstrap/cache
```

Recreate container:

```bash
docker compose down
docker compose up -d --build
```

### 15.7 Aplikasi lambat

- Jalankan proyek dari filesystem WSL seperti `~/projects/Laravel_docker`, bukan `/mnt/c`.
- Hindari menjalankan Composer pada setiap request.
- Gunakan `docker compose logs` untuk mencari error berulang.
- Pastikan hanya query yang diperlukan yang dijalankan.
- Jangan mengurangi `BCRYPT_ROUNDS` hanya demi mempercepat login karena berpengaruh pada keamanan password.

## 16. Backup dan Penghapusan Data

Lihat daftar volume:

```bash
docker volume ls
```

Backup database:

```bash
docker compose exec -T mysql mysqldump -ularavel -psecret laravel_db > backup.sql
```

Restore database:

```bash
cat backup.sql | docker compose exec -T mysql mysql -ularavel -psecret laravel_db
```

Jangan menjalankan `docker compose down -v` kecuali memang ingin menghapus named volume dan seluruh data database/runtime.

## 17. Catatan Pengembangan

- Edit kode Laravel di dalam folder `laravel_app`.
- Setelah perubahan PHP atau Blade, refresh browser.
- Setelah perubahan konfigurasi `.env`, jalankan:

  ```bash
  docker compose exec app php artisan optimize:clear
  ```

- Setelah perubahan Dockerfile atau konfigurasi build, jalankan:

  ```bash
  docker compose up -d --build
  ```

- Setelah perubahan database migration, jalankan:

  ```bash
  docker compose exec app php artisan migrate
  ```

## 18. Pengujian

Test menggunakan PHPUnit bawaan Laravel dan database SQLite in-memory. Test tidak menggunakan database Docker development sehingga data development tetap aman.

Test yang tersedia meliputi:

- Repository barang: filter, relasi kategori, create, update, dan delete.
- Repository kategori: pagination dan urutan data.
- Service barang: upload serta penghapusan gambar.
- Service kategori: delegasi ke repository melalui dependency injection.
- Autentikasi: halaman login, login berhasil, logout, dan kredensial tidak valid.
- Authorization route: guest tidak dapat mengakses dashboard, barang, dan kategori.
- Feature barang: create, upload gambar, pencarian, dan filter kategori.
- Feature kategori: create, update, dan delete.

Jalankan seluruh test dari terminal Ubuntu/WSL:

```bash
docker compose up -d --build
docker compose exec app php artisan test
```

Jalankan test tertentu:

```bash
docker compose exec app php artisan test tests/Unit
docker compose exec app php artisan test tests/Feature
docker compose exec app php artisan test tests/Unit/BarangRepositoryTest.php
```

Konfigurasi test berada di `phpunit.xml` dan menggunakan:

```text
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
SESSION_DRIVER=array
CACHE_STORE=array
```

Image PHP Docker memasang ekstensi `pdo_sqlite` agar konfigurasi test tersebut dapat berjalan.

## 19. Lisensi dan Keamanan

Konfigurasi password pada dokumentasi ini ditujukan untuk development lokal. Gunakan secret yang aman untuk production, matikan `APP_DEBUG`, gunakan HTTPS, dan jangan commit `.env` ke repository publik.
