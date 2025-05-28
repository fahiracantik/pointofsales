<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    $_SESSION['warning'] = "Halaman tidak dapat diakses. Silahkan masuk!";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_POST['periode_awal']) && isset($_POST['periode_akhir'])) {
    $periode_awal = $_POST['periode_awal'] . " 00:00:00";
    $periode_akhir = $_POST['periode_akhir'] . " 23:59:59";

    // Query tanpa stok_barang
    $sqlPrintLaporan = "SELECT barang.*, jenis_barang.jenis_barang 
                        FROM barang 
                        INNER JOIN jenis_barang ON barang.id_jenis_barang=jenis_barang.id_jenis_barang
                        WHERE barang.tanggal_masuk BETWEEN '$periode_awal' AND '$periode_akhir'
                        ORDER BY barang.tanggal_masuk ASC";

    $queryPrintLaporan = mysqli_query($koneksi, $sqlPrintLaporan);

    if (!$queryPrintLaporan) {
        die("Query Error: " . mysqli_error($koneksi));
    }
} else {
    $_SESSION['warning'] = "Silahkan masukkan kembali periode!";
    echo "<script>window.location.href = 'media.php?page=data_riwayat_barang';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Point Of Sales</title>
    <link rel="shortcut icon" href="assets/img/hijau.png">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <style>
        table { font-size: 10px !important; }
    </style>
</head>

<body>
    <main class="d-flex justify-content-center">
        <div class="container-fluid">
            <div class="pb-2 mb-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <img src="assets/img/hijau.png" alt="Logo" width="64" height="64">
                    <div>
                        <h4 class="mb-0">POINT OF SALES TOKO SEMBAKO</h4>
                        <small class="fst-italic">Jl. Pelabuhan Sape, Komplek Pasar Tradisional Sape, Desa Naru Barat, Kec Sape, 84183</small>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-center">
                <h4>Laporan Barang Masuk</h4>
                <span>Periode: <?= date('d F Y', strtotime($periode_awal)); ?> s/d <?= date('d F Y', strtotime($periode_akhir)); ?></span>
            </div>

            <div class="mb-4">
                <small><span class="text-danger">*</span> Catatan: Subtotal = Harga Perunit ✕ Stok.</small>
            </div>

            <table class="table table-sm table-bordered">
                <thead class="table-light text-center align-middle">
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
                    $total = 0;
                    $no = 1;
                    while ($data = mysqli_fetch_array($queryPrintLaporan)) :
                        $subtotal = $data['harga'] * $data['jumlah'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime($data['tanggal_masuk'])); ?></td>
                            <td><?= $data['id_barang'] ?></td>
                            <td><?= $data['nama_barang'] ?></td>
                            <td><?= $data['jenis_barang'] ?></td>
                            <td><?= 'Rp ' . number_format($data['harga'], 0, ',', '.') ?></td>
                            <td><?= $data['unit'] ?></td>
                            <td><?= date('d-m-Y', strtotime($data['kedaluwarsa'])); ?></td>
                            <td><?= $data['jumlah']; ?></td>
                            <td><?= 'Rp ' . number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <th colspan="9" class="text-center">Total</th>
                        <th><?= 'Rp ' . number_format($total, 0, ',', '.'); ?></th>
                    </tr>
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="d-flex flex-column text-center">
                        <span class="mb-5">Mataram, <?= date('d F Y'); ?></span>
                        <h5 class="mb-0"><?= $_SESSION['nama_user']; ?></h5>
                        <small>Kasir</small>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
