<?php
if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];

    $ambil_data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

    if (mysqli_num_rows($ambil_data) > 0) {
        $data = mysqli_fetch_array($ambil_data);
    } else {
        $_SESSION['warning'] = "Data tidak ditemukan!";
        echo "<script>window.location.href = 'media.php?page=data_pelanggan';</script>";
        exit();
    }
}
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Ubah Data Pelanggan</h3>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <form method="post" action="controller.php?ubah_pelanggan=<?= $data['id_pelanggan'] ?>">
                <div class="form-group mb-4">
                    <label class="form-label" for="nama_pelanggan">Nama Lengkap <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['nama_pelanggan']) ? 'is-invalid' : ''; ?>" name="nama_pelanggan" value="<?= $data['nama_pelanggan']; ?>" id="nama_pelanggan" type="text" placeholder="Masukan Nama Lengkap" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['nama_pelanggan']) ? $_SESSION['errors']['nama_pelanggan'] : '' ?>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input <?= isset($_SESSION['errors']['jenis_kelamin']) ? 'is-invalid' : ''; ?>" value="L" type="radio" name="jenis_kelamin" id="jenis_kelamin1" <?= $data['jenis_kelamin'] == 'L' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="jenis_kelamin1">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?= isset($_SESSION['errors']['jenis_kelamin']) ? 'is-invalid' : ''; ?>" value="P" type="radio" name="jenis_kelamin" id="jenis_kelamin2" <?= $data['jenis_kelamin'] == 'P' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="jenis_kelamin2">
                            Perempuan
                        </label>
                        <div class="invalid-feedback">
                            <?= isset($_SESSION['errors']['jenis_kelamin']) ? $_SESSION['errors']['jenis_kelamin'] : '' ?>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="nomor_hp">Nomor HP <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['nomor_hp']) ? 'is-invalid' : ''; ?>" name="nomor_hp" value="<?= $data['nomor_hp']; ?>" id="nomor_hp" type="teL" placeholder="Masukan Nomor HP" />
                    <small>Contoh: 081123456789</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['nomor_hp']) ? $_SESSION['errors']['nomor_hp'] : '' ?>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control <?= isset($_SESSION['errors']['alamat']) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" placeholder="Masukan Alamat" rows="5"><?= $data['alamat']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['alamat']) ? $_SESSION['errors']['alamat'] : '' ?>
                    </div>
                </div>
<div class="form-group mb-4">
    <label class="form-label">Poin</label>
    <input class="form-control" type="number" name="poin" value="<?= $data['poin'] ?>">
</div>

                <div class="d-flex gap-2">
                    <a href="media.php?page=data_pelanggan" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save me-1"></i> Simpan</button>
                </div>
            </form>

            <?php unset($_SESSION['errors']); ?>
        </div>
    </div>
</div>