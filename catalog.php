<?php
// catalog.php
require 'db.php'; // Hubungkan ke database
// require 'auth.php';
$page_title = "Catalog - Booksy"; // Set judul halaman
include 'templates/header.php'; // Masukkan header
?>

<main class="container">
    <h1 class="page-title">Book Catalog</h1>

    <?php
    // 1. Ambil semua kategori
    $sql_categories = "SELECT * FROM categories ORDER BY id";
    $result_categories = $conn->query($sql_categories);

    if ($result_categories->num_rows > 0) {
        // Loop untuk setiap kategori
        while ($category = $result_categories->fetch_assoc()) {
    ?>
            <section class="category-section">
                <div class="section-header">
                    <h2><?php echo htmlspecialchars($category['name']); ?></h2>
                </div>
                <div class="book-grid">
                    <?php
                    // 2. Ambil semua buku untuk kategori ini
                    $category_id = $category['id'];
                    $sql_books = "SELECT * FROM books WHERE category_id = ?";
                    
                    $stmt = $conn->prepare($sql_books);
                    $stmt->bind_param("i", $category_id);
                    $stmt->execute();
                    $result_books = $stmt->get_result();

                    if ($result_books->num_rows > 0) {
                        // Loop untuk setiap buku dalam kategori ini
                        while ($book = $result_books->fetch_assoc()) {
                            // Tentukan kelas hidden
                            $book_class = ($book['is_hidden'] == 'Yes') ? 'hidden-book' : '';
                    ?>
                            <div class="book-card <?php echo $book_class; ?>">
                                <div class="book-cover">
                                    <span class="tag"><?php echo htmlspecialchars($book['tag']); ?></span>
                                    <a href="detail.php?id=<?php echo $book['id']; ?>">
                                        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                                    </a>
                                </div>
                                <div class="book-info">
                                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($book['author']); ?></p>
                                    <div class="rating">
                                        <?php echo generate_ratings($book['rating']); // Panggil fungsi rating dari db.php ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        } // Akhir loop buku
                    } else {
                        echo "<p>Belum ada buku di kategori ini.</p>";
                    }
                    $stmt->close();
                    ?>
                </div> <p class="no-results-message" style="display: none;">Tidak ada buku yang cocok dengan pencarian Anda.</p>
                <div class="view-all-container">
                <button class="btn-secondary view-all-btn">View All</button>
                <button class="btn-secondary view-less-btn" style="display: none;">View Less</button>
            </div>
            </section>
    <?php
        } // Akhir loop kategori
    } else {
        echo "<p>Belum ada kategori buku yang tersedia.</p>";
    }
    ?>

</main>

<?php
include 'templates/footer.php'; // Masukkan footer
$conn->close(); // Tutup koneksi database
?>