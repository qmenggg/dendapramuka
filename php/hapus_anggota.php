<?php
    include "koneksi.php";

    $id=$_GET['id'];
    
    $anggota=mysqli_query($db,"delete from anggota where id='$id'");

    header("location:anggota.php");
    
?>
