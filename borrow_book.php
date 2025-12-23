<?php
// borrow_book.php
require 'db.php';
require 'auth.php'; // Wajib Login

// 1. UBAH METODE KE POST (Karena pakai Form)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['user_id'];
    
    // Ambil Durasi dari Form (Default 30 hari jika kosong/error)
    $duration_days = isset($_POST['duration']) ? (int)$_POST['duration'] : 30;

    // Validasi Durasi (Biar user iseng ga masukin 1000 tahun)
    $allowed_durations = [3, 7, 14, 30];
    if (!in_array($duration_days, $allowed_durations)) {
        $duration_days = 30;
    }

    // 2. Cek User (Sudah pinjam buku ini?)
    $check_loan = $conn->prepare("SELECT id FROM loans WHERE user_id = ? AND book_id = ? AND status != 'returned'");
    $check_loan->bind_param("ii", $user_id, $book_id);
    $check_loan->execute();
    if ($check_loan->get_result()->num_rows > 0) {
        echo "<script>alert('Anda sedang meminjam buku ini!'); window.location='mybooks.php';</script>";
        exit;
    }

    // 3. CEK STOK BUKU
    $check_stock = $conn->prepare("SELECT stock FROM books WHERE id = ?");
    $check_stock->bind_param("i", $book_id);
    $check_stock->execute();
    $res_stock = $check_stock->get_result()->fetch_assoc();

    if ($res_stock['stock'] <= 0) {
        echo "<script>alert('Maaf, stok buku ini sedang habis.'); window.location='detail.php?id=$book_id';</script>";
        exit;
    }

    // 4. PROSES PINJAM
    $conn->begin_transaction();

    try {
        // A. Kurangi Stok
        $conn->query("UPDATE books SET stock = stock - 1 WHERE id = $book_id");

        // B. Buat Tiket Peminjaman dengan DUE DATE Dinamis
        $loan_date = date('Y-m-d');
        
        // HITUNG TANGGAL KEMBALI BERDASARKAN PILIHAN USER
        $due_date = date('Y-m-d', strtotime("+$duration_days days"));
        
        // Generate Kode Unik
        $loan_code = "BKSY-" . $user_id . "-" . $book_id . "-" . date('dmYHis');

        $stmt = $conn->prepare("INSERT INTO loans (loan_code, user_id, book_id, loan_date, due_date, status) VALUES (?, ?, ?, ?, ?, 'booked')");
        $stmt->bind_param("siiss", $loan_code, $user_id, $book_id, $loan_date, $due_date);
        $stmt->execute();

        $conn->commit();
        
        $loan_id = $stmt->insert_id;
        header("Location: view_ticket.php?id=" . $loan_id);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Gagal memproses: " . $e->getMessage();
    }
} else {
    // Jika akses langsung lewat URL tanpa POST, kembalikan ke home
    header("Location: index.php");
    exit;
}
?>