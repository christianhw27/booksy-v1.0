<?php

// 2. Cek apakah role-nya ADMIN
if ($_SESSION['role'] !== 'admin') {
    // Jika user biasa coba masuk admin, lempar ke beranda user
    header("Location: ../index.php"); 
    exit;
}
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Booksy'; ?></title>
    
    <link rel="stylesheet" href="../style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar-top">
                <div class="nav-logo">
                    <a href="index.php">Booksy (Admin)</a>
                </div>
                
                <div class="nav-actions">
                    <button class="icon-btn" id="dark-mode-toggle" title="Toggle Dark Mode">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </button>

                    <button onclick="window.location.href='../logout.php'" class="icon-btn" title="Logout" style="border-color: var(--accent-color);">
                           <span class="material-symbols-outlined" style="color: var(--accent-color);">logout</span>
                    </button>
                </div>
            </nav>
            <nav class="navbar-bottom">
                <ul>
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="manage_books.php" class="<?php echo (in_array($current_page, ['manage_books.php', 'add_book.php', 'edit_book.php'])) ? 'active' : ''; ?>">Kelola Buku</a></li>
                    <li><a href="messages.php" class="<?php echo ($current_page == 'messages.php') ? 'active' : ''; ?>">Pesan Masuk</a></li>
                    <li><a href="users.php" class="<?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">Users</a></li>
                    <li><a href="loans.php" class="<?php echo ($current_page == 'loans.php') ? 'active' : ''; ?>">Peminjaman</a></li>
                    </ul>
            </nav>
        </div>
    </header>