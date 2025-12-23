<?php
// view_ticket.php
require 'db.php';
require 'auth.php';
$page_title = "Tiket Peminjaman";

if (!isset($_GET['id'])) {
    header("Location: mybooks.php");
    exit;
}

$loan_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data peminjaman + Data Buku
$sql = "SELECT l.*, b.title, b.cover_image, b.author 
        FROM loans l 
        JOIN books b ON l.book_id = b.id 
        WHERE l.id = ? AND l.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $loan_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$loan = $result->fetch_assoc();

if (!$loan) {
    echo "Tiket tidak ditemukan.";
    exit;
}

include 'templates/header.php';
?>

<main class="container" style="max-width: 600px; margin-top: 40px; text-align: center;">
    <div class="ticket-card" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px dashed var(--secondary-color);">
        
        <h2 style="color: var(--primary-color);">Tiket Peminjaman</h2>
        <p style="color: var(--light-text-color); margin-bottom: 30px;">Tunjukkan QR Code ini kepada pustakawan.</p>

        <?php 
            // 1. Susun isi pesan yang mau dimasukkan ke QR
            // "\n" itu kode untuk ganti baris (Enter)
            $qr_content  = "TIKET PEMINJAMAN BOOKSY\n";
            $qr_content .= "-----------------------\n";
            $qr_content .= "Kode: " . $loan['loan_code'] . "\n";
            $qr_content .= "Judul: " . $loan['title'] . "\n";
            // Kita ambil nama peminjam dari Session
            $qr_content .= "Peminjam: " . ucfirst($_SESSION['username']) . "\n"; 
            $qr_content .= "Tgl Kembali: " . date('d M Y', strtotime($loan['due_date']));
            
            // 2. Encode teksnya supaya aman masuk ke URL (spasi jadi %20, dll)
            $qr_encoded = urlencode($qr_content);
        ?>
        
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $qr_encoded; ?>" alt="QR Code" style="margin-bottom: 20px;">
        
        <h3 style="margin: 10px 0;"><?php echo $loan['loan_code']; ?></h3>
        
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

        <div style="text-align: left;">
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
                <img src="<?php echo htmlspecialchars($loan['cover_image']); ?>" style="width: 60px; border-radius: 5px;">
                <div>
                    <h4 style="margin: 0;"><?php echo htmlspecialchars($loan['title']); ?></h4>
                    <span style="font-size: 0.9em; color: #777;"><?php echo htmlspecialchars($loan['author']); ?></span>
                </div>
            </div>

            <p><strong>Status:</strong> 
                <?php 
                    if($loan['status'] == 'booked') echo '<span style="color:orange; font-weight:bold;">Menunggu Pengambilan</span>';
                    else if($loan['status'] == 'borrowed') echo '<span style="color:green; font-weight:bold;">Sedang Dipinjam</span>';
                    else echo '<span style="color:gray;">Dikembalikan</span>';
                ?>
            </p>
            <p><strong>Tanggal Pinjam:</strong> <?php echo date('d M Y', strtotime($loan['loan_date'])); ?></p>
            <p><strong>Wajib Kembali:</strong> <span style="color: var(--accent-color); font-weight: bold;"><?php echo date('d M Y', strtotime($loan['due_date'])); ?></span></p>
        </div>

        <div style="margin-top: 30px;">
            <a href="mybooks.php" class="btn-secondary">Kembali ke My Books</a>
        </div>
    </div>
</main>

<?php include 'templates/footer.php'; ?>