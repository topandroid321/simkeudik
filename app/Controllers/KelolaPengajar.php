<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengajar;
use Hermawan\DataTables\DataTable;


class kelolaPengajar extends BaseController
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
        $this->ModelPengajar = new ModelPengajar();
        return view('kelolapengajar/tampildata');
    }

    // mengambil data user
    public function getDataPengajar()
    {
        $db = db_connect();
        $builder = $db->table('m_pengajar_diklat')->select('id_pengajar,nama_pengajar,jk,no_tlp,alamat,photo');

        return DataTable::of($builder)
            ->edit('photo', function ($builder) {
                return '<img src="' . base_url() . '/assets/template/img/' . $builder->photo . '" width="70">';
            }, 'last')
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_pengajar . ')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_pengajar . ')"><i class="fas fa-trash"></i></button>
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
                'nama_pengajar' => [
                    'label' => 'Nama Pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'no_tlp' => [
                    'label' => 'Nomor Telepon',
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
                        'nama_pengajar' => $validation->getError('nama_pengajar'),
                        'jk' => $validation->getError('jk'),
                        'no_tlp' => $validation->getError('no_tlp'),
                        'alamat' => $validation->getError('alamat'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_pengajar' => $this->request->getVar('nama_pengajar'),
                    'jk' => $this->request->getVar('jk'),
                    'no_tlp' => $this->request->getVar('no_tlp'),
                    'alamat' => $this->request->getVar('alamat'),
                    'photo' => 'default.jpg',
                ];
                $data = new ModelPengajar();
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
            $msg = [
                'sukses' => view('kelolapengajar/modaltambah'),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_pengajar');
            $pengajar = new ModelPengajar();
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
            $pengajar = new ModelPengajar();
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
            $pengajar = new ModelPengajar();
            $pengajar->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
