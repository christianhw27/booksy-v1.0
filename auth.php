<?php
// auth.php
// File ini bertugas sebagai "Satpam" DAN "Pencatat Waktu"

// 1. Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Kalau belum login, tendang ke login.php
    header("Location: login.php");
    exit;
}

// 3. FITUR BARU: Update waktu 'last_active' user ke Database
// Kita butuh koneksi database. Karena auth.php dipanggil SETELAH db.php, 
// variabel $conn seharusnya sudah tersedia.
if (isset($conn) && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    // Update kolom last_active menjadi waktu SEKARANG (NOW())
    $conn->query("UPDATE users SET last_active = NOW() WHERE id = $uid");
}
?>