<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Data Barang</h3>
        <a href="media.php?page=tambah_barang" class="btn btn-success btn-sm"><i class="fas fa-plus me-1"></i> Tambah</a>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alerts -->
            <?php include "alerts.php" ?>

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Harga Perunit</th>
                        <th>Unit</th>
                        <th>Jumlah</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Kedaluwarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $tampil_data = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang=jenis_barang.id_jenis_barang ORDER BY nama_barang ASC");
                    while ($data = mysqli_fetch_array($tampil_data)) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['id_barang'] ?></td>
                            <td><?= $data['nama_barang'] ?></td>
                            <td><?= $data['jenis_barang'] ?></td>
                            <td><?= 'Rp ' . number_format($data['harga'], 0, ',', '.') ?></td>
                            <td><?= $data['unit'] ?></td>
                            <td><?= $data['jumlah'] ?></td>
                            <td><?= date('d-m-Y', strtotime($data['tanggal_masuk'])); ?></td>
                            <td><?= date('d-m-Y', strtotime($data['kedaluwarsa'])) ?></td>
                            <td>
                                <a href="media.php?page=ubah_barang&&id_barang=<?= $data['id_barang'] ?>" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-pencil"></i> Ubah
                                </a>
                                <a href="controller.php?hapus_barang=<?= $data['id_barang'] ?>" onclick="return confirm('Apakah Anda yakin menghapus data dengan ID \'<?= $data['id_barang']; ?>\'?')" class="btn btn-danger btn-sm me-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
