<?php
// contact.php
require 'db.php';
// require 'auth.php';
$page_title = "Contact Us - Booksy";

// Variabel untuk melacak status pengiriman
$message_sent = false;
$error_message = '';

// 1. Cek jika form sudah di-submit (method == POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Ambil data dari form (dan bersihkan sedikit)
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // 3. Validasi sederhana
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = "Harap isi semua kolom yang wajib diisi (Nama, Email, Pesan).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format email yang Anda masukkan tidak valid.";
    } else {
        // 4. MASUKKAN PESAN KE DATABASE
$stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
// 'ssss' berarti 4 variabelnya adalah String
$stmt->bind_param("ssss", $name, $email, $subject, $message);

// Eksekusi kueri
if ($stmt->execute()) {
    $message_sent = true;
} else {
    // Jika gagal menyimpan ke database
    $error_message = "Terjadi kesalahan. Pesan Anda tidak dapat disimpan.";
}
$stmt->close();
    }
}

// Masukkan header SETELAH semua logika PHP
include 'templates/header.php';
?>

<main class="form-content">

    <?php if ($message_sent): ?>
        
        <div class="contact-success">
            <h2>Terima Kasih, <?php echo $name; ?>!</h2>
            <p>Pesan Anda telah kami terima. Kami akan segera menghubungi Anda kembali jika diperlukan.</p>
            <a href="index.php" class="btn">Kembali ke Beranda</a>
        </div>

    <?php else: ?>

        <h2>Contact Us</h2>
        <p>Have suggestions, feedback, or want to request your favorite book? Fill out the form below!</p>
        
        <?php if ($error_message): ?>
            <div class="contact-error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form id="contact-form" method="POST" action="contact.php">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject">
                    <option value="feedback" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'feedback') ? 'selected' : ''; ?>>Suggestions & Feedback</option>
                    <option value="request" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'request') ? 'selected' : ''; ?>>Book Request</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="6" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
        </form>

    <?php endif; ?>

</main>

<?php
include 'templates/footer.php';
?>