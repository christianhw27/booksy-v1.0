<?php
// admin/process_loan.php
require '../db.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $loan_id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action == 'borrow') {
        // 1. UBAH STATUS JADI 'BORROWED' (User sudah ambil fisik buku)
        // Stok TIDAK berubah (karena sudah dikurangi saat booking/klik pinjam di awal)
        $conn->query("UPDATE loans SET status = 'borrowed' WHERE id = $loan_id");
    
    } elseif ($action == 'return') {
        // 2. UBAH STATUS JADI 'RETURNED' & TAMBAH STOK
        
        // Ambil ID buku dulu dari tabel loans
        $res = $conn->query("SELECT book_id FROM loans WHERE id = $loan_id");
        $book_id = $res->fetch_assoc()['book_id'];

        $conn->begin_transaction();
        try {
            // Update Status Transaksi
            $conn->query("UPDATE loans SET status = 'returned' WHERE id = $loan_id");
            
            // Kembalikan Stok (+1)
            $conn->query("UPDATE books SET stock = stock + 1 WHERE id = $book_id");
            
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
        }
    }
}

// Kembali ke halaman daftar peminjaman
header("Location: loans.php");
exit;
?>