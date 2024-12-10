<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Peminjaman;
use App\Models\M_Pengembalian;

class Anggota extends BaseController
{   
    public function master_data_anggota()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $session = session();
        $adminId = $session->get('ses_id');

        $adminModel = new M_Admin();

        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
        $modelAnggota = new M_Anggota();
        $dataAnggota = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();

        $data = [
            'admin' => $adminData,
            'pages' => 'anggota',
            'data_anggota' => $dataAnggota,
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Anggota/master-data-anggota', $data) .
               view('Backend/Template/footer');
    }

    public function input_data_anggota()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $session = session();
            $adminId = $session->get('ses_id');
    
            $adminModel = new M_Admin();
    
            $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        $data = [
            'admin' => $adminData,
            'pages' => 'anggota',
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Anggota/input-anggota', $data) .
               view('Backend/Template/footer');
    }

    public function simpan_data_anggota()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAnggota = new M_Anggota();

        $rules = [
            'nama_anggota' => 'required',
            'email' => 'required|valid_email|is_unique[tbl_anggota.email]',
        ];

        $errors = [
            'email' => [
                'is_unique' => 'Email sudah digunakan oleh anggota lain.'
            ]
        ];

        if (!$this->validate($rules, $errors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator);
        }

        $nama_anggota = $this->request->getPost('nama_anggota');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $no_tlp = $this->request->getPost('no_tlp');
        $email = $this->request->getPost('email');
        $password_anggota = $this->request->getPost('password_anggota');
        $alamat = $this->request->getPost('alamat');

        $hasil = $modelAnggota->autoNumber();
        if (!$hasil || !$hasil['max_id']) {
            $id_anggota = "ANG001";
        } else {
            $kode = $hasil['max_id'];
            $noUrut = (int)substr($kode, -3);
            $noUrut++;
            $id_anggota = "ANG" . sprintf("%03s", $noUrut);
        }

        $data = [
            'id_anggota' => $id_anggota,
            'nama_anggota' => $nama_anggota,
            'jenis_kelamin' => $jenis_kelamin,
            'no_tlp' => $no_tlp,
            'email' => $email,
            'password_anggota' => $password_anggota,
            'alamat' => $alamat,
            'is_delete_anggota' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelAnggota->saveDataAnggota($data);

        session()->setFlashdata('success', 'Data Anggota Berhasil Ditambahkan!!');
        return redirect()->to(base_url('admin/master-data-anggota'));
    }

    public function edit_data_anggota($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $session = session();
            $adminId = $session->get('ses_id');
    
            $adminModel = new M_Admin();
    
            $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
        $modelAnggota = new M_Anggota();
        $dataAnggota = $modelAnggota->find($id);

        $data = [
            'admin' => $adminData,
            'pages' => 'anggota',
            'data_anggota' => $dataAnggota,
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Anggota/edit-anggota', $data) .
               view('Backend/Template/footer');
    }

    public function update_data_anggota()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAnggota = new M_Anggota();

        $id_anggota = $this->request->getPost('id_anggota');
        $nama_anggota = $this->request->getPost('nama_anggota');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $no_tlp = $this->request->getPost('no_tlp');
        $email = $this->request->getPost('email');
        $alamat = $this->request->getPost('alamat');

        $change_password = $this->request->getPost('change_password');
        $password_anggota = '';

        if ($change_password == 1) {
            $password_anggota = $this->request->getPost('password_anggota');
        }

        $data = [
            'nama_anggota' => $nama_anggota,
            'jenis_kelamin' => $jenis_kelamin,
            'no_tlp' => $no_tlp,
            'email' => $email,
            'alamat' => $alamat,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($change_password == 1) {
            $data['password_anggota'] = $password_anggota;
        }

        if (!$modelAnggota->updateDataAnggota($data, $id_anggota)) {
            return redirect()->back()->withInput()->with('errors', $modelAnggota->errors());
        }

        session()->setFlashdata('success', 'Data Anggota Berhasil Diperbarui!!');
        return redirect()->to(base_url('admin/master-data-anggota'));
    }

    public function hapus_data_anggota($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAnggota = new M_Anggota();

        $data = [
            'is_delete_anggota' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelAnggota->updateDataAnggota($data, ['id_anggota' => $id]);

        session()->setFlashdata('success', 'Data Anggota Berhasil Dihapus!!');
        return redirect()->to(base_url('admin/master-data-anggota'));
    }

    public function restore_data_anggota() 
    {

        $anggotaModel = new M_Anggota();

        $anggotaModel ->restoreAnggota();

        session()->setFlashdata('success', 'Data anggota yang terhapus telah dipulihkan.');

        return redirect()->to('admin/master-data-anggota');
    }
}
