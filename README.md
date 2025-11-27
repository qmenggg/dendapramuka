# 🏕️ ScoutTax — Aplikasi Denda Pramuka

**ScoutTax** adalah aplikasi berbasis web untuk mencatat, mengelola, dan merekap denda Pramuka secara digital.  
Aplikasi ini dibuat untuk menggantikan pencatatan manual yang sering tidak konsisten dan sulit direkap, terutama saat mengelola absensi ALPHA dan denda mingguan.

---

## 📌 Fitur Utama

### 🔐 1. Sistem Login & Role
- Sistem login menggunakan PHP Session
- Role: **Admin**, **Viewer**
- Setiap role memiliki batasan akses halaman
- Proteksi URL langsung dengan session

### 👥 2. Manajemen Data Siswa
- Tambah, edit, hapus siswa
- Data meliputi nama, kelas, sangga, NIS
- Dashboard siswa lengkap

### 📅 3. Pencatatan Absensi & Denda
- Input denda manual & otomatis
- Pencatatan otomatis ALPHA → masuk ke denda
- Perhitungan total denda per siswa
- Riwayat denda lengkap

### 📊 4. Dashboard Interaktif
Menggunakan
- Grafik absensi ALPHA
- Statistik denda siswa
- Monitoring mingguan & bulanan

### 🧾 5. Rekap & Export PDF
- Rekap harian
- Rekap bulanan
- Export PDF menggunakan **mPDF**
- Layout rapih & siap cetak

### 🗄️ 6. Database MySQL
- Struktur tabel rapi (users, siswa, absensi, denda)
- Relasi sesuai kebutuhan operasional

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Fungsi |
|----------|--------|
| **PHP 8+** | Backend, autentikasi, business logic |
| **MySQL** | Database utama |
| **Bootstrap 5** | Tampilan admin panel |
| **Chart.js** | Visualisasi grafik |
| **mPDF** | Export PDF |
| **FontAwesome** | Ikon |
| **Composer** | Library management |
| **Git & GitHub** | Version Control |

---

## 📂 Struktur Folder Project

/assets
/css
/js
/img

/auth
login.php
logout.php

/includes
koneksi.php
navbar.php
sidebar.php
session.php

/pages
absensi.php
denda.php
siswa.php
rekap.php
dashboard.php

/database
dendapramuka.sql

/vendor
(folder composer untuk mPDF, autoload)

yaml
Salin kode

---

## ⚙️ Instalasi & Setup

### 1️⃣ Clone repository

```sh
git clone https://github.com/iiqbaael/dendapramuka.git
2️⃣ Pindahkan ke folder server lokal
swift
Salin kode
C:/xampp/htdocs/dendapramuka/
3️⃣ Import database
Import file SQL:

pgsql
Salin kode
database/dendapramuka.sql
Melalui:

arduino
Salin kode
http://localhost/phpmyadmin
4️⃣ Konfigurasi koneksi database
Edit file:

bash
Salin kode
includes/koneksi.php
Isi:

php
Salin kode
<?php
$db = mysqli_connect("localhost", "root", "", "dendapramuka");
if (!$db) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
5️⃣ Jalankan aplikasi
Akses melalui browser:

arduino
Salin kode
http://localhost/dendapramuka
🔑 Akun Default
pgsql
Salin kode
Username : iqbal
Password : 123
Role     : admin
Disarankan mengganti password melalui database.


Contoh:

Dashboard

Halaman denda

Rekap PDF

Login screen

🤝 Kontribusi
Kontribusi sangat terbuka untuk:

Penambahan fitur laporan mingguan

Auto-Reminder pembayaran denda

Mode Gelap / Terang

Export Excel

Cara kontribusi:

Fork repository

Buat branch baru

css
Salin kode
git checkout -b fitur-baru
Commit perubahan

sql
Salin kode
git commit -m "Tambah fitur X"
Push branch

perl
Salin kode
git push origin fitur-baru
Buat Pull Request

📜 Lisensi
Project ini bersifat Open Source dan boleh digunakan untuk keperluan pembelajaran, sekolah, dan pengembangan internal.

👤 Author
Iqbal
SMK — PPLG
GitHub: https://github.com/iiqbaael
