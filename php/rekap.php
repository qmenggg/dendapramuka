<?php
include "koneksi.php";
?>

<?php
include "navbar.php";
?>

<!-- konten -->

<div class="container-fluid px-4">
    <h1 class="mt-4">Rekap Absensi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Rekap Absensi Per Tanggal</li>
    </ol>

    <!-- FILTER RANGE TANGGAL -->
    <form method="GET" class="row g-2 mb-3 align-items-end">
        <div class="col-auto">
            <label class="form-label">Dari</label>
            <input type="date" name="start" class="form-control"
                value="<?= isset($_GET['start']) ? htmlspecialchars($_GET['start']) : "" ?>">
        </div>

        <div class="col-auto">
            <label class="form-label">Sampai</label>
            <input type="date" name="end" class="form-control"
                value="<?= isset($_GET['end']) ? htmlspecialchars($_GET['end']) : "" ?>">
        </div>

        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="rekap.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <?php
    // Siapkan filter SQL aman
    $where = "";
    if (!empty($_GET['start']) && !empty($_GET['end'])) {
        $start = mysqli_real_escape_string($db, $_GET['start']);
        $end = mysqli_real_escape_string($db, $_GET['end']);
        $where = "WHERE tanggal BETWEEN '$start' AND '$end'";
    }

    // Query: group per tanggal, hitung hadir/sakit/izin/alpha dan total
    $sql = "
    SELECT 
        tanggal,
        SUM(keterangan='HADIR')  AS hadir,
        SUM(keterangan='SAKIT')  AS sakit,
        SUM(keterangan='IZIN')   AS izin,
        SUM(keterangan='ALPHA')  AS alpha,
        COUNT(*)                 AS total
    FROM absensi
    $where
    GROUP BY tanggal
    ORDER BY tanggal DESC
";

    $q = mysqli_query($db, $sql);
    ?>

    <div class="card">
        <div class="card-header">
            <strong>Daftar Rekap</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpha</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($q) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($r = mysqli_fetch_assoc($q)): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['tanggal']) ?></td>
                                <td><?= (int) $r['hadir'] ?></td>
                                <td><?= (int) $r['sakit'] ?></td>
                                <td><?= (int) $r['izin'] ?></td>
                                <td><?= (int) $r['alpha'] ?></td>
                                <td><?= (int) $r['total'] ?></td>
                                <td>
                                    <a href="rekap_detail.php?tanggal=<?= urlencode($r['tanggal']) ?>"
                                        class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /konten -->

<?php
include "footer.php";
?>