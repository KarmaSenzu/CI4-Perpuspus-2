<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Pengembalian extends Model
{
    protected $table = 'tbl_pengembalian';
    protected $primaryKey = 'id_pengembalian';
    protected $allowedFields = ['id_pengembalian', 'id_peminjaman', 'id_buku', 'denda', 'tgl_pengembalian', 'id_admin'];

    public function getDataPengembalian($where = false)
    {
        $builder = $this->db->table($this->table);
        
        $builder->select('tbl_pengembalian.*, tbl_peminjaman.id_peminjaman, tbl_peminjaman.status_transaksi, tbl_peminjaman.tgl_pinjam, tbl_peminjaman.total_pinjam, tbl_detail_peminjaman.tgl_kembali, tbl_anggota.nama_anggota, tbl_buku.judul_buku, tbl_buku.tahun, tbl_buku.pengarang');
        $builder->join('tbl_peminjaman', 'tbl_pengembalian.id_peminjaman = tbl_peminjaman.id_peminjaman', 'left');
        $builder->join('tbl_detail_peminjaman', 'tbl_peminjaman.id_peminjaman = tbl_detail_peminjaman.id_peminjaman', 'left');
        $builder->join('tbl_anggota', 'tbl_peminjaman.id_anggota = tbl_anggota.id_anggota', 'left');
        $builder->join('tbl_buku', 'tbl_pengembalian.id_buku = tbl_buku.id_buku', 'left');

        if ($where) {
            $builder->where($where);
        }

        $builder->orderBy('tgl_pengembalian', 'DESC');
        return $builder->get();
    }    

    public function saveDataPengembalian($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function getDetailPengembalian($where)
    {
        return $this->db->table('tbl_pengembalian')
            ->select('tbl_pengembalian.*, tbl_anggota.nama_anggota, tbl_anggota.email, tbl_anggota.no_tlp, tbl_anggota.alamat, tbl_buku.judul_buku, tbl_buku.pengarang, tbl_buku.penerbit, tbl_buku.tahun, tbl_kategori.nama_kategori, tbl_peminjaman.tgl_pinjam, tbl_peminjaman.status_transaksi, tbl_peminjaman.total_pinjam, tbl_detail_peminjaman.tgl_kembali')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id_peminjaman = tbl_pengembalian.id_peminjaman')
            ->join('tbl_anggota', 'tbl_anggota.id_anggota = tbl_peminjaman.id_anggota')
            ->join('tbl_buku', 'tbl_buku.id_buku = tbl_pengembalian.id_buku')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_buku.id_kategori')
            ->join('tbl_detail_peminjaman', 'tbl_detail_peminjaman.id_peminjaman = tbl_peminjaman.id_peminjaman', 'left')
            ->where($where)
            ->get()
            ->getRowArray();
    }

    public function getLastIdPengembalian()
    {
    return $this->orderBy('id_pengembalian', 'DESC')->first();
    }

}
