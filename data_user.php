<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Data Pengguna</h3>
        <a href="media.php?page=tambah_user" class="btn btn-success btn-sm"><i class="fas fa-plus me-1"></i> Tambah</a>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alers -->
            <?php include "alerts.php" ?>

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Nama Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $tampil_data = mysqli_query($koneksi, "SELECT * FROM user ORDER BY nama_user ASC");
                    while ($data = mysqli_fetch_array($tampil_data)) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nama_user'] ?></td>
                            <td><?= $data['username'] ?></td>
                            <td>
                                <a href="media.php?page=ubah_user&&id_user=<?= $data['id_user'] ?>" class="btn btn-success btn-sm"> <i class=" fas fa-pencil me-1"></i> Ubah</a>
                                <a href="controller.php?hapus_user=<?= $data['id_user'] ?>" onclick="return confirm('Apakah Anda yakin menghapus \'<?= $data['nama_user'] ?>\' dari data pengguna?')" class="btn btn-danger btn-sm"> <i class="fas fa-trash me-1"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>