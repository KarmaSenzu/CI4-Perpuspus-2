<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;

class Buku extends BaseController
{
    protected $modelAdmin;
    protected $modelKategori;
    protected $modelRak;

    public function __construct()
    {
        $this->modelAdmin = new M_Admin();
        $this->modelBuku = new M_Buku();
        $this->modelKategori = new M_Kategori();
        $this->modelRak = new M_Rak();
    }

    public function countAll()
    {
        return $this->modelBuku->countAllResults();
    }

    public function master_data_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {

            $session = session();
            $adminId = $session->get('ses_id');
    
            $adminModel = new M_Admin();
    
            $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
            $dataBuku = $this->modelBuku->getDataBukuJoin(['is_delete_buku' => '0'])->getResultArray();

            $uri = service('uri');
            $pages = $uri->getSegment(2);
            $kirimData = [
                'admin' => $adminData,
                'pages' => 'buku',
                'data_buku' => $dataBuku,
                'ses_level' => session()->get('ses_level')
            ];

            return view('Backend/Template/header', $kirimData) .
                   view('Backend/Template/sidebar', $kirimData) .
                   view('Backend/Buku/master-data-buku', $kirimData) .
                   view('Backend/Template/footer');
        }
    }

    public function input_data_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $session = session();
        $adminId = $session->get('ses_id');

        $adminModel = new M_Admin();

        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        $kategori = $this->modelKategori->where('is_delete_kategori', '0')->findAll();
        $rak = $this->modelRak->where('is_delete_rak', '0')->findAll();

        $data = [
            'admin' => $adminData,
            'pages' => 'buku',
            'kategori' => $kategori,
            'rak' => $rak,
            'ses_level' => session()->get('ses_level')
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Buku/input-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_data_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $judul = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlah = $this->request->getPost('jumlah_buku');
        $isbn = $this->request->getPost('isbn');
        $kategori = $this->request->getPost('id_kategori');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('id_rak');
        
        $coverFile = $this->request->getFile('cover_buku');
        $coverName = $coverFile->getName();
    
        if ($coverFile && $coverFile->isValid() && !$coverFile->hasMoved()) {
            $coverFile->move(ROOTPATH . 'public/assets/Cover_buku');
        } else {
            $coverName = null;
        }
    
        $hasil = $this->modelBuku->autoNumber()->getRowArray();
        if (!$hasil) {
            $id = "BUK001";
        } else {
            $kode = $hasil['id_buku'];
            $noUrut = (int)substr($kode, -3);
            $noUrut++;
            $id = "BUK" . sprintf("%03s", $noUrut);
        }
    
        $statusBuku = $jumlah > 0 ? 'Tersedia' : 'Tidak Tersedia';
    
        $dataSimpan = [
            'id_buku' => $id,
            'judul_buku' => $judul,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'jumlah_buku' => $jumlah,
            'tahun' => $tahun,
            'isbn' => $isbn,
            'id_kategori' => $kategori,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $coverName,
            'is_delete_buku' => '0',
            'status_buku' => $statusBuku,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $this->modelBuku->saveDataBuku($dataSimpan);
        session()->setFlashdata('success', 'Data Buku Berhasil Ditambahkan!!');
        return redirect()->to(base_url('admin/master-data-buku'));
    }

    public function edit_data_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
        session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
        return redirect()->to(base_url('admin/master-data-buku'));
        }
        $session = session();
        $adminId = $session->get('ses_id');

        $adminModel = new M_Admin();

        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
        $idEdit = $this->request->uri->getSegment(3);

        $dataEdit = $this->modelBuku->getDataBuku(['is_delete_buku' => '0', 'sha1(id_buku)' => $idEdit])->getRowArray();

     session()->set('idUpdate', $dataEdit['id_buku']);

        $kategori = $this->modelKategori->where('is_delete_kategori', '0')->findAll();
        $rak = $this->modelRak->where('is_delete_rak', '0')->findAll();

        $data = [
        'admin' => $adminData,
        'kategori' => $kategori,
        'rak' => $rak,
        'pages' => 'buku',
        'data_edit' => $dataEdit,
        'ses_level' => session()->get('ses_level')
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Buku/edit-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/master-data-buku'));
        }
    
        $judul = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlah = $this->request->getPost('jumlah_buku');
        $isbn = $this->request->getPost('isbn');
        $kategori = $this->request->getPost('id_kategori');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('id_rak');
        $idUpdate = session()->get('idUpdate');
    
        $coverFile = $this->request->getFile('cover_buku');
        $coverName = $this->request->getPost('existing_cover');
    
        if ($coverFile && $coverFile->isValid() && !$coverFile->hasMoved()) {
            $coverName = $coverFile->getName();
            $coverFile->move(ROOTPATH . 'public/assets/Cover_buku');
        }
    
        $statusBuku = $jumlah > 0 ? 'Tersedia' : 'Tidak Tersedia';
    
        $dataUpdate = [
            'judul_buku' => $judul,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'jumlah_buku' => $jumlah,
            'tahun' => $tahun,
            'isbn' => $isbn,
            'id_kategori' => $kategori,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $coverName,
            'status_buku' => $statusBuku,
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $this->modelBuku->updateDataBuku($dataUpdate, ['id_buku' => $idUpdate]);
        session()->remove('idUpdate');
        session()->setFlashdata('success', 'Data Buku Berhasil Diubah!!');
        return redirect()->to(base_url('admin/master-data-buku'));
    }
    
    public function hapus_data_buku($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
        session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('admin/login-admin'));
        }

        $modelBuku = new M_Buku();

        $data = [
        'is_delete_buku' => '1',
        'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelBuku->updateDataBuku($data, ['id_buku' => $id]);

        session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!!');
        return redirect()->to(base_url('admin/master-data-buku'));
    }

    public function restore_data_buku() 
    {

        $bukuModel = new M_Buku();

        $bukuModel->restoreBuku();

        session()->setFlashdata('success', 'Data buku yang terhapus telah dipulihkan.');

        return redirect()->to('admin/master-data-buku');
    }
}
