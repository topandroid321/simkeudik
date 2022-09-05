<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelTransaksiMasuk;
use App\Models\ModelLemdik;
use App\Models\ModelDiklat;
use App\Models\ModelPesertaDidik;
use App\Models\ModelPerencanaanDiklat;
use CodeIgniter\Model;
use CodeIgniter\Files\File;
use Hermawan\DataTables\DataTable;


class PembayaranPeserta extends BaseController
{
   public function __construct()
   {
      if (session()->get('role') == "1" || session()->get('role') == "3" || session()->get('role') == NULL) {
         echo view('pages/blok');
         exit;
      }
   }

   public function index()
   {
      helper(['form', 'url']);
      $this->ModelTransaksiMasuk = new ModelTransaksiMasuk();
      return view('PembayaranPeserta/tampildata');
   }

   public function history()
   {
      helper(['form', 'url']);
      $this->ModelTransaksiMasuk = new ModelTransaksiMasuk();
      return view('PembayaranPeserta/history');
   }

   // mengambil data
   public function getData()
   {
      $session = session();
      $db = db_connect();
      $builder = $db->table('t_transaksi_masuk')
         ->select('t_transaksi_masuk.id_transaksi_masuk,m_peserta_didik.nama_lengkap,m_peserta_didik.kelas,m_peserta_didik.jurusan,m_diklat.id_diklat,m_diklat.nama_diklat,t_perencanaan_diklat.tanggal_pelaksanaan,t_transaksi_masuk.status_pembayaran,t_detail_transaksi.status_verifikasi,t_detail_transaksi.file')
         ->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn')
         ->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id')
         ->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk')
         ->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id')
         ->where('m_peserta_didik.nisn', $session->get('nisn'))
         ->where('t_detail_transaksi.status_verifikasi', "Belum Terverifikasi")
         ->orWhere('t_transaksi_masuk.status_pembayaran', "Belum Lunas");

      return DataTable::of($builder)
         ->add('action', function ($builder) {
            return '
                <a class="btn btn-primary" href="' . base_url('/transaksimasuk/detailtransaksi') . '/' . $builder->id_transaksi_masuk . '/' . $builder->id_diklat . '">Detail</a>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_transaksi_masuk . ')"><i class="fas fa-trash"></i></button>
                <a class="btn btn-primary" href="uploads/' . $builder->file . '">Bukti Transaksi</a>
                ';
         }, 'last')
         ->hide('id_diklat')
         ->hide('file')
         ->addNumbering()
         ->toJson();
   }

   public function getDataHistory()
   {
      $session = session();
      $db = db_connect();
      $builder = $db->table('t_transaksi_masuk')
         ->select('t_transaksi_masuk.id_transaksi_masuk,m_peserta_didik.nama_lengkap,m_peserta_didik.kelas,m_peserta_didik.jurusan,m_diklat.id_diklat,m_diklat.nama_diklat,t_detail_transaksi.jumlah_bayar,t_perencanaan_diklat.tanggal_pelaksanaan,t_transaksi_masuk.status_pembayaran,t_detail_transaksi.status_verifikasi')
         ->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn')
         ->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id')
         ->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk')
         ->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id')
         ->where('m_peserta_didik.nisn', $session->get('nisn'))
         ->where('t_detail_transaksi.status_verifikasi', "Sudah Terverifikasi");

      return DataTable::of($builder)
         ->hide('id_diklat')
         ->format('jumlah_bayar', function ($value) {
            return 'Rp ' . number_format($value, 2, '.', ',');
         })
         ->addNumbering()
         ->toJson();
   }

   //tambah data untuk data transaksi awal
   public function add()
   {
      if ($this->request->isAJAX()) {
         $session = session();
         $validation = \config\Services::validation();
         $valid = $this->validate([
            'file' => [
               'label' => 'File',
               'rules' => 'uploaded[file]'
                  . '|is_image[file]'
                  . '|mime_in[file,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
               'errors' => [
                  'uploaded' => 'Harus Ada File yang diupload',
                  'mime_in' => 'File Extention Harus Berupa pdf',
                  'max_size' => 'Ukuran File Maksimal 2 MB'
               ]
            ],
            'diklat_id' => [
               'label' => 'Jenis Diklat',
               'rules' => 'required',
               'errors' => [
                  'required' => '{field} tidak boleh kosong'
               ]
            ],
            'perencanaan_id' => [
               'label' => 'Priode Diklat',
               'rules' => 'required',
               'errors' => [
                  'required' => '{field} tidak boleh kosong'
               ]
            ],
            'tgl_transaksi' => [
               'label' => 'Tanggal Transaksi',
               'rules' => 'required',
               'errors' => [
                  'required' => '{field} tidak boleh kosong'
               ]
            ],
            'jumlah_bayar' => [
               'label' => 'Jumlah Bayar',
               'rules' => 'required',
               'errors' => [
                  'required' => '{field} tidak boleh kosong'
               ]
            ],
         ]);

         if (!$valid) {
            $msg = [
               'error' => [
                  'file' => $validation->getError('file'),
                  'jumlah_bayar' => $validation->getError('jumlah_bayar'),
                  'perencanaan_id' => $validation->getError('perencanaan_id'),
                  'tgl_transaksi' => $validation->getError('tgl_transaksi'),
                  'diklat_id' => $validation->getError('diklat_id'),
               ]
            ];
         } else {
            $harga = $this->request->getPost('harga');
            $bayar = $this->request->getPost('jumlah_bayar');
            if ($bayar < $harga) {
               $ket = "Belum Lunas";
            } else {
               $ket = "Lunas";
            }
            $session = session();
            $sisabayar = $harga - $bayar;
            $simpandata1 = [
               'nisn' => $session->get('nisn'),
               'diklat_id' => $this->request->getPost('diklat_id'),
               'perencanaan_id' => $this->request->getPost('perencanaan_id'),
               'status_pembayaran' => $ket,
            ];
            $data = new ModelTransaksiMasuk();
            $data->insert($simpandata1);
            $file = $this->request->getFile('file');
            if ($file->isValid() && !$file->hasMoved()) {
               $newName = $file->getRandomName();
               $file->move("uploads/", $newName);
            }
            $lastid = $data->getInsertID();
            $simpandata2 = [
               'id_transaksi_masuk' => $lastid,
               'tgl_transaksi' => $this->request->getPost('tgl_transaksi'),
               'created_by' => $session->get('nama_lengkap'),
               'jumlah_bayar' => $this->request->getVar('jumlah_bayar'),
               'sisa_pembayaran' => $sisabayar,
               'status_verifikasi' => "Belum Terverifikasi",
               'nisn' => $session->get('nisn'),
               'file' => $newName,
            ];
            $data2 = new ModelDetailTransaksi();
            $data2->insert($simpandata2);
            $msg = [
               'sukses' => 'Data Berhasil Disimpan'
            ];
         }
         echo json_encode($msg);
      }
   }

   public function formtambah()
   {
      if ($this->request->isAJAX()) {
         $ModelLemdik = new ModelLemdik();
         $ModelDiklat = new ModelDiklat();
         $ModelPesertaDidik = new ModelPesertaDidik();
         $ModelPerencanaanDiklat = new ModelPerencanaanDiklat();
         $data['lembaga'] = $ModelLemdik->getDataLemdik()->getResult();
         $data['jenis_diklat'] = $ModelDiklat->getDataDiklat()->getResult();
         $data['perencanaan'] = $ModelPerencanaanDiklat->getDataPerencanaan()->getResult();
         $data['peserta'] = $ModelPesertaDidik->getDataPeserta()->getResult();
         $msg = [
            'sukses' => view('PembayaranPeserta/modaltambah', $data),
         ];
         echo json_encode($msg);
      }
   }
   // tambah transaksi untuk pelunasan, dengan id transaksi yang sama
   public function tambahtransaksi()
   {
      $uri = service('uri');
      $id_transaksi = $uri->getSegment(3);
      $diklat_id = $uri->getSegment(4);
      $modeldetail = new ModelDetailTransaksi();
      $data['transaksi'] = $modeldetail->getDataTransaksi($id_transaksi, $diklat_id);
      return view('transaksimasuk/tambahdatapelunasan', $data);
   }
   //tambah data pelunasan
   public function simpantransaksi()
   {
      $session = session();
      $id = $this->request->getVar('id_transaksi_masuk');
      $sisabayarawal = $this->request->getPost('sisabayar');
      $bayar = $this->request->getPost('jumlah_bayar');
      if ($bayar >= $sisabayarawal) {
         $ket = "Lunas";
      } else {
         $ket = "Belum Lunas";
      }
      $sisabayarakhir = $sisabayarawal - $bayar;
      $simpandata1 = [
         'status_pembayaran' => $ket,
      ];
      $data = new ModelTransaksiMasuk();
      $data->update($id, $simpandata1);
      $simpandata2 = [
         'id_transaksi_masuk' => $this->request->getVar('id_transaksi_masuk'),
         'nisn' => $this->request->getVar('nisn'),
         'tgl_transaksi' => $this->request->getVar('tgl_transaksi'),
         'created_by' => $session->get('nama_lengkap'),
         'jumlah_bayar' => $this->request->getVar('jumlah_bayar'),
         'sisa_pembayaran' => $sisabayarakhir,
         'status_verifikasi' => "0",
      ];
      $data2 = new ModelDetailTransaksi();
      $data2->insert($simpandata2);
      return redirect()->to('/transaksimasuk');
   }

   public function getHarga()
   {
      if ($this->request->isAJAX()) {
         $id = $this->request->getVar('id');
         $perencanaan = new ModelPerencanaanDiklat();
         $row = $perencanaan->find($id);

         $data = [
            'id_perencanaan' => $row['id_perencanaan'],
            'harga' => $row['harga'],
         ];

         echo json_encode($data);
      }
   }

   public function formedit()
   {
      if ($this->request->isAJAX()) {
         $ModelLemdik = new ModelLemdik();
         $id = $this->request->getVar('id_jenis_diklat');
         $user = new ModelDiklat();
         $row = $user->find($id);

         $data = [
            'id_jenis_diklat' => $row['id_jenis_diklat'],
            'nama_diklat' => $row['nama_diklat'],
            'id_lembaga' => $row['id_lembaga'],
            'harga_diklat' => $row['harga_diklat'],
         ];
         $data['lembaga'] = $ModelLemdik->getDataLemdik()->getResult();

         $msg = [
            'sukses' => view('kelolaJenisDiklat/modaledit', $data),
         ];
         echo json_encode($msg);
      }
   }

   public function updatedata()
   {
      if ($this->request->isAJAX()) {
         $id = $this->request->getVar('id_jenis_diklat');
         $updatedata = [
            'nama_diklat' => $this->request->getVar('nama_diklat'),
            'id_lembaga' => $this->request->getVar('id_lembaga'),
            'harga_diklat' => $this->request->getVar('harga_diklat'),
         ];
         $user = new ModelDiklat();
         $user->update($id, $updatedata);
         $msg = [
            'sukses' => 'Data Berhasil DiUpdate'
         ];

         echo json_encode($msg);
      }
   }

   public function hapus()
   {
      if ($this->request->isAJAX()) {
         $id = $this->request->getVar('id');
         $pembayaran = new ModelTransaksiMasuk();
         $detail = new ModelDetailTransaksi();
         $pembayaran->delete($id);
         $detail->delete($id);
         $msg = [
            'sukses' => "User Dengan id $id berhasil dihapus"
         ];

         echo json_encode($msg);
      }
   }

   public function detailtransaksi()
   {
      $uri = service('uri');
      $id_transaksi = $uri->getSegment(3);
      $diklat_id = $uri->getSegment(4);
      $modeldetail = new ModelDetailTransaksi();
      $data['transaksi'] = $modeldetail->getDataDetail($id_transaksi, $diklat_id);
      return view('transaksimasuk/detail', $data);
   }


   // Mulai Dari sini controller untuk transaksi untuk aktor peserta didik

}
