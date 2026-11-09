# SIPALA
### Sistem Informasi Peminjaman Alat

SIPALA (Sistem Informasi Peminjaman Alat) adalah aplikasi berbasis web yang dirancang untuk mengelola inventaris alat, proses peminjaman dan pengembalian, serta memantau kondisi dan ketersediaan alat di lingkungan gudang. Aplikasi ini bertujuan untuk meningkatkan efisiensi, ketertiban, dan akurasi pengelolaan inventaris. SIPALA telah memiliki fungsionalitas utama dan akan terus dikembangkan untuk meningkatkan fitur serta kualitas layanan.

---

## 📌 Fitur Aplikasi

- Dashboard Gudang
- Manajemen Data Alat
- Peminjaman Alat
- Pengembalian Alat
- Riwayat Peminjaman
- Riwayat Pengembalian
- Monitoring Kondisi Alat
- PIN Akses Fitur

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 12, PHP 8.2+, Composer
- **Frontend:** HTML5, CSS3, Bootstrap 5, AdminLTE, JavaScript.
- **Database:** MySQL.
- **Tools:** Visual Studio Code, Laragon, Git, GitHub.

---

## ⚙️ Persyaratan Sistem

Sebelum melakukan instalasi, pastikan perangkat telah memiliki:

- PHP sesuai persyaratan Laravel 12.
- Composer.
- MySQL.
- Git.

---

## 🚀 Instalasi dan Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan SIPALA pada lingkungan lokal (*localhost*).

### 1. Clone Repository

Clone repository SIPALA dari GitHub:

```bash
git clone https://github.com/DevialdiMp/SIPALA-GUDANG.git
```

Masuk ke direktori project:

```bash
cd sipala-gudang
```

### 2. Install Dependency

Jalankan perintah berikut untuk menginstal dependency Laravel:

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

**Windows:**

```bash
copy .env.example .env
```

**Linux / macOS:**

```bash
cp .env.example .env
```

### 4. Konfigurasi Database

Buat database baru melalui MySQL atau phpMyAdmin.

Contoh nama database:

```text
dbsipala
```

Kemudian buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbsipala
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi MySQL masing-masing.

### 5. Generate Application Key

Jalankan perintah berikut untuk membuat application key Laravel:

```bash
php artisan key:generate
```

### 6. Migrasi Database

Jalankan migrasi untuk membuat struktur tabel database:

```bash
php artisan migrate
```

Jika repository menyediakan seeder dan memang diperlukan, jalankan:

```bash
php artisan migrate --seed
```

### 7. Konfigurasi PIN Akses Fitur

SIPALA menggunakan mekanisme **PIN Akses Fitur** sebagai solusi keamanan sementara untuk membatasi akses terhadap fitur-fitur tertentu, seperti pengelolaan data staf, data alat, dan fitur manajemen lainnya.

Mekanisme ini diterapkan karena SIPALA dirancang untuk digunakan secara bersama oleh seluruh karyawan di lingkungan gudang, tanpa mengharuskan setiap karyawan melakukan login dan logout secara berulang menggunakan akun yang berbeda.

Dengan adanya PIN Akses, fitur-fitur tertentu tetap memiliki lapisan perlindungan tambahan, sementara karyawan dapat menggunakan aplikasi secara bergantian dengan lebih praktis.

**Catatan:** Mekanisme PIN Akses ini masih bersifat sementara dan akan dievaluasi seiring dengan pengembangan sistem. PIN tersebut bukan merupakan pengganti sistem autentikasi pengguna secara individual.

PIN Akses dibuat melalui Laravel Tinker, kemudian hasil hash PIN disimpan ke dalam file `.env`.

**Langkah-langkah konfigurasi:**

**A. Jalankan Laravel Tinker**

```bash
php artisan tinker
```

**B. Generate Hash PIN**

Masukkan perintah berikut:

```php
Hash::make('123456')
```

Ganti `123456` dengan PIN yang ingin digunakan.

**C. Salin Hasil Hash**

Salin hasil hash yang ditampilkan oleh Laravel Tinker.

**D. Masukkan Hash ke File `.env`**

Tambahkan konfigurasi berikut:

```env
SIPALA_MANAGEMENT_PIN_HASH='MASUKKAN_HASH_PIN_DI_SINI'
```

Ganti `MASUKKAN_HASH_PIN_DI_SINI` dengan hasil hash yang diperoleh dari Laravel Tinker.

**E. Bersihkan Cache Konfigurasi**

Setelah menyimpan perubahan pada file `.env`, jalankan:

```bash
php artisan config:clear
```

**Catatan:**
- Setiap instalasi SIPALA perlu mengonfigurasi PIN Akses secara mandiri.
- Gunakan PIN yang aman dan tidak mudah ditebak.
- Simpan hash PIN hanya di dalam file `.env`.

### 8. Jalankan Aplikasi

Setelah seluruh proses instalasi dan konfigurasi selesai, jalankan aplikasi menggunakan perintah:

```bash
php artisan serve
```

---

## 🚧 Status Pengembangan

**SIPALA masih dalam tahap pengembangan (Under Development).**

Beberapa aspek aplikasi masih dapat mengalami perubahan, penyesuaian, dan penyempurnaan, baik dari sisi fitur, antarmuka, keamanan, maupun alur proses bisnis.

Masukan dan saran sangat terbuka untuk mendukung pengembangan aplikasi ini ke depannya.

---

## 👨‍💻 Developer

**DEVMP Solutions**

SIPALA — Sistem Informasi Peminjaman Alat.
=======
# SIPALA-GUDANG
SIPALA (Sistem Informasi Peminjaman Alat) adalah aplikasi berbasis web yang dirancang untuk mengelola inventaris alat, proses peminjaman dan pengembalian, serta memantau kondisi dan ketersediaan alat di lingkungan gudang. SIPALA telah memiliki fungsionalitas utama dan akan terus dikembangkan untuk meningkatkan fitur serta kualitas layanan.

