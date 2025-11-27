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

🖥️ CARA AMBIL PROJECT DARI GITHUB KE LAPTOP LAIN
1️⃣ Pastikan Git sudah ter-install

Cek dulu:

git --version


Kalau belum ada, install Git for Windows.

2️⃣ Clone project kamu

Masuk folder manapun yang kamu mau (contoh: C:\xampp\htdocs)

Lalu jalankan:

git clone https://github.com/iiqbaael/dendapramuka.git


Ini akan membuat folder:

dendapramuka/

3️⃣ Masuk ke folder project
cd dendapramuka

4️⃣ Cek branch apa saja yang ada
git branch -a


Output akan muncul:

main
remotes/origin/main
remotes/origin/feature/xxx
remotes/origin/dev

5️⃣ Pindah ke branch yang kamu mau kerja

Kalau mau ke main:

git checkout main


Kalau mau kerja di branch dev:

git checkout dev


Kalau mau ambil branch fitur:

git checkout feature/nama-branch

6️⃣ Kalau mau coding → Buat BRANCH BARU

Biar aman dan ga ngerusak project.

git checkout -b feature/nama-fitur-baru

7️⃣ Kalau sudah selesai coding → Push lagi
git add .
git commit -m "pesan perubahan"
git push -u origin feature/nama-fitur-baru

✅ LANGKAH NYAMBUNGIN DATABASE DI LAPTOP BARU
1️⃣ Buka XAMPP → Start MySQL

Pastikan:

Apache ✔️

MySQL ✔️

2️⃣ Buka phpMyAdmin

Akses:

http://localhost/phpmyadmin/

3️⃣ Buat database baru

Klik New → buat database dengan nama yang sama seperti di koneksi.php.

Misal di project kamu file koneksi.php isinya:

$db = mysqli_connect("localhost", "root", "", "dendapramuka");


Berarti kamu harus buat database:

➡️ dendapramuka

Setelah buat → klik database itu.

4️⃣ Import file SQL

Cari file database kamu di:

dendapramuka/db/namafile.sql


Langkah:

Klik database yang barusan dibuat

Klik tab Import

Klik Choose File

Pilih file SQL (misal dendapramuka/db/dendapramuka.sql)

Klik Go

Kalau berhasil → tabel-tabel langsung muncul.

5️⃣ Pastikan koneksi.php sesuai laptop baru

Biasanya tetap sama:

$db = mysqli_connect("localhost", "root", "", "dendapramuka");


Kalau temanmu pakai password MySQL (jarang), ubah:

$db = mysqli_connect("localhost", "root", "password_mysql", "dendapramuka");

6️⃣ Jalankan project

Taruh folder project di:

C:\xampp\htdocs\dendapramuka


Lalu buka:

http://localhost/dendapramuka/home.php

🎉 Beres!

👤 Author
Iqbal
SMK — PPLG
GitHub: https://github.com/iiqbaael
