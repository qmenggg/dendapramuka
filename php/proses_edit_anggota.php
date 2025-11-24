<?php
    include "koneksi.php";

    $id=$_POST['id'];
    $nama=$_POST['nama'];
    $kelas=$_POST['kelas'];
    $sangga=$_POST['sangga'];
    $jkel=$_POST['jkel'];
    
    $anggota=mysqli_query($db,"update anggota set nama='$nama',kelas='$kelas',sangga='$sangga',jkel='$jkel' where id='$id'");

    header("location:anggota.php");
?>