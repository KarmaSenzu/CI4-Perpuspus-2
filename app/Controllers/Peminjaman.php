<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Peminjaman;
use App\Models\M_Pengembalian;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Peminjaman extends BaseController
{
    protected $modelAdmin;
    protected $modelAnggota;
    protected $modelBuku;
    protected $modelPeminjaman;
    protected $modelPengembalian;

    public function __construct()
    {
        $this->modelAdmin = new M_Admin();
        $this->modelAnggota = new M_Anggota();
        $this->modelBuku = new M_Buku();
        $this->modelPeminjaman = new M_Peminjaman();
        $this->modelPengembalian = new M_Pengembalian();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function transaksi_data_peminjaman()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $session = session();
        $adminId = $session->get('ses_id');
    
        $adminModel = new M_Admin();
        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
    
        $dataPeminjaman = $this->modelPeminjaman->getDataPeminjamanJoin()->getResultArray();
        $today = date('Y-m-d');

        foreach ($dataPeminjaman as &$peminjaman) {
            if ($peminjaman['tgl_kembali'] < $today && $peminjaman['status_transaksi'] == 'Berjalan') {
                $peminjaman['status_transaksi'] = 'Terlambat';
            }
        }
    
        $data = [
            'admin' => $adminData,
            'pages' => 'peminjaman',
            'data_peminjaman' => $dataPeminjaman,
            'ses_level' => session()->get('ses_level')
        ];
    
        return view('Backend/Template/header', $data) .
               view('Backend/Template/sidebar', $data) .
               view('Backend/Peminjaman/transaksi-data-peminjaman', $data) .
               view('Backend/Template/footer');
    }
    
    public function peminjaman_step1()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $session = session();
        $adminId = $session->get('ses_id');
    
        $modelAdmin = new M_Admin();
        $admin = $modelAdmin->find($adminId);
    
        $modelAnggota = new M_Anggota();
        $modelPeminjaman = new M_Peminjaman();
        $uri = service('uri');
        $page = $uri->getSegment(2);
    
        $allAnggota = $modelAnggota->getDataAnggota()->getResultArray();
    
        $dataAnggota = array_filter($allAnggota, function($anggota) {
            return $anggota['is_delete_anggota'] === '0';
        });

        $data['admin'] = $admin;
        $data['dataAnggota'] = $dataAnggota;
        $data['pages'] = $page;
        $data['web_title'] = "Pilih Anggota untuk Peminjaman";
        $data['ses_level'] = $session->get('ses_level');    
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Peminjaman/peminjaman-step1', $data);
        echo view('Backend/Template/footer', $data);
    }
    
    public function peminjaman_step2()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $modelAnggota = new M_Anggota;
        $modelBuku = new M_Buku;
        $modelPeminjaman = new M_Peminjaman;
        $modelAdmin = new M_Admin;
    
        $uri = service('uri');
        $page = $uri->getSegment(2);
    
        $idAnggota = $this->request->getPost('id_anggota') ?: session()->get('idAgt');
        session()->set(['idAgt' => $idAnggota]);
    
        $cekPeminjaman = $modelPeminjaman->getDataPeminjaman(['id_anggota' => $idAnggota, 'status_transaksi' => "Berjalan"])->getNumRows();
        if ($cekPeminjaman > 0) {
            session()->setFlashdata('error', 'Tidak dapat meminjam buku karena masih ada peminjaman yang sedang berlangsung. Harap selesaikan peminjaman yang ada terlebih dahulu!');
            echo "<script>history.go(-1);</script>";
            return;
        }
    
        $adminData = $modelAdmin->getDataAdmin(['id_admin' => session()->get('ses_id')])->getRowArray();
        $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();

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
            'admin' => $adminData,
            'pages' => $page,
            'web_title' => "Transaksi Peminjaman",
            'dataAnggota' => $dataAnggota ?: [],
            'dataBuku' => $dataBuku,
            'jumlahTemp' => $jumlahTemp,
            'dataTemp' => $dataTemp,
            'ses_level' => session()->get('ses_level'),
            'idAnggota' => $idAnggota,
            'search' => $search
        ];
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Peminjaman/peminjaman-step2', $data);
        echo view('Backend/Template/footer', $data);
    }
    
    public function peminjaman_step3()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAnggota = new M_Anggota;
        $modelPeminjaman = new M_Peminjaman;
        $modelAdmin = new M_Admin;

        $uri = service('uri');
        $page = $uri->getSegment(2);

        $idAnggota = session()->get('idAgt');
        if (!$idAnggota) {
            session()->setFlashdata('error', 'Pilih anggota terlebih dahulu!');
            return redirect()->to(base_url('admin/peminjaman-step1'));
        }

        $adminData = $modelAdmin->getDataAdmin(['id_admin' => session()->get('ses_id')])->getRowArray();
        $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();

        $dataTemp = $modelPeminjaman->getDataTempJoin(['temp.id_anggota' => $idAnggota])->getResultArray();
        $jumlahTemp = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();

        $data = [
            'admin' => $adminData,
            'pages' => $page,
            'web_title' => "Pilih Durasi dan Jumlah Buku",
            'dataAnggota' => $dataAnggota ?: [],
            'dataTemp' => $dataTemp,
            'jumlahTemp' => $jumlahTemp,
            'ses_level' => session()->get('ses_level'),
            'idAnggota' => $idAnggota,
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Peminjaman/peminjaman-step3', $data);
        echo view('Backend/Template/footer', $data);
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
            return redirect()->to(base_url('admin/transaksi-data-peminjaman'));
        }

        $jumlahPinjam = $this->request->getPost('total_pinjam');
        $durasiPinjam = $this->request->getPost('durasi_pinjaman');

        foreach ($jumlahPinjam as $idBuku => $jumlah) {
            if ($jumlah > 0) {
                $buku = $modelBuku->find($idBuku);
                if ($buku['jumlah_buku'] < $jumlah) {
                    session()->setFlashdata('error', 'Stok buku tidak cukup!');
                    return redirect()->to(base_url('admin/peminjaman-step3'));
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

                return redirect()->to(base_url('admin/detail-peminjaman/' . $newIdPeminjaman));
            }
        }

        session()->setFlashdata('error', 'Tidak ada buku yang dipinjam!');
        return redirect()->to(base_url('admin/transaksi-data-peminjaman'));
    }

    public function detail_peminjaman($id_peminjaman)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $session = session();
        $adminId = $session->get('ses_id');
    
        $modelAdmin = new M_Admin();
        $admin = $modelAdmin->find($adminId);
        $modelPeminjaman = new M_Peminjaman();
        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
            return redirect()->to(base_url('admin/transaksi-data-peminjaman'));
        }
    
        $uri = service('uri');
        $pages = $uri->getSegment(2);
        $namaQR = "qr_" . $id_peminjaman . ".png";

        $tglKembali = new \DateTime($detailPeminjaman['tgl_kembali']);
        $tglPengembalian = isset($detailPeminjaman['tgl_pengembalian']) 
            ? new \DateTime($detailPeminjaman['tgl_pengembalian']) 
            : new \DateTime();
    
        $hariTerlambat = ($tglPengembalian > $tglKembali) ? $tglPengembalian->diff($tglKembali)->days : 0;
    
        $data['admin'] = $admin;
        $data['pages'] = $pages;
        $data['detail_peminjaman'] = $detailPeminjaman;
        $data['title'] = 'Detail Peminjaman';
        $data['ses_level'] = $session->get('ses_level'); 
        $data['namaQR'] = base_url('assets/qr_code/' . $namaQR);
    
        $data['is_completed'] = ($detailPeminjaman['status_transaksi'] ?? '') === 'Selesai';
        $data['hari_terlambat'] = $hariTerlambat > 0 ? $hariTerlambat : 'Tidak Ada Keterlambatan';
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Peminjaman/detail-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
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
            echo "<script>document.location = '" . base_url('admin/peminjaman-step2') . "';</script>";
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
            document.location = "<?= base_url('admin/peminjaman-step2');?>";
        </script>
        <?php
    }
}
