<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelPesertaDidik;
use App\Models\ModelTransaksiMasuk;
use App\Models\ModelTransaksiKeluar;
use App\Models\ModelGajiPengajar;
use Dompdf\Dompdf;
use App\Models\ModelDetailTransaksiMasuk;
use App\Models\ModelUser;

use Hermawan\DataTables\DataTable;

use function PHPSTORM_META\map;

class KelolaLaporan extends BaseController
{
   // laporan pembayaran masuk /transaksi masuk
   public function index()
   {
      $modeltransaksimasuk = new ModelTransaksiMasuk();
      $data['pembayaran'] = $modeltransaksimasuk->getDataTransaksi();
      $data['sumjumlahbayar'] = $modeltransaksimasuk->getJumlahTransaksiSum();
      return view('kelolalaporan/pembayarandiklat', $data);
   }
   // laporan pembayaran gaji pengajar
   public function gajipengajar()
   {
      $modelgajipengajar = new ModelGajiPengajar();
      $data['sumjumlahgaji'] = $modelgajipengajar->getJumlahgajiSum();
      $data['gaji'] = $modelgajipengajar->getAllDataGaji();
      return view('kelolalaporan/pembayarangaji', $data);
   }

   public function transaksikeluar()
   {
      $modeltransaksikeluar = new ModelTransaksiKeluar();
      $data['pembayaran'] = $modeltransaksikeluar->getTransaksiKeluar();
      return view('kelolalaporan/transaksikeluar', $data);
   }
   //cetak laporan pembayaran diklat atau transaksi masuk
   public function cetak_lap_transaksimasuk()
   {
      $modeltransaksimasuk = new ModelTransaksiMasuk();
      $data['sumjumlahbayar'] = $modeltransaksimasuk->getJumlahTransaksiSum();
      $data['pembayaran'] = $modeltransaksimasuk->getDataTransaksi();

      $filename = date('y-m-d-H-i-s') . '-Transaksi Masuk';

      // instantiate and use the dompdf class
      $dompdf = new Dompdf();

      // load HTML content
      $dompdf->loadHtml(view('KelolaLaporan/cetak_transaksimasuk', $data));

      // (optional) setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // render html as PDF
      $dompdf->render();

      // output the generated pdf
      $dompdf->stream($filename);
   }

   //cetak lapran pembayaran gaji
   public function cetak_lap_gaji()
   {
      $modelgajipengajar = new ModelGajiPengajar();
      $data['sumjumlahgaji'] = $modelgajipengajar->getJumlahgajiSum();
      $data['gaji'] = $modelgajipengajar->getAllDataGaji();

      $filename = date('y-m-d-H-i-s') . '-Gaji Pengajar';

      // instantiate and use the dompdf class
      $dompdf = new Dompdf();

      // load HTML content
      $dompdf->loadHtml(view('KelolaLaporan/cetak_gajipengajar', $data));

      // (optional) setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // render html as PDF
      $dompdf->render();

      // output the generated pdf
      $dompdf->stream($filename);
   }

   public function cetak_lap_pertgl()
   {
      $tgl_awal = $this->request->getVar('tgl_awal');
      $tgl_akhir = $this->request->getVar('tgl_akhir');
      $modeltransaksimasuk = new ModelTransaksiMasuk();
      $data['sumjumlahbayar'] = $modeltransaksimasuk->getJumlahBarangSumPerTgl($tgl_awal, $tgl_akhir);
      $data['pembayaran'] = $modeltransaksimasuk->getDataPerTgl($tgl_awal, $tgl_akhir);

      $filename = date('y-m-d-H-i-s') . '-Transaksi Masuk Pertanggal';

      // instantiate and use the dompdf class
      $dompdf = new Dompdf();

      // load HTML content
      $dompdf->loadHtml(view('KelolaLaporan/cetak_transaksimasuk', $data));

      // (optional) setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // render html as PDF
      $dompdf->render();

      // output the generated pdf
      $dompdf->stream($filename);
   }
   public function cetak_gaji_pertgl()
   {
      $tgl_awal = $this->request->getVar('tgl_awal');
      $tgl_akhir = $this->request->getVar('tgl_akhir');
      $modelgajipengajar = new ModelGajiPengajar();
      $data['sumjumlahgaji'] = $modelgajipengajar->getJumlahgajiSumPertgl($tgl_awal, $tgl_akhir);
      $data['gaji'] = $modelgajipengajar->getDataGajitgl($tgl_awal, $tgl_akhir);

      $filename = date('y-m-d-H-i-s') . '-Gaji Pertanggal';

      // instantiate and use the dompdf class
      $dompdf = new Dompdf();

      // load HTML content
      $dompdf->loadHtml(view('KelolaLaporan/cetak_gajipengajar', $data));

      // (optional) setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // render html as PDF
      $dompdf->render();

      // output the generated pdf
      $dompdf->stream($filename);
   }

   public function cetak_transaksikeluar()
   {
      $modeltransaksikeluar = new ModelTransaksiKeluar();
      $data['pembayaran'] = $modeltransaksikeluar->getTransaksiKeluar();

      $filename = date('y-m-d-H-i-s') . '-Transaksi Keluar';

      // instantiate and use the dompdf class
      $dompdf = new Dompdf();

      // load HTML content
      $dompdf->loadHtml(view('KelolaLaporan/cetak_transaksikeluar', $data));

      // (optional) setup the paper size and orientation
      $dompdf->setPaper('A4', 'landscape');

      // render html as PDF
      $dompdf->render();

      // output the generated pdf
      $dompdf->stream($filename);
   }
}
