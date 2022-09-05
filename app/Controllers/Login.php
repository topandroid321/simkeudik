<?php

namespace App\Controllers;

use App\Models\ModelUser;
use App\Models\ModelPesertaDidik;

class Login extends BaseController
{
    public function index()
    {
        helper(['form']);

        return view('pages/viewlogin');
    }
    public function login()
    {
        helper(['form']);
        $session = session();
        $model = new ModelUser();
        $model2 = new ModelPesertaDidik();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        if ($data == NULL) {
            $data = $model2->where('username', $username)->first();
        }
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                if ($data['role'] == 4) {
                    $this->setUserSessionPeserta($data);
                } else {
                    $this->setUserSession($data);
                }
                //$session->setFlashdata('success', 'Successful Registration');
                // Redirecting to dashboard after login
                if ($data['role'] == "1") {
                    return redirect()->to(base_url('admin'));
                }
                if ($data['role'] == "2") {
                    return redirect()->to(base_url('bendahara'));
                }
                if ($data['role'] == "3") {
                    return redirect()->to(base_url('kepalaprogram'));
                }
                if ($data['role'] == "4") {
                    return redirect()->to(base_url('pesertadidik'));
                }
            } else {
                $session->setFlashdata('pesan', 'Username Tersedia namun password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('pesan', 'Username dan password tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    private function setUserSession($data)
    {
        $datarow = [
            'id' => $data['id'],
            'nama_lengkap' => $data['nama_lengkap'],
            'username' => $data['username'],
            'isLoggedIn' => true,
            "role" => $data['role'],
        ];

        session()->set($datarow);
        return true;
    }

    private function setUserSessionPeserta($data)
    {
        $datarow = [
            'id' => $data['id'],
            'nama_lengkap' => $data['nama_lengkap'],
            'nisn' => $data['nisn'],
            'username' => $data['username'],
            'isLoggedIn' => true,
            "role" => $data['role'],
        ];

        session()->set($datarow);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function blokir()
    {
        return view('pages/blok');
    }
}
