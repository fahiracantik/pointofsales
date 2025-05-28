<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Tambah Jenis Barang</h3>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <?php
            $idJenisBarangValue = isset($_SESSION['form_data']['id_jenis_barang']) ? $_SESSION['form_data']['id_jenis_barang'] : '';
            $jenisBarangValue = isset($_SESSION['form_data']['jenis_barang']) ? $_SESSION['form_data']['jenis_barang'] : '';
            ?>

            <form method="post" action="controller.php">
                <div class="form-group mb-4">
                    <label class="form-label" for="id_jenis_barang">ID Barang <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['id_jenis_barang']) ? 'is-invalid' : ''; ?>" name="id_jenis_barang" value="<?= $idJenisBarangValue; ?>" id="id_jenis_barang" type="text" placeholder="Masukan ID Jenis Barang" />
                    <small>Contoh: JB00001</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['id_jenis_barang']) ? $_SESSION['errors']['id_jenis_barang'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="jenis_barang">Jenis Barang <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['jenis_barang']) ? 'is-invalid' : ''; ?>" name="jenis_barang" value="<?= $jenisBarangValue; ?>" id="jenis_barang" type="text" placeholder="Masukan Jenis Barang" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['jenis_barang']) ? $_SESSION['errors']['jenis_barang'] : '' ?>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="media.php?page=data_jenis_barang" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button class="btn btn-primary btn-sm" name="tambah_jenis_barang" type="submit"><i class="fa fa-save me-1"></i> Simpan</button>
                </div>
            </form>

            <?php
            unset($_SESSION['errors']);
            unset($_SESSION['form_data']);
            ?>
        </div>
    </div>
</div>