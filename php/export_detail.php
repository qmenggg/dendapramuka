<?php
// export_detail.php
require __DIR__ . '/../vendor/autoload.php'; // path fix karena vendor ada di luar php
include "koneksi.php";

use Mpdf\Mpdf;

// Cek tanggal
if (!isset($_GET['tanggal']) || empty($_GET['tanggal'])) {
    die("Tanggal belum dipilih. <a href='rekap.php'>Kembali ke Rekap</a>");
}

$tanggal = mysqli_real_escape_string($db, $_GET['tanggal']);
$ket = isset($_GET['ket']) ? mysqli_real_escape_string($db, $_GET['ket']) : "";

// Filter keterangan
$filterKet = $ket !== "" ? "AND a.keterangan = '$ket'" : "";

// Ambil data absensi
$sql = "
    SELECT a.*, ag.nama, ag.kelas, ag.sangga
        FROM absensi a
        JOIN anggota ag ON a.anggota_id = ag.id
        WHERE a.tanggal = '$tanggal' $filterKet
        ORDER BY ag.kelas ASC, ag.nama ASC
";
$q = mysqli_query($db, $sql);

// Ambil ringkasan (jumlah masing-masing keterangan)
$sum_sql = "
    SELECT 
        SUM(keterangan='HADIR') AS hadir,
        SUM(keterangan='SAKIT') AS sakit,
        SUM(keterangan='IZIN') AS izin,
        SUM(keterangan='ALPHA') AS alpha,
        COUNT(*) AS total
    FROM absensi
    WHERE tanggal = '$tanggal'
";
$sum_res = mysqli_query($db, $sum_sql);
$sum = mysqli_fetch_assoc($sum_res);

// Mulai generate PDF
$mpdf = new Mpdf();
$mpdf->SetTitle("Rekap Absensi $tanggal");

// Header PDF
$html = "
<h2 style='text-align:center;'>REKAP ABSENSI PRAMUKA</h2>
<h4 style='text-align:center;'>Tanggal: $tanggal</h4>
<p style='text-align:center;'>Filter: " . ($ket == "" ? "Semua" : $ket) . "</p>

<div style='margin-top:10px;'>
<strong>Ringkasan:</strong> 
Hadir: " . (int) $sum['hadir'] . " | 
Sakit: " . (int) $sum['sakit'] . " | 
Izin: " . (int) $sum['izin'] . " | 
Alpha: " . (int) $sum['alpha'] . " | 
Total: " . (int) $sum['total'] . "
</div>

<hr>

<table border='1' cellpadding='5' cellspacing='0' width='100%' style='border-collapse: collapse;'>
<tr style='background-color:#343a40; color:white; text-align:center;'>
<th>No</th>
<th>Nama</th>
<th>Kelas</th>
<th>Sangga</th>
<th>Keterangan</th>
</tr>
";

// Isi data
if (mysqli_num_rows($q) == 0) {
    $html .= "<tr><td colspan='5' style='text-align:center;'>Tidak ada data</td></tr>";
} else {
    $no = 1;
    while ($row = mysqli_fetch_assoc($q)) {
        $html .= "<tr>
        <td style='text-align:center;'>" . $no++ . "</td>
        <td>" . htmlspecialchars($row['nama']) . "</td>
        <td style='text-align:center;'>" . htmlspecialchars($row['kelas']) . "</td>
        <td style='text-align:center;'>" . htmlspecialchars($row['sangga']) . "</td>
        <td style='text-align:center;'>" . htmlspecialchars($row['keterangan']) . "</td>
        </tr>";
    }
}

$html .= "</table>";

// Tulis ke PDF
$mpdf->WriteHTML($html);

// Download langsung
$filename = "rekap_absensi_" . $tanggal . ".pdf";
$mpdf->Output($filename, "D");
