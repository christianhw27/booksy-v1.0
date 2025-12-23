<?php
// remove_from_wishlist.php
require 'db.php';
require 'auth.php'; // Wajib Login

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Hapus data dari tabel wishlist
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}

// Kembali ke halaman wishlist
header('Location: wishlist.php');
exit;
?>