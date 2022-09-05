<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLemdik;
use Hermawan\DataTables\DataTable;


class KelolaLemdik extends BaseController
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
        $this->ModelLemdik = new ModelLemdik();
        return view('kelolalemdik/tampildata');
    }

    // mengambil data user
    public function getDataUser()
    {
        $db = db_connect();
        $builder = $db->table('m_lembaga_diklat')->select('id_lembaga,nama_lembaga,alamat');

        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_lembaga . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_lembaga . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')


            ->addNumbering()
            ->toJson();
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([
                'nama_lembaga' => [
                    'label' => 'Nama Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_lembaga' => $validation->getError('nama_lembaga'),
                        'alamat' => $validation->getError('alamat'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_lembaga' => $this->request->getVar('nama_lembaga'),
                    'alamat' => $this->request->getVar('alamat'),
                ];
                $user = new ModelLemdik();
                $user->insert($simpandata);
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
            $msg = [
                'sukses' => view('kelolalemdik/modaltambah'),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_lembaga');
            $user = new ModelLemdik();
            $row = $user->find($id);

            $data = [
                'id_lembaga' => $row['id_lembaga'],
                'nama_lembaga' => $row['nama_lembaga'],
                'alamat' => $row['alamat'],
            ];

            $msg = [
                'sukses' => view('kelolaLemdik/modaledit', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $updatedata = [
                'nama_lembaga' => $this->request->getVar('nama_lembaga'),
                'alamat' => $this->request->getVar('alamat'),
            ];
            $lemdik = new ModelLemdik();
            $lemdik->update($id, $updatedata);
            $msg = [
                'sukses' => 'Data Berhasil DiUpdate'
            ];

            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_lembaga');
            $user = new ModelLemdik();
            $user->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
