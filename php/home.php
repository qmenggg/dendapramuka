
<?php
include "session.php";
include "koneksi.php";
include "navbar.php";

// =======================
// AMBIL MASTER DENDA
// =======================
$master_denda = [];
$res = mysqli_query($db, "SELECT * FROM master_denda ORDER BY alpha ASC");
while ($row = mysqli_fetch_assoc($res)) {
  $master_denda[$row['alpha']] = $row['nominal'];
}

// =======================
// AMBIL DATA SETIAP SISWA
// =======================
$sql = "
SELECT ag.id, ag.nama,
SUM(CASE WHEN a.keterangan='Alpha' THEN 1 ELSE 0 END) AS total_alpha,
IFNULL(pd.total_bayar,0) AS sudah_bayar
FROM anggota ag
LEFT JOIN absensi a ON ag.id = a.anggota_id
LEFT JOIN (
    SELECT anggota_id, SUM(total_bayar) AS total_bayar
    FROM pembayaran_denda
    GROUP BY anggota_id
) pd ON ag.id = pd.anggota_id
GROUP BY ag.id
";

$q = mysqli_query($db, $sql);

// HITUNG TOTAL2AN
$total_denda_keseluruhan = 0;
$total_pembayaran = 0;
$leaderboard = [];
$rows_per_siswa = []; // optional, in case later needed

while ($row = mysqli_fetch_assoc($q)) {
  $alpha = (int) $row['total_alpha'];

  // HITUNG DENDA MODEL BERTINGKAT PERSIS SEPERTI DI HALAMAN DENDA
  $total_denda_siswa = 0;
  for ($i = 1; $i <= $alpha; $i++) {
    if (isset($master_denda[$i])) {
      $total_denda_siswa += $master_denda[$i];
    }
  }

  $total_denda_keseluruhan += $total_denda_siswa;
  $total_pembayaran += (int) $row['sudah_bayar'];

  // simpan ke leaderboard
  $leaderboard[] = [
    "id" => $row['id'],
    "nama" => $row['nama'],
    "alpha" => $alpha,
    "total_denda" => $total_denda_siswa,
    "sudah_bayar" => (int) $row['sudah_bayar']
  ];

  // simpan rows per siswa (jika butuh detail nanti)
  $rows_per_siswa[$row['id']] = [
    "nama" => $row['nama'],
    "alpha" => $alpha,
    "total_denda" => $total_denda_siswa,
    "sudah_bayar" => (int) $row['sudah_bayar']
  ];
}

$sisa_denda = $total_denda_keseluruhan - $total_pembayaran;
if ($sisa_denda < 0)
  $sisa_denda = 0;

// SORT LEADERBOARD (desc alpha)
usort($leaderboard, function ($a, $b) {
  return $b['alpha'] - $a['alpha'];
});

// =======================
// CHART ABSENSI
// =======================
$qChart = mysqli_query($db, "
    SELECT keterangan, COUNT(*) AS jumlah
    FROM absensi
    GROUP BY keterangan
");

$chartLabels = [];
$chartValues = [];

while ($row = mysqli_fetch_assoc($qChart)) {
  $chartLabels[] = $row['keterangan'];
  $chartValues[] = (int) $row['jumlah'];
}

// total alpha overall (sum of alpha column we built)
$totalAlphaAll = array_sum(array_column($leaderboard, 'alpha'));
?>

<!-- Optional: Bootstrap Icons (if navbar.php/head belum include) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
  /* small cosmetic tweaks */
  .card-left-accent {
    border-left: 6px solid;
    border-radius: .6rem;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
  }

  .leader-medal {
    font-size: 1.1rem;
    width: 40px;
    text-align: center;
  }

  .leader-row {
    transition: background .12s ease;
  }

  .leader-row:hover {
    background: rgba(13, 110, 253, 0.03);
  }

  .small-muted {
    color: #6c757d;
    font-size: .85rem;
  }
</style>

<div class="container mt-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <!-- <div>
      <h2 class="mb-0">Dashboard</h2>
      <div class="small-muted">Aplikasi Denda Pramuka Kiciraka</div>
    </div> -->
    <div class="container mb-0">
      <div class="card border-0 p-2">
        <h1>Selamat datang, <?= htmlspecialchars($username) ?>!</h1>
        <p>Role Anda: <strong style="color: <?= $textColor ?>;"><?= htmlspecialchars($role) ?></strong></p>
      </div>
    </div>
    <div>
      <a href="rekap.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-text me-1"></i> Lihat
        Rekap</a>
    </div>
  </div>

  <!-- CARD STATISTIK (styled) -->
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card card-left-accent" style="border-left-color:#0d6efd;">
        <div class="card-body d-flex align-items-center">
          <div>
            <div class="small-muted">Total Alpha</div>
            <h3 class="fw-bold mb-0"><?= number_format($totalAlphaAll) ?></h3>
          </div>
          <div class="ms-auto text-primary">
            <i class="bi bi-clipboard-x fs-1"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-left-accent" style="border-left-color:#dc3545;">
        <div class="card-body d-flex align-items-center">
          <div>
            <div class="small-muted">Total Denda</div>
            <h3 class="fw-bold mb-0">Rp <?= number_format($total_denda_keseluruhan, 0, ",", ".") ?></h3>
          </div>
          <div class="ms-auto text-danger">
            <i class="bi bi-cash-stack fs-1"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-left-accent" style="border-left-color:#28a745;">
        <div class="card-body d-flex align-items-center">
          <div>
            <div class="small-muted">Total Pembayaran</div>
            <h3 class="fw-bold mb-0">Rp <?= number_format($total_pembayaran, 0, ",", ".") ?></h3>
          </div>
          <div class="ms-auto text-success">
            <i class="bi bi-wallet2 fs-1"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-left-accent" style="border-left-color:#ffc107;">
        <div class="card-body d-flex align-items-center">
          <div>
            <div class="small-muted">Sisa Denda</div>
            <h3 class="fw-bold mb-0">Rp <?= number_format($sisa_denda, 0, ",", ".") ?></h3>
          </div>
          <div class="ms-auto text-warning">
            <i class="bi bi-exclamation-triangle fs-1"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MAIN ROW: Leaderboard + Chart -->
  <div class="row mt-4">
    <!-- Leaderboard -->
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
          <div class="fw-semibold">🏆 Leaderboard Alpha (Top 5)</div>
          <small class="small-muted">Peringkat berdasarkan jumlah Alpha</small>
        </div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush">
            <?php
            $rank = 1;
            foreach (array_slice($leaderboard, 0, 5) as $l):
              $medal = $rank == 1 ? '🥇' : ($rank == 2 ? '🥈' : ($rank == 3 ? '🥉' : '🏅'));
              ?>
              <div class="list-group-item d-flex align-items-center leader-row">
                <div class="leader-medal"><?= $medal ?></div>
                <div class="ms-2">
                  <div class="fw-semibold"><?= htmlspecialchars($l['nama']) ?></div>
                  <div class="small-muted">Alpha: <?= $l['alpha'] ?> &nbsp; • &nbsp; Denda: Rp
                    <?= number_format($l['total_denda'] ?? 0, 0, ",", ".") ?>
                  </div>
                </div>
                <div class="ms-auto text-end">
                  <?php
                  $kekurangan = max(0, ($l['total_denda'] ?? 0) - ($l['sudah_bayar'] ?? 0));
                  if ($kekurangan <= 0) {
                    echo '<span class="badge bg-success">LUNAS</span>';
                  } else {
                    echo '<span class="badge bg-danger">Rp ' . number_format($kekurangan, 0, ",", ".") . '</span>';
                  }
                  ?>
                </div>
              </div>
              <?php
              $rank++;
            endforeach;
            ?>
          </div>
        </div>
        <div class="card-footer text-muted small">
          <i class="bi bi-info-circle"></i> Klik <strong>Denda</strong> untuk detail pembayaran per siswa.
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
          <div class="fw-semibold">📊 Diagram Absensi Keseluruhan</div>
          <div class="small-muted">Perbandingan jumlah tiap keterangan</div>
        </div>
        <div class="card-body">
          <canvas id="absensiChart" style="max-height:360px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function () {
    const ctx = document.getElementById('absensiChart').getContext('2d');

    // prepare colors (auto) — you can change these to match theme
    const colors = [
      'rgba(13,110,253,0.85)', // blue
      'rgba(25,135,84,0.85)', // green
      'rgba(220,53,69,0.85)', // red
      'rgba(255,193,7,0.85)', // yellow
      'rgba(108,117,125,0.85)' // gray (fallback)
    ];

    const labels = <?= json_encode($chartLabels) ?>;
    const values = <?= json_encode($chartValues) ?>;

    // build dataset with dynamic color assignment
    const dataset = {
      label: 'Jumlah',
      data: values,
      backgroundColor: labels.map((_, i) => colors[i % colors.length]),
      borderColor: labels.map((_, i) => colors[i % colors.length].replace('0.85', '1')),
      borderWidth: 1
    };

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [dataset]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          x: {
            ticks: { maxRotation: 0, autoSkip: false }
          },
          y: {
            beginAtZero: true,
            ticks: { precision: 0 }
          }
        }
      }
    });
  })();
</script>

<?php include "footer.php"; ?>