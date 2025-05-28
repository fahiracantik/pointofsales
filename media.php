<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    $_SESSION['warning'] = "Halaman tidak dapat diakses. Silahkan masuk!";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Point Of Sales</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/hijau.png">
    <link rel="apple-touch-icon" href="assets/img/hijau.png">

    <!-- CSS -->
    <link href="assets/css/datatables-simple.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/select2.min.css" rel="stylesheet" />
    <link href="assets/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- Icons -->
    <script src="assets/js/fontawesome-free.js"></script>
</head>

<body class="sb-nav-fixed bg-light">
<nav class="sb-topnav navbar navbar-expand navbar-light bg-white shadow-sm">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="media.php">
            <img src="assets/img/hijau.png" alt="Logo" width="24" height="24" class="me-2">
            <small>POS TOKO SEMBAKO</small>
        </a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><span class="text-uppercase d-none d-lg-inline"><?= $_SESSION['nama_user']; ?></span><i
                        class="fas fa-user fa-fw ms-2"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-right-from-bracket me-2"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="media.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Beranda
                        </a>
                            <a class="nav-link" href="media.php?page=data_user">
            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
            Data Pengguna
        </a>
                            <a class="nav-link" href="media.php?page=data_pelanggan">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data Pelanggan
                            </a>

                        <a class="nav-link" href="media.php?page=data_barang">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Data Barang
                        </a>
                            <a class="nav-link" href="media.php?page=data_jenis_barang">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                Jenis Barang
                            </a>
                        <a class="nav-link" href="media.php?page=data_penjualan_barang">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                            Transaksi
                        </a>
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <a class="nav-link" href="media.php?page=data_transaksi_penjualan">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Penjualan
                        </a>

                            <a class="nav-link" href="media.php?page=data_riwayat_barang">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Barang Masuk
                           </a>
                                                <!-- Content         <a class="nav-link" href="media.php?page=data_riwayat_barang_keluar">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Barang Keluar
                            </a>-->
                    </div>
                </div>

            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <!-- Content -->
                <?php include "konten.php" ?>
            </main>

            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; <?= date('Y'); ?> POS TOKO SEMBAKO</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="logoutModalLabel">Keluar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong class="text-capitalize"><?= $_SESSION['nama_user']; ?></strong>, apakah anda ingin mengakhiri sesi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <a type="button" class="btn btn-danger" href="controller.php?aksi_logout">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/select2.full.min.js"></script>
    <script src="assets/js/datatables-simple.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>