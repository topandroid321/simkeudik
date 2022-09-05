<h1>Laporan Transaksi Keluar</h1>
<table id="table" border="1" class="table table-bordered" id="table" width="100%" cellspacing="0">
   <thead>
      <tr>
         <th>No</th>
         <th>Tanggal Transaksi Keluar</th>
         <th>Nama Diklat</th>
         <th>Pelaksanaan Diklat</th>
         <th>Jumlah Pembayaran</th>
         <th>Keterangan</th>
      </tr>
   </thead>
   <tbody>
      <?php
      $no = 1;
      foreach ($pembayaran as $item) : ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $item->tgl_transaksi_keluar ?></td>
            <td><?= $item->nama_diklat ?></td>
            <td><?= $item->tanggal_pelaksanaan ?></td>
            <td id="count"><?php echo $hasil_rupiah = "Rp" . number_format($item->total_biaya, 2, ',', '.'); ?></td>
            <td><?= $item->keterangan ?></td>
         </tr>
      <?php endforeach ?>
      <tr>
         <td colspan="4">Total</td>
         <td>
         </td>
         <td>
         </td>
      </tr>
   </tbody>
</table>