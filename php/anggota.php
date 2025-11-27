<?php
include "navbar.php";
include "session.php"; // session_start + ambil $username & $role
?>

<!-- / Navbar -->

<!-- konten -->
<!-- Striped Rows -->
<div class="card mx-4 mt-3">
    <div class="card-header d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Anggota</h5>
        <?php if ($role == 'admin'): ?>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAnggota">
                + Tambah Anggota
            </button>
        <?php endif; ?>
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
                    <?php if ($role == 'admin'): ?>
                        <th>Opsi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>

                <?php
                $nomor = 1;
                include "koneksi.php";
                $anggota = mysqli_query($db, "SELECT * FROM anggota");
                while ($data = mysqli_fetch_array($anggota)) {
                    ?>
                    <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['kelas'] ?></td>
                        <td><?= $data['sangga'] ?></td>
                        <td><?= $data['jkel'] ?></td>
                        <?php if ($role == 'admin'): ?>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editAnggota_<?= $data['id']; ?>">
                                    Edit
                                </button>
                                <a href="hapus_anggota.php?id=<?= $data['id'] ?>"
                                    class="btn btn-outline-danger btn-sm">Hapus</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL ADD ANGGOTA -->
<?php if ($role == 'admin'): ?>
    <div class="modal fade" id="tambahAnggota" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="proses_add_anggota.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <select name="kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="BUSANA">BUSANA</option>
                                <option value="TJKT1">TJKT 1</option>
                                <option value="TJKT2">TJKT 2</option>
                                <option value="PPLG">PPLG</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Sangga</label>
                            <input type="text" name="sangga" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jkel" class="form-control" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- MODAL EDIT -->
<?php if ($role == 'admin'): ?>
    <?php
    $anggota = mysqli_query($db, "SELECT * FROM anggota");
    while ($data = mysqli_fetch_array($anggota)) { ?>
        <div class="modal fade" id="editAnggota_<?= $data['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="proses_edit_anggota.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <select name="kelas" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option <?php if ($data['kelas'] == 'BUSANA')
                                        echo 'selected'; ?> value="BUSANA">BUSANA</option>
                                    <option <?php if ($data['kelas'] == 'TJKT1')
                                        echo 'selected'; ?> value="TJKT1">TJKT 1</option>
                                    <option <?php if ($data['kelas'] == 'TJKT2')
                                        echo 'selected'; ?> value="TJKT2">TJKT 2</option>
                                    <option <?php if ($data['kelas'] == 'PPLG')
                                        echo 'selected'; ?> value="PPLG">PPLG</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Sangga</label>
                                <input type="text" name="sangga" class="form-control" value="<?= $data['sangga'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Jenis Kelamin</label>
                                <select name="jkel" class="form-control" required>
                                    <option <?php if ($data['jkel'] == 'Laki-laki')
                                        echo 'selected'; ?> value="Laki-laki">Laki-laki
                                    </option>
                                    <option <?php if ($data['jkel'] == 'Perempuan')
                                        echo 'selected'; ?> value="Perempuan">Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>

<!-- /konten -->

<?php
include "footer.php";
?>