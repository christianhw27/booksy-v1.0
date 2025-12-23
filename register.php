<?php
// register.php
require 'db.php';
$page_title = "Daftar Akun Baru - Booksy";

// Jika sudah login, lempar ke home
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Validasi Input
    if (empty($username) || empty($password)) {
        $error_message = "Semua kolom wajib diisi.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Konfirmasi password tidak cocok.";
    } else {
        // 2. Cek apakah username sudah ada
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Username '$username' sudah dipakai. Silakan pilih yang lain.";
        } else {
            // 3. Simpan User Baru (Password Plain Text sesuai request)
            // Role otomatis di-set 'user'
            $insert_stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $insert_stmt->bind_param("ss", $username, $password);

            if ($insert_stmt->execute()) {
                // Berhasil!
                $success_message = "Pendaftaran berhasil! Silakan login.";
                // Reset form agar tidak terkirim ulang
                $username = ''; 
                // Opsional: Redirect langsung ke login setelah 2 detik
                header("refresh:2;url=login.php"); 
            } else {
                $error_message = "Terjadi kesalahan sistem: " . $conn->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}

include 'templates/header.php';
?>

<main class="form-content" style="margin-top: 50px;">
    <h2>Buat Akun Baru</h2>
    <p>Bergabunglah dengan Booksy untuk mulai mengoleksi buku favoritmu.</p>

    <?php if ($error_message): ?>
        <div class="contact-error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="contact-success" style="padding: 15px; margin-bottom: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; text-align: center;">
            <?php echo $success_message; ?>
            <p style="font-size: 0.9em; margin-top: 5px;">Mengalihkan ke halaman login...</p>
        </div>
    <?php endif; ?>

    <?php if (empty($success_message)): ?>
    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="btn">Daftar Sekarang</button>
        
        <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
            Sudah punya akun? <a href="login.php" style="color: var(--secondary-color); font-weight: bold;">Login di sini</a>
        </p>
    </form>
    <?php endif; ?>
</main>

<?php include 'templates/footer.php'; ?>