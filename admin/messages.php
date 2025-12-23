<?php
// admin/messages.php
require '../db.php'; // <-- UBAH PATH
$page_title = "Admin - Pesan Masuk";
include 'admin_templates/header.php'; // <-- UBAH PATH
?>

<main class="container message-container">
    <h1 class="page-title">Pesan Masuk</h1>
    <p>Daftar pesan yang dikirim melalui formulir kontak.</p>

    <?php
    // Ambil semua pesan, urutkan dari yang terbaru
    $sql = "SELECT name, email, subject, message, sent_at FROM messages ORDER BY sent_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // ... (sisa kode untuk menampilkan pesan, tidak ada yang berubah) ...
            $name = htmlspecialchars($row['name']);
            $email = htmlspecialchars($row['email']);
            $subject = htmlspecialchars($row['subject']);
            $message = nl2br(htmlspecialchars($row['message']));
            $time = date('d M Y, H:i', strtotime($row['sent_at']));
    ?>
            <div class="message-card">
                <div class="message-header">
                    <div>
                        <strong><?php echo $name; ?></strong>
                        (<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>)
                    </div>
                    <span><?php echo $time; ?></span>
                </div>
                <div class="message-body">
                    <div class="subject">Subjek: <?php echo $subject; ?></div>
                    <p><?php echo $message; ?></p>
                </div>
            </div>
    <?php
        } // Akhir loop
    } else {
        echo "<p>Belum ada pesan yang masuk.</p>";
    }
    $conn->close();
    ?>
</main>

<?php
include 'admin_templates/footer.php'; // <-- UBAH PATH
?>