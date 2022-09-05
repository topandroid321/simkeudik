<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelUser;
use Hermawan\DataTables\DataTable;

use function PHPSTORM_META\map;

class KelolaUser extends BaseController
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
        $this->ModelUser = new ModelUser();
        return view('kelolauser/tampildata');
    }

    // mengambil data user
    public function getDataUser()
    {
        $db = db_connect();
        $builder = $db->table('m_user')->select('id,nama_lengkap,username,role,photo');

        return DataTable::of($builder)
            ->edit('photo', function ($builder) {
                return '<img src="' . base_url() . '/assets/template/img/' . $builder->photo . '" width="70">';
            }, 'last')
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id . ')"><i class="fas fa-trash"></i></button>
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
                'nama_lengkap' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_lengkap' => $validation->getError('nama_lengkap'),
                        'username' => $validation->getError('username'),
                    ]
                ];
            } else {
                $simpandata = [
                    'password' => password_hash("12345678", PASSWORD_DEFAULT),
                    'photo' => "default.jpg",
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'username' => $this->request->getVar('username'),
                    'role' => $this->request->getVar('role'),
                ];
                $user = new ModelUser;
                $user->insert($simpandata);
                $msg = [
                    'sukses' => 'Data Berhasil Disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $user = new ModelUser;
            $row = $user->find($id);

            $data = [
                'id' => $row['id'],
                'username' => $row['username'],
                'nama_lengkap' => $row['nama_lengkap'],
                'role' => $row['role'],
            ];

            $msg = [
                'sukses' => view('kelolauser/modaledit', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $simpandata = [
                'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                'username' => $this->request->getVar('username'),
                'role' => $this->request->getVar('role'),
            ];
            $user = new ModelUser;
            $user->update($id, $simpandata);
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
            $user = new ModelUser;
            $user->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
