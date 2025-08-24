# Baca Saya 
## Detail Skema 
Ini adalah skema docker compose yang bisa digunakan untuk menjalankan laravel. 
Beberapa program yang digunakan adalah:
- Apache
- Versi PHP    : 8.2
- Backend      : Laravel Versi 12
- Database     : MySQL 8.0
- Frontend UI  : Blade + Bootstrap
- Autentikasi  : Manual auth
- Hosting      : Localhost
- CI/CD        : Github

## Cara Install
1. Masuk ke Repository GitHub : https://github.com/dirumahrafif/laravel-docker.git
2. Kemudian Download/Clone Repository tersebut di CMD/Gitbash :
   ```bash
   git clone https://github.com/dirumahrafif/laravel-docker.git
   ```
3. Jika sudah, pastikan anda sudah menginstall docker dan docker-compose di komputer anda.
5. Buka terminal CMD/Gitbash dan masuk ke direktori tempat anda menyimpan file ini.
6. Jalankan perintah berikut untuk membangun dan menjalankan container:
   ```bash
   docker-compose up -d
   ```
7. Setelah container berjalan, buka browser anda dan akses `http://localhost:8000` untuk melihat aplikasi Laravel yang sedang berjalan.
8. Jangan lupa untuk mengatur file `.env` sesuai dengan kebutuhan anda, terutama bagian database.

# Command untuk Docker
1. docker-compose up -d --build
2. docker-compose up -d
3. docker-compose up
# untuk seeder :
1. docker exec app php artisan db:seed --force
# untuk specific seeder (for example CategorySeeder):
2. docker exec app php artisan db:seed --class=CategorySeeder
# (Optional) Run fresh migration + seed
If you want to refresh all migrations and then seed:
3. docker exec app php artisan migrate:fresh --seed
# untuk config :
1. docker compose exec app php artisan cache:clear  
2. docker compose exec app php artisan config:clear  
3. docker compose exec app php artisan route:clear  
4. docker compose exec app php artisan view:clear  

# Remove .Git for unlink author repository (command in diretory project)
1. rm -rf .git

===============================================================================

# Struktur Data
1. Tabel Barang :
   - id
   - kode_barang
   - nama_barang
   - kategori_id
   - jumlah_stok
   - lokasi
   - tanggal_kategori
   - gambar (path file laravel storage)
   - created_at, update_at
2. Tabel Kategori :
   - id
   - nama_kategori
   - created_at, update_at

# Daftar Fitur yang sudah ditambahkan
1. Login dan Logout
2. CRUD Barang
2. CRUD Kategori
3. Upload Gambar Barang
4. Search & Filter Barang

# Akun Dummy (Akun yang telah dibuat dari Seeder)
Email    : admin_elitech14@gmail.com
Password : admin123

# Screenshot UI
1. UI Dashboard         : ![alt text](laravel_app/storage/app/public/UI_Dashboard.png)
2. UI Barang            : ![alt text](laravel_app/storage/app/public/UI_Barang.png)
3. UI Edit Barang       : ![alt text](laravel_app/storage/app/public/UI_Edit_Barang.png)
4. UI Create Barang     : ![alt text](laravel_app/storage/app/public/UI_Create_Barang.png)
5. UI Kategori          : ![alt text](laravel_app/storage/app/public/UI_Kategori.png)
6. UI Edit Kategori     : ![alt text](laravel_app/storage/app/public/UI_Edit_Kategori.png)
7. UI Create Kategori   : ![alt text](laravel_app/storage/app/public/UI_Create_Kategori.png)
8. UI Login             : ![alt text](laravel_app/storage/app/public/UI_Login.png)