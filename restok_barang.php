<?php
if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    $ambil_data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'");

    if (mysqli_num_rows($ambil_data) > 0) {
        $data = mysqli_fetch_array($ambil_data);
    } else {
        $_SESSION['warning'] = "Data tidak ditemukan!";
        echo "<script>window.location.href = 'media.php?page=data_barang';</script>";
        exit();
    }
}
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Restok Barang</h3>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <form method="post" action="controller.php?restok_barang=<?= $data['id_barang']; ?>">
                <input class="form-control  d-none <?= isset($_SESSION['errors']['id_barang']) ? 'is-invalid' : ''; ?>" name="id_barang" value="<?= $data['id_barang']; ?>" id="id_barang" type="text" placeholder="Masukan ID Barang" disabled />
                <input class="form-control d-none <?= isset($_SESSION['errors']['nama_barang']) ? 'is-invalid' : ''; ?>" name="nama_barang" value="<?= $data['nama_barang']; ?>" id="nama_barang" type="text" placeholder="Masukan Nama Barang" />
                <input class="form-control d-none <?= isset($_SESSION['errors']['unit']) ? 'is-invalid' : ''; ?>" name="unit" value="<?= $data['unit'] ?>" id="unit" type="text" placeholder="Masukan unit Barang" />
                <input class="form-control d-none <?= isset($_SESSION['errors']['harga']) ? 'is-invalid' : ''; ?>" name="harga" value="<?= $data['harga']; ?>" id="harga" type="number" placeholder="Masukan Harga Barang" />
                <input class="form-control d-none <?= isset($_SESSION['errors']['tanggal_masuk']) ? 'is-invalid' : ''; ?>" name="tanggal_masuk" value="<?= $data['tanggal_masuk']; ?>" id="tanggal_masuk" type="date" />
                <select class="form-select d-none<?= isset($_SESSION['errors']['id_jenis_barang']) ? 'is-invalid' : ''; ?>" name="id_jenis_barang" id="id_jenis_barang">
                    <option value="" disabled>-- Pilih Jenis Barang --</option>

                    <?php
                    $queryJenisBarang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");
                    while ($hasil = mysqli_fetch_array($queryJenisBarang)):
                    ?>
                        <option value="<?= $hasil['id_jenis_barang']; ?>" <?= $data['id_jenis_barang'] == $hasil['id_jenis_barang'] ? 'selected' : ''; ?>><?= $hasil['jenis_barang']; ?></option>
                    <?php endwhile ?>
                </select>
                <input class="form-control d-none <?= isset($_SESSION['errors']['kedaluwarsa']) ? 'is-invalid' : ''; ?>" name="kedaluwarsa" value="<?= $data['kedaluwarsa']; ?>" id="kedaluwarsa" type="date" />

                <div class="form-group mb-4">
                    <label class="form-label" for="harga">Jumlah<span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['jumlah']) ? 'is-invalid' : ''; ?>" name="jumlah" value="<?= $data['jumlah']; ?>" id="jumlah" type="number" placeholder="Masukan Jumlah Barang" />
                    <small>Contoh: 10</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['jumlah']) ? $_SESSION['errors']['jumlah'] : '' ?>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="media.php?page=data_barang" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save me-1"></i> Simpan</button>
                </div>
            </form>

            <?php unset($_SESSION['errors']); ?>
        </div>
    </div>
</div>