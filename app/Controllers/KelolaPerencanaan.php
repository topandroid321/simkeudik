<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDiklat;
use App\Models\ModelPerencanaanDiklat;
use App\Models\ModelLemdik;
use Hermawan\DataTables\DataTable;


class kelolaPerencanaan extends BaseController
{

    public function __construct()
    {
        if (session()->get('role') == "1" || session()->get('role') == "2") {
            echo view('pages/blok');
            exit;
        }
    }

    public function index()
    {
        helper(['form', 'url']);
        $this->ModelPerencanaanDiklat = new ModelPerencanaanDiklat();
        return view('kelola_perencanaan/tampildata');
    }

    // mengambil data perencanaan
    public function getData()
    {
        $db = db_connect();
        $builder = $db->table('t_perencanaan_diklat')
            ->select('id_perencanaan,m_diklat.nama_diklat,tanggal_pelaksanaan,m_diklat.lama_pelaksanaan,m_lembaga_diklat.nama_lembaga,harga,ket')
            ->join('m_diklat', 'm_diklat.id_diklat = t_perencanaan_diklat.diklat_id')
            ->join('m_lembaga_diklat', 'm_lembaga_diklat.id_lembaga = t_perencanaan_diklat.lembaga_diklat_id');

        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_perencanaan . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_perencanaan . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')
            ->format('harga', function ($value) {
                return 'Rp ' . number_format($value, 2, '.', ',');
            })
            ->hide('id_perencanaan')
            ->addNumbering()
            ->toJson();
    }


    public function getDatajadwal()
    {
        $db = db_connect();
        $builder = $db->table('t_perencanaan_diklat')
            ->select('id_perencanaan,m_diklat.nama_diklat,tanggal_pelaksanaan,m_diklat.lama_pelaksanaan,m_lembaga_diklat.nama_lembaga,harga,ket')
            ->join('m_diklat', 'm_diklat.id_diklat = t_perencanaan_diklat.diklat_id')
            ->join('m_lembaga_diklat', 'm_lembaga_diklat.id_lembaga = t_perencanaan_diklat.lembaga_diklat_id');

        return DataTable::of($builder)
            ->format('harga', function ($value) {
                return 'Rp ' . number_format($value, 2, '.', ',');
            })
            ->hide('id_perencanaan')
            ->addNumbering()
            ->toJson();
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([
                'diklat_id' => [
                    'label' => 'Nama Diklat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tanggal_pelaksanaan' => [
                    'label' => 'Tanggal Pelaksanaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'lembaga_diklat_id' => [
                    'label' => 'Lembaga Diklat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
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
                        'diklat_id' => $validation->getError('diklat_id'),
                        'tanggal_pelaksanaan' => $validation->getError('tanggal_pelaksanaan'),
                        'lembaga_diklat_id' => $validation->getError('lembaga_diklat_id'),
                        'harga' => $validation->getError('harga'),
                        'ket' => $validation->getError('ket'),
                    ]
                ];
            } else {
                $simpandata = [
                    'diklat_id' => $this->request->getVar('diklat_id'),
                    'tanggal_pelaksanaan' => $this->request->getVar('tanggal_pelaksanaan'),
                    'lembaga_diklat_id' => $this->request->getVar('lembaga_diklat_id'),
                    'harga' => $this->request->getVar('harga'),
                    'ket' => $this->request->getVar('ket'),

                ];
                $data = new ModelPerencanaanDiklat();
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
            $ModelLemdik = new ModelLemdik();
            $ModelDiklat = new ModelDiklat();
            $data['lembaga'] = $ModelLemdik->getDataLemdik()->getResult();
            $data['diklat'] = $ModelDiklat->getDataDiklat()->getResult();
            $msg = [
                'sukses' => view('kelola_perencanaan/modaltambah', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $ModelLemdik = new ModelLemdik();
            $ModelDiklat = new ModelDiklat();
            $id = $this->request->getVar('id_perencanaan');
            $perencanaan = new ModelPerencanaanDiklat();
            $row = $perencanaan->find($id);
            $data = [
                'id_perencanaan' => $row['id_perencanaan'],
                'diklat_id' => $row['diklat_id'],
                'tanggal_pelaksanaan' => $row['tanggal_pelaksanaan'],
                'lembaga_diklat_id' => $row['lembaga_diklat_id'],
                'harga' => $row['harga'],
            ];
            $data['lembaga'] = $ModelLemdik->getDataLemdik()->getResult();
            $data['diklat'] = $ModelDiklat->getDataDiklat()->getResult();
            $msg = [
                'sukses' => view('kelola_perencanaan/modaledit', $data),
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
            $pengajar = new ModelPerencanaanDiklat();
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
            $perencanaan = new ModelPerencanaanDiklat();
            $perencanaan->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
