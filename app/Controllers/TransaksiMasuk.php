<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelTransaksiMasuk;
use App\Models\ModelLemdik;
use App\Models\ModelDiklat;
use App\Models\ModelPesertaDidik;
use App\Models\ModelPerencanaanDiklat;
use Hermawan\DataTables\DataTable;


class TransaksiMasuk extends BaseController
{
    public function __construct()
    {
        if (session()->get('role') == "3" || session()->get('role') == NULL) {
            echo view('pages/blok');
            exit;
        }
    }

    public function index()
    {
        helper(['form', 'url']);
        $this->ModelTransaksiMasuk = new ModelTransaksiMasuk();
        return view('TransaksiMasuk/tampildata');
    }

    // mengambil data
    public function getData()
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_masuk')
            ->select('t_transaksi_masuk.id_transaksi_masuk,m_peserta_didik.nama_lengkap,m_peserta_didik.kelas,m_peserta_didik.jurusan,m_diklat.id_diklat,m_diklat.nama_diklat,t_perencanaan_diklat.ket,t_transaksi_masuk.status_pembayaran,t_detail_transaksi.status_verifikasi')
            ->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn')
            ->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id')
            ->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk')
            ->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id');
        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '
                <a class ="btn btn-primary" href="' . base_url('/transaksimasuk/detailtransaksi') . '/' . $builder->id_transaksi_masuk . '/' . $builder->id_diklat . '">Detail</a>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_transaksi_masuk . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')
            ->hide('id_diklat')
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
                'nisn' => [
                    'label' => 'Nama Peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
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
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nisn' => $validation->getError('nisn'),
                        'perencanaan_id' => $validation->getError('perencanaan_id'),
                        'tgl_transaksi' => $validation->getError('tgl_transaksi'),
                        'id_diklat' => $validation->getError('id_diklat'),
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
                $sisabayar = $harga - $bayar;
                $simpandata1 = [
                    'nisn' => $this->request->getPost('nisn'),
                    'diklat_id' => $this->request->getPost('diklat_id'),
                    'perencanaan_id' => $this->request->getPost('perencanaan_id'),
                    'status_pembayaran' => $ket,
                ];
                $data = new ModelTransaksiMasuk();
                $data->insert($simpandata1);
                $lastid = $data->getInsertID();
                $simpandata2 = [
                    'id_transaksi_masuk' => $lastid,
                    'tgl_transaksi' => $this->request->getPost('tgl_transaksi'),
                    'created_by' => $session->get('nama_lengkap'),
                    'jumlah_bayar' => $this->request->getVar('jumlah_bayar'),
                    'sisa_pembayaran' => $sisabayar,
                    'status_verifikasi' => "Sudah Terverifikasi",
                    'nisn' => $this->request->getPost('nisn'),
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
                'sukses' => view('TransaksiMasuk/modaltambah', $data),
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
            'status_verifikasi' => "Sudah Terverifikasi",
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

    public function verifikasi()
    {
        $uri = service('uri');
        $id_transaksi = $uri->getSegment(3);
        $updatedata = [
            'status_verifikasi' => "Sudah Terverifikasi",
        ];
        $data = new ModelDetailTransaksi();
        $data->update($id_transaksi, $updatedata);
        return redirect()->to('/transaksimasuk');
    }

    public function cetakbukti(){
        $modeltransaksimasuk = new ModelTransaksiMasuk();
      $data['pembayaran'] = $modeltransaksimasuk->getTransaksiMasuk();

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
}
