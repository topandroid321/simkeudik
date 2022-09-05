<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGajiPengajar;
use App\Models\ModelDiklat;
use App\Models\ModelPengajar;
use Dompdf\Dompdf;
use Hermawan\DataTables\DataTable;


class kelolaGajiPengajar extends BaseController
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
        $this->ModelGajiPengajar = new ModelGajiPengajar();
        return view('kelolagajipengajar/tampildata');
    }

    // mengambil data user
    public function getDataGaji()
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar')->select('id_gaji,m_pengajar_diklat.nama_pengajar,m_diklat.nama_diklat,tgl_pembayaran_gaji,jumlah_jam,gaji_perjam,gaji_total')
            ->join('m_diklat', 'm_diklat.id_diklat = t_gaji_pengajar.diklat_id')
            ->join('m_pengajar_diklat', 'm_pengajar_diklat.id_pengajar = t_gaji_pengajar.pengajar_id');

        return DataTable::of($builder)
            ->add('action', function ($builder) {
                return '<button type="button" class="btn btn-success" onclick="edit(' . $builder->id_gaji . ')">Edit <i class="fas fa-edit"></i></button>
                <a href="' . base_url('/kelolagajipengajar/cetak_bukti_gaji') . '/' . $builder->id_gaji . '" class="btn btn-primary"><i class="fas fa-print"></i>Print</a>
                <button type="button" class="btn btn-danger" onclick="hapus(' . $builder->id_gaji . ')"><i class="fas fa-trash"></i></button>
                ';
            }, 'last')
            ->format('gaji_perjam', function ($value) {
                return 'Rp ' . number_format($value, 2, '.', ',');
            })

            ->format('gaji_total', function ($value) {
                return 'Rp ' . number_format($value, 2, '.', ',');
            })
            ->hide('id_gaji')
            ->addNumbering()
            ->toJson();
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([
                'pengajar_id' => [
                    'label' => 'Nama Pengajar',
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
                'tgl_pembayaran_gaji' => [
                    'label' => 'Tanggal Pembayaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jumlah_jam' => [
                    'label' => 'Jumlah Jam',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'gaji_perjam' => [
                    'label' => 'Gaji perjam',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'pengajar_id' => $validation->getError('pengajar_id'),
                        'diklat_id' => $validation->getError('diklat_id'),
                        'tgl_pembayaran_gaji' => $validation->getError('tgl_pembayaran_gaji'),
                        'jumlah_jam' => $validation->getError('jumlah_jam'),
                        'gaji_perjam' => $validation->getError('gaji_perjam'),
                    ]
                ];
            } else {
                $jumlahjam = $this->request->getVar('jumlah_jam');
                $gaji_perjam = $this->request->getVar('gaji_perjam');
                $gajitotal = $jumlahjam * $gaji_perjam;
                $simpandata = [
                    'pengajar_id' => $this->request->getVar('pengajar_id'),
                    'diklat_id' => $this->request->getVar('diklat_id'),
                    'tgl_pembayaran_gaji' => $this->request->getVar('tgl_pembayaran_gaji'),
                    'jumlah_jam' => $this->request->getVar('jumlah_jam'),
                    'gaji_perjam' => $this->request->getVar('gaji_perjam'),
                    'gaji_total' => $gajitotal,
                ];
                $data = new ModelGajiPengajar();
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
            $ModelPengajar = new ModelPengajar();
            $data['diklat'] = $ModelDiklat->getDataDiklat()->getResult();
            $data['pengajar'] = $ModelPengajar->getDataPengajar()->getResult();
            $msg = [
                'sukses' => view('kelolagajipengajar/modaltambah', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_gaji');
            $ModelDiklat = new ModelDiklat();
            $ModelPengajar = new ModelPengajar();
            $gaji = new ModelGajiPengajar();
            $data['diklat'] = $ModelDiklat->getDataDiklat()->getResult();
            $data['pengajar'] = $ModelPengajar->getDataPengajar()->getResult();
            $data['gaji'] = $gaji->getDataGaji($id);

            $msg = [
                'sukses' => view('KelolaGajiPengajar/modaledit', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_gaji');
            $jumlahjam = $this->request->getPost('jumlah_jam');
            $gaji_perjam = $this->request->getVar('gaji_perjam');
            $gajitotal = $jumlahjam * $gaji_perjam;
            $update = [
                'diklat_id' => $this->request->getPost('diklat_id'),
                'tgl_pembayaran_gaji' => $this->request->getPost('tgl_pembayaran_gaji'),
                'jumlah_jam' => $this->request->getPost('jumlah_jam'),
                'gaji_perjam' => $this->request->getPost('gaji_perjam'),
                'gaji_total' => $gajitotal,
            ];
            $gaji = new ModelGajiPengajar();
            $gaji->update($id, $update);
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
            $pengajar = new ModelGajiPengajar();
            $pengajar->delete($id);
            $msg = [
                'sukses' => "User Dengan id $id berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }

    public function cetak_bukti_gaji()
    {
        $uri = service('uri');
        $id = $uri->getSegment(3);
        $gaji = new ModelGajiPengajar();
        $data['gaji'] = $gaji->getDataGaji($id);

        $filename = date('y-m-d-H-i-s') . '-Bukti Gaji';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('KelolaGajiPengajar/bukti_pembayaran_gaji', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
