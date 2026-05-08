# Dian POS - Sistem Kasir Pintar

Dian POS adalah aplikasi sistem Point of Sale (POS) berbasis web yang dirancang untuk memudahkan pengelolaan transaksi, stok barang, dan pemantauan pendapatan toko secara real-time. Aplikasi ini dibangun dengan fokus pada kemudahan penggunaan (UX) dan performa yang optimal.

## 🚀 Fitur Utama

- **Kasir Pintar**: Antarmuka kasir yang responsif untuk memproses pesanan dengan cepat, manajemen keranjang belanja, dan kalkulasi pembayaran otomatis.
- **Manajemen Stok**: Kelola katalog produk, pantau jumlah stok fisik, dan dapatkan peringatan otomatis untuk stok yang hampir habis.
- **Riwayat Transaksi**: Pantau semua aktivitas penjualan dengan detail item, filter rentang waktu, dan ringkasan pendapatan harian/bulanan.
- **Export Data**: Kemudahan untuk mengekspor riwayat transaksi ke format CSV untuk kebutuhan laporan keuangan.
- **Keamanan**: Sistem autentikasi pengguna dan fitur ganti password untuk menjaga keamanan akses data toko.

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan teknologi modern:

- **Framework**: [Laravel 12.x](https://laravel.com) (PHP 8.2+)
- **Frontend**: [Tailwind CSS 4.x](https://tailwindcss.com) & Vite
- **Database**: MySQL / SQLite
- **Icons**: Lucide Icons
- **Tooling**: Composer & NPM

## 📋 Langkah-langkah Instalasi

Ikuti langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Clone Repositori
```bash
git clone https://github.com/username/dian-pos.git
cd dian-pos
```

### 2. Instalasi Dependency
Instal library PHP menggunakan Composer:
```bash
composer install
```

Instal library JavaScript menggunakan NPM:
```bash
npm install
```

### 3. Konfigurasi Lingkungan
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_anda
DB_PASSWORD=password_anda
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Migrasi Database
Jalankan migrasi untuk membuat struktur tabel:
```bash
php artisan migrate --seed
php artisan storage:link
```
Dan jalankan Vite untuk aset frontend (di terminal terpisah):
```bash
npm run build
npm run dev
```
### 6. Menjalankan Aplikasi
Jalankan server pengembangan Laravel:
```bash
php artisan serve
```


Aplikasi sekarang dapat diakses melalui browser di `http://127.0.0.1:8000`.

## 📄 Lisensi
Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
