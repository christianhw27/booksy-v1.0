<?php
// guest_login.php
session_start();

// Set identitas tamu
$_SESSION['username'] = 'Tamu';
$_SESSION['role'] = 'guest';

// PENTING: Kita TIDAK set $_SESSION['user_id']
// Supaya halaman-halaman penting (MyBooks/Wishlist) tetap terkunci.

header("Location: index.php");
exit;
?>