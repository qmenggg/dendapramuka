<?php
include "navbar.php";
include "koneksi.php"
    ?>

<?php

if (!isset($_GET['tanggal']) || empty($_GET['tanggal'])) {
    echo "<div class='container'><div class='alert alert-warning'>Tanggal belum dipilih. <a href='rekap.php'>Kembali ke Rekap</a></div></div>";
    include "footer.php";
    exit;
}

$tanggal = mysqli_real_escape_string($db, $_GET['tanggal']);
$ket = isset($_GET['ket']) ? mysqli_real_escape_string($db, $_GET['ket']) : "";

// Build filter for keterangan
$filterKet = "";
if ($ket !== "") {
    $filterKet = "AND a.keterangan = '$ket'";
}

// Ambil daftar siswa + keterangan pada tanggal tersebut
$sql = "
    SELECT a.*, ag.nama, ag.kelas, ag.sangga
        FROM absensi a
        JOIN anggota ag ON a.anggota_id = ag.id
        WHERE a.tanggal = '$tanggal' $filterKet
        ORDER BY ag.kelas ASC, ag.nama ASC
";
$q = mysqli_query($db, $sql);

// Juga ambil ringkasan (jumlah masing2) untuk ditampilkan
$sum_sql = "
    SELECT 
        SUM(keterangan='HADIR') AS hadir,
        SUM(keterangan='SAKIT') AS sakit,
        SUM(keterangan='IZIN')  AS izin,
        SUM(keterangan='ALPHA') AS alpha,
        COUNT(*) AS total
    FROM absensi
    WHERE tanggal = '$tanggal'
";
$sum_res = mysqli_query($db, $sum_sql);
$sum = mysqli_fetch_assoc($sum_res);
?>

<div class="container-fluid px-4">
    <h2 class="mt-4">Detail Rekap — <?= htmlspecialchars($tanggal) ?></h2>
    <a href="rekap.php" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card p-2">
                <div><strong>Ringkasan</strong></div>
                <div>Hadir: <?= (int) $sum['hadir'] ?> &nbsp;|&nbsp; Sakit: <?= (int) $sum['sakit'] ?> &nbsp;|&nbsp;
                    Izin:
                    <?= (int) $sum['izin'] ?> &nbsp;|&nbsp; Alpha: <?= (int) $sum['alpha'] ?> &nbsp;|&nbsp; Total:
                    <?= (int) $sum['total'] ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex justify-content-end align-items-center gap-2">

                <!-- FILTER -->
                <form method="GET" id="filterForm" class="d-flex">
                    <input type="hidden" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
                    <label class="me-2 align-self-center">Filter:</label>
                    <select name="ket" class="form-select w-auto"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="" <?= $ket === '' ? 'selected' : '' ?>>Semua</option>
                        <option value="HADIR" <?= $ket === 'HADIR' ? 'selected' : '' ?>>HADIR</option>
                        <option value="SAKIT" <?= $ket === 'SAKIT' ? 'selected' : '' ?>>SAKIT</option>
                        <option value="IZIN" <?= $ket === 'IZIN' ? 'selected' : '' ?>>IZIN</option>
                        <option value="ALPHA" <?= $ket === 'ALPHA' ? 'selected' : '' ?>>ALPHA</option>
                    </select>
                </form>

                <!-- COPY -->
                <button class="btn btn-secondary" onclick="copyTable()">Copy</button>

                <!-- EXCEL -->
                <button class="btn btn-success" onclick="exportExcel()">Excel</button>

                <!-- PDF -->
                <a href="export_detail.php?tanggal=<?= urlencode($tanggal) ?>&ket=<?= urlencode($ket) ?>"
                    class="btn btn-danger">PDF</a>

            </div>

            <!-- <script>
                    new DataTable('#example', {
                        layout: {
                            topStart: {
                                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                            }
                        }
                    });
            </script> -->

            <script>
                // COPY TABLE
                function copyTable() {
                    let range = document.createRange();
                    range.selectNode(document.querySelector("table"));
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    document.execCommand("copy");
                    alert("Tabel berhasil disalin!");
                    window.getSelection().removeAllRanges();
                }

                // EXPORT EXCEL
                function exportExcel() {
                    var table = document.querySelector("table");
                    var html = table.outerHTML;

                    var a = document.createElement("a");
                    a.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
                    a.download = "rekap_<?= $tanggal ?>.xls";
                    a.click();
                }
            </script>


        </div>
    </div>


    <div class="card">
        <div class="card-header"><strong>Daftar Peserta — <?= htmlspecialchars($tanggal) ?></strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Sangga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($q) == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data untuk filter ini.</td>
                        </tr>
                    <?php else:
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($q)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['kelas']) ?></td>
                                <td><?= htmlspecialchars($row['sangga']) ?></td>
                                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            </tr>
                        <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>