<?php
// login.php
require 'db.php';
$page_title = "Login - Booksy";

// Jika user sudah login, langsung arahkan sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Password yang diketik user

    // Ambil data user dari database
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi Password (PLAIN TEXT)
        if ($password === $user['password']) {
            
            // Password Benar! Set Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan Role
            if ($user['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
    $stmt->close();
}

include 'templates/header.php';
?>

<main class="form-content" style="margin-top: 50px;">
    <h2>Login to Booksy</h2>
    <p>Masuk untuk mengakses perpustakaan digital Anda.</p>

    <?php if ($error): ?>
        <div class="contact-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
        
        <a href="guest_login.php" class="btn-secondary" style="display: block; text-align: center; margin-top: 10px; text-decoration: none;">
            Masuk sebagai Tamu
        </a>

        <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
            Belum punya akun? <a href="register.php" style="color: var(--secondary-color); font-weight: bold;">Daftar di sini</a>
        </p>
    </form>
</main>

<?php include 'templates/footer.php'; ?>