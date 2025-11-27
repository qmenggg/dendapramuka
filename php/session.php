<?php
// session.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Simpan username & role untuk dipakai di include lain
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$textColor = ($role == 'admin') ? '#64B5F6' : '#4CAF50'; // biru untuk admin, hijau untuk viewer
?>