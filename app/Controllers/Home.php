<?php

namespace App\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;

class Home extends BaseController
{
    public function home()
    {
        $modelAnggota = new M_Anggota();
        $modelBuku = new M_Buku();
        $modelKategori = new M_Kategori();
        $modelRak = new M_Rak();

        $jumlahAnggota = $modelAnggota->where('is_delete_anggota', '0')->countAllResults();
        $jumlahBuku = $modelBuku->where('is_delete_buku', '0')->countAllResults();
        $jumlahKategori = $modelKategori->where('is_delete_kategori', '0')->countAllResults();
        $jumlahRak = $modelRak->where('is_delete_rak', '0')->countAllResults();
    
        $bukuTerlaris = $modelBuku->orderBy('jumlah_buku', 'asc')
            ->limit(3)
            ->findAll();
        
        $data = [
            'jumlahAnggota' => $jumlahAnggota,
            'jumlahBuku' => $jumlahBuku,
            'jumlahKategori' => $jumlahKategori,
            'jumlahRak' => $jumlahRak,
            'bukuTerlaris' => $bukuTerlaris,
        ];

        echo view('Backend/Template/header1', $data);
        echo view('Backend/Home/home', $data);
        echo view('Backend/Template/footer1', $data);
    }

    public function daftar_buku()
    {
        $modelBuku = new M_Buku();

        $bukuList = $modelBuku->where('is_delete_buku', '0')->findAll();
        $data = [
            'bukuList' => $bukuList,
        ];

        echo view('Backend/Template/header1', $data);
        echo view('Backend/Home/daftar-buku', $data);
        echo view('Backend/Template/footer1', $data);
    }
    
    public function contact()
    {
        echo view('Backend/Template/header1');
        echo view('Backend/Home/contact');
        echo view('Backend/Template/footer1');
    }

    public function faq()
    {
        echo view('Backend/Template/header1');
        echo view('Backend/Home/faq');
        echo view('Backend/Template/footer1');
    }
}
