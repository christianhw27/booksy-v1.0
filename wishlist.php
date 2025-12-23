<?php
// wishlist.php
require 'db.php';
require 'auth.php'; // Wajib Login
$page_title = "My Wishlist - Booksy";
include 'templates/header.php';
?>

<main>
    <div class="container">
        <div class="page-header" style="margin-bottom: 30px;">
            <h1>My Wishlist</h1>
            <p>Koleksi buku impianmu.</p>
        </div>

        <section class="wishlist-section">
            <div class="book-grid">
                <?php
                $user_id = $_SESSION['user_id'];

                // JOIN TABLE: Ambil data buku, tapi HANYA yang ada di tabel wishlist milik user ini
                $sql = "SELECT b.* FROM books b
                        JOIN wishlist w ON b.id = w.book_id
                        WHERE w.user_id = ?
                        ORDER BY w.created_at DESC";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($book = $result->fetch_assoc()) {
                ?>
                        <div class="book-card">
                            <div class="book-cover">
                                <span class="tag"><?php echo htmlspecialchars($book['tag']); ?></span>
                                <a href="detail.php?id=<?php echo $book['id']; ?>">
                                    <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover">
                                </a>
                            </div>
                            <div class="book-info">
                                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                <p><?php echo htmlspecialchars($book['author']); ?></p>
                                <div class="rating">
                                    <?php echo generate_ratings($book['rating']); ?>
                                </div>
                                
                                <a href="remove_from_wishlist.php?id=<?php echo $book['id']; ?>" 
                                   class="btn-secondary" 
                                   style="display: inline-block; margin-top: 10px; font-size: 12px; padding: 5px 15px; color: var(--accent-color); border-color: var(--accent-color);">
                                   Hapus dari Wishlist
                                </a>
                            </div>
                        </div>
                <?php
                    } // Akhir loop
                } else {
                    echo "<p>Wishlist kamu masih kosong. Yuk cari buku menarik di <a href='catalog.php'>Katalog</a>!</p>";
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php include 'templates/footer.php'; ?>