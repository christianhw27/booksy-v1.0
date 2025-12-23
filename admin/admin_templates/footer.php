<?php
// admin/admin_templates/footer.php
?>
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-logo">
                <h2>Booksy (Admin)</h2>
                <p>Booksy Admin Panel v1.0</p>
            </div>

            <div class="footer-links">
                <h3>Navigasi Cepat</h3>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="add_book.php">Tambah Buku</a></li>
                    <li><a href="messages.php">Pesan Masuk</a></li>
                </ul>
            </div>

            <div class="footer-links"> <h3>Aksi</h3>
                <ul>
                    <li><a href="../index.php" target="_blank">Lihat Situs</a></li>
                    <li><a href="#">(Kelola Akun Anda)</a></li>
                    <li><a href="../logout.php" style="color: var(--accent-color);">Logout</a></li>
            </div>

            <div></div>


        </div> <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Booksy Admin. All rights reserved.</p>
        </div>
    </footer>

    <script src="../script.js"></script>
</body>
</html>