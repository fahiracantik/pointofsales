<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Tambah Data Barang</h3>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <?php
            $idBarangValue = isset($_SESSION['form_data']['id_barang']) ? $_SESSION['form_data']['id_barang'] : '';
            $namaBarangValue = isset($_SESSION['form_data']['nama_barang']) ? $_SESSION['form_data']['nama_barang'] : '';
            $jenisBarangValue = isset($_SESSION['form_data']['id_jenis_barang']) ? $_SESSION['form_data']['id_jenis_barang'] : '';
            $unitValue = isset($_SESSION['form_data']['unit']) ? $_SESSION['form_data']['unit'] : '';
            $hargaValue = isset($_SESSION['form_data']['harga']) ? $_SESSION['form_data']['harga'] : '';
            $jumlahValue = isset($_SESSION['form_data']['jumlah']) ? $_SESSION['form_data']['jumlah'] : '';
            $tanggal_masukValue = isset($_SESSION['form_data']['tanggal_masuk']) ? $_SESSION['form_data']['tanggal_masuk'] : '';
            $kedaluwarsaValue = isset($_SESSION['form_data']['kedaluwarsa']) ? $_SESSION['form_data']['kedaluwarsa'] : '';
            ?>

            <form method="post" action="controller.php">
                <div class="form-group mb-4">
                    <label class="form-label" for="id_barang">ID Barang <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['id_barang']) ? 'is-invalid' : ''; ?>" name="id_barang" value="<?= $idBarangValue; ?>" id="id_barang" type="text" placeholder="Masukan ID Barang" />
                    <small>Contoh: BA00001</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['id_barang']) ? $_SESSION['errors']['id_barang'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['nama_barang']) ? 'is-invalid' : ''; ?>" name="nama_barang" value="<?= $namaBarangValue; ?>" id="nama_barang" type="text" placeholder="Masukan Nama Barang" />
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['nama_barang']) ? $_SESSION['errors']['nama_barang'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="unit">Unit <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['unit']) ? 'is-invalid' : ''; ?>" name="unit" value="<?= $unitValue; ?>" id="unit" type="text" placeholder="Masukan Unit Barang" />
                    <small>Contoh: 10 kg, 10 butir, dan lain-lain</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['unit']) ? $_SESSION['errors']['unit'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['harga']) ? 'is-invalid' : ''; ?>" name="harga" value="<?= $hargaValue; ?>" id="harga" type="number" placeholder="Masukan Harga Barang" />
                    <small>Contoh: 100000</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['harga']) ? $_SESSION['errors']['harga'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="jumlah"> Jumlah <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['jumlah']) ? 'is-invalid' : ''; ?>" name="jumlah" value="<?= $jumlahValue; ?>" id="jumlah" type="number" placeholder="Masukan Jumlah Barang" />
                    <small>Contoh: 10</small>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['jumlah']) ? $_SESSION['errors']['jumlah'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['tanggal_masuk']) ? 'is-invalid' : ''; ?>" name="tanggal_masuk" value="<?= $tanggal_masukValue; ?>" id="tanggal_masuk" type="date" />
                    <div class=" invalid-feedback">
                        <?= isset($_SESSION['errors']['tanggal_masuk']) ? $_SESSION['errors']['tanggal_masuk'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="id_jenis_barang">Jenis Barang <span class="text-danger">*</span></label>
                    <select class="form-select <?= isset($_SESSION['errors']['id_jenis_barang']) ? 'is-invalid' : ''; ?>" name="id_jenis_barang" id="id_jenis_barang">
                        <option value="" disabled <?= empty($jenisBarangValue) ? 'selected' : ''; ?>>-- Pilih Jenis Barang --</option>

                        <?php
                        $queryJenisBarang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");
                        while ($hasil = mysqli_fetch_array($queryJenisBarang)):
                        ?>
                            <option value="<?= $hasil['id_jenis_barang']; ?>" <?= $jenisBarangValue == $hasil['id_jenis_barang'] ? 'selected' : ''; ?>><?= $hasil['jenis_barang']; ?></option>
                        <?php endwhile ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['errors']['id_jenis_barang']) ? $_SESSION['errors']['id_jenis_barang'] : '' ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="kedaluwarsa">Kedaluwarsa <span class="text-danger">*</span></label>
                    <input class="form-control <?= isset($_SESSION['errors']['kedaluwarsa']) ? 'is-invalid' : ''; ?>" name="kedaluwarsa" value="<?= $kedaluwarsaValue; ?>" id="kedaluwarsa" type="date" />
                    <div class=" invalid-feedback">
                        <?= isset($_SESSION['errors']['kedaluwarsa']) ? $_SESSION['errors']['kedaluwarsa'] : '' ?>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="media.php?page=data_barang" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button class="btn btn-primary btn-sm" name="tambah_barang" type="submit"><i class="fa fa-save me-1"></i> Simpan</button>
                </div>
            </form>

            <?php
            unset($_SESSION['errors']);
            unset($_SESSION['form_data']);
            ?>
        </div>
    </div>
</div>