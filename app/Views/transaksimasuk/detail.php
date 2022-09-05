<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3>Detail Transaksi Masuk</h3>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Masuk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Taruna</th>
                                <th>Kelas / Jurusan</th>
                                <th>Nama Diklat</th>
                                <th>Tanggal Transaksi</th>
                                <th>Jumlah Bayar</th>
                                <th>Status Pembayaran</th>
                                <th>Sisa Pembayaran</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($transaksi as $row) {
                                $hargadiklat = $row->harga;
                                $jumlahbayar = $row->jumlah_bayar;
                                $sisabayar = $hargadiklat - $jumlahbayar;
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->nama_lengkap ?></td>
                                    <td><?= $row->kelas ?> / <?= $row->jurusan ?></td>
                                    <td><?= $row->nama_diklat ?></td>
                                    <td><?= $row->tgl_transaksi ?></td>
                                    <td><?= $row->jumlah_bayar ?></td>
                                    <td><?= $row->status_pembayaran ?></td>
                                    <td>Rp. <?= $row->sisa_pembayaran ?></td>
                                    <td><?= $row->status_verifikasi ?></td>
                                    <td>
                                        <?php if ($row->status_verifikasi == "Belum Terverifikasi") : ?>
                                            <a href="/transaksimasuk/verifikasi/<?= $row->id_detail_transaksi ?>" class="btn btn-primary"><i class="fas fa-check"></i> </a>
                                        <?php else : ?>
                                            <a href="/transaksimasuk/tambahtransaksi/<?= $row->id_transaksi_masuk ?>/<?= $row->id_diklat ?>" class="btn btn-primary">Tambah</a>
                                            <a href="/transaksimasuk/cetakbukti/<?= $row->id_transaksi_masuk ?>/<?= $row->id_diklat ?>" class="btn btn-primary"><i class="fas fa-print"></i>Cetak Kwitansi</a>
                                        <?php endif ?>
                                    </td>
                                <?php } ?>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>