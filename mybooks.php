<?php
// mybooks.php
require 'db.php';
require 'auth.php'; // Wajib Login
$page_title = "My Books - Booksy";
include 'templates/header.php';
?>

<main>
    <div class="container">
        <div class="page-header" style="margin-bottom: 30px;">
            <h1>My Books</h1>
            <p>Daftar buku yang sedang kamu pinjam atau booking.</p>
        </div>

        <section class="mybooks-section">
            <div class="book-grid">
                <?php
                $user_id = $_SESSION['user_id'];
                
                // Ambil data dari tabel LOANS join BOOKS
                // Hanya ambil yang statusnya BUKAN 'returned' (masih aktif)
                $sql = "SELECT l.id as loan_id, l.due_date, l.status, b.* FROM loans l
                        JOIN books b ON l.book_id = b.id
                        WHERE l.user_id = ? AND l.status != 'returned'
                        ORDER BY l.loan_date DESC";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Tentukan label status
                        $status_label = ($row['status'] == 'booked') ? 'Menunggu Diambil' : 'Sedang Dipinjam';
                        $status_color = ($row['status'] == 'booked') ? '#ff9800' : '#4caf50';
                ?>
                        <div class="book-card" onclick="window.location='view_ticket.php?id=<?php echo $row['loan_id']; ?>'">
                            <div class="book-cover">
                                <span class="tag" style="background-color: <?php echo $status_color; ?>;">
                                    <?php echo $status_label; ?>
                                </span>
                                <img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover">
                            </div>
                            <div class="book-info">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p><?php echo htmlspecialchars($row['author']); ?></p>
                                <p class="due-date" style="font-size: 0.85em; color: var(--accent-color); margin-top: 5px;">
                                    <i class="fa-regular fa-clock"></i> Kembali: <?php echo date('d M Y', strtotime($row['due_date'])); ?>
                                </p>
                                <button class="btn-secondary" style="width: 100%; margin-top: 10px; padding: 8px; font-size: 12px;">Lihat QR Code</button>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>Kamu belum meminjam buku apapun.</p>";
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php include 'templates/footer.php'; ?>