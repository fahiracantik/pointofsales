<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    $_SESSION['warning'] = "Halaman tidak dapat diakses. Silahkan masuk!";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_GET['id_struk'])) {
    $id_struk = $_GET['id_struk'];

    $ambil_data = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_struk='$id_struk'");
    if (mysqli_num_rows($ambil_data) > 0) {
        $data = mysqli_fetch_array($ambil_data);
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silahkan coba kembali!";
        echo "<script>window.location.href = 'media.php?page=data_transaksi_penjualan_detail&&id_struk=$id_struk';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nota Pembelian - POS Toko</title>
    <link rel="shortcut icon" href="assets/img/hijau.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        table {
            font-size: 12px !important;
        }
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

            <h4 class="text-center mb-4">Nota Pembelian</h4>

            <div class="d-flex justify-content-between gap-2 mb-4">
                <div class="table-responsive">
                    <table class="table table-borderless table-nowrap">
                        <tr>
                            <td style="width: 10rem;">ID Struk</td>
                            <td style="width: 1rem;">:</td>
                            <th><?= $data['id_struk']; ?></th>
                        </tr>
                        <tr>
                            <td>Tanggal Transaksi</td>
                            <td>:</td>
                            <th><?= date('d-m-Y H:i', strtotime($data['tanggal_pembelian'])); ?></th>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-nowrap">
                        <tr>
                            <td style="width: 10rem;">Nama Pelanggan</td>
                            <td style="width: 1rem;">:</td>
                            <th>
<?php
$id_pelanggan = $data['id_pelanggan'];
if (!empty($id_pelanggan)) {
    $pelanggan = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
    if ($pelanggan && mysqli_num_rows($pelanggan) > 0) {
        $data_pelanggan = mysqli_fetch_array($pelanggan);
        echo htmlspecialchars($data_pelanggan['nama_pelanggan']);
    } else {
        echo "-";
    }
} else {
    echo "-";
}
?>
                            </th>
                        </tr>
                        <tr>
                            <td>Dibuat oleh</td>
                            <td>:</td>
                            <th>
                                <?php
                                $id_user = $data['id_user'];
                                $user = mysqli_query($koneksi, "SELECT nama_user FROM user WHERE id_user='$id_user'");
                                $data_user = mysqli_fetch_array($user);
                                echo $data_user['nama_user'];
                                ?>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Unit</th>
                            <th>Harga Perunit</th>
                            <th>Jumlah</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total = 0;

                        $sqlNota = "SELECT * FROM penjualan
                                    INNER JOIN barang ON penjualan.id_barang=barang.id_barang
                                    WHERE id_struk='$id_struk'
                                    ORDER BY nama_barang ASC";
                        $queryNota = mysqli_query($koneksi, $sqlNota);

                        while ($hasil = mysqli_fetch_array($queryNota)) :
                            $subTotal = $hasil['harga'] * $hasil['jumlah_pembelian'];
                            $total += $subTotal;
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $hasil['id_barang']; ?></td>
                                <td><?= $hasil['nama_barang']; ?></td>
                                <td><?= $hasil['unit']; ?></td>
                                <td><?= 'Rp ' . number_format($hasil['harga'], 0, ',', '.') ?></td>
                                <td><?= $hasil['jumlah_pembelian']; ?></td>
                                <td><?= 'Rp ' . number_format($subTotal, 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile ?>
                        <tr>
                            <th colspan="6" class="text-center">Total</th>
                            <th><?= 'Rp ' . number_format($total, 0, ',', '.') ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>

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
