<div align="center">
  <a href="https://github.com/username/booksy">
    <img src="assets/images/logo-placeholder.png" alt="Logo Booksy" width="80" height="80">
  </a>

  <h1 align="center">Booksy</h1>

  <p align="center">
    <strong>Sistem Perpustakaan Hybrid: Cari Online, Ambil Fisik.</strong>
    <br />
    Solusi modern untuk manajemen peminjaman buku dengan teknologi QR Code.
    <br />
    <br />
    <a href="#cara-instalasi"><strong>Lihat Demo</strong></a> ·
    <a href="https://github.com/username/booksy/issues"><strong>Laporkan Bug</strong></a> ·
    <a href="https://github.com/username/booksy/pulls"><strong>Request Fitur</strong></a>
  </p>
</div>

<div align="center">

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Database](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Active-success?style=for-the-badge)

</div>

---

## 📖 Daftar Isi
- [Tentang Proyek](#-tentang-proyek)
- [Masalah & Solusi](#-masalah--solusi)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Folder](#-struktur-folder)
- [Cara Instalasi](#-cara-instalasi)
- [Cara Penggunaan](#-cara-penggunaan)
- [Tim Pengembang](#-tim-pengembang)
- [Lisensi](#-lisensi)

---

## 🧐 Tentang Proyek

**Booksy** adalah aplikasi manajemen perpustakaan berbasis web yang dirancang untuk menjembatani kemudahan digital dengan koleksi fisik. Aplikasi ini memungkinkan anggota perpustakaan untuk melakukan pencarian katalog dan reservasi buku dari mana saja, memastikan buku yang diinginkan tersedia saat mereka tiba di lokasi.

### 💡 Masalah & Solusi
| Masalah Konvensional | Solusi Booksy |
| :--- | :--- |
| **Ketidakpastian Stok:** Pengunjung sering kehabisan buku saat tiba di lokasi. | **Real-time Booking:** Mengunci stok buku secara digital sebelum kedatangan. |
| **Antrean Panjang:** Administrasi pencatatan manual memakan waktu. | **QR Code Ticket:** Scan tiket digital untuk serah terima buku dalam hitungan detik. |
| **Pencarian Sulit:** Katalog fisik sulit ditelusuri. | **Smart Search:** Pencarian cepat berdasarkan judul, penulis, atau kategori. |

---

## 🚀 Fitur Utama

### Untuk Pengguna (Member)
* ✅ **Cek Stok Real-time:** Menampilkan ketersediaan buku secara akurat.
* ✅ **Booking Online:** Reservasi buku favorit tanpa takut diambil orang lain.
* ✅ **Tiket QR Code:** Bukti peminjaman digital yang unik dan aman.
* ✅ **Riwayat Peminjaman:** Pantau status buku yang sedang dipinjam dan histori pengembalian.

### Untuk Pustakawan (Admin)
* 🛡️ **Validasi Tiket:** Scan QR Code pengguna untuk memproses peminjaman/pengembalian.
* 📊 **Manajemen Buku (CRUD):** Tambah, edit, dan hapus data buku dengan mudah.
* 👥 **Kelola Anggota:** Pantau aktivitas pengguna dan pesan masuk.

---

## 🛠 Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan *stack* teknologi yang ringan, cepat, dan mudah di-deploy di lingkungan kampus/lokal.

* **Backend:** PHP (Native)
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Scripting:** JavaScript (Vanilla) & QR Code API
* **Server:** Apache (via XAMPP)

---

## 📂 Struktur Folder

Berikut adalah gambaran umum struktur direktori proyek Booksy:

```text
booksy/
├── admin/              # Halaman dashboard admin
│   ├── admin_templates/# Header/Footer khusus admin
│   ├── books.php       # Manajemen buku
│   ├── users.php       # Manajemen user
│   └── ...
├── assets/             # File statis (CSS, JS, Gambar)
│   ├── css/
│   └── img/
├── templates/          # Header/Footer umum (User)
├── db.php              # Konfigurasi koneksi database
├── index.php           # Landing page & Katalog
├── catalog.php         # Halaman pencarian
├── login.php           # Autentikasi
└── README.md           # Dokumentasi proyek

```

---

## 💻 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan Booksy di komputer lokal (Localhost):

### Prasyarat

* Install **XAMPP** (atau WAMP/MAMP) untuk menjalankan PHP & MySQL.
* Web Browser (Chrome/Firefox/Edge).

### Langkah Instalasi

1. **Clone Repository**
Buka terminal (Git Bash/CMD) dan jalankan:
```bash
git clone [https://github.com/username-anda/booksy.git](https://github.com/username-anda/booksy.git)

```


Atau download ZIP dan ekstrak.
2. **Pindahkan ke htdocs**
Pindahkan folder `booksy` ke dalam direktori instalasi XAMPP: `C:/xampp/htdocs/booksy`.
3. **Setup Database**
* Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
* Buat database baru dengan nama: `booksy_db`.
* Klik menu **Import**, pilih file `database/booksy.sql` (atau file SQL yang disertakan), lalu klik **Go**.


4. **Konfigurasi Koneksi**
Pastikan file `db.php` sudah sesuai dengan settingan XAMPP kamu (default biasanya tanpa password):
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "booksy_db";

```


5. **Jalankan Aplikasi**
Buka browser dan akses:
`http://localhost/booksy`

---

## 🎮 Cara Penggunaan

1. **Daftar Akun:** Pengguna baru melakukan registrasi di menu "Daftar".
2. **Cari Buku:** Gunakan fitur pencarian di halaman Katalog.
3. **Booking:** Klik tombol "Pinjam" pada buku yang tersedia.
4. **Dapatkan QR:** Sistem akan memberikan kode QR unik.
5. **Ambil Buku:** Tunjukkan QR Code kepada Admin di perpustakaan untuk di-scan.

---

## 👥 Tim Pengembang

Proyek ini dikembangkan sebagai bagian dari Tugas Akhir/Proyek Kampus oleh:

* **Danny Christian Hermawan** - *Backend & Database Engineer*
* **Cesya Aulia Ramadhani** - *Frontend & UI/UX Designer*
* **Hanifah Kurnia Fa'izah** - *Documentation & Quality Assurance*

---

## 📄 Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.

---

<div align="center">
<p>Dibuat dengan ❤️ oleh Tim Booksy</p>
</div>

```

3.  **Edit Link:** Ganti `https://github.com/username/booksy` dengan link repository GitHub kamu yang asli.

```
