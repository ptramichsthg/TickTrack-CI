# TickTrack - Sistem Helpdesk dan Ticketing

TickTrack adalah platform manajemen tiket pengaduan pelanggan berbasis web yang dikembangkan menggunakan framework PHP CodeIgniter 4 dan Tailwind CSS. Aplikasi ini dirancang untuk memfasilitasi komunikasi antara klien dan administrator dalam menangani berbagai masalah atau layanan melalui sistem tiket yang terstruktur.

## Tim Pengembang (Tugas Besar)

Proyek ini dikembangkan oleh:
1. **Arnest Suhendra** (2350081054)
2. **Bagas Ibnu Abdillah** (2350081074)
3. **Putra Michael Sitohang** (2350081087)

## Fitur Utama

### 1. Portal Pengguna (Klien)
* Pendaftaran dan Autentikasi Akun.
* Pembuatan Tiket Pengaduan (dilengkapi dengan penentuan prioritas dan kategori).
* Pelacakan Status Tiket (Buka, Diproses, Selesai, Ditolak).
* Sistem Komentar/Diskusi pada setiap tiket.
* Pengaturan Profil Pengguna.

### 2. Portal Administrator
* Dashboard Analitik dengan visualisasi grafik (Chart.js) untuk statistik tiket.
* Manajemen Tiket (Pembaruan status, pemberian respons, dan penyelesaian tiket).
* Manajemen Pengguna (Fungsi CRUD untuk seluruh akun pengguna yang terdaftar).
* Pemantauan aktivitas sistem secara keseluruhan.

### 3. Fitur Sistem Tambahan
* Notifikasi Polling Real-time: Sistem lonceng pemberitahuan untuk pembaruan tiket terbaru.
* Role-based Access Control (RBAC): Pemisahan hak akses yang ketat antara Admin dan Pengguna biasa.
* Proteksi Keamanan: Perlindungan CSRF bawaan CodeIgniter pada seluruh formulir.
* Desain Antarmuka Responsif: Tampilan yang dioptimalkan untuk perangkat seluler, tablet, dan komputer menggunakan Tailwind CSS.
* Lokalisasi: Seluruh antarmuka telah diterjemahkan secara utuh ke dalam Bahasa Indonesia.

## Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut sebelum melakukan instalasi:
* PHP versi 8.1 atau lebih baru.
* Ekstensi PHP: intl, mbstring, json, mysqlnd.
* Composer (Manajer Dependensi PHP).
* MySQL atau MariaDB.

## Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi TickTrack di server lokal Anda:

1. Kloning Repositori
Jalankan perintah ini di terminal Anda:
git clone https://github.com/ptramichsthg/TickTrack-CI.git
cd TickTrack-CI

2. Instalasi Dependensi
Jalankan Composer untuk mengunduh semua pustaka yang dibutuhkan:
composer install

3. Konfigurasi Lingkungan (Environment)
* Salin file `env` menjadi `.env`.
* Buka file `.env` dan atur konfigurasi berikut:
  CI_ENVIRONMENT = development
  app.baseURL = 'http://localhost:8080/'
  database.default.hostname = localhost
  database.default.database = ticktrack_ci4
  database.default.username = root
  database.default.password = 
  database.default.DBDriver = MySQLi

4. Migrasi dan Seeding Basis Data
Jalankan perintah berikut untuk membangun struktur tabel dan memasukkan data awal (akun Admin):
php spark migrate
php spark db:seed DatabaseSeeder

5. Menjalankan Server Lokal
Mulai server bawaan CodeIgniter:
php spark serve

Aplikasi sekarang dapat diakses melalui browser pada alamat http://localhost:8080.

## Informasi Akun Uji Coba (Default)

Anda dapat masuk menggunakan kredensial yang dihasilkan oleh Database Seeder:
* Akun Admin:
  Email: admin@ticktrack.com
  Password: password

## Teknologi yang Digunakan

* Backend: CodeIgniter 4
* Frontend: Tailwind CSS, Feather Icons, Chart.js
* Database: MySQL

## Lisensi

Proyek ini bersifat sumber terbuka (Open Source) dan bebas digunakan serta dimodifikasi untuk kebutuhan pembelajaran maupun komersial.
