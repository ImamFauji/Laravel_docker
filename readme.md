# Baca Saya 
## Detail Skema 
Ini adalah skema docker compose yang bisa digunakan untuk menjalankan laravel. 
Beberapa program yang digunakan adalah:
- Apache
- PHP 8.2
- Laravel Versi 12
- MySQL 8.0

## Cara Menggunakan
1. Pastikan anda sudah menginstall docker dan docker-compose di komputer anda.
2. Download atau clone repository ini.
3. Buka terminal dan masuk ke direktori tempat anda menyimpan file ini.
4. Jalankan perintah berikut untuk membangun dan menjalankan container:
   ```bash
   docker-compose up -d
   ```
5. Setelah container berjalan, buka browser anda dan akses `http://localhost:8000` untuk melihat aplikasi Laravel yang sedang berjalan.
6. Jangan lupa untuk mengatur file `.env` sesuai dengan kebutuhan anda, terutama bagian database.
 
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
2. 