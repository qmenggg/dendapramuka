<?php
include "koneksi.php";

$nama   = $_POST['nama'];
$kelas  = $_POST['kelas'];
$sangga = $_POST['sangga'];
$jkel   = $_POST['jkel'];
$alpha   = $_POST['alpha'];
$denda   = $_POST['denda'];
$total_denda   = $_POST['total_denda'];

if($nama == "" || $kelas == "" || $sangga == "" || $jkel == ""){
    echo "<script>alert('Data tidak boleh kosong!'); window.location='anggota.php';</script>";
    exit;
}

mysqli_query($db, "INSERT INTO anggota VALUES ('', '$nama', '$kelas', '$sangga', '$jkel','$alpha','$denda','$total_denda')");

header("location: anggota.php");
exit;
?>
