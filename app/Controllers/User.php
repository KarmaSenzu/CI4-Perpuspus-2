<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Peminjaman;
use App\Models\M_Pengembalian;
use Dompdf\Dompdf;
use Dompdf\Options;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;


class User extends BaseController
{
    protected $modelBuku;
    protected $modelKategori;
    protected $modelRak;
    protected $modelAnggota;
    protected $modelPeminjaman;
    protected $modelPengembalian;

    public function __construct()
{
    $this->modelBuku = new M_Buku();
    $this->modelKategori = new M_Kategori();
    $this->modelRak = new M_Rak();
    $this->modelAnggota = new M_Anggota();
    $this->modelPeminjaman = new M_Peminjaman();
    $this->modelPengembalian = new M_Pengembalian();
}

    public function login()
    {
        return view('Backend/Login/login-user');
    }

    public function dashboard()
    {
        $userId = session()->get('ses_id'); 
        $modelAnggota = new M_Anggota();
        $userData = $modelAnggota->find($userId);

        if (!session()->has('ses_id') || !session()->has('ses_user')) {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('user/login-user'));
        }

        $modelBuku = new M_Buku();
        $modelKategori = new M_Kategori();
        $modelRak = new M_Rak();
        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();

        $data = [
            'user' => $userData,
            'jumlahAnggota' => $modelAnggota->where('is_delete_anggota', '0')->countAllResults(),
            'jumlahBuku' => $modelBuku->where('is_delete_buku', '0')->countAllResults(),
            'jumlahKategori' => $modelKategori->where('is_delete_kategori', '0')->countAllResults(),
            'jumlahRak' => $modelRak->where('is_delete_rak', '0')->countAllResults(),
            'jumlahPeminjaman' => $modelPeminjaman->countAllResults(),
            'jumlahPengembalian' => $modelPengembalian->countAllResults(),
        ];

        $dataPeminjaman = $modelPeminjaman
            ->where('id_anggota', $userId)
            ->getDataPeminjamanJoin()
            ->getResultArray();

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

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        $kirimData['pages'] = $pages;
        $kirimData['jumlahAnggota'] = $data['jumlahAnggota'];
        $kirimData['jumlahBuku'] = $data['jumlahBuku'];
        $kirimData['jumlahKategori'] = $data['jumlahKategori'];
        $kirimData['jumlahRak'] = $data['jumlahRak'];
        $kirimData['jumlahPeminjaman'] = $data['jumlahPeminjaman'];
        $kirimData['jumlahPengembalian'] = $data['jumlahPengembalian'];
        $kirimData['data_peminjaman'] = $dataPeminjaman;
        $kirimData['data_buku'] = $dataBuku;

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $kirimData);
        echo view('User/Dashboard/dashboard', $data);
        echo view('User/Template/footer');
    }

    public function autentikasi()
    {
        $modelAnggota = new M_Anggota();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $recaptchaToken = $this->request->getPost('recaptchaToken');
        
        if (!$recaptchaToken) {
            session()->setFlashdata('error', 'Token reCAPTCHA tidak ditemukan.');
            return redirect()->to(base_url('user/login-user'));
        }

        $apiUrl = "https://www.google.com/recaptcha/api/siteverify";
        $payload = [
            'secret' => '6LfHt5UqAAAAAGOhXmUt5kV6JBTpAK0J42SoZvEC',
            'response' => $recaptchaToken,
        ];
        
        $client = \Config\Services::curlrequest();
        $response = $client->post($apiUrl, ['form_params' => $payload]);
        $responseData = json_decode($response->getBody(), true);
        
        if (!$responseData['success']) {
            session()->setFlashdata('error', 'Captcha tidak valid, silakan coba lagi.');
            return redirect()->to(base_url('user/login-user'));
        }

        $query = $modelAnggota->getDataAnggota(['email' => $email, 'is_delete_anggota' => '0']);
        $cekEmail = $modelAnggota->getDataAnggota(['email' => $email])->getNumRows();
        
        if ($cekEmail == 0) {
            session()->setFlashdata('error', 'Masukkan Email dengan benar!');
            return redirect()->to(base_url('user/login-user'));
        } else {
            $dataUser = $modelAnggota->getDataAnggota(['email' => $email, 'is_delete_anggota' => '0'])->getRowArray();
        
            if ($password !== $dataUser['password_anggota']) {
                session()->setFlashdata('error', 'Password yang dimasukkan salah.');
                return redirect()->to(base_url('user/login-user'));
            } else {
                session()->setFlashdata('success', 'Berhasil Login!');
                $dataSession = [
                    'ses_id' => $dataUser['id_anggota'],
                    'ses_user' => $dataUser['nama_anggota'],
                ];
                session()->set($dataSession);
                return redirect()->to(base_url('user/dashboard'));
            }
        }
    }
          
    public function registrasi()
    {
        return view('Backend/Login/registrasi');
    }

    public function prosesRegistrasi()
    {
        $modelAnggota = new M_Anggota();

        $nama_anggota = $this->request->getPost('nama_anggota');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $no_tlp = $this->request->getPost('no_tlp');
        $email = $this->request->getPost('email');
        $password_anggota = $this->request->getPost('password_anggota');
        $confirm_password = $this->request->getPost('confirm_password');
        $alamat = $this->request->getPost('alamat');

        if (empty($nama_anggota) || empty($jenis_kelamin) || empty($no_tlp) || empty($email) || empty($password_anggota) || empty($alamat)) {
            session()->setFlashdata('error', 'Semua field wajib diisi.');
            return redirect()->to(base_url('user/registrasi'))->withInput();
        }
    
        if (strlen($password_anggota) < 8) {
            session()->setFlashdata('error', 'Password harus minimal 8 karakter.');
            return redirect()->to(base_url('user/registrasi'))->withInput();
        }
    
        if ($password_anggota !== $confirm_password) {
            session()->setFlashdata('error', 'Password dan konfirmasi password tidak cocok.');
            return redirect()->to(base_url('user/registrasi'))->withInput();
        }

        $cekEmail = $modelAnggota->where(['email' => $email, 'is_delete_anggota' => '0'])->countAllResults();
        if ($cekEmail > 0) {
            session()->setFlashdata('error', 'Email sudah digunakan. Silahkan gunakan email lain.');
            return redirect()->to(base_url('user/registrasi'))->withInput();
        }

        $verificationCode = rand(100000, 999999);
        session()->set('verification_code', $verificationCode);
        session()->set('temp_email', $email);

        session()->set('temp_data', [
            'nama_anggota' => $nama_anggota,
            'jenis_kelamin' => $jenis_kelamin,
            'no_tlp' => $no_tlp,
            'password_anggota' => $password_anggota,
            'alamat' => $alamat
        ]);

        $this->sendVerificationEmail($email, $verificationCode);

        return redirect()->to(base_url('user/verify-email'));
    }   
    
    public function sendVerificationEmail($email, $verificationCode)
    {
        $emailService = \Config\Services::email();

        $nama_anggota = htmlspecialchars(session()->get('temp_data')['nama_anggota'], ENT_QUOTES, 'UTF-8');
        $verificationCode = htmlspecialchars($verificationCode, ENT_QUOTES, 'UTF-8');
    
        $emailService->setFrom('perpuspus.id@gmail.com', 'Perpuspus');
        $emailService->setTo($email);
        $emailService->setSubject('Kode OTP Verifikasi Email');
        
        $message = "
            <html>
            <head>
                <title>Verifikasi Email</title>
                <style>
                    body, p, h1, h2, h3, h4, h5, h6 {
                        color: #000000 !important;
                        font-family: Arial, sans-serif;
                    }

                    h2 {
                        color: #012970 !important;
                    }
                    strong {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <p>Halo, " . $nama_anggota . ".</p>
                <p>Terima kasih telah mendaftar di <strong>Perpuspus</strong>.</p>
                <p>Untuk melanjutkan proses pendaftaran, silahkan masukkan kode OTP berikut pada halaman pendaftaran:</p>
                <h2 style='font-size: 24px; text-align: center;'>" . $verificationCode . "</h2>
                <p>Jika Anda tidak merasa melakukan pendaftaran, harap abaikan email ini.</p>
                <p>Terima kasih atas perhatian Anda.</p>
                <p>Salam,<br><strong>Perpuspus Team</strong></p>
            </body>
            </html>
        ";
    
        $emailService->setMessage($message);
        $emailService->setMailType('html');
    
        if ($emailService->send()) {
            return true;
        } else {
            $error = $emailService->printDebugger(['headers']);
            session()->setFlashdata('error', 'Gagal mengirim email verifikasi. Error: ' . $error);
            return redirect()->to(base_url('user/registrasi'));
        }
    }    
      
    public function verifyEmail()
    {
        if (!session()->has('verification_code') || !session()->has('temp_email')) {
            return redirect()->to(base_url('user/registrasi'));
        }

        return view('Backend/Login/verify-email');
    }

    public function verifyCode()
    {
        $verificationCode = $this->request->getPost('verification_code');
        $storedCode = session()->get('verification_code');
        $email = session()->get('temp_email');
    
        if ($verificationCode == $storedCode) {
            $tempData = session()->get('temp_data');
            
            if ($tempData) {
                $modelAnggota = new M_Anggota();

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
                    'nama_anggota' => $tempData['nama_anggota'],
                    'jenis_kelamin' => $tempData['jenis_kelamin'],
                    'no_tlp' => $tempData['no_tlp'],
                    'email' => $email,
                    'password_anggota' => $tempData['password_anggota'],
                    'alamat' => $tempData['alamat'],
                    'is_delete_anggota' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $modelAnggota->saveDataAnggota($data);

                session()->remove(['verification_code', 'temp_email', 'temp_data']);
                session()->setFlashdata('success', 'Registrasi berhasil!');
                return redirect()->to(base_url('user/login-user'));
            }
        } else {
            session()->setFlashdata('error', 'Kode verifikasi salah!');
            return redirect()->to(base_url('user/verify-email'));
        }
    }
    
    public function buku()
    {
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $dataBuku = $this->modelBuku->getDataBukuJoin(['is_delete_buku' => '0'])->getResultArray();

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        $kirimData = [
            'pages' => 'buku',
            'data_buku' => $dataBuku,
            'user' => $userData,
        ];

        return view('User/Template/header', $kirimData) .
               view('User/Template/sidebar', $kirimData) .
               view('User/Buku/buku', $kirimData) .
               view('User/Template/footer');
    }

    public function detail_buku($id_buku)
    {
         $userId = session()->get('ses_id');
         $userData = $this->modelAnggota->find($userId);
     
         if (!$userData) {
             session()->setFlashdata('error', 'Data Anggota tidak ditemukan.');
             return redirect()->to(base_url('user/dashboard'));
         }
    
         $idEdit = $this->request->uri->getSegment(3);

         $dataEdit = $this->modelBuku->getDataBukuJoin(['is_delete_buku' => '0', 'sha1(id_buku)' => $idEdit])->getResultArray();
     
         if (empty($dataEdit)) {
             return redirect()->to(base_url('user/buku'))->with('error', 'Buku dengan ID ' . $id_buku . ' tidak ditemukan');
         }
         
         $data = [
             'pages' => 'buku',
             'buku' => $dataEdit[0],
             'user' => $userData,
         ];
     
         return view('User/Template/header', $data) .
                view('User/Template/sidebar', $data) .
                view('User/Buku/detail-buku', $data) .
                view('User/Template/footer');
    }
    
    public function kategori()
    {

        $modelKategori = new M_Kategori();
        $dataKategori = $modelKategori->getDataKategori(['is_delete_kategori' => '0']);
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $data = [
            'pages' => 'kategori',
            'data_kategori' => $dataKategori,
            'user' => $userData,
        ];

        return view('User/Template/header', $data) .
               view('User/Template/sidebar', $data) .
               view('User/Kategori/kategori', $data) .
               view('User/Template/footer');
    }
     
    public function rak()
    {

        $modelRak = new M_Rak();
        $dataRak = $modelRak->getDataRak(['is_delete_rak' => '0']);
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $data = [
            'pages' => 'rak',
            'data_rak' => $dataRak,
            'user' => $userData,
        ];

        return view('User/Template/header', $data) .
               view('User/Template/sidebar', $data) .
               view('User/Rak/rak', $data) .
               view('User/Template/footer');
    }

    public function peminjaman()
    {
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);
      
        $modelPeminjaman = new M_Peminjaman();  
        $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin(['tbl_peminjaman.id_anggota' => $userId]); 

        $dataPeminjamanArray = $dataPeminjaman->getResultArray();
        
        $isTransaksiBerjalan = false;
        $currentDate = date('Y-m-d');

        foreach ($dataPeminjamanArray as $key => $peminjaman) {
            if ($peminjaman['status_transaksi'] === 'Berjalan' && strtotime($peminjaman['tgl_kembali']) < strtotime($currentDate)) {
                $dataPeminjamanArray[$key]['status_transaksi'] = 'Terlambat';
            }
            if ($peminjaman['status_transaksi'] === 'Berjalan') {
                $isTransaksiBerjalan = true;
            }
        }

        $data = [
            'pages' => 'peminjaman',
            'data_peminjaman' => $dataPeminjamanArray,
            'user' => $userData,
            'ses_level' => session()->get('ses_level'),
            'isTransaksiBerjalan' => $isTransaksiBerjalan
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Peminjaman/peminjaman', $data);
        echo view('User/Template/footer');
    }
    
    public function peminjaman_step1()
    {

        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $modelAnggota = new M_Anggota;
        $modelBuku = new M_Buku;
        $modelPeminjaman = new M_Peminjaman;
    
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $idAnggota = session()->get('ses_id');
        if (!$idAnggota) {
            session()->setFlashdata('error', 'Anda belum login atau sesi Anda telah berakhir!');
            return redirect()->to(base_url('login'));
        }

        session()->set(['idAgt' => $idAnggota]);

        $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();
        if (!$dataAnggota) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }

        $search = $this->request->getPost('search');
        if ($search) {
            $dataBuku = $modelBuku->getDataBukuJoin()->getResultArray();
            $dataBuku = array_filter($dataBuku, function($buku) use ($search) {
                return stripos($buku['judul_buku'], $search) !== false || 
                       stripos($buku['pengarang'], $search) !== false || 
                       stripos($buku['penerbit'], $search) !== false;
            });
        } else {
            $dataBuku = [];
        }

        $jumlahTemp = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();
        $dataTemp = $modelPeminjaman->getDataTempJoin(['temp.id_anggota' => $idAnggota])->getResultArray();

        $data = [
            'pages' => $page,
            'web_title' => "Transaksi Peminjaman",
            'dataAnggota' => $dataAnggota,
            'dataBuku' => $dataBuku,
            'jumlahTemp' => $jumlahTemp,
            'dataTemp' => $dataTemp,
            'search' => $search,
            'idAnggota' => $idAnggota,
            'user' => $userData
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Peminjaman/peminjaman-step1', $data);
        echo view('User/Template/footer', $data);
    }
    
    public function peminjaman_step2()
    {
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $modelAnggota = new M_Anggota;
        $modelPeminjaman = new M_Peminjaman;
        $modelAdmin = new M_Admin;

        $uri = service('uri');
        $page = $uri->getSegment(2);

        $idAnggota = session()->get('ses_id');
        $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();

        if (!$idAnggota) {
            session()->setFlashdata('error', 'Pilih anggota terlebih dahulu!');
            return redirect()->to(base_url('user/peminjaman-step1'));
        }

        $dataTemp = $modelPeminjaman->getDataTempJoin(['temp.id_anggota' => $idAnggota])->getResultArray();
        $jumlahTemp = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();

        $data = [
            'pages' => $page,
            'web_title' => "Pilih Durasi dan Jumlah Buku",
            'dataAnggota' => $dataAnggota ?: [],
            'dataTemp' => $dataTemp,
            'jumlahTemp' => $jumlahTemp,
            'idAnggota' => $idAnggota,
            'user' => $userData 
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Peminjaman/peminjaman-step2', $data);
        echo view('User/Template/footer', $data);
    }

    public function simpan_transaksi_peminjaman()
    {
        $modelPeminjaman = new M_Peminjaman();
        $modelAnggota = new M_Anggota();
        $modelBuku = new M_Buku();

        $lastPinjaman = $modelPeminjaman->getLastIdPeminjaman();

        if (!$lastPinjaman) {
            $newIdPeminjaman = 'PIN001';
        } else {
            preg_match('/(\D+)(\d+)/', $lastPinjaman['id_peminjaman'], $matches);
            if (count($matches) === 3) {
                $prefix = $matches[1];
                $number = intval($matches[2]);
                $newNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
                $newIdPeminjaman = $prefix . $newNumber;
            } else {
                $newIdPeminjaman = 'PIN001';
            }
        }

        $time_sekarang = time();
        $kembali = date("Y-m-d", strtotime("+7 days", $time_sekarang));

        $dataAnggota = session()->get('idAgt');
        $anggotaDetail = $modelAnggota->getDataAnggota(['id_anggota' => $dataAnggota])->getRowArray();

        if (!$anggotaDetail) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan!');
            return redirect()->to(base_url('user/peminjaman'));
        }

        $jumlahPinjam = $this->request->getPost('total_pinjam');
        $durasiPinjam = $this->request->getPost('durasi_pinjaman');

        foreach ($jumlahPinjam as $idBuku => $jumlah) {
            if ($jumlah > 0) {
                $buku = $modelBuku->find($idBuku);
                if ($buku['jumlah_buku'] < $jumlah) {
                    session()->setFlashdata('error', 'Stok buku tidak cukup!');
                    return redirect()->to(base_url('user/peminjaman-step2'));
                }

                $detailPinjam = "No Peminjaman: $newIdPeminjaman\n";
                $detailPinjam .= "Nama Anggota: " . $anggotaDetail['nama_anggota'] . "\n";
                $detailPinjam .= "Tanggal Pinjam: " . date("Y-m-d") . "\n";
                $detailPinjam .= "Buku Dipinjam: " . $idBuku . " - Jumlah: " . $jumlah . "\n";
                $detailPinjam .= "Tanggal Kembali: $kembali\n";

                $builder = new Builder(
                    writer: new PngWriter(),
                    writerOptions: [],
                    validateResult: false,
                    data: $detailPinjam,
                    encoding: new Encoding('UTF-8'),
                    errorCorrectionLevel: ErrorCorrectionLevel::High,
                    size: 300,
                    margin: 10,
                    roundBlockSizeMode: RoundBlockSizeMode::Margin,
                    logoPath: FCPATH . 'assets/img/logo.png',
                    logoResizeToWidth: 50,
                    logoPunchoutBackground: true,
                    labelText: $newIdPeminjaman,
                    labelFont: new OpenSans(20),
                    labelAlignment: LabelAlignment::Center
                );

                $result = $builder->build();

                $namaQR = "qr_" . $newIdPeminjaman . ".png";
                $result->saveToFile(FCPATH . 'assets/qr_code/' . $namaQR);

                $dataSimpan = [
                    'id_peminjaman' => $newIdPeminjaman,
                    'id_anggota' => session()->get('idAgt'),
                    'tgl_pinjam' => date("Y-m-d"),
                    'total_pinjam' => $jumlah,
                    'id_admin' => '-',
                    'status_transaksi' => "Berjalan",
                    'status_ambil_buku' => "Sudah Diambil",
                ];

                $modelPeminjaman->saveDataPeminjaman($dataSimpan);

                $durasi = isset($durasiPinjam[$idBuku]) ? intval($durasiPinjam[$idBuku]) : 7;
                $kembali = date("Y-m-d", strtotime("+$durasi days"));

                $dataTemp = $modelPeminjaman->getDataTemp(['id_anggota' => session()->get('idAgt')])->getResultArray();
                foreach ($dataTemp as $sementara) {
                    $simpanDetail = [
                        'id_peminjaman' => $newIdPeminjaman,
                        'id_buku' => $sementara['id_buku'],
                        'status_pinjam' => "Sedang Dipinjam",
                        'perpanjangan' => "2",
                        'tgl_kembali' => $kembali
                    ];
                    $modelPeminjaman->saveDataDetail($simpanDetail);

                    $modelBuku->update($sementara['id_buku'], ['jumlah_buku' => $buku['jumlah_buku'] - $jumlah]);
                }

                $modelPeminjaman->hapusDataTemp(['id_anggota' => session()->get('idAgt')]);
                session()->remove('idAgt');
                session()->setFlashdata('success', 'Data Peminjaman Buku Berhasil Disimpan!');

                return redirect()->to(base_url('user/detail-peminjaman/' . $newIdPeminjaman));
            }
        }

        session()->setFlashdata('error', 'Tidak ada buku yang dipinjam!');
        return redirect()->to(base_url('user/peminjaman'));
    }

    public function detail_peminjaman($id_peminjaman)
    {
        $session = session();
        $adminId = $session->get('ses_id');

        $modelAnggota = new M_Anggota();
        $user = $modelAnggota->find($adminId);

        $modelPeminjaman = new M_Peminjaman();
        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
            return redirect()->to(base_url('user/peminjaman'));
        }
    
        $uri = service('uri');
        $pages = $uri->getSegment(2);
        $namaQR = "qr_" . $id_peminjaman . ".png";

        $tglKembali = new \DateTime($detailPeminjaman['tgl_kembali']);
        $tglPengembalian = isset($detailPeminjaman['tgl_pengembalian']) 
            ? new \DateTime($detailPeminjaman['tgl_pengembalian']) 
            : new \DateTime();
    
        $hariTerlambat = ($tglPengembalian > $tglKembali) ? $tglPengembalian->diff($tglKembali)->days : 0;

        $data['user'] = $user;
        $data['pages'] = $pages;
        $data['detail_peminjaman'] = $detailPeminjaman;
        $data['title'] = 'Detail Peminjaman';
        $data['ses_level'] = $session->get('ses_level'); 
        $data['namaQR'] = base_url('assets/qr_code/' . $namaQR);
    
        $data['is_completed'] = ($detailPeminjaman['status_transaksi'] ?? '') === 'Selesai';
        $data['hari_terlambat'] = $hariTerlambat > 0 ? $hariTerlambat : 'Tidak Ada Keterlambatan';

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Peminjaman/detail-peminjaman', $data);
        echo view('User/Template/footer', $data);
    }
    
    public function simpan_temp_pinjam()
    {
        $modelPeminjaman = new M_Peminjaman;
        $modelBuku = new M_Buku;
    
        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();
    
        $adaTemp = $modelPeminjaman->getDataTemp(['sha1(id_buku)' => $idBuku])->getNumRows();
        $adaBerjalan = $modelPeminjaman->getDataPeminjaman(['id_anggota' => session()->get('idAgt'), 'status_transaksi' => "Berjalan"])->getNumRows();
    
        $jumlahPinjam = $this->request->getPost('total_pinjam');
    
        if (empty($jumlahPinjam) || $jumlahPinjam < 1) {
            $jumlahPinjam = 1;
        }
    
        if ($adaTemp) {
            session()->setFlashdata('error', 'Satu Anggota Hanya Bisa Meminjam 1 Buku dengan Judul yang Sama!');
            echo "<script>history.go(-1);</script>";
        } elseif ($adaBerjalan) {
            session()->setFlashdata('error', 'Masih ada transaksi peminjaman yang belum diselesaikan, silakan selesaikan peminjaman sebelumnya terlebih dahulu!');
            echo "<script>history.go(-1);</script>";
        } else {
            $dataSimpanTemp = [
                'id_anggota' => session()->get('idAgt'),
                'id_buku' => $dataBuku['id_buku'],
                'jumlah_temp' => $jumlahPinjam
            ];
            $modelPeminjaman->saveDataTemp($dataSimpanTemp);
            echo "<script>document.location = '" . base_url('user/peminjaman-step1') . "';</script>";
        }
    }

    public function hapus_temp_pinjam()
    {
        $modelPeminjaman = new M_Peminjaman;
    
        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
    
        $modelPeminjaman->hapusDataTemp(['sha1(id_buku)' => $idBuku, 'id_anggota' => session()->get('idAgt')]);
        
        ?>
        <script>
            document.location = "<?= base_url('user/peminjaman-step1');?>";
        </script>
        <?php
    }

    public function pengembalian()
    {
        $userId = session()->get('ses_id');

        $userData = $this->modelAnggota->find($userId);

        $modelPengembalian = new M_Pengembalian();

        $dataPengembalian = $modelPengembalian->getDataPengembalian([
            'tbl_peminjaman.id_anggota' => $userId
        ])->getResultArray();

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        $data = [
            'user' => $userData,
            'data_pengembalian' => $dataPengembalian,
            'pages' => $pages,
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Pengembalian/pengembalian', $data);
        echo view('User/Template/footer', $data);
    }
    
    public function proses_pengembalian($id_peminjaman)
    {

        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();
        $modelBuku = new M_Buku();
    
        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
            return redirect()->to(base_url('user/pengembalian-buku'));
        }
    
        $idBuku = $detailPeminjaman['id_buku'];
        $dataUpdate = [
            'status_transaksi' => 'Selesai',
        ];
        $modelPeminjaman->updateDataPeminjaman($dataUpdate, ['id_peminjaman' => $id_peminjaman]);
        $dataDetailUpdate = [
            'status_pinjam' => 'Sudah Dikembalikan',
        ];
        $modelPeminjaman->updateDataDetail($dataDetailUpdate, ['id_peminjaman' => $id_peminjaman]);
    
        $jumlahPinjam = $detailPeminjaman['total_pinjam'];

        $modelBuku->update($idBuku, ['jumlah_buku' => $modelBuku->find($idBuku)['jumlah_buku'] + $jumlahPinjam]);
        
    
        $lastIdPengembalian = $modelPengembalian->getLastIdPengembalian();
        if ($lastIdPengembalian) {
            $idNumber = (int) substr($lastIdPengembalian['id_pengembalian'], 3) + 1;
            $idPengembalian = 'PB-' . str_pad($idNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $idPengembalian = 'PB-001';
        }
    
        $dataPengembalian = [
            'id_pengembalian' => $idPengembalian,
            'id_peminjaman' => $id_peminjaman,
            'id_buku' => $idBuku,
            'denda' => 0,
            'tgl_pengembalian' => date('Y-m-d'),
            'id_admin' => session()->get('ses_id'),
        ];
    
        $modelPengembalian->saveDataPengembalian($dataPengembalian);

        $detailPengembalian = "ID Pengembalian: $idPengembalian\n";
        $detailPengembalian .= "ID Peminjaman: $id_peminjaman\n";
        $detailPengembalian .= "Tanggal Pengembalian: " . date("Y-m-d") . "\n";
        $detailPengembalian .= "Denda: Rp0\n";
    
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $detailPengembalian,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: FCPATH . 'assets/img/logo.png',
            logoResizeToWidth: 50,
            logoPunchoutBackground: true,
            labelText: $idPengembalian,
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center
        );
    
        $result = $builder->build();
        $namaQR = "qr_" . $idPengembalian . ".png";
        $result->saveToFile(FCPATH . 'assets/qr_code/' . $namaQR);
    
        session()->setFlashdata('success', 'Proses pengembalian berhasil dilakukan.');
        return redirect()->to(base_url('user/pengembalian'));
    }
    
    public function detail_pengembalian($id_pengembalian)
    {
        $session = session();
        $userId = $session->get('ses_id'); 

        $modelAnggota = new M_Anggota();
        $user = $modelAnggota->find($userId);

        $modelPengembalian = new M_Pengembalian();
        $detailPengembalian = $modelPengembalian->getDetailPengembalian(['id_pengembalian' => $id_pengembalian, 'tbl_anggota.id_anggota' => $userId]);

        if (!$detailPengembalian) {
            session()->setFlashdata('error', 'Data pengembalian tidak ditemukan!');
            return redirect()->to(base_url('user/pengembalian'));
        }

        $tglKembali = strtotime($detailPengembalian['tgl_kembali']);
        $tglSekarang = strtotime(date('Y-m-d'));
        $sisaHari = ($tglKembali - $tglSekarang) / (60 * 60 * 24);
    
        $denda = 0;
        if ($sisaHari < 0) {
            $hariTerlambat = abs($sisaHari);
            $tarifDenda = 1000;
            $denda = $hariTerlambat * $tarifDenda;
        }

        $dendaDibayar = 0;
        if (isset($detailPengembalian['denda'])) {
            $dendaDibayar = $detailPengembalian['denda'];
        }

        $uri = service('uri');
        $pages = $uri->getSegment(2);
        $namaQR = "qr_" . $id_pengembalian . ".png";
    
        $data = [
            'user' => $user,
            'pages' => $pages,
            'detail_pengembalian' => $detailPengembalian,
            'title' => 'Detail Pengembalian',
            'ses_level' => $session->get('ses_level'),
            'namaQR' => base_url('assets/qr_code/' . $namaQR),
            'is_completed' => ($detailPengembalian['status_transaksi'] ?? '') === 'Selesai',
            'denda' => $denda,
            'denda_dibayar' => $dendaDibayar
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Pengembalian/detail-pengembalian', $data);
        echo view('User/Template/footer', $data);
    }
    
    public function denda()
    {
        $session = session();
        $userId = $session->get('ses_id');
        $userModel = new M_Anggota();
        $userData = $userModel->find($userId);

        $today = date('Y-m-d');
        $overdueLoans = $this->modelPeminjaman->getDataPeminjamanJoin([
            'tbl_peminjaman.id_anggota' => $userId,
            'tbl_peminjaman.status_transaksi' => 'Selesai',
            'tbl_detail_peminjaman.tgl_kembali <' => $today
        ])->getResultArray();

        $dataDenda = [];
        foreach ($overdueLoans as $loan) {
            $dueDate = $loan['tgl_kembali'];
            $date1 = new \DateTime($dueDate);
            $date2 = new \DateTime($today);
            $interval = $date1->diff($date2);
            $overdueDays = $interval->days;

            $fineRate = 1000;
            $totalFine = $overdueDays * $fineRate;

            $dendaDibayar = 0;
            $pengembalian = $this->modelPengembalian->where('id_peminjaman', $loan['id_peminjaman'])->first();
            if ($pengembalian) {
                $dendaDibayar = $pengembalian['denda'] ?? 0;
            }

            $dataDenda[] = [
                'id_peminjaman' => $loan['id_peminjaman'],
                'nama_anggota' => $loan['nama_anggota'],
                'judul_buku' => $loan['judul_buku'],
                'tahun' => $loan['tahun'],
                'pengarang' => $loan['pengarang'],
                'tgl_kembali' => $loan['tgl_kembali'],
                'tgl_pengembalian' => $loan['tgl_pengembalian'],
                'hari_terlambat' => $overdueDays,
                'jumlah_denda' => $totalFine,
                'denda_dibayar' => $dendaDibayar
            ];
        }

        $data = [
            'user' => $userData,
            'data_denda' => $dataDenda,
            'title' => 'Denda Peminjaman Terlambat',
            'ses_level' => session()->get('ses_level')
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Denda/denda', $data);
        echo view('User/Template/footer', $data);
    }

    public function detail_denda($id_peminjaman)
    {
        $session = session();
        $userId = $session->get('ses_id');
        $userModel = new M_Anggota();
        $userData = $userModel->find($userId);

        $detailPeminjaman = $this->modelPeminjaman->getDetailPeminjaman($id_peminjaman);
 
        $dueDate = $detailPeminjaman['tgl_kembali'];
        $currentDate = date('Y-m-d');
        $dueDateObj = new \DateTime($dueDate);
        $currentDateObj = new \DateTime($currentDate);
    
        $interval = $dueDateObj->diff($currentDateObj);
        $lateDays = $interval->days;
    
        $finePerDay = 1000;
        $denda = ($currentDate > $dueDate) ? $lateDays * $finePerDay : 0;

        $pengembalian = $this->modelPengembalian->where('id_peminjaman', $id_peminjaman)->first();
        $dendaDibayar = $pengembalian['denda'] ?? 0;

        $data = [
            'user' => $userData,
            'detail_peminjaman' => $detailPeminjaman,
            'late_days' => ($currentDate > $dueDate) ? $lateDays : 0,
            'denda' => $denda,
            'denda_dibayar' => $dendaDibayar,
            'title' => 'Detail Denda',
            'ses_level' => session()->get('ses_level')
        ];

        echo view('User/Template/header', $data);
        echo view('User/Template/sidebar', $data);
        echo view('User/Denda/detail-denda', $data);
        echo view('User/Template/footer', $data);
    }
    
    public function bayarDenda($id_peminjaman)
    {
        $nominalBayar = $this->request->getPost('nominal_bayar');
    
        if (empty($nominalBayar) || $nominalBayar <= 0) {
            session()->setFlashdata('error', 'Nominal pembayaran tidak valid.');
            return redirect()->to(base_url('user/detail-denda/' . $id_peminjaman));
        }
    
        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();
        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);

        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan.');
            return redirect()->to(base_url('user/denda'));
        }

        $dueDate = new \DateTime($detailPeminjaman['tgl_kembali']);
        $currentDate = new \DateTime();
        $overdueDays = ($currentDate > $dueDate) ? $currentDate->diff($dueDate)->days : 0;

        $fineRate = 1000;
        $totalFine = $overdueDays * $fineRate;

        $pengembalian = $modelPengembalian->where('id_peminjaman', $id_peminjaman)->first();
        $dendaDibayar = $pengembalian['denda'] ?? 0;
        $remainingFine = $totalFine - $dendaDibayar;

        if ($nominalBayar > $remainingFine) {
            session()->setFlashdata('error', 'Nominal pembayaran melebihi jumlah denda.');
            return redirect()->to(base_url('user/detail-denda/' . $id_peminjaman));
        }

        $newDenda = $dendaDibayar + $nominalBayar;
        $modelPengembalian->update($pengembalian['id_pengembalian'], ['denda' => $newDenda]);

        if ($newDenda >= $totalFine) {
            session()->setFlashdata('success', 'Denda telah lunas.');
        } else {
            $remaining = $totalFine - $newDenda;
            session()->setFlashdata('success', "Pembayaran berhasil. Sisa denda: Rp$remaining.");
        }

        return redirect()->to(base_url('user/detail-denda/' . $id_peminjaman));
    }

    public function profile()
    {
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);
    
        if (!$userData) {
            session()->setFlashdata('error', 'Data Anggota tidak ditemukan.');
            return redirect()->to(base_url('user/dashboard'));
        }
    
        $data = [
            'pages' => 'profile',
            'user' => $userData,
        ];
    
        return view('User/Template/header', $data) .
            view('User/Template/sidebar', $data) .
            view('User/Profile/profile', $data) .
            view('User/Template/footer');
    }
    
    public function updateProfile()
    {
        $userId = session()->get('ses_id');
        $userData = $this->modelAnggota->find($userId);

        $validationRules = [
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required',
            'no_tlp' => 'required',
            'email' => 'required|valid_email',
            'alamat' => 'required',
        ];
    
        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', 'Gagal memperbarui profil. Pastikan semua kolom telah terisi.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_anggota' => $this->request->getPost('nama_anggota'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_tlp' => $this->request->getPost('no_tlp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
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

        $this->modelAnggota->updateProfileData($userId, $data);
    
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
    
        return redirect()->to(base_url('user/profile'));
    }
    
    public function updatePassword()
    {
    $validationRules = [
        'new_password' => 'required|min_length[8]',
        'confirm_password' => 'required|matches[new_password]',
    ];

    if (!$this->validate($validationRules)) {
        session()->setFlashdata('error', 'Gagal memperbarui password. Pastikan semua kolom terisi dan sesuai.');
        return redirect()->to(base_url('user/profile'))->withInput();
    }

    $inputPassword = $this->request->getPost('new_password');

    $userId = session()->get('ses_id');
    $data = [
        'password_anggota' => $inputPassword,
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    $this->modelAnggota->update($userId, $data);

    session()->setFlashdata('success', 'Password berhasil diperbarui.');
    return redirect()->to(base_url('user/profile'));
    }

    public function downloadPdf()
    {
        $userId = session()->get('ses_id');
        $dataPengembalian = $this->modelPengembalian->getDataPengembalianJoin([
            'tbl_peminjaman.id_anggota' => $userId
        ]);

        $html = '<html><head><style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    h1 { text-align: center; }
                </style></head><body>';
        $html .= '<h1>Riwayat Transaksi Peminjaman</h1>';
        $html .= '<table><thead><tr><th>#</th><th>Nama Anggota</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th></tr></thead><tbody>';

        $no = 1;
        foreach ($dataPengembalian as $pengembalian) {
            $html .= '<tr><td>' . $no++ . '</td><td>' . $pengembalian['nama_anggota'] . '</td><td>' . $pengembalian['judul_buku'] . '</td><td>' . date('d-m-Y', strtotime($pengembalian['tgl_pinjam'])) . '</td><td>' . date('d-m-Y', strtotime($pengembalian['tgl_kembali'])) . '</td></tr>';
        }

        $html .= '</tbody></table></body></html>';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('riwayat_transaksi_peminjaman.pdf', ['Attachment' => 1]);
    }

    public function logout()
    {
        if(session()->get('ses_id') == "" or session()->get('ses_user') == ""){
            session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('user/login-user'));
        }
        else{
            session()->remove('ses_id');
            session()->remove('ses_user');
            session()->setFlashdata('info','Anda Telah Logout!');
            return redirect()->to(base_url('user/login-user'));
        }
    }
}