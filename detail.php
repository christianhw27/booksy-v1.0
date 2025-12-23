<?php
// detail.php
require 'db.php'; // Hubungkan ke database
// require 'auth.php';
// 1. Dapatkan ID buku dari URL dan pastikan itu angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = (int)$_GET['id'];
} else {
    header('Location: catalog.php');
    exit;
}

// 2. Ambil data buku spesifik dari database
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Buku tidak ditemukan.";
    exit;
}

$book = $result->fetch_assoc();

// Set judul halaman dinamis
$page_title = "Detail: " . htmlspecialchars($book['title']);
include 'templates/header.php';
?>

<main class="container">
    <div class="book-detail-container">
        <div class="book-detail-cover">
            <img src="<?= htmlspecialchars($book['cover_image']); ?>" 
                alt="Cover Buku <?= htmlspecialchars($book['title']); ?>">
        </div>

        <div class="book-detail-info">
            <h1 class="book-title"><?= htmlspecialchars($book['title']); ?></h1>
            <p class="author">oleh <?= htmlspecialchars($book['author']); ?></p>

            <div class="rating">
                <?= generate_ratings($book['rating']); ?>
            </div>

            <ul class="book-meta">
                    <li><span>Genre:</span> <?php echo htmlspecialchars($book['tag'] ?? 'N/A'); ?></li>
                    <li><span>Penerbit:</span> <?php echo htmlspecialchars($book['publisher'] ?? 'N/A'); ?></li>
                    <li><span>Tahun Terbit:</span> <?php echo htmlspecialchars($book['publish_year'] ?? 'N/A'); ?></li>
                    <li><span>Jumlah Halaman:</span> <?php echo htmlspecialchars($book['page_count'] ?? 'N/A'); ?></li>
                    
                    <li>
                        <span>Stok Tersedia:</span> 
                        <?php 
                        if ($book['stock'] > 0) {
                            echo "<strong style='color: green;'>{$book['stock']} Copy</strong>";
                        } else {
                            echo "<strong style='color: red;'>Habis (0)</strong>";
                        }
                        ?>
                    </li>
                </ul>

                <h2 class="section-subtitle">Sinopsis</h2>
                <p class="synopsis">
                    <?php echo nl2br(htmlspecialchars($book['synopsis'] ?? 'Sinopsis tidak tersedia.')); ?>
                </p>

                <div class="book-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        
                        <?php if ($book['stock'] > 0): ?>
                            
                            <form action="borrow_book.php" method="POST" style="display: inline-flex; align-items: center; gap: 10px;">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                
                                <select name="duration" required style="padding: 13px 10px; border: 2px solid var(--secondary-color); border-radius: 8px; font-family: var(--font-family); background: var(--background-color); color: var(--text-color); cursor: pointer;">
                                    <option value="3">3 Hari</option>
                                    <option value="7">1 Minggu</option>
                                    <option value="14">2 Minggu</option>
                                    <option value="30" selected>1 Bulan</option>
                                </select>

                                <button type="submit" class="btn-primary btn-large" onclick="return confirm('Yakin ingin meminjam buku ini?');">
                                   Pinjam Buku
                                </button>
                            </form>

                        <?php else: ?>
                            <button class="btn-primary btn-large" style="background-color: #ccc; cursor: not-allowed;" onclick="alert('Maaf, stok buku ini sedang habis. Silakan cek lagi nanti!');">
                               Stok Habis
                            </button>
                        <?php endif; ?>

                        <a href="add_to_wishlist.php?id=<?php echo $book['id']; ?>" class="btn-icon-action">
                            <span class="material-symbols-outlined">favorite</span>
                            <span>Tambah ke Wishlist</span>
                        </a>

                    <?php else: ?>
                        <a href="login.php" class="btn-primary btn-large" onclick="alert('Silakan Login untuk meminjam buku!');">
                           Login untuk Pinjam
                        </a>
                        <a href="login.php" class="btn-icon-action">
                            <span class="material-symbols-outlined">favorite</span>
                            <span>Wishlist</span>
                        </a>
                    <?php endif; ?>
                </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <section class="recommendations">
        <h2 class="section-title-center">Rekomendasi Lainnya</h2>
        <div class="book-grid">

        <?php
        $recom_stmt = $conn->prepare("SELECT * FROM books WHERE id != ? ORDER BY RAND() LIMIT 4");
        $recom_stmt->bind_param("i", $book_id);
        $recom_stmt->execute();
        $recom_result = $recom_stmt->get_result();

        if ($recom_result->num_rows > 0) {
            while ($rec_book = $recom_result->fetch_assoc()) {
        ?>
                <div class="book-card">
                    <div class="book-cover">
                        <span class="tag"><?= htmlspecialchars($rec_book['tag']); ?></span>
                        <a href="detail.php?id=<?= $rec_book['id']; ?>">
                            <img src="<?= htmlspecialchars($rec_book['cover_image']); ?>" 
                                alt="<?= htmlspecialchars($rec_book['title']); ?>">
                        </a>
                    </div>
                    <div class="book-info">
                        <h3><?= htmlspecialchars($rec_book['title']); ?></h3>
                        <p><?= htmlspecialchars($rec_book['author']); ?></p>
                        <div class="rating"><?= generate_ratings($rec_book['rating']); ?></div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>Tidak ada rekomendasi lain.</p>";
        }

        $stmt->close();
        $recom_stmt->close();
        ?>
        </div>
    </section>
</main>

<?php
include 'templates/footer.php';
$conn->close();
?>
