<?php
include "navbar.php";
?>


<?php
include "koneksi.php";

$tanggal = $_GET['tanggal'];
$kelas = $_GET['kelas'];
$sangga = $_GET['sangga'];

$where = "WHERE absensi.tanggal = '$tanggal'";

if ($kelas != '') {
    $where .= " AND anggota.kelas = '$kelas'";
}

if ($sangga != '') {
    $where .= " AND anggota.sangga = '$sangga'";
}

$q = mysqli_query($db, "
    SELECT anggota.nama, anggota.kelas, anggota.sangga, absensi.keterangan
    FROM absensi
    JOIN anggota ON absensi.anggota_id = anggota.id
    $where
    ORDER BY anggota.nama ASC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Detail Rekap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <h3>Detail Absensi Tanggal <?= $tanggal ?></h3>
    <a href="rekap.php" class="btn btn-secondary mb-4">← Kembali</a>

    <table id="example" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Sangga</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($d = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['kelas'] ?></td>
                    <td><?= $d['sangga'] ?></td>
                    <td><?= $d['keterangan'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>

<?php
include "footer.php";
?>