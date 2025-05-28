<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Tambah Data Pengguna</h3>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <?php
            $namaUserValue = isset($_SESSION['form_data']['nama_user']) ? $_SESSION['form_data']['nama_user'] : '';
            $usernameValue = isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : '';
            ?>

            <form method="post" action="controller.php">
                <div class="form-group mb-4">
                    <label class="form-label" for="nama_user">Nama Lengkap <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['nama_user']) ? 'is-invalid' : ''; ?>" name="nama_user" value="<?= $namaUserValue; ?>" id="nama_user" type="text" placeholder="Masukan Nama Lengkap" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['nama_user']) ? $_SESSION['errors']['nama_user'] : '' ?>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="username">Nama Pengguna <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['username']) ? 'is-invalid' : ''; ?>" name="username" value="<?= $usernameValue; ?>" id="username" type="text" placeholder="Masukan Nama Pengguna" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['username']) ? $_SESSION['errors']['username'] : '' ?>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="password">Kata Sandi <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" type="password" placeholder="Masukan Kata Sandi" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['password']) ? $_SESSION['errors']['password'] : '' ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="media.php?page=data_user" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button class="btn btn-primary btn-sm" name="tambah_user" type="submit"><i class="fa fa-save me-1"></i> Simpan</button>
                </div>
            </form>

            <?php
            unset($_SESSION['errors']);
            unset($_SESSION['form_data']);
            ?>
        </div>
    </div>
</div>