<h1>Laporan Pembayaran Gaji Pengajar</h1>
<table id="table" border="1" id="table" width="100%" cellspacing="0">
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
            <td><?php echo $hasil_rupiah = "Rp" . number_format($item->gaji_total, 2, ',', '.'); ?></td>
         </tr>
      <?php endforeach ?>
      <tr>
         <td colspan="5">Total</td>
         <td>
            <?php echo $hasil_rupiah = "Rp" . number_format($sumjumlahgaji->gaji_total, 2, ',', '.'); ?>
         </td>
      </tr>
   </tbody>
</table>