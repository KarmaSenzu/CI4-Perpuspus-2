<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Peminjaman;
use App\Models\M_Pengembalian;

class Admin extends BaseController
{
    protected $modelAdmin;

    public function __construct()
    {
        $this->modelAdmin = new M_Admin();
    }

    public function login()
    {
        // echo password_hash("developer", PASSWORD_DEFAULT) . "\n";
        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $modelAdmin = new M_Admin();
            $admin = $modelAdmin->getDataAdmin(['username_admin' => $username])->getRowArray();

            echo "Username yang dimasukkan: $username <br>";
            echo "Password yang dimasukkan: $password <br>";

            if ($admin) {
                echo "Data Admin ditemukan: <pre>";
                print_r($admin);
                echo "</pre>";

                if (password_verify($password, $admin['password_admin'])) {
                    session()->set([
                        'ses_id' => $admin['id_admin'],
                        'ses_user' => $admin['username_admin'],
                        'ses_level' => $admin['akses_level'],
                        'isLoggedIn' => true
                    ]);
                    return redirect()->to(base_url('admin/dashboard'));
                } else {
                    echo "Password tidak cocok.";
                    session()->setFlashdata('error', 'Password salah!');
                    return redirect()->back();
                }
            } else {
                echo "Username tidak ditemukan.";
                session()->setFlashdata('error', 'Username tidak ditemukan!');
                return redirect()->back();
            }
        }

        return view('Backend/Login/login-admin');
    }

    public function dashboard()
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
        $modelBuku = new M_Buku();
        $modelKategori = new M_Kategori();
        $modelRak = new M_Rak();
        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();
    
        $jumlahAnggota = $modelAnggota->where('is_delete_anggota', '0')->countAllResults();
        $jumlahBuku = $modelBuku->where('is_delete_buku', '0')->countAllResults();
        $jumlahKategori = $modelKategori->where('is_delete_kategori', '0')->countAllResults();
        $jumlahRak = $modelRak->where('is_delete_rak', '0')->countAllResults();
        $jumlahPeminjaman = $modelPeminjaman->countAllResults();
        $jumlahPengembalian = $modelPengembalian->countAllResults();
    
        $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray();
        $today = date('Y-m-d');
    
        foreach ($dataPeminjaman as &$peminjaman) {
            if ($peminjaman['tgl_kembali'] < $today && $peminjaman['status_transaksi'] == 'Berjalan') {
                $peminjaman['status_transaksi'] = 'Terlambat';
            }
            $peminjaman['nama_anggota'] = $peminjaman['nama_anggota'] ?? 'Data tidak tersedia';
            $peminjaman['judul_buku'] = $peminjaman['judul_buku'] ?? 'Data tidak tersedia';
            $peminjaman['tgl_kembali'] = isset($peminjaman['tgl_kembali']) ? date('d-m-Y', strtotime($peminjaman['tgl_kembali'])) : 'Data tidak tersedia';
        }
    
        $dataBuku = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();
    
        $data = [
            'admin' => $adminData,
            'jumlahAnggota' => $jumlahAnggota,
            'jumlahBuku' => $jumlahBuku,
            'jumlahKategori' => $jumlahKategori,
            'jumlahRak' => $jumlahRak,
            'jumlahPeminjaman' => $jumlahPeminjaman,
            'jumlahPengembalian' => $jumlahPengembalian,
            'ses_level' => session()->get('ses_level'),
            'data_peminjaman' => $dataPeminjaman,
            'data_buku' => $dataBuku
        ];
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Dashboard/dashboard', $data);
        echo view('Backend/Template/footer', $data);
    }
    
    public function autentikasi()
    {
        $modelAdmin = new M_Admin;

        $username = $this->request->getPost('username');
        $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
        if ($cekUsername == 0) {
            session()->setFlashdata('error', 'Masukkan Username Dengan Benar!');
            return redirect()->back();
        } else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
            $password = $this->request->getPost('password');

            $verifikasi_password = password_verify($password, $dataUser['password_admin']);
            if (!$verifikasi_password) {
                session()->setFlashdata('error', 'Masukkan Password Dengan Benar!');
                return redirect()->back();
            } else {
                session()->setFlashdata('success', 'Berhasil Login!');
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level']
                ];
                session()->set($dataSession);
                return redirect()->to(base_url('admin/dashboard'));
            }
        }
    }

    public function profile()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $adminId = session()->get('ses_id');
        $adminModel = new M_Admin();

        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        if (!$adminData) {
            session()->setFlashdata('error', 'Data Admin tidak ditemukan.');
            return redirect()->to(base_url('admin/dashboard'));
        }

        $data = [
            'pages' => 'profile',
            'admin' => $adminData,
            'ses_level' => session()->get('ses_level')
        ];

        return view('Backend/Template/header', $data) .
            view('Backend/Template/sidebar', $data) .
            view('Backend/Profile/profile', $data) .
            view('Backend/Template/footer');
    }

    public function updateProfile()
    {
        $adminId = session()->get('ses_id');
        $adminData = $this->modelAdmin->find($adminId);

        $validationRules = [
            'nama_admin' => 'required',
            'username_admin' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', 'Gagal memperbarui profil. Pastikan semua kolom telah terisi.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_admin' => $this->request->getPost('nama_admin'),
            'username_admin' => $this->request->getPost('username_admin'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $profileImage = $this->request->getFile('profile_image');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $newFileName = time() . '_' . $profileImage->getName();

            $tempFilePath = FCPATH . 'assets/tmp/' . $newFileName;
            $profileImage->move(FCPATH . 'assets/tmp', $newFileName);

            $image = \Config\Services::image()->withFile($tempFilePath);
            $image->fit(300, 300, 'center')->save(FCPATH . 'assets/profile/' . $newFileName);

            unlink($tempFilePath);

            $data['profile_image'] = $newFileName;
        }
    
        $this->modelAdmin->update($adminId, $data);
    
        $dataUpdate = [
            'nama_admin' => $data['nama_admin'],
            'username_admin' => $data['username_admin'],
            'profile_image' => $data['profile_image'] ?? null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->modelAdmin->updateProfileData($dataUpdate);

        session()->setFlashdata('success', 'Profil berhasil diperbarui.');

        return redirect()->to(base_url('admin/profile'));
    }
    
    public function updatePassword()
    {
        $validationRules = [
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];
    
        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', 'Gagal memperbarui password. Pastikan semua kolom terisi dan sesuai.');
            return redirect()->to(base_url('admin/profile'))->withInput();
        }
    
        $inputPassword = $this->request->getPost('new_password');
        $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
    
        $adminId = session()->get('ses_id');
        $data = [
            'password_admin' => $hashedPassword,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        $this->modelAdmin->update($adminId, $data);
    
        session()->setFlashdata('success', 'Password berhasil diperbarui.');
        return redirect()->to(base_url('admin/profile'));
    }
    
    public function logout()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        session()->destroy();
        return redirect()->to(base_url('admin/login-admin'));
    }

    public function master_data_admin()
    {
        if(session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == ""){
            session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        else{

            $session = session();
            $adminId = $session->get('ses_id');

            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $pages = 'admin';
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0'])->getResultArray();
            $adminData = $modelAdmin->getDataAdmin(['id_admin' => $adminId])->getRowArray();

            $kirimData['pages'] = $pages;
            $kirimData['admin'] = $adminData;
            $kirimData['data_user'] = $dataUser;
            $kirimData['ses_level'] = session()->get('ses_level');

            echo view('Backend/Template/header', $kirimData);
            echo view('Backend/Template/sidebar', $kirimData);
            echo view('Backend/Admin/master-data-admin', $kirimData);
            echo view('Backend/Template/footer');
        }
    }

    public function input_data_admin()
    {
        if(session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == ""){
            session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        else{
            $session = session();
            $adminId = $session->get('ses_id');
    
            $adminModel = new M_Admin();
    
            $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
            $uri = service('uri');
            $pages = 'admin';
            $kirimData['pages'] = $pages;
            $kirimData['admin'] = $adminData;
            $kirimData['ses_level'] = session()->get('ses_level');

            echo view('Backend/Template/header',$kirimData);
            echo view('Backend/Template/sidebar',$kirimData);
            echo view('Backend/Admin/input-admin',$kirimData);
            echo view('Backend/Template/footer',$kirimData);
        }
    }

    public function simpan_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            $modelAdmin = new M_Admin;

            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $level = $this->request->getPost('level');

            $cekUname = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
            if ($cekUname > 0) {
                session()->setFlashdata('error', 'Username sudah digunakan!');
                return redirect()->back();
            } else {
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if (!$hasil) {
                    $id = "ADM001";
                } else {
                    $kode = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "ADM" . sprintf("%03s", $noUrut);
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $dataSimpan = [
                    'id_admin' => $id,
                    'nama_admin' => $nama,
                    'username_admin' => $username,
                    'password_admin' => $hashedPassword,
                    'akses_level' => $level,
                    'is_delete_admin' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelAdmin->saveDataAdmin($dataSimpan);
                session()->setFlashdata('success', 'Data Admin Berhasil Ditambahkan!');
                return redirect()->to(base_url('admin/master-data-admin'));
            }
        }
    }

    public function edit_data_admin($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAdmin = new M_Admin();

        $admin = $modelAdmin->getDataAdmin(['id_admin' => $id])->getRowArray();

        if (!$admin) {
            session()->setFlashdata('error', 'Data Admin tidak ditemukan.');
            return redirect()->to(base_url('admin/master-data-admin'));
        }

        $data = [
            'pages' => 'admin',
            'admin' => $admin,
            'ses_level' => session()->get('ses_level')
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Admin/edit-admin', $data);
        echo view('Backend/Template/footer');
    }

    public function update_data_admin($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/master-data-admin'));
        }

        $modelAdmin = new M_Admin;

        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level = $this->request->getPost('level');

        $dataSimpan = [
            'nama_admin' => $nama,
            'username_admin' => $username,
            'akses_level' => $level,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($password)) {
            $dataSimpan['password_admin'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($modelAdmin->updateDataAdmin($dataSimpan, ['id_admin' => $id])) {
            session()->setFlashdata('success', 'Data Admin Berhasil Diperbarui!!');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data Admin.');
        }
        return redirect()->to(base_url('admin/master-data-admin'));
    }

    public function hapus_data_admin()
    {
        if(session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == ""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/master-data-admin'));
        }
        $modelAdmin = new M_Admin;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataSimpan = [
            'is_delete_admin' => "1",
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($modelAdmin->updateDataAdmin($dataSimpan, ['id_admin' => $idHapus])) {
            session()->setFlashdata('success', 'Data Admin Berhasil Dihapus!!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data Admin.');
        }
        return redirect()->to(base_url('admin/master-data-admin'));
    }

    public function restore_data_admin() 
    {

        $adminModel = new M_Admin();

        $adminModel->restoreAdmin();

        session()->setFlashdata('success', 'Data admin yang terhapus telah dipulihkan.');

        return redirect()->to('admin/master-data-admin');
    }
}
