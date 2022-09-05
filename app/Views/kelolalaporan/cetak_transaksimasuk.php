<h1>Laporan Pembayaran Diklat</h1>
<table border="1">
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
            <td><?php echo $hasil_rupiah = "Rp" . number_format($item->jumlah_bayar, 2, ',', '.'); ?></td>
         <?php endforeach ?>
         </tr>
         <tr>
            <td colspan="7">Total</td>
            <td><?php echo $hasil_rupiah = "Rp" . number_format($sumjumlahbayar->jumlah_bayar, 2, ',', '.'); ?></td>
         </tr>
   </tbody>
</table>