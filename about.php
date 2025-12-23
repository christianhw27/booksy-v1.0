<?php
// about.php
require 'db.php'; // Hubungkan ke database
// require 'auth.php'; // Auth tidak wajib di halaman publik
$page_title = "About Us - Booksy";

// --- LOGIKA STATISTIK DARI DATABASE (TETAP DIPERTAHANKAN) ---

// 1. Hitung Total Buku
$sql_books = "SELECT COUNT(*) as total FROM books";
$res_books = $conn->query($sql_books);
$total_books = ($res_books) ? $res_books->fetch_assoc()['total'] : 0;

// 2. Hitung Total User (Active Readers)
$sql_users = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
$res_users = $conn->query($sql_users);
$total_users = ($res_users) ? $res_users->fetch_assoc()['total'] : 0;

// 3. Hitung Total Kategori
$sql_cats = "SELECT COUNT(*) as total FROM categories";
$res_cats = $conn->query($sql_cats);
$total_cats = ($res_cats) ? $res_cats->fetch_assoc()['total'] : 0;

// 4. Hitung Rata-rata Rating (Opsional, jika nanti ada fitur rating)
$sql_rating = "SELECT AVG(rating) as average FROM books";
$res_rating = $conn->query($sql_rating);
$avg_data = ($res_rating) ? $res_rating->fetch_assoc()['average'] : 0;
$avg_rating = number_format((float)$avg_data, 1);

include 'templates/header.php';
?>

<main>
    <div class="container">
        
        <section class="about-hero">
            <h1>Menghubungkan Kamu dengan Buku Fisik</h1>
            <p>Tidak perlu lagi kecewa karena kehabisan stok saat tiba di perpustakaan. Cari, Booking dari rumah, dan Ambil bukumu dengan kepastian.</p>
        </section>

        <div class="about-content">
            <div class="about-section">
                <h2>Kisah Kami</h2>
                <p>Booksy lahir dari sebuah masalah klasik yang sering dialami pelajar dan mahasiswa: <em>"Sudah jauh-jauh datang ke perpustakaan, ternyata bukunya sedang dipinjam orang lain."</em></p>
                <p>Kami menyadari bahwa katalog konvensional seringkali tidak akurat atau sulit diakses dari luar. Oleh karena itu, kami membangun Booksy sebagai jembatan digital.</p>
                <p>Dimulai sebagai proyek sederhana, kini Booksy berkembang menjadi sistem manajemen perpustakaan modern yang memungkinkan anggota untuk melakukan reservasi buku secara online, mendapatkan tiket antrean digital, dan menikmati proses peminjaman fisik yang cepat dan efisien.</p>
            </div>

            <div class="about-section">
                <h2>Misi Kami</h2>
                <p>Misi utama kami adalah <strong>mendigitalkan pengalaman perpustakaan konvensional</strong> agar lebih transparan dan mudah diakses, tanpa menghilangkan esensi membaca buku fisik.</p>
                <p>Kami ingin menghapus "ketidakpastian" dalam meminjam buku. Dengan sistem <em>Real-time Stock</em> dan <em>QR Code Booking</em>, kami memastikan bahwa buku yang Anda inginkan benar-benar tersedia untuk Anda.</p>
                <p>Kami percaya teknologi seharusnya mempermudah akses literasi. Dengan Booksy, perpustakaan bukan lagi tempat yang membingungkan, melainkan pusat pengetahuan yang terorganisir di ujung jari Anda.</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_books; ?>+</div>
                <div class="stat-label">Koleksi Buku</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Anggota Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_cats; ?></div>
                <div class="stat-label">Kategori</div> 
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Akses Katalog</div>
            </div>
        </div>

        <section class="team-section">
            <h2>Keunggulan Kami</h2>
            <p>Prinsip yang membuat pengalaman meminjam buku di Booksy berbeda.</p>
        </section>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🚀</div>
                <h3>Cepat & Efisien</h3>
                <p>Tidak perlu mencari manual di rak. Booking lewat web, buku sudah disiapkan oleh petugas saat Anda datang.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📅</div>
                <h3>Kepastian Stok</h3>
                <p>Sistem kami mengunci stok untuk Anda saat booking. Tidak ada lagi istilah "rebutan buku" di lokasi.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📱</div>
                <h3>Teknologi QR</h3>
                <p>Proses serah terima buku tanpa ribet administrasi kertas. Cukup scan tiket QR Code Anda.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3>Terintegrasi</h3>
                <p>Satu akun untuk semua aktivitas: cek ketersediaan, riwayat peminjaman, hingga pengingat pengembalian.</p>
            </div>
        </div>

        <section class="team-section" style="margin-top: 80px;">
            <h2>Meet The Team</h2>
            <p>Orang-orang di balik layar yang membangun sistem Booksy.</p>
        </section>

        <div class="values-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div class="value-card" style="border-top: 5px solid var(--primary-color);">
                <div class="value-icon">👨‍💻</div>
                <h3 style="margin-bottom: 5px;">Danny Christian Hermawan</h3>
                <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 10px;">Backend & Database</p>
                <p style="font-size: 14px;">Creates the CRUD backend logic, complex queries, and robust database architecture.</p>
            </div>

            <div class="value-card" style="border-top: 5px solid var(--accent-color);">
                <div class="value-icon">🎨</div>
                <h3 style="margin-bottom: 5px;">Cesya Aulia Ramadhani</h3>
                <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 10px;">Frontend & UI/UX</p>
                <p style="font-size: 14px;">Creates the beautiful user interface, responsive design, and seamless user experience.</p>
            </div>

            <div class="value-card" style="border-top: 5px solid var(--secondary-color);">
                <div class="value-icon">📝</div>
                <h3 style="margin-bottom: 5px;">Hanifah Kurnia Fa'izah</h3>
                <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 10px;">Documentation & QA</p>
                <p style="font-size: 14px;">Ensures system quality through rigorous testing and creates comprehensive documentation.</p>
            </div>
        </div>

    </div>
</main>

<?php
include 'templates/footer.php';
?>