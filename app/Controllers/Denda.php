<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Peminjaman;
use App\Models\M_Buku;
use App\Models\M_Pengembalian;

class Denda extends BaseController
{
    protected $modelPeminjaman;
    protected $modelBuku;
    protected $modelPengembalian;

    public function __construct()
    {
        $this->modelBuku = new M_Admin();
        $this->modelPeminjaman = new M_Peminjaman();
        $this->modelBuku = new M_Buku();
        $this->modelPengembalian = new M_Pengembalian();
    }

    public function denda()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $session = session();
        $adminId = $session->get('ses_id');
        $adminModel = new M_Admin();
        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();
        $today = date('Y-m-d');

        $overdueLoans = $this->modelPeminjaman->getDataPeminjamanJoin([
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
            'admin' => $adminData,
            'data_denda' => $dataDenda,
            'title' => 'Denda Peminjaman Terlambat',
            'ses_level' => session()->get('ses_level')
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Denda/denda', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function detail_denda($id_peminjaman)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
    
        $session = session();
        $adminId = $session->get('ses_id');
        $adminModel = new M_Admin();
        $adminData = $adminModel->getDataAdmin(['id_admin' => $adminId])->getRowArray();

        $detailPeminjaman = $this->modelPeminjaman->getDetailPeminjaman($id_peminjaman);
    
        if (!$detailPeminjaman) {
            session()->setFlashdata('error', 'Data peminjaman tidak ditemukan!');
            return redirect()->to(base_url('admin/denda'));
        }

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
            'admin' => $adminData,
            'detail_peminjaman' => $detailPeminjaman,
            'late_days' => ($currentDate > $dueDate) ? $lateDays : 0,
            'denda' => $denda,
            'denda_dibayar' => $dendaDibayar,
            'title' => 'Detail Denda',
            'ses_level' => session()->get('ses_level')
        ];
    
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Denda/detail-denda', $data);
        echo view('Backend/Template/footer', $data);
    }
    
    public function bayarDenda($id_peminjaman = null)
    {
        if (is_null($id_peminjaman)) {
            session()->setFlashdata('error', 'ID peminjaman tidak ditemukan.');
            return redirect()->to(base_url('admin/denda'));
        }
    
        $nominalBayar = $this->request->getPost('nominal_bayar');
    
        if (empty($nominalBayar) || $nominalBayar <= 0) {
            session()->setFlashdata('error', 'Nominal bayar harus lebih dari 0!');
            return redirect()->back();
        }
    
        $modelPengembalian = new M_Pengembalian();
        $pengembalian = $modelPengembalian->where('id_peminjaman', $id_peminjaman)->first();
    
        if ($pengembalian) {
            $modelPengembalian->update($pengembalian['id_pengembalian'], [
                'denda' => $pengembalian['denda'] + $nominalBayar
            ]);
    
            session()->setFlashdata('success', 'Denda berhasil dibayar!');
        } else {
            session()->setFlashdata('error', 'Data pengembalian tidak ditemukan!');
        }
    
        return redirect()->to(base_url('admin/denda'));
    }
    
}    