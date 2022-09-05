<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

   <!-- Begin Page Content -->
   <div class="container-fluid">
      <h3>Laporan Pembayaran Gaji Pengajar</h3>
      <br />
      <a href="<?= base_url() ?>/kelolalaporan/cetak_lap_gaji" class="btn btn-success"><i class="fas fa-print"></i> Cetak Semua</a>
      <br />
      <br />
      <form method="POST" action="<?php base_url() ?>/kelolalaporan/cetak_gaji_pertgl">
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
            <h6 class="m-0 font-weight-bold text-primary">Laporan Pembayaran Gaji Transaksi</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="table" class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Nama Pengajar</th>
                        <th>Nama Diklat</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Jumlah Jam</th>
                        <th>Gaji Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $no = 1;
                     foreach ($gaji as $item) : ?>
                        <tr>
                           <td><?= $no++ ?></td>
                           <td><?= $item->nama_pengajar ?></td>
                           <td><?= $item->nama_diklat ?></td>
                           <td><?= $item->tgl_pembayaran_gaji ?></td>
                           <td><?= $item->jumlah_jam ?></td>
                           <td id="count"><?php echo $hasil_rupiah = "Rp" . number_format($item->gaji_total, 2, ',', '.'); ?></td>
                        </tr>
                     <?php endforeach ?>
                  </tbody>
                  <tr>
                     <td colspan="5">Total</td>
                     <td><?php echo $hasil_rupiah = "Rp" . number_format($sumjumlahgaji->gaji_total, 2, ',', '.'); ?></td>
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