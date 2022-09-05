<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIMKEUDIK</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('/assets/template'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/assets/plugins/node_modules/'); ?>/sweetalert2/dist/sweetalert2.min.css">
    <link href="<?= base_url('/assets/select'); ?>/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('/assets/template'); ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('/assets/template'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('/assets/template'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('/assets/select'); ?>/js/select2.full.min.js"></script>
    <script src="<?= base_url('/assets/jqueryui'); ?>/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTable CDN js -->
    <!-- Page level plugins -->
    <script src="<?= base_url('/assets/plugins/node_modules/'); ?>/sweetalert2/dist/sweetalert2.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Kode untuk mengatur sidebar menu agar sesuai dengan role akses -->
        <?php
        if (session()->get('role') == "1") {
            echo $this->include('layouts/sidebar');
        } else if (session()->get('role') == "2") {
            echo $this->include('layouts/sidebarbendahara');
        } else if (session()->get('role') == "3") {
            echo $this->include('layouts/sidebarkaprog');
        } else {
            echo $this->include('layouts/sidebarpeserta');
        }

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?= $this->include('layouts/navbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $this->renderSection('content'); ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Simkeudik Dev 0.1</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>




    <script src="<?= base_url('/assets/template'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('/assets/template'); ?>/js/sb-admin-2.min.js"></script>



</body>

</html>