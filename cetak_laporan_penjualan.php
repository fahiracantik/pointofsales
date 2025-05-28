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

    $sqlPrintLaporan = "SELECT 
                            penjualan.id_struk, 
                            penjualan.tanggal_pembelian, 
                            pelanggan.nama_pelanggan,
                            SUM(barang.harga * penjualan.jumlah_pembelian) AS total_transaksi
                        FROM penjualan
                        LEFT JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan
                        INNER JOIN barang ON penjualan.id_barang = barang.id_barang
                        WHERE penjualan.tanggal_pembelian BETWEEN '$periode_awal' AND '$periode_akhir'
                        GROUP BY penjualan.id_struk, penjualan.tanggal_pembelian, pelanggan.nama_pelanggan
                        ORDER BY penjualan.tanggal_pembelian ASC";

    $queryPrintLaporan = mysqli_query($koneksi, $sqlPrintLaporan);
} else {
    $_SESSION['warning'] = "Silahkan masukan kembali periode!";
    echo "<script>window.location.href = 'media.php?page=data_transaksi_penjualan';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Laporan Penjualan - POS</title>
    <link rel="shortcut icon" href="assets/img/hijau.png">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <style>
        table {
            font-size: 12px !important;
        }
    </style>
</head>

<body>
    <main class="d-flex justify-content-center">
        <div class="container-fluid">
            <!-- Header toko -->
            <div class="pb-2 mb-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <img src="assets/img/hijau.png" alt="Logo" width="64" height="64">
                    <div class="d-flex flex-column gap-1">
                        <h4 class="mb-0">POINT OF SALES TOKO SEMBAKO</h4>
                        <small class="fst-italic">Jl. Pelabuhan Sape, Komplek Pasar Tradisional Sape, Desa Naru Barat, Kec Sape, 84183</small>
                    </div>
                </div>
            </div>

            <!-- Judul -->
            <div class="mb-4 text-center">
                <h4>Laporan Penjualan</h4>
                <span>Periode: <?= date('d F Y', strtotime($periode_awal)); ?> s/d <?= date('d F Y', strtotime($periode_akhir)); ?></span>
            </div>

            <!-- Tabel Laporan -->
            <table class="table table-sm table-bordered">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>ID Struk</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $no = 1;
                    while ($data = mysqli_fetch_array($queryPrintLaporan)) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($data['tanggal_pembelian'])); ?></td>
                            <td><?= $data['id_struk'] ?></td>
                            <td><?= !empty($data['nama_pelanggan']) ? htmlspecialchars($data['nama_pelanggan']) : '<em>-</em>' ?></td>
                            <td><?= 'Rp ' . number_format($data['total_transaksi'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php $total += $data['total_transaksi']; ?>
                    <?php endwhile ?>
                    <tr>
                        <th colspan="4" class="text-center">Total Keseluruhan</th>
                        <th><?= 'Rp ' . number_format($total, 0, ',', '.'); ?></th>
                    </tr>
                </tbody>
            </table>

            <!-- Footer cetak -->
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
