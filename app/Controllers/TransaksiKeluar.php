<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelTransaksiKeluar;
use App\Models\ModelPerencanaanDiklat;
use App\Models\ModelDiklat;
use Hermawan\DataTables\DataTable;


class TransaksiKeluar extends BaseController
{

    public function __construct()
    {
        if (session()->get('role') != "2") {
            echo view('pages/blok');
            exit;
        }
    }

    public function index()
    {
        helper(['form', 'url']);
        $this->ModelTransaksiKeluar = new ModelTransaksiKeluar();
        return view('transaksikeluar/tampildata');
    }

    // mengambil data user
    public function getDataTransaksikel()
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_keluar')->select('id_transaksi_keluar,tgl_transaksi_keluar,m_diklat.nama_diklat,t_perencanaan_diklat.ket,total_biaya,t_transaksi_keluar.keterangan,created_by')
            ->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_keluar.diklat_id')
            ->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_keluar.perencanaan_id');


        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_transaksi_keluar . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_transaksi_keluar . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')

            ->format('total_biaya', function ($value) {
                return 'Rp ' . number_format($value, 2, '.', ',');
            })
            ->addNumbering()
            ->toJson();
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([
                'tgl_transaksi_keluar' => [
                    'label' => 'Tanggal TransaksI',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'diklat_id' => [
                    'label' => 'Diklat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'perencanaan_id' => [
                    'label' => 'Diklat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'total_biaya' => [
                    'label' => 'Total Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'ket' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'tgl_transaksi_keluar' => $validation->getError('tgl_transaksi_keluar'),
                        'diklat_id' => $validation->getError('diklat_id'),
                        'perencanaan_id' => $validation->getError('perencanaan_id'),
                        'total_biaya' => $validation->getError('total_biaya'),
                        'keterangan' => $validation->getError('keterangan'),
                    ]
                ];
            } else {
                $session = session();
                $simpandata = [
                    'tgl_transaksi_keluar' => $this->request->getVar('tgl_transaksi_keluar'),
                    'diklat_id' => $this->request->getVar('diklat_id'),
                    'perencanaan_id' => $this->request->getVar('perencanaan_id'),
                    'total_biaya' => $this->request->getVar('total_biaya'),
                    'keterangan' => $this->request->getVar('keterangan'),
                    'created_by' => $session->get('nama_lengkap'),
                ];
                $data = new ModelTransaksiKeluar();
                $data->insert($simpandata);
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
            $ModelDiklat = new ModelDiklat();
            $ModelPerencanaanDiklat = new ModelPerencanaanDiklat();
            $data['perencanaan'] = $ModelPerencanaanDiklat->getDataPerencanaan()->getResult();
            $data['jenis_diklat'] = $ModelDiklat->getDataDiklat()->getResult();
            $msg = [
                'sukses' => view('TransaksiKeluar/modaltambah', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_pengajar');
            $pengajar = new ModelTransaksiKeluar();
            $row = $pengajar->find($id);
            $data = [
                'id_pengajar' => $row['id_pengajar'],
                'nama_pengajar' => $row['nama_pengajar'],
                'jk' => $row['jk'],
                'no_tlp' => $row['no_tlp'],
                'alamat' => $row['alamat'],
                'photo' => 'default.jpg',
            ];

            $msg = [
                'sukses' => view('kelolaPengajar/modaledit', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_pengajar');
            $simpandata = [
                'nama_pengajar' => $this->request->getVar('nama_pengajar'),
                'jk' => $this->request->getVar('jk'),
                'no_tlp' => $this->request->getVar('no_tlp'),
                'alamat' => $this->request->getVar('alamat'),
                'photo' => 'default.jpg',
            ];
            $pengajar = new ModelTransaksiKeluar();
            $pengajar->update($id, $simpandata);
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
            $pengajar = new ModelTransaksiKeluar();
            $pengajar->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
