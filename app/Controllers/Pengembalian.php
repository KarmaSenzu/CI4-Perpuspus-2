<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Pengembalian;
use App\Models\M_Peminjaman;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Pengembalian extends BaseController
{
    protected $modelAdmin;
    protected $modelAnggota;
    protected $modelBuku;
    protected $modelPengembalian;
    protected $modelPeminjaman;

    public function __construct()
    {
        $this->modelAdmin = new M_Admin();
        $this->modelAnggota = new M_Anggota();
        $this->modelBuku = new M_Buku();
        $this->modelPengembalian = new M_Pengembalian();
        $this->modelPeminjaman = new M_Peminjaman();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function transaksi_data_pengembalian()
    {
    if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
        session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin'); ?>";
        </script>
        <?php
    } else {
        $modelPengembalian = new M_Pengembalian();
        $adminModel = new M_Admin();

        $adminId = session()->get('ses_id');
        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        $uri = service('uri');
        $pages = $uri->getSegment(2);

        $data = [
            'data_pengembalian' => $modelPengembalian->getDataPengembalian()->getResultArray(),
            'title' => 'Transaksi Data Pengembalian',
            'pages' => $pages,
            'admin' => $adminData,
            'ses_level' => session()->get('ses_level')
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Pengembalian/transaksi-data-pengembalian', $data);
        echo view('Backend/Template/footer', $data); 
    }
    }

    public function detail_pengembalian($id_pengembalian)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $session = session();
        $adminId = $session->get('ses_id');
        $modelAdmin = new M_Admin();
        $admin = $modelAdmin->find($adminId);

        $modelPengembalian = new M_Pengembalian();
        $detailPengembalian = $modelPengembalian->getDetailPengembalian(['id_pengembalian' => $id_pengembalian]);

        if (!$detailPengembalian) {
            session()->setFlashdata('error', 'Data pengembalian tidak ditemukan!');
            return redirect()->to(base_url('admin/transaksi-data-pengembalian'));
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
    
        $data['admin'] = $admin;
        $data['pages'] = $pages;
        $data['detail_pengembalian'] = $detailPengembalian;
        $data['title'] = 'Detail Pengembalian';
        $data['ses_level'] = $session->get('ses_level'); 
        $data['namaQR'] = base_url('assets/qr_code/' . $namaQR);

        $data['is_completed'] = ($detailPengembalian['status_transaksi'] ?? '') === 'Selesai';
        $data['denda'] = $denda;
        $data['denda_dibayar'] = $dendaDibayar;
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Pengembalian/detail-pengembalian', $data);
        echo view('Backend/Template/footer', $data);
    }
    
    public function proses_pengembalian($id_peminjaman)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();
        $modelBuku = new M_Buku();
    
        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
            return redirect()->to(base_url('admin/pengembalian-buku'));
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
        return redirect()->to(base_url('admin/transaksi-data-pengembalian'));
    }
    
    public function perpanjang_pinjam($id_peminjaman)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
        session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
        return redirect()->to(base_url('admin/login-admin'));
        }

        $modelPeminjaman = new M_Peminjaman();
        $modelPengembalian = new M_Pengembalian();

        $detailPeminjaman = $modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
        session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
        return redirect()->to(base_url('admin/transaksi-data-pengembalian'));
        }

        $pengembalianExists = $modelPengembalian->where('id_peminjaman', $id_peminjaman)->findAll();
            if ($pengembalianExists) {
            foreach ($pengembalianExists as $pengembalian) {
            $modelPengembalian->delete($pengembalian['id_peminjaman']);
            }
        }

        $dataUpdate = [
            'status_transaksi' => 'Berjalan',
        ];

        $dataDetailUpdate = [
            'status_pinjam' => 'Sedang Dipinjam',
            'tgl_kembali' => date('Y-m-d', strtotime($detailPeminjaman['tgl_kembali'] . ' +7 days')),
        ];

        $modelPeminjaman->updateDataPeminjaman($dataUpdate, ['id_peminjaman' => $id_peminjaman]);
        $modelPeminjaman->updateDataDetail($dataDetailUpdate, ['id_peminjaman' => $id_peminjaman]);

        $id_buku = $detailPeminjaman['id_buku'];

        $modelBuku = new M_Buku();
        $modelBuku->kurangiStok($id_buku, 1);

        session()->setFlashdata('success', 'Perpanjangan peminjaman berhasil!');
        return redirect()->to(base_url('admin/transaksi-data-pengembalian'));
    }
}
