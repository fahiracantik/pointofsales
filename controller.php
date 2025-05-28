<?php
// Koneksi Database
include "config.php";

// Auth
if (isset($_GET['aksi_login'])) {
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $errors = [];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)) {
            $errors['username'] = 'Nama pengguna wajib diisi!';
        }

        if (empty($password)) {
            $errors['password'] = 'Kata sandi wajib diisi!';
        }

        if (empty($errors)) {
            $password_hash = md5($password);
            $sql = "SELECT * FROM user WHERE username='$username' AND password='$password_hash'";
            $query = mysqli_query($koneksi, $sql);
            $result = mysqli_fetch_array($query);

            if (mysqli_num_rows($query) > 0) {
                $_SESSION['id_user'] = $result['id_user'];
                $_SESSION['nama_user'] = $result['nama_user'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['success'] = "Selamat Datang " . $_SESSION['nama_user'];
                echo "<script>window.location.href = 'media.php';</script>";
                exit();
            } else {
                $_SESSION['error'] = "Nama Pengguna atau Kata Sandi salah";
            }
        } else {
            $_SESSION['errors'] = $errors;
        }
    }
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_GET['aksi_logout'])) {
    session_start();
    session_destroy();
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
// Akhir Auth

// Data Jenis Barang
if (isset($_POST['tambah_jenis_barang'])) {
    session_start();

    $errors = [];
    $id_jenis_barang = isset($_POST['id_jenis_barang']) ? $_POST['id_jenis_barang'] : '';
    $jenis_barang = isset($_POST['jenis_barang']) ? $_POST['jenis_barang'] : '';

    if (empty($id_jenis_barang)) {
        $errors['id_jenis_barang'] = 'ID jenis barang wajib diisi!';
    } elseif (strlen($id_jenis_barang) != 7) {
        $errors['id_jenis_barang'] = 'ID jenis barang harus 7 karakter!';
    } else {
        $cek_id_jenis_barang = mysqli_query($koneksi, "SELECT id_jenis_barang FROM jenis_barang WHERE id_jenis_barang='$id_jenis_barang'");
        if (mysqli_num_rows($cek_id_jenis_barang)) {
            $errors['id_jenis_barang'] = 'ID jenis barang sudah ada!';
        }
    }

    if (empty($jenis_barang)) {
        $errors['jenis_barang'] = 'Jenis barang wajib diisi!';
    } else {
        $cek_jenis_barang = mysqli_query($koneksi, "SELECT jenis_barang FROM jenis_barang WHERE jenis_barang='$jenis_barang'");
        if (mysqli_num_rows($cek_jenis_barang)) {
            $errors['jenis_barang'] = 'Jenis barang sudah ada!';
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO jenis_barang VALUES('$id_jenis_barang', '$jenis_barang')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
            unset($_SESSION['form_data']);
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_jenis_barang';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        echo "<script>window.location.href = 'media.php?page=tambah_jenis_barang';</script>";
        exit();
    }
}

if (isset($_GET['ubah_jenis_barang'])) {
    session_start();

    $errors = [];
    $id_jenis_barang = $_GET['ubah_jenis_barang']; // Pengambilan ID melalui url action pada form
    $jenis_barang = $_POST['jenis_barang'];

    $ambil_jenis_barang = mysqli_query($koneksi, "SELECT jenis_barang FROM jenis_barang WHERE id_jenis_barang='$id_jenis_barang'");
    $jenis_barang_lama = mysqli_fetch_array($ambil_jenis_barang)['jenis_barang'];
    if (empty($jenis_barang)) {
        $errors['jenis_barang'] = 'Jenis barang wajib diisi!';
    } else {
        if ($jenis_barang !== $jenis_barang_lama) {
            $cek_jenis_barang = mysqli_query($koneksi, "SELECT jenis_barang FROM jenis_barang WHERE jenis_barang='$jenis_barang'");
            if (mysqli_num_rows($cek_jenis_barang)) {
                $errors['jenis_barang'] = 'Jenis barang sudah ada!';
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE jenis_barang SET jenis_barang='$jenis_barang' WHERE id_jenis_barang='$id_jenis_barang'";

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_jenis_barang';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        echo "<script>window.location.href = 'media.php?page=ubah_jenis_barang&&id_jenis_barang=$id_jenis_barang';</script>";
        exit();
    }
}

if (isset($_GET['hapus_jenis_barang'])) {
    session_start();

    $id_jenis_barang = $_GET['hapus_jenis_barang'];

    $query = mysqli_query($koneksi, "DELETE FROM jenis_barang WHERE id_jenis_barang='$id_jenis_barang'");

    if ($query) {
        $_SESSION['success'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Data gagal dihapus!";
    }
    echo "<script>window.location.href = 'media.php?page=data_jenis_barang';</script>";
    exit();
}
// Akhir Jenis Barang

// Barang
if (isset($_POST['tambah_barang'])) {
    session_start();

    $errors = [];
    $id_barang = isset($_POST['id_barang']) ? $_POST['id_barang'] : '';
    $id_jenis_barang = isset($_POST['id_jenis_barang']) ? $_POST['id_jenis_barang'] : '';
    $nama_barang = isset($_POST['nama_barang']) ? $_POST['nama_barang'] : '';
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $harga = isset($_POST['harga']) ? $_POST['harga'] : '';
	$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
	$tanggal_masuk = isset($_POST['tanggal_masuk']) ? $_POST['tanggal_masuk'] : '';
    $kedaluwarsa = isset($_POST['kedaluwarsa']) ? $_POST['kedaluwarsa'] : '';

    $cek_id_barang = mysqli_query($koneksi, "SELECT id_barang FROM barang WHERE id_barang='$id_barang'");
    if (mysqli_num_rows($cek_id_barang)) {
        $errors['id_barang'] = 'ID barang sudah ada!';
    } elseif (empty($id_barang)) {
        $errors['id_barang'] = 'ID barang wajib diisi!';
    } elseif (strlen($id_barang) != 7) {
        $errors['id_barang'] = 'ID barang harus 7 karakter!';
    }

    if (empty($id_jenis_barang)) {
        $errors['id_jenis_barang'] = 'Jenis barang wajib dipilih!';
    }

    if (empty($nama_barang)) {
        $errors['nama_barang'] = 'Nama barang wajib diisi!';
    }

    if (empty($unit)) {
        $errors['unit'] = 'unit wajib diisi!';
    }

    if (empty($harga)) {
        $errors['harga'] = 'Harga wajib diisi!';
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = 'Harga harus berupa angka!';
    }
	    if (empty($jumlah)) {
        $errors['jumlah'] = 'Jumlah wajib diisi!';
    } elseif (!is_numeric($jumlah)) {
        $errors['jumlah'] = 'Jumlah harus berupa angka!';
    }
    if (empty($tanggal_masuk)) {
        $errors['tanggal_masuk'] = 'Tanggal barang masuk wajib diisi!';
    }

    if (empty($kedaluwarsa)) {
        $errors['kedaluwarsa'] = 'Kedaluwarsa wajib diisi!';
    }

    if (empty($errors)) {
        $sql = "INSERT INTO barang VALUES('$id_barang', '$id_jenis_barang', '$nama_barang', '$unit', '$harga', '$jumlah', '$tanggal_masuk', '$kedaluwarsa')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
            unset($_SESSION['form_data']);
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_barang';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        echo "<script>window.location.href = 'media.php?page=tambah_barang';</script>";
        exit();
    }
}

if (isset($_GET['ubah_barang'])) {
    session_start();

    $errors = [];
    $id_barang = $_GET['ubah_barang']; // Pengambilan ID melalui url action pada form
    $id_jenis_barang = $_POST['id_jenis_barang'];
    $nama_barang = $_POST['nama_barang'];
    $unit = $_POST['unit'];
    $harga = $_POST['harga'];
	$jumlah = $_POST['jumlah'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
    $kedaluwarsa = $_POST['kedaluwarsa'];

    if (empty($id_jenis_barang)) {
        $errors['id_jenis_barang'] = 'Jenis barang wajib dipilih!';
    }

    if (empty($nama_barang)) {
        $errors['nama_barang'] = 'Nama barang wajib diisi!';
    }

    if (empty($unit)) {
        $errors['unit'] = 'Unit wajib diisi!';
    }

    if (empty($harga)) {
        $errors['harga'] = 'Harga wajib diisi!';
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = 'Harga harus berupa angka!';
    }

    if (empty($jumlah)) {
        $errors['jumlah'] = 'Jumlah wajib diisi!';
    } elseif (!is_numeric($jumlah)) {
        $errors['jumlah'] = 'Jumlah harus berupa angka!';
    }
	
	if (empty($tanggal_masuk)) {
        $errors['tanggal_masuk'] = 'Tanggal masuk barang wajib diisi!';
    }

    if (empty($kedaluwarsa)) {
        $errors['kedaluwarsa'] = 'Kedaluwarsa wajib diisi!';
    }

    if (empty($errors)) {
        $sql = "UPDATE barang SET 
                id_jenis_barang='$id_jenis_barang',
                nama_barang='$nama_barang', 
                unit='$unit',
                harga='$harga',
				jumlah='$jumlah',
				tanggal_masuk='$tanggal_masuk',
                kedaluwarsa='$kedaluwarsa'
                WHERE id_barang='$id_barang'";

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_barang';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        echo "<script>window.location.href = 'media.php?page=ubah_barang&&id_barang=$id_barang';</script>";
        exit();
    }
}


if (isset($_GET['restok_barang'])) {
    session_start();

    $errors = [];
    $id_barang = $_GET['restok_barang']; // Pengambilan ID melalui url action pada form
    $id_jenis_barang = $_POST['id_jenis_barang'];
    $nama_barang = $_POST['nama_barang'];
    $unit = $_POST['unit'];
    $harga = $_POST['harga'];
	$jumlah = $_POST['jumlah'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
    $kedaluwarsa = $_POST['kedaluwarsa'];

    if (empty($id_jenis_barang)) {
        $errors['id_jenis_barang'] = 'Jenis barang wajib dipilih!';
    }

    if (empty($nama_barang)) {
        $errors['nama_barang'] = 'Nama barang wajib diisi!';
    }

    if (empty($unit)) {
        $errors['unit'] = 'Unit wajib diisi!';
    }

    if (empty($harga)) {
        $errors['harga'] = 'Harga wajib diisi!';
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = 'Harga harus berupa angka!';
    }

    if (empty($jumlah)) {
        $errors['jumlah'] = 'Jumlah wajib diisi!';
    } elseif (!is_numeric($jumlah)) {
        $errors['jumlah'] = 'Jumlah harus berupa angka!';
    }
	
	if (empty($tanggal_masuk)) {
        $errors['tanggal_masuk'] = 'Tanggal masuk barang wajib diisi!';
    }

    if (empty($kedaluwarsa)) {
        $errors['kedaluwarsa'] = 'Kedaluwarsa wajib diisi!';
    }

    if (empty($errors)) {
        $sql = "UPDATE barang SET 
                id_jenis_barang='$id_jenis_barang',
                nama_barang='$nama_barang', 
                unit='$unit',
                harga='$harga',
				jumlah='$jumlah',
				tanggal_masuk='$tanggal_masuk',
                kedaluwarsa='$kedaluwarsa'
                WHERE id_barang='$id_barang'";

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_barang';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        echo "<script>window.location.href = 'media.php?page=restok_barang&&id_barang=$id_barang';</script>";
        exit();
    }
}

if (isset($_GET['hapus_barang'])) {
    session_start();

    $id_barang = $_GET['hapus_barang'];

    $query = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id_barang'");

    if ($query) {
        $_SESSION['success'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Data gagal dihapus!";
    }
    echo "<script>window.location.href = 'media.php?page=data_barang';</script>";
    exit();
}
// Akhir Barang

// Penjualan
if (isset($_GET['tambah_keranjang'])) {
    session_start();

    $id_barang = $_GET['tambah_keranjang'];

    $sql = "INSERT INTO penjualan VALUES(NULL, NULL, NULL, NULL, '$id_barang', NULL, NULL, 'Belum Terjual')";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        $_SESSION['success'] = "Barang berhasil ditambah ke keranjang!";
    } else {
        $_SESSION['error'] = "Barang gagal ditambah ke keranjang!";
    }
    echo "<script>window.location.href = 'media.php?page=data_penjualan_barang';</script>";
    exit();
}

if (isset($_GET['hapus_keranjang'])) {
    session_start();

    $id_penjualan = $_GET['hapus_keranjang'];

    $query = mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");

    if ($query) {
        $_SESSION['success_cart'] = "Barang berhasil dihapus dari keranjang!";
    } else {
        $_SESSION['error_cart'] = "Barang gagal dihapus dari keranjang!";
    }
    echo "<script>window.location.href = 'media.php?page=data_penjualan_barang';</script>";
    exit();
}
// Fungsi untuk menambah poin ke pelanggan
function tambahPoinPelanggan($id_pelanggan, $poin) {
    global $koneksi;
    $sql = "UPDATE pelanggan SET poin = poin + $poin WHERE id_pelanggan = '$id_pelanggan'";
    return mysqli_query($koneksi, $sql);
}

if (isset($_POST['tambah_penjualan'])) {
    session_start();

    $id_struk = $_POST['id_struk'];
    $id_pelanggan = !empty($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : NULL;
    $id_user = $_POST['id_user'];
    $tanggal_pembelian = date('Y-m-d H:i:s', strtotime($_POST['tanggal_pembelian']));
    $jumlah_pembelian = $_POST['jumlah_pembelian'];
    $total_belanja = 0;
    $transaksi = '';

    foreach ($jumlah_pembelian as $id_barang => $jumlah) {
        $jumlah = intval($jumlah);
        if ($jumlah > 0) {
            // Ambil harga jual barang
            $result = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang = '$id_barang'");
            if (!$result) {
                die("Query Error: " . mysqli_error($koneksi));
            }
            $row = mysqli_fetch_assoc($result);
            $harga = $row['harga'];

            // Hitung subtotal dan tambahkan ke total belanja
            $subtotal = $jumlah * $harga;
            $total_belanja += $subtotal;

            // Update penjualan
            $sql = "UPDATE penjualan SET id_struk='$id_struk', id_pelanggan=" . ($id_pelanggan ? "'$id_pelanggan'" : "NULL") . ", id_user='$id_user', tanggal_pembelian='$tanggal_pembelian', jumlah_pembelian='$jumlah', status_pembelian='Terjual' WHERE id_barang='$id_barang' AND status_pembelian='Belum Terjual'";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                $transaksi = 'Berhasil';

                $tanggal_masuk = date('Y-m-d H:i:s');
                $id_stok_barang = 'ST' . strtoupper(uniqid());
                mysqli_query($koneksi, "UPDATE barang SET jumlah = jumlah - $jumlah WHERE id_barang = '$id_barang'");
            } else {
                $transaksi = 'Gagal';
            }
        }
    }

    // Tambah poin jika member dan total belanja >= 20.000
// Tambah poin jika member dan total belanja >= 10.000
if (!empty($id_pelanggan) && $total_belanja >= 10000) {
    $poin = floor($total_belanja / 10000); // 1 poin tiap 10.000
    if (tambahPoinPelanggan($id_pelanggan, $poin)) {
        $_SESSION['success'] = "Transaksi berhasil, total belanja Rp" . number_format($total_belanja, 0, ',', '.') . " dan poin bertambah +$poin!";
    } else {
        $_SESSION['error'] = "Transaksi berhasil, tapi gagal menambahkan poin.";
    }
}

    if ($transaksi == 'Berhasil') {
        if (!isset($_SESSION['success'])) {
            $_SESSION['success'] = "Transaksi berhasil disimpan!";
        }
        echo "<script>
                window.onload = function() {
                    var iframe = document.createElement('iframe');
                    iframe.style.height = '0';
                    iframe.style.width = '0';
                    iframe.style.border = '0';
                    iframe.style.position = 'absolute';
                
                    iframe.src = 'cetak_nota.php?id_struk=" . $id_struk . "';
                    document.body.appendChild(iframe);
                
                    iframe.onload = function () {
                        iframe.contentWindow.print();
                        setTimeout(function () {
                            document.body.removeChild(iframe);
                            window.location.href = 'media.php?page=data_penjualan_barang';
                        }, 1000);
                    };
                };
            </script>";
        exit();
    } else {
        $_SESSION['error'] = "Transaksi gagal disimpan!";
        echo "<script>window.location.href = 'media.php?page=data_penjualan_barang';</script>";
        exit();
    }
}

//Akhir Penjualan

// User
if (isset($_POST['tambah_user'])) {
    session_start();

    $errors = [];
    $nama_user = isset($_POST['nama_user']) ? $_POST['nama_user'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($nama_user)) {
        $errors['nama_user'] = 'Nama lengkap wajib diisi!';
    }

    if (empty($username)) {
        $errors['username'] = 'Nama pengguna wajib diisi!';
    } else {
        $cek_username = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$username'");
        if (mysqli_num_rows($cek_username)) {
            $errors['username'] = 'Nama pengguna sudah ada!';
        }
    }

    if (empty($password)) {
        $errors['password'] = 'Kata sandi wajib diisi!';
    }

    if (empty($errors)) {
        $password_hash = md5($password);
        $sql = "INSERT INTO user VALUES(NULL, '$nama_user', '$username', '$password')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";
            unset($_SESSION['form_data']);
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }
        echo "<script>window.location.href = 'media.php?page=data_user';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        echo "<script>window.location.href = 'media.php?page=tambah_user';</script>";
        exit();
    }
}

if (isset($_GET['ubah_user'])) {
    session_start();

    $errors = [];
    $id_user = $_GET['ubah_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($nama_user)) {
        $errors['nama_user'] = 'Nama lengkap wajib diisi!';
    }

    $ambil_username = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='$id_user'");
    $username_lama = mysqli_fetch_array($ambil_username)['username'];

    if (empty($username)) {
        $errors['username'] = 'Nama pengguna wajib diisi!';
    } else {
        if ($username !== $username_lama) {
            $cek_username = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$username'");
            if (mysqli_num_rows($cek_username)) {
                $errors['username'] = 'Nama pengguna sudah ada!';
            }
        }
    }

    if (empty($errors)) {
        if (!empty($password)) {
            $password_hash = md5($password);
            $sql = "UPDATE user SET 
                    nama_user='$nama_user', 
                    username='$username',
                    password='$password_hash'
                    WHERE id_user='$id_user'";
        } else {
            $sql = "UPDATE user SET 
                    nama_user='$nama_user', 
                    username='$username'
                    WHERE id_user='$id_user'";
        }

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil disimpan!";

            // Update session jika user yang login mengubah datanya
            if ($id_user === $_SESSION['id_user']) {
                $_SESSION['nama_user'] = $nama_user;
                $_SESSION['username'] = $username;
            }
        } else {
            $_SESSION['error'] = "Data gagal disimpan!";
        }

        echo "<script>window.location.href = 'media.php?page=data_user';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        echo "<script>window.location.href = 'media.php?page=ubah_user&&id_user=$id_user';</script>";
        exit();
    }
}

if (isset($_GET['hapus_user'])) {
    session_start();

    $id_user = $_GET['hapus_user'];

    $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id_user'");

    if ($query) {
        $_SESSION['success'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Data gagal dihapus!";
    }
    echo "<script>window.location.href = 'media.php?page=data_user';</script>";
    exit();
}
// Akhir User

// Pelanggan
if (isset($_POST['tambah_pelanggan'])) {
    session_start();

    $errors = [];
    $nama_pelanggan = isset($_POST['nama_pelanggan']) ? $_POST['nama_pelanggan'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    $nomor_hp = isset($_POST['nomor_hp']) ? $_POST['nomor_hp'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $status_member = isset($_POST['status_member']) ? 'ya' : 'tidak';
    $poin = 0;

    if (empty($nama_pelanggan)) {
        $errors['nama_pelanggan'] = 'Nama lengkap wajib diisi!';
    }

    if (empty($jenis_kelamin)) {
        $errors['jenis_kelamin'] = 'Jenis kelamin wajib dipilih!';
    }

    if (empty($nomor_hp)) {
        $errors['nomor_hp'] = 'Nomor HP wajib diisi!';
    }

    if (empty($alamat)) {
        $errors['alamat'] = 'Alamat wajib diisi!';
    }

if (empty($errors)) {
    $sql = "INSERT INTO pelanggan 
            (nama_pelanggan, jenis_kelamin, nomor_hp, alamat, status_member, poin) 
            VALUES 
            ('$nama_pelanggan', '$jenis_kelamin', '$nomor_hp', '$alamat', 'ya', $poin)";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        $_SESSION['success'] = "Data pelanggan berhasil disimpan!";
        unset($_SESSION['form_data']);
    } else {
        $_SESSION['error'] = "Data gagal disimpan!";
    }

    echo "<script>window.location.href = 'media.php?page=data_pelanggan';</script>";
    exit();
}
}

if (isset($_GET['ubah_pelanggan'])) {
    session_start();

    $errors = [];
    $id_pelanggan = $_GET['ubah_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_hp = $_POST['nomor_hp'];
    $alamat = $_POST['alamat'];
    $status_member = isset($_POST['status_member']) ? $_POST['status_member'] : 'tidak';
    $poin = isset($_POST['poin']) ? intval($_POST['poin']) : 0;

    if (empty($nama_pelanggan)) {
        $errors['nama_pelanggan'] = 'Nama lengkap wajib diisi!';
    }

    if (empty($jenis_kelamin)) {
        $errors['jenis_kelamin'] = 'Jenis kelamin wajib dipilih!';
    }

    if (empty($nomor_hp)) {
        $errors['nomor_hp'] = 'Nomor HP wajib diisi!';
    }

    if (empty($alamat)) {
        $errors['alamat'] = 'Alamat wajib diisi!';
    }

    if (empty($errors)) {
        $sql = "UPDATE pelanggan SET 
                nama_pelanggan='$nama_pelanggan', 
                jenis_kelamin='$jenis_kelamin',
                nomor_hp='$nomor_hp',
                alamat='$alamat',
                status_member='$status_member',
                poin=$poin
                WHERE id_pelanggan='$id_pelanggan'";

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $_SESSION['success'] = "Data berhasil diubah!";
        } else {
            $_SESSION['error'] = "Data gagal diubah!";
        }
        echo "<script>window.location.href = 'media.php?page=data_pelanggan';</script>";
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        echo "<script>window.location.href = 'media.php?page=ubah_pelanggan&&id_pelanggan=$id_pelanggan';</script>";
        exit();
    }
}

if (isset($_GET['hapus_pelanggan'])) {
    session_start();

    $id_pelanggan = $_GET['hapus_pelanggan'];

    $query = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

    if ($query) {
        $_SESSION['success'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Data gagal dihapus!";
    }
    echo "<script>window.location.href = 'media.php?page=data_pelanggan';</script>";
    exit();
}
// Akhir Pelanggan
