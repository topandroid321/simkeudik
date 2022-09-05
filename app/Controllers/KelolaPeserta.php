<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPesertaDidik;
use Hermawan\DataTables\DataTable;


class KelolaPeserta extends BaseController
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
        $this->ModelPesertaDidik = new ModelPesertaDidik();
        return view('kelolapeserta/tampildata');
    }

    // mengambil data user
    public function getDataUser()
    {
        $db = db_connect();
        $builder = $db->table('m_peserta_didik')->select('id,nisn,nama_lengkap,username,kelas,tahun_masuk,jk,jurusan,photo');

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
                'nisn' => [
                    'label' => 'NISN',
                    'rules' => 'required|is_unique[m_peserta_didik.id]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} Tidak Boleh sama dengan yang lain'
                    ]
                ],
                'tahun_masuk' => [
                    'label' => 'Tahun Masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jk' => [
                    'label' => 'jk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
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
                        'tahun_masuk' => $validation->getError('tahun_masuk'),
                        'jk' => $validation->getError('jk'),
                        'nisn' => $validation->getError('nisn'),
                        'nama_lengkap' => $validation->getError('nama_lengkap'),
                        'username' => $validation->getError('username'),
                    ]
                ];
            } else {
                $simpandata = [
                    'password' => password_hash("12345678", PASSWORD_DEFAULT),
                    'photo' => "default.jpg",
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'nisn' => $this->request->getVar('nisn'),
                    'tahun_masuk' => $this->request->getVar('tahun_masuk'),
                    'jk' => $this->request->getVar('jk'),
                    'kelas' => $this->request->getVar('kelas'),
                    'jurusan' => $this->request->getVar('jurusan'),
                    'username' => $this->request->getVar('username'),
                    'role' => '4',
                ];
                $peserta = new ModelPesertaDidik();
                $peserta->insert($simpandata);
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
                'sukses' => view('kelolapeserta/modaltambah'),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $user = new ModelPesertaDidik();
            $row = $user->find($id);

            $data = [
                'id' => $row['id'],
                'nisn' => $row['nisn'],
                'username' => $row['username'],
                'nama_lengkap' => $row['nama_lengkap'],
                'jk' => $row['jk'],
                'tahun_masuk' => $row['tahun_masuk'],
                'kelas' => $row['kelas'],
                'jurusan' => $row['jurusan'],
                'role' => $row['role'],
            ];

            $msg = [
                'sukses' => view('kelolaPeserta/modaledit', $data),
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
                'kelas' => $this->request->getVar('kelas'),
                'jk' => $this->request->getVar('jk'),
                'tahun_masuk' => $this->request->getVar('tahun_masuk'),
                'jurusan' => $this->request->getVar('jurusan'),
                'role' => '4',
            ];
            $user = new ModelPesertaDidik();
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
            $user = new ModelPesertaDidik();
            $user->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}
