# Sistem Informasi Perpustakaan Berbasis Web
Repositori ini berisi source code untuk Sistem Informasi Manajemen Perpustakaan yang dikembangkan menggunakan CodeIgniter 4. Proyek ini dirancang untuk membantu perpustakaan dalam mengelola data buku, anggota, dan transaksi peminjaman/pengembalian secara efisien.
**Fitur Utama**
* **Manajemen Buku**: Tambah, edit, hapus, dan pencarian data buku.
* **Manajemen Anggota**: Registrasi, autentikasi, dan pengelolaan data anggota.
* **Peminjaman dan Pengembalian**: Pencatatan serta pelacakan transaksi.
* **Notifikasi OTP**: Proses verifikasi saat pendaftaran anggota.
* **User-friendly Interface**: Tampilan antarmuka yang mudah digunakan.
Teknologi yang Digunakan
* Framework: CodeIgniter 4
* Database: MySQL
* Frontend: Bootstrap (atau framework pilihan lainnya)
* Environment: PHP 8+
Panduan Instalasi
1. **Clone repositori**:
    ```bash
    git clone https://github.com/username/repository.git
    ```
2. **Install dependencies**: Pastikan Composer terpasang di sistem Anda, lalu jalankan: 
   ```bash
   composer install
   ```
3. **Konfigurasi Database**:
    * Ubah file .env sesuai dengan konfigurasi database Anda.
    * Jalankan migrasi database:
   ```bash 
   php spark migrate
   ```
4. **Menjalankan Server Lokal**: Jalankan perintah berikut untuk memulai server pengembangan:
   ```bash 
   php spark serve
   ```
6. **Akses aplikasi melalui browser** di http://localhost:8080.
   
**Catatan**
Proyek ini merupakan sistem manajemen perpustakaan yang dapat diintegrasikan ke lingkungan kerja nyata maupun digunakan sebagai pembelajaran. Jika Anda memiliki saran atau menemukan bug, silakan kirimkan issue atau pull request ke repositori ini.


Semoga ini membantu! Anda bisa menyesuaikan nama pengguna GitHub dan URL repositori sesuai kebutuhan Anda. 😊
