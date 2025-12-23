<?php
// templates/header.php

// Dapatkan nama file saat ini untuk menentukan halaman aktif
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Booksy - Your Digital Library'; ?></title>
    <link rel="stylesheet" href="style.css">
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
                    <a href="index.php">Booksy</a>
                </div>
                <div class="search-bar">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" id="search-input" placeholder="Search by author or title">
                </div>
                <div class="nav-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="mybooks.php" class="icon-btn <?php echo ($current_page == 'mybooks.php') ? 'active-icon' : ''; ?>" title="My Books">
                            <span class="material-symbols-outlined">menu_book</span>
                        </a>
                        <a href="wishlist.php" class="icon-btn <?php echo ($current_page == 'wishlist.php') ? 'active-icon' : ''; ?>" title="Wishlist">
                            <span class="material-symbols-outlined">favorite</span>
                        </a>
                        
                        <a href="logout.php" class="icon-btn" title="Logout" style="border-color: var(--accent-color);">
                           <span class="material-symbols-outlined" style="color: var(--accent-color);">logout</span>
                        </a>

                    <?php else: ?>
                        <a href="login.php" class="btn" style="padding: 8px 20px; font-size: 14px;">Login</a>
                    <?php endif; ?>

                    <button class="icon-btn" id="dark-mode-toggle" title="Toggle Dark Mode">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </button>
                </div>
            </nav>
            <nav class="navbar-bottom">
                <ul>
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="catalog.php" class="<?php echo ($current_page == 'catalog.php') ? 'active' : ''; ?>">Catalog</a></li>
                    <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>