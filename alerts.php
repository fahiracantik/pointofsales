<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <strong class="text-capitalize"><i class="fas fa-circle-check me-1"></i> <?= $_SESSION['success']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['success']) ?>
<?php endif ?>

<?php if (isset($_SESSION['warning'])): ?>
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <strong class="text-capitalize"><i class="fas fa-triangle-exclamation me-1"></i> <?= $_SESSION['warning']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['warning']) ?>
<?php endif ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <strong class="text-capitalize"><i class="fas fa-xmark me-1"></i> <?= $_SESSION['error']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <?php unset($_SESSION['error']) ?>
<?php endif ?>

<?php
// Cek apakah sedang di halaman 'data_barang'
if (isset($_GET['page']) && $_GET['page'] === 'data_barang') {
    include "config.php"; // pastikan koneksi sudah dibuat

    $cek_stok = mysqli_query($koneksi, "SELECT * FROM barang WHERE jumlah <= 3");
    while ($stok = mysqli_fetch_array($cek_stok)) :
?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Perhatian!</strong> Stok barang <strong><?= $stok['nama_barang'] ?></strong> hanya tersisa <strong><?= $stok['jumlah'] ?></strong> unit.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
    endwhile;
}
?>

