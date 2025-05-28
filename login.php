<?php session_start(); ?>

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
    <link href="assets/css/styles.css" rel="stylesheet" />

    <!-- Icons -->
    <script src="assets/js/fontawesome-free.js"></script>
</head>

<body class="bg-light">
    <main class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4 p-2">
                        <div class="card-body">
                            <img src="assets/img/hijau.png" alt="Logo" class="d-block mx-auto mb-2" height="100" width="100">
                            <h4 class="text-center font-weight-light mb-5 text-uppercase">Point Of Sales <br> Toko Sembako</h4>

                            <?php if (isset($_SESSION['warning'])): ?>
                                <div class="alert alert-warning text-center mb-4" role="alert">
                                    <i class="fas fa-triangle-exclamation me-1"></i> <?= $_SESSION['warning']; ?>
                                </div>
                                <?php unset($_SESSION['warning']) ?>
                            <?php endif ?>

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger text-center mb-4" role="alert">
                                    <i class="fas fa-xmark me-1"></i> <?= $_SESSION['error']; ?>
                                </div>
                                <?php unset($_SESSION['error']) ?>
                            <?php endif ?>

                            <form method="post" action="controller.php?aksi_login">
                                <div class="form-floating mb-4">
                                    <input class="form-control <?= (isset($_SESSION['errors']['username'])) ? 'is-invalid' : ''; ?>" id="username" name="username" type="text" placeholder="Nama Pengguna" />
                                    <label for="username">Nama Pengguna</label>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['errors']['username']) ? $_SESSION['errors']['username'] : '' ?>
                                    </div>
                                </div>
                                <div class="form-floating mb-4">
                                    <input class="form-control <?= (isset($_SESSION['errors']['password'])) ? 'is-invalid' : ''; ?>" id="password" name="password" type="password" placeholder="Kata Sandi" />
                                    <label for="password">Kata Sandi</label>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['errors']['password']) ? $_SESSION['errors']['password'] : '' ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4">
                                    <button class="btn btn-lg btn-outline-pink w-100 fs-3"type="submit">Masuk</button>
                                </div>
                            </form>

                            <?php unset($_SESSION['errors']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Javascript -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>