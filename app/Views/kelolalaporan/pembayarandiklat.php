<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

   <!-- Begin Page Content -->
   <div class="container-fluid">
      <h3>Laporan Pembayaran Diklat</h3>
      <br />
      <a href="<?= base_url() ?>/kelolalaporan/cetak_lap_transaksimasuk" class="btn btn-success"><i class="fas fa-print"></i> Cetak Semua</a>
      <br />
      <br />
      <form method="POST" action="<?php base_url() ?>/kelolalaporan/cetak_lap_pertgl">
         <div class="row">
            <div class="col-2">
               <label for="">Tanggal Mulai</label>
               <input type="date" name="tgl_awal" class="form-control" placeholder="First name">
            </div>
            <div class="col-2">
               <label for="">Tanggal Akhir</label>
               <input type="date" name="tgl_akhir" class="form-control" placeholder="Last name">
            </div>
            <div class="col-2">
               <label for="">Cetak Per Tanggal</label>
               <br>
               <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
            </div>
         </div>
      </form>
      <br>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Pembayaran Diklat</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="table" class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Nama Taruna</th>
                        <th>Kelas / Jurusan</th>
                        <th>Nama Diklat</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Status Verifikasi</th>
                        <th>Status Pembayaran</th>
                        <th>Jumlah Bayar</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $no = 1;
                     foreach ($pembayaran as $item) : ?>
                        <tr>
                           <td><?= $no++ ?></td>
                           <td><?= $item->nama_lengkap ?></td>
                           <td><?= $item->kelas ?> / <?= $item->jurusan ?></td>
                           <td><?= $item->nama_diklat ?></td>
                           <td><?= $item->tgl_transaksi ?></td>
                           <td><?= $item->status_verifikasi ?></td>
                           <td><?= $item->status_pembayaran ?></td>
                           <td id="count"><?php echo $hasil_rupiah = "Rp" . number_format($item->jumlah_bayar, 2, ',', '.'); ?></td>
                        </tr>
                     <?php endforeach ?>

                  </tbody>
                  <tr>
                     <td colspan="7">Total</td>
                     <td>
                        <?php echo $hasil_rupiah = "Rp" . number_format($sumjumlahbayar->jumlah_bayar, 2, ',', '.'); ?>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
   </div>

</div>
<script>
   $(document).ready(function() {
      $('#table').DataTable();
   });
</script>
<?= $this->endSection() ?>