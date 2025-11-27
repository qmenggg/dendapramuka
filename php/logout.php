<?php
session_start();

// Hapus semua session
session_unset();  // menghapus semua variable session
session_destroy(); // menghancurkan session

// Redirect ke halaman login
header("Location: login.php");
exit;
?>
