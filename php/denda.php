<?php
include "navbar.php";
include "koneksi.php";
include "session.php";

// ===============================
// AMBIL MASTER DENDA BERTINGKAT
// ===============================
$master_denda = [];
$res = mysqli_query($db, "SELECT * FROM master_denda ORDER BY alpha ASC");
while ($row = mysqli_fetch_assoc($res)) {
    $master_denda[$row['alpha']] = $row['nominal'];
}

// ===============================
// AMBIL DATA SISWA + ALPHA + PEMBAYARAN
// ===============================
$sql = "
SELECT ag.id, ag.nama, ag.kelas, ag.sangga,
SUM(CASE WHEN a.keterangan='ALPHA' THEN 1 ELSE 0 END) AS total_alpha,
IFNULL(pd.total_bayar,0) AS sudah_bayar
FROM anggota ag
LEFT JOIN absensi a ON ag.id = a.anggota_id
LEFT JOIN (
SELECT anggota_id, SUM(total_bayar) AS total_bayar
FROM pembayaran_denda
GROUP BY anggota_id
) pd ON ag.id = pd.anggota_id
GROUP BY ag.id
ORDER BY ag.nama ASC
";
$q = mysqli_query($db, $sql);

// ===============================
// HITUNG TOTALAN
// ===============================
$rows = [];
$total_denda_keseluruhan = 0;
$total_terkumpul = 0;

while ($r = mysqli_fetch_assoc($q)) {

    $alpha = (int) $r['total_alpha'];

    // Hitung denda bertingkat
    $total_denda = 0;
    for ($i = 1; $i <= $alpha; $i++) {
        if (isset($master_denda[$i])) {
            $total_denda += $master_denda[$i];
        }
    }

    $r['total_denda'] = $total_denda;

    $total_denda_keseluruhan += $total_denda;
    $total_terkumpul += (int) $r['sudah_bayar'];

    $rows[] = $r;
}

$sisa_kumpul = $total_denda_keseluruhan - $total_terkumpul;

?>
<!-- =============================== -->
<!-- CONTENT -->
<!-- =============================== -->
<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Denda Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Denda</li>
    </ol>

    <!-- SUMMARY CARD -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4" style="border-left:6px solid #dc3545;">
                <div class="card-body">
                    <h6 class="text-muted">Total Denda Keseluruhan</h6>
                    <h3 class="fw-bold">Rp <?= number_format($total_denda_keseluruhan) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4" style="border-left:6px solid #28a745;">
                <div class="card-body">
                    <h6 class="text-muted">Total Terkumpul</h6>
                    <h3 class="fw-bold">Rp <?= number_format($total_terkumpul) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4" style="border-left:6px solid #ffc107;">
                <div class="card-body">
                    <h6 class="text-muted">Sisa Yang Harus Dikumpulkan</h6>
                    <h3 class="fw-bold">Rp <?= number_format($sisa_kumpul) ?></h3>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card mt-4 shadow rounded-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📄 Data Denda Semua Siswa</h5>
        </div>
        <div class="card-body">
            <table id="dendaTable" class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Sangga</th>
                        <th>Total Alpha</th>
                        <th>Total Denda</th>
                        <th>Sudah Bayar</th>
                        <th>Kekurangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($rows as $r):
                        $alpha = (int) $r['total_alpha'];
                        $total_denda = (int) $r['total_denda'];
                        $bayar = (int) $r['sudah_bayar'];
                        $kurang = $total_denda - $bayar;
                        $status = $kurang <= 0 ? "LUNAS" : "BELUM LUNAS";
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $r['nama'] ?></td>
                            <td class="text-center"><?= $r['kelas'] ?></td>
                            <td class="text-center"><?= $r['sangga'] ?></td>
                            <td class="text-center"><?= $alpha ?></td>
                            <td class="text-end">Rp <?= number_format($total_denda) ?></td>
                            <td class="text-end">Rp <?= number_format($bayar) ?></td>
                            <td class="text-end">Rp <?= number_format($kurang) ?></td>

                            <td class="text-center">
                                <?php if ($status == "LUNAS"): ?>
                                    <span class="badge bg-success">LUNAS</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">BELUM</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($role == 'admin'): ?>
                                    <?php if ($kurang > 0): ?>
                                        <a href="bayar_denda.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-success">
                                            <i class="bx bx-money"></i> Bayar
                                        </a>
                                    <?php else: ?>
                                        <a href="bayar_denda.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-success">
                                            <i class="bx bx-money"></i> Detail
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="bayar_denda.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="bx bx-money"></i> Detail
                                    </a>
                                    <!-- <span class="text-muted">-</span> -->
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- =============================== -->
<!-- DATATABLES -->
<!-- =============================== -->

<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        $('#dendaTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf', 'print'],
            scrollX: true,
        });
    });
</script>

<?php include "footer.php"; ?>