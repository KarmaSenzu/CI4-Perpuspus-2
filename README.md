# CodeIgniter 4 Application Starter
Sistem Informasi Perpustakaan Berbasis Web
Repositori ini berisi source code untuk Sistem Informasi Manajemen Perpustakaan yang dikembangkan menggunakan CodeIgniter 4. Proyek ini dirancang untuk membantu perpustakaan dalam mengelola data buku, anggota, dan transaksi peminjaman/pengembalian secara efisien.

Fitur Utama
Manajemen Buku: Tambah, edit, hapus, dan pencarian data buku.
Manajemen Anggota: Registrasi, autentikasi, dan pengelolaan data anggota.
Peminjaman dan Pengembalian: Pencatatan serta pelacakan transaksi.
Notifikasi OTP: Proses verifikasi saat pendaftaran anggota.
User-friendly Interface: Tampilan antarmuka yang mudah digunakan.
Teknologi yang Digunakan
Framework: CodeIgniter 4
Database: MySQL
Frontend: Bootstrap (atau framework pilihan lainnya)
Environment: PHP 8+
Panduan Instalasi
Clone repositori:

bash
Salin kode
git clone https://github.com/username/repository.git
Install dependencies:
Pastikan Composer terpasang di sistem Anda, lalu jalankan:

bash
Salin kode
composer install
Konfigurasi Database:

Ubah file .env sesuai dengan konfigurasi database Anda.
Jalankan migrasi database:
bash
Salin kode
php spark migrate
Menjalankan Server Lokal:
Jalankan perintah berikut untuk memulai server pengembangan:

bash
Salin kode
php spark serve
Akses aplikasi melalui browser di http://localhost:8080.
