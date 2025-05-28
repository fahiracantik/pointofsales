<?php
// Mengatur zona waktu ke Asia/Makassar
date_default_timezone_set('Asia/Makassar');

// Konfigurasi database
$hostname   = "localhost";
$username   = "root";
$password   = "";
$dbname     = "penjualan";

$koneksi = mysqli_connect($hostname, $username, $password, $dbname);
