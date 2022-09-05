<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('/assets/template'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('/assets/template'); ?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <h1 class="text-center text-light pt-4">SIMKEUDIK - SISTEM INFORMASI MANAJEMEN KEUANGAN DIKLAT KEPELAUTAN</h1>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img class="my-5 mx-5 p-5" src="<?= base_url('/assets/template/img'); ?>/logo.png" width="340" height="400" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Silahkan Login Terlebih Dahulu!!</h1>
                                    </div>
                                    <?php if (session()->get('pesan')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= session()->get('pesan') ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="user" action="<?= base_url('Login/login') ?>" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" <?= set_value('username') ?> name="username" id="username" placeholder="Enter username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('/assets/template'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('/assets/template'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('/assets/template'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('/assets/template'); ?>/js/sb-admin-2.min.js"></script>

</body>

</html>