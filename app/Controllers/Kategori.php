<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Kategori;
use App\Models\M_Buku;

class Kategori extends BaseController
{
    public function master_data_kategori()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        
        $session = session();
        $adminId = $session->get('ses_id');

        $adminModel = new M_Admin();
        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        $modelKategori = new M_Kategori();
        $modelBuku = new M_Buku();

        $dataKategori = $modelKategori->getDataKategori(['is_delete_kategori' => '0']);

        foreach ($dataKategori as &$kategori) {
            $kategori['jumlah_buku'] = $modelBuku->countBukuByKategori($kategori['id_kategori']);
        }

        $data = [
            'admin' => $adminData,
            'pages' => 'kategori',
            'data_kategori' => $dataKategori,
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Kategori/master-data-kategori', $data) .
               view('Backend/Template/footer');
    }

    public function input_data_kategori()
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
            'pages' => 'kategori',
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Kategori/input-kategori', $data) .
               view('Backend/Template/footer');
    }

    public function simpan_data_kategori()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == ""){
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelKategori = new M_Kategori();

        $hasil = $modelKategori->autoNumber();
        if (!$hasil) {
            $id_kategori = "KAT001";
        } else {
            $kode = $hasil['max_id'];
            $noUrut = (int)substr($kode, -3);
            $noUrut++;
            $id_kategori = "KAT" . sprintf("%03s", $noUrut);
        }

        $nama_kategori = $this->request->getPost('nama_kategori');

        $data = [
            'id_kategori' => $id_kategori,
            'nama_kategori' => $nama_kategori,
            'is_delete_kategori' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelKategori->saveDataKategori($data);
        session()->setFlashdata('success', 'Data Kategori Berhasil Ditambahkan!!');
        return redirect()->to(base_url('admin/master-data-kategori'));
        }

        public function edit_data_kategori($id)
        {
            if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
                session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
                return redirect()->to(base_url('admin/login-admin'));
            }
            $session = session();
            $adminId = $session->get('ses_id');

            $adminModel = new M_Admin();

            $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
            $modelKategori = new M_Kategori();
            $dataKategori = $modelKategori->find($id);

            $data = [
                'admin' => $adminData,
                'pages' => 'kategori',
                'data_kategori' => $dataKategori,
                'ses_level' => session()->get('ses_level')
            ];

            return view('Backend/Template/header', $data) .
                view('Backend/Template/sidebar', $data) .
                view('Backend/Kategori/edit-kategori', $data) .
                view('Backend/Template/footer');
    }

    public function update_data_kategori()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelKategori = new M_Kategori();

        $id_kategori = $this->request->getPost('id_kategori');
        $nama_kategori = $this->request->getPost('nama_kategori');

        $data = [
            'nama_kategori' => $nama_kategori,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelKategori->updateDataKategori($data, ['id_kategori' => $id_kategori]);
        session()->setFlashdata('success', 'Data Kategori Berhasil Diperbarui!!');
        return redirect()->to(base_url('admin/master-data-kategori'));
    }

    public function hapus_data_kategori($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelKategori = new M_Kategori();

        $data = [
            'is_delete_kategori' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelKategori->updateDataKategori($data, ['id_kategori' => $id]);
        session()->setFlashdata('success', 'Data Kategori Berhasil Dihapus!!');
        return redirect()->to(base_url('admin/master-data-kategori'));
    }

    public function restore_data_kategori() 
    {

        $kategoriModel = new M_Kategori();

        $kategoriModel->restoreKategori();

        session()->setFlashdata('success', 'Data kategori yang terhapus telah dipulihkan.');

        return redirect()->to('admin/master-data-kategori');
    }
}
       
