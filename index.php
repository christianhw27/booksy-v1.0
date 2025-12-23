<?php
// index.php
require 'db.php'; // Hubungkan ke database
// require 'auth.php';
$page_title = "Booksy - Your Digital Library";
include 'templates/header.php';
?>

<main>
    <div class="container">
        <section class="hero-section">
           <div class="hero-text">
    <?php 
    // Cek apakah ada username (User atau Tamu)
    $sapaan = isset($_SESSION['username']) ? ucfirst($_SESSION['username']) : "Pengunjung";
    ?>
    <h1>Halo, <?php echo htmlspecialchars($sapaan); ?>! 👋</h1>
                <p>Read More, Pay Nothing, Learn More, Keep Growing.</p>
                <a href="catalog.php" class="btn-primary">View all</a>
            </div>
            <div class="hero-image">
                <img src="images/logoutama.svg" alt="Illustration">
            </div>
        </section>

        <section class="category-section">
            <div class="section-header">
                <h2>Popular Now</h2>
            </div>
            <div class="book-grid">
                <?php
                // Ambil buku yang populer
                $sql_popular = "SELECT * FROM books WHERE is_popular = 'Yes'";
                $result_popular = $conn->query($sql_popular); 

                if ($result_popular->num_rows > 0) {
                    $book_index = 0;
                    while ($book = $result_popular->fetch_assoc()) {
                        // Tentukan kelas hidden, sama seperti di index.html (setelah 4 buku)
                        $book_class = ($book_index >= 4 || $book['is_hidden'] == 'Yes') ? 'hidden-book' : '';
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
                                    <?php echo generate_ratings($book['rating']); ?>
                                </div>
                            </div>
                        </div>
                <?php
                        $book_index++;
                    } // Akhir loop buku
                } else {
                    echo "<p>Belum ada buku populer saat ini.</p>";
                }
                ?>
            </div> <div class="no-results-message" style="display: none;">
                <h3>Oops! Buku tidak ditemukan.</h3>
                <p>Coba gunakan kata kunci lain untuk menemukan buku favoritmu.</p>
            </div>

            <div class="view-all-container">
                <button class="btn-secondary view-all-btn">View All</button>
                <button class="btn-secondary view-less-btn" style="display: none;">View Less</button>
            </div>
        </section>
    </div>
</main>

<?php
include 'templates/footer.php';
$conn->close();
?>