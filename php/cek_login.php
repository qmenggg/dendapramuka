<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$q = mysqli_query($db, "SELECT * FROM user WHERE username='$username'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    echo "User tidak ditemukan!";
    exit;
}

// cek password (pakai password_hash seharusnya)
if (password_verify($password, $d['password'])) {
    $_SESSION['username'] = $d['username'];
    $_SESSION['role'] = $d['role'];

    if ($d['role'] == 'admin') {
        header("Location: /home.php");
        exit;
    } else {
        header("Location: viewer/home.php");
        exit;
    }
} else {
    echo "Password salah!";
}
?>