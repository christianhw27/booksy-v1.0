<?php
session_start();
// db.php
define('DB_SERVER', 'sql203.infinityfree.com');
define('DB_USERNAME', 'if0_40688561'); // Ganti dengan username database Anda
define('DB_PASSWORD', '27Agustu5');     // Ganti dengan password database Anda
define('DB_NAME', 'if0_40688561_booksy_db'); // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Fungsi untuk membuat bintang rating
function generate_ratings($rating) {
    $stars = '';
    for ($i = 0; $i < 5; $i++) {
        if ($i < $rating) {
            $stars .= '<span>⭐</span>';
        } else {
            $stars .= '<span>☆</span>'; // Opsional, jika ingin bintang kosong
        }
    }
    return $stars;
}
?>