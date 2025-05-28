<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center gap-2 my-4">
        <h3 class="mb-0">Riwayat Barang Masuk</h3>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#printModal"><i class="fas fa-print me-1"></i> Cetak Laporan</button>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <!-- Alerts -->
            <?php include "alerts.php"; ?>

            <div class="mb-4">
                <h6 class="mb-0"><span class="text-danger">*</span> Catatan: Sub Total = Harga Perunit ✕ Jumlah Masuk.</h6>
            </div>

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Masuk</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Harga Perunit</th>
                        <th>Satuan</th>
                        <th>Tanggal Kedaluwarsa</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $no = 1;
    $sql = "SELECT barang.*, jenis_barang.jenis_barang 
            FROM barang
            INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang
            ORDER BY barang.tanggal_masuk DESC";  // Urut berdasarkan tanggal masuk terbaru

    $query = mysqli_query($koneksi, $sql);

    while ($data = mysqli_fetch_array($query)) :
        $subtotal = $data['harga'] * $data['jumlah']; // Asumsi kolom stok ada di tabel barang
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-m-Y', strtotime($data['tanggal_masuk'])) ?></td>  <!-- Tanggal Masuk -->
            <td><?= $data['id_barang'] ?></td>
            <td><?= $data['nama_barang'] ?></td>
            <td><?= $data['jenis_barang'] ?></td>
            <td><?= 'Rp ' . number_format($data['harga'], 0, ',', '.') ?></td>
            <td><?= $data['unit'] ?></td>
            <td><?= isset($data['kedaluwarsa']) ? date('d-m-Y', strtotime($data['kedaluwarsa'])) : '-' ?></td>
            <td><?= $data['jumlah'] ?></td>
            <td><?= 'Rp ' . number_format($subtotal, 0, ',', '.') ?></td>
        </tr>
    <?php endwhile ?>
</tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="cetak_laporan_barang.php" target="printFrame" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="printModalLabel">Cetak Laporan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="periode_awal">Periode Awal <span class="text-danger">*</span></label>
                            <input class="form-control" name="periode_awal" id="periode_awal" type="date" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="periode_akhir">Periode Akhir <span class="text-danger">*</span></label>
                            <input class="form-control" name="periode_akhir" id="periode_akhir" type="date" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" onclick="printPage()"><i class="fas fa-print me-1"></i> Cetak</button>
            </div>
        </form>
    </div>
</div>

<!-- iframe untuk print laporan -->
<iframe id="printFrame" name="printFrame" style="display: none;"></iframe>