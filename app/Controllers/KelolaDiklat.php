<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDiklat;
use App\Models\ModelLemdik;
use Hermawan\DataTables\DataTable;


class KelolaDiklat extends BaseController
{

    public function __construct()
    {
        if (session()->get('role') != "1") {
            echo view('pages/blok');
            exit;
        }
    }

    public function index()
    {
        helper(['form', 'url']);
        $this->ModelLemdik = new ModelDiklat();
        return view('keloladiklat/tampildata');
    }

    // mengambil data user
    public function getData()
    {
        $db = db_connect();
        $builder = $db->table('m_diklat')
            ->select('id_diklat,nama_diklat,lama_pelaksanaan,deskripsi');

        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_diklat . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_diklat . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')

            ->format('harga_diklat', function ($value) {
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
                'nama_diklat' => [
                    'label' => 'Nama Diklat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'lama_pelaksanaan' => [
                    'label' => 'Lama Pelaksanaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_diklat' => $validation->getError('nama_diklat'),
                        'lama_pelaksanaan' => $validation->getError('lama_pelaksanaan'),
                        'deskripsi' => $validation->getError('deskripsi'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_diklat' => $this->request->getVar('nama_diklat'),
                    'lama_pelaksanaan' => $this->request->getVar('lama_pelaksanaan'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                ];
                $data_diklat = new ModelDiklat();
                $data_diklat->insert($simpandata);
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
            $data['lembaga'] = $ModelLemdik->getDataLemdik()->getResult();
            $msg = [
                'sukses' => view('KelolaDiklat/modaltambah', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_diklat');
            $diklat = new ModelDiklat();
            $row = $diklat->find($id);

            $data = [
                'id_diklat' => $row['id_diklat'],
                'nama_diklat' => $row['nama_diklat'],
                'lama_pelaksanaan' => $row['lama_pelaksanaan'],
                'deskripsi' => $row['deskripsi'],
            ];

            $msg = [
                'sukses' => view('kelolaDiklat/modaledit', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_diklat');
            $updatedata = [
                'nama_diklat' => $this->request->getVar('nama_diklat'),
                'lama_pelaksanaan' => $this->request->getVar('lama_pelaksanaan'),
                'deskripsi' => $this->request->getVar('deskripsi'),
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
            $id = $this->request->getVar('id_diklat');
            $user = new ModelDiklat();
            $user->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
