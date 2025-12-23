<?php
// admin/delete_book.php
require '../db.php';

// 1. Cek jika ID ada
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_books.php');
    exit;
}

$book_id = $_GET['id'];

// 2. Hapus buku dari database
$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);

if ($stmt->execute()) {
    // Berhasil dihapus, kembali ke katalog dengan pesan sukses
    header('Location: manage_books.php?status=deleted');
} else {
    // Gagal dihapus
    echo "Error: Gagal menghapus buku.";
}

$stmt->close();
$conn->close();
exit;
?>