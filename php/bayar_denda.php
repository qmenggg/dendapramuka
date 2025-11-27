<?php
include "navbar.php";
include "koneksi.php";
include "session.php";


// Ambil ID siswa
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID siswa tidak ditemukan. <a href='denda.php'>Kembali</a>");
}
$id = (int) $_GET['id'];

// Ambil data siswa + total alpha + total bayar
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
WHERE ag.id = $id
GROUP BY ag.id
";
$q = mysqli_query($db, $sql) or die("Error: " . mysqli_error($db));

if (mysqli_num_rows($q) == 0) {
    die("Data siswa tidak ditemukan. <a href='denda.php'>Kembali</a>");
}
$row = mysqli_fetch_assoc($q);

// Ambil master denda
$master_denda = [];
$res = mysqli_query($db, "SELECT * FROM master_denda ORDER BY alpha ASC");
while ($r = mysqli_fetch_assoc($res)) {
    $master_denda[$r['alpha']] = $r['nominal'];
}

// Hitung total denda
$total_alpha = (int) $row['total_alpha'];
$total_denda = 0;
for ($i = 1; $i <= $total_alpha; $i++) {
    if (isset($master_denda[$i]))
        $total_denda += $master_denda[$i];
}

$sudah_bayar = (int) $row['sudah_bayar'];
$kekurangan = $total_denda - $sudah_bayar;

// Ambil daftar tanggal alpha
$alpha_dates = [];
$alpha_q = mysqli_query($db, "SELECT tanggal FROM absensi WHERE anggota_id=$id AND keterangan='ALPHA' ORDER BY tanggal ASC");
while ($a = mysqli_fetch_assoc($alpha_q)) {
    $alpha_dates[] = $a['tanggal'];
}

// Ambil riwayat pembayaran
$history = [];
$hist_q = mysqli_query($db, "SELECT total_bayar, tgl_bayar FROM pembayaran_denda WHERE anggota_id=$id ORDER BY tgl_bayar ASC");
while ($h = mysqli_fetch_assoc($hist_q)) {
    $history[] = $h;
}

// Proses submit pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bayar = isset($_POST['bayar']) ? (int) $_POST['bayar'] : 0;

    if ($bayar <= 0) {
        $error = "Jumlah bayar harus lebih dari 0!";
    } elseif ($bayar > $kekurangan) {
        $error = "Jumlah bayar tidak boleh lebih dari kekurangan!";
    } else {
        $insert = mysqli_query($db, "INSERT INTO pembayaran_denda (anggota_id, total_bayar, tgl_bayar) VALUES ($id, $bayar, NOW())")
            or die("Error insert pembayaran: " . mysqli_error($db));
        echo "<script>alert('Pembayaran berhasil!'); window.location='bayar_denda.php?id=$id';</script>";
        exit;
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Bayar Denda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="denda.php">Denda</a></li>
        <li class="breadcrumb-item active">Bayar</li>
    </ol>

    <div class="card p-3 mb-3">
        <h4><?= htmlspecialchars($row['nama']) ?> (<?= htmlspecialchars($row['kelas']) ?> -
            <?= htmlspecialchars($row['sangga']) ?>)
        </h4>
        <p>Total Alpha: <?= $total_alpha ?></p>
        <p>Total Denda: Rp <?= number_format($total_denda, 0, ",", ".") ?></p>
        <p>Sudah Bayar: Rp <?= number_format($sudah_bayar, 0, ",", ".") ?></p>
        <p>Kekurangan: Rp <?= number_format($kekurangan, 0, ",", ".") ?></p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Daftar Tanggal Alpha</h5>
        <?php if (empty($alpha_dates)): ?>
            <p class="text-muted">Belum pernah alpha.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($alpha_dates as $tgl): ?>
                    <li><?= date("d M Y", strtotime($tgl)) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="card p-3 mb-3">
        <h5>Riwayat Pembayaran</h5>
        <?php if (empty($history)): ?>
            <p class="text-muted">Belum ada pembayaran.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($history as $h): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>Rp <?= number_format($h['total_bayar'], 0, ",", ".") ?></td>
                            <td><?= date("d M Y", strtotime($h['tgl_bayar'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php if ($role == 'admin'): ?>
        <div class="card p-3">
            <?php if (isset($error))
                echo "<div class='alert alert-danger'>$error</div>"; ?>

            <?php if ($kekurangan > 0): ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Jumlah Bayar</label>
                        <input type="number" name="bayar" class="form-control" max="<?= $kekurangan ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Bayar</button>
                    <a href="denda.php" class="btn btn-secondary">Batal</a>
                </form>
            <?php else: ?>
                <div class="alert alert-success">Siswa sudah lunas.</div>
                <a href="denda.php" class="btn btn-secondary">Kembali</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php include "footer.php"; ?>