<?php $session = session() ?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><b>Dashboard Bendahara</b></h1>
    <h2 class="h4 mb-4 text-gray-800">Selamat Datang <?= $session->get('nama_lengkap') ?></h2>
    <div class="row">
        <div class="col">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Masuk</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Keluar</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
    ];

    const data = {
        labels: labels,
        datasets: [{
            label: 'Transaksi Masuk 2022',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<script>
    const labels2 = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
            label: 'Transaksi Keluar 2022',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    };

    const config2 = {
        type: 'line',
        data: data2,
        options: {}
    };
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
</script>
<?= $this->endSection() ?>