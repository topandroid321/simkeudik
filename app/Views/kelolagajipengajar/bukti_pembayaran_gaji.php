<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cetak Bukti Pembayaran</title>
   <style>
      .kotak td {
         border: 1px solid;
      }

      .kotak th {
         border: 1px solid;
      }
   </style>
</head>

<body>
   <div style="border: 1px solid; width: 650px;">
      <h1 align="center">Bukti Pembayaran Gaji</h1>
      <table align="center" class="kotak">
         <thead>
            <tr>
               <th>Nama Pengajar</th>
               <th>Nama Diklat</th>
               <th>Tanggal Pembayaran</th>
               <th>Jumlah Jam</th>
               <th>Gaji Total</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td><?= $gaji->nama_pengajar ?></td>
               <td><?= $gaji->nama_diklat ?></td>
               <td><?= $gaji->tgl_pembayaran_gaji ?></td>
               <td><?= $gaji->jumlah_jam ?></td>
               <td><?php echo $hasil_rupiah = "Rp" . number_format($gaji->gaji_total, 2, ',', '.'); ?></td>
            </tr>
         </tbody>
      </table>
      <br>
      <br>
      <table align="center">
         <tr>
            <td>
               Bendahara
               <br>
               <br>
               <br>
               <br>
               <br>
               Karisem, S.Pd
               <br>
               NIP. 212029977861625152
            </td>
            <td width="190"></td>
            <td>
               Yang Menerima
               <br>
               <br>
               <br>
               <br>
               <br>
               <?= $gaji->nama_pengajar ?>
            </td>
         </tr>
      </table>
   </div>
</body>

</html>