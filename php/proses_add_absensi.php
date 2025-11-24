<?php
include "koneksi.php";

$tanggal = $_POST['tanggal'];

if ($tanggal == "") {
    echo "<script>alert('Data tidak boleh kosong!'); window.location='absensi.php';</script>";
    exit;
}

for ($i = 0; $i < count($_POST['anggota_id']); $i++) {
    $anggota_id = $_POST['anggota_id'][$i];
    $keterangan = $_POST['keterangan'][$i];
    
// validasi add/edit
    $absensi = mysqli_query($db, "select * from absensi where tanggal='$tanggal' and anggota_id='$anggota_id' ");
    if (mysqli_num_rows($absensi) == 0) {
        mysqli_query($db, "INSERT INTO absensi VALUES ('', '$anggota_id', '$tanggal', '$keterangan')");
    }else{
            $absensi=mysqli_query($db,"update absensi set keterangan='$keterangan' where anggota_id='$anggota_id' and tanggal='$tanggal'");
    }


}


header("location: anggota.php");
exit;
?>