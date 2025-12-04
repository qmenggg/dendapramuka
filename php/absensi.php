<?php
include "navbar.php";
include "session.php";

// Hanya admin yang boleh akses
if ($role != 'admin') {
    // Bisa redirect ke home atau halaman error
    header("Location: home.php");
    exit;
}

?>

<!-- / Navbar -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- konten -->
<div class="card mx-4 mt-3">
    <form method="POST" action="proses_add_absensi.php">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0">Absensi</h5>
            <input type="date" name="tanggal">
        </div>
        <div class="table-responsive text-nowrap">
            <table cellpadding="10" cellspacing="0" id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Sangga</th>
                        <th>Jenis Kelamin</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $nomor = 1;

                    include "koneksi.php";
                    $anggota = mysqli_query($db, "select * from anggota");
                    while ($data = mysqli_fetch_array($anggota)) {
                        ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td><input type="hidden" name="anggota_id[]" value="<?= $data['id'] ?>"><?= $data['nama'] ?>
                            </td>
                            <td><?= $data['kelas'] ?></td>
                            <td><?= $data['sangga'] ?></td>
                            <td><?= $data['jkel'] ?></td>
                            <td>
                                <select name="keterangan[]" class="form-select" required>
                                    <option value="HADIR">HADIR</option>
                                    <option value="SAKIT">SAKIT</option>
                                    <option value="IZIN">IZIN</option>
                                    <option value="ALPHA">ALPHA</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <input type="submit" class="btn btn-primary" value="Simpan">
    </form>
</div>
</div>
<!-- /konten -->

<?php
include "footer.php";
?>