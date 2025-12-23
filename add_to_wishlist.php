<?php
// add_to_wishlist.php
require 'db.php';
require 'auth.php'; // Wajib Login

// Cek ID Buku
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Cek apakah buku sudah ada di wishlist user ini?
    $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND book_id = ?");
    $check->bind_param("ii", $user_id, $book_id);
    $check->execute();
    
    // Jika belum ada, baru masukkan
    if ($check->get_result()->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
    }
    // Jika sudah ada, biarkan saja (tidak perlu error)
}

// Kembali ke halaman sebelumnya (detail buku)
header('Location: detail.php?id=' . $book_id);
exit;
?>