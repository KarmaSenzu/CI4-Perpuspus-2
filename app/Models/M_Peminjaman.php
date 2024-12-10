<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Peminjaman extends Model
{
    protected $table = 'tbl_peminjaman';
    protected $tableDetail = 'tbl_detail_peminjaman';
    protected $tableTmp = 'tbl_temp_peminjaman';
    protected $allowedFields = ['id_peminjaman', 'id_anggota', 'tgl_pinjam', 'total_pinjam', 'id_admin', 'status_transaksi', 'status_ambil_buku'];


    public function getDataPeminjaman($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('id_peminjaman', 'DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('id_peminjaman', 'DESC');
            return $query = $builder->get();
        }
    }

    public function getDataPeminjamanJoin($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_peminjaman.*, tbl_anggota.nama_anggota, tbl_admin.nama_admin, tbl_buku.judul_buku, tbl_buku.tahun, tbl_buku.pengarang, tbl_detail_peminjaman.tgl_kembali, tbl_pengembalian.tgl_pengembalian');
        $builder->join('tbl_anggota', 'tbl_anggota.id_anggota = tbl_peminjaman.id_anggota', 'left');
        $builder->join('tbl_admin', 'tbl_admin.id_admin = tbl_peminjaman.id_admin', 'left');
        $builder->join('tbl_detail_peminjaman', 'tbl_detail_peminjaman.id_peminjaman = tbl_peminjaman.id_peminjaman', 'left');
        $builder->join('tbl_buku', 'tbl_buku.id_buku = tbl_detail_peminjaman.id_buku', 'left');
        $builder->join('tbl_pengembalian', 'tbl_pengembalian.id_peminjaman = tbl_peminjaman.id_peminjaman', 'left');
    
        if ($where) {
            $builder->where($where);
        }
    
        $builder->orderBy('tbl_peminjaman.id_peminjaman', 'DESC');
        return $builder->get();
    }
    
    public function saveDataPeminjaman($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataPeminjaman($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }

    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_peminjaman");
        $builder->orderBy("id_peminjaman", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
    }

    public function getDetailPeminjaman($id_peminjaman)
    {
    return $this->db->table('tbl_peminjaman')
        ->select('tbl_peminjaman.id_peminjaman, tbl_anggota.nama_anggota, tbl_anggota.email, tbl_anggota.no_tlp, tbl_anggota.alamat, tbl_buku.judul_buku, tbl_buku.pengarang, tbl_buku.penerbit, tbl_buku.cover_buku, tbl_kategori.nama_kategori, tbl_peminjaman.tgl_pinjam, tbl_peminjaman.total_pinjam, tbl_peminjaman.status_transaksi, tbl_detail_peminjaman.tgl_kembali, tbl_detail_peminjaman.status_pinjam, tbl_detail_peminjaman.id_buku, tbl_peminjaman.status_transaksi, tbl_pengembalian.tgl_pengembalian')
        ->join('tbl_anggota', 'tbl_anggota.id_anggota = tbl_peminjaman.id_anggota')
        ->join('tbl_detail_peminjaman', 'tbl_detail_peminjaman.id_peminjaman = tbl_peminjaman.id_peminjaman')
        ->join('tbl_buku', 'tbl_buku.id_buku = tbl_detail_peminjaman.id_buku')
        ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_buku.id_kategori')
        ->join('tbl_pengembalian', 'tbl_pengembalian.id_peminjaman = tbl_peminjaman.id_peminjaman', 'left')
        
        ->where('tbl_peminjaman.id_peminjaman', $id_peminjaman)
        ->get()
        ->getRowArray();
    }

    public function saveDataDetail($data)
    {
        $builder = $this->db->table('tbl_detail_peminjaman');
        return $builder->insert($data);
    }

    public function updateDataDetail($data, $where)
    {
        $builder = $this->db->table($this->tableDetail);
        $builder->where($where);
        return $builder->update($data);
    }

    public function getDataTemp($where = false)
    {
        $builder = $this->db->table('tbl_temp_peminjaman');
        $builder->select('*');

        if ($where !== false) {
            $builder->where($where);
        }

        return $builder->get();
    }

    public function getDataTempJoin($where = false)
    {
        $builder = $this->db->table('tbl_temp_peminjaman AS temp');
        $builder->select('temp.*, buku.judul_buku, buku.pengarang, buku.penerbit, buku.tahun, buku.cover_buku, buku.jumlah_buku');
        $builder->join('tbl_buku AS buku', 'temp.id_buku = buku.id_buku', 'LEFT');
    
        if ($where !== false) {
        $builder->where($where);
        }

        return $builder->get();
    }

    public function saveDataTemp($data)
    {
        $builder = $this->db->table('tbl_temp_peminjaman');
        return $builder->insert($data);
    }

    public function hapusDataTemp($where)
    {
        $builder = $this->db->table('tbl_temp_peminjaman');
        $builder->where($where);
        return $builder->delete();
    }

    public function getLastIdPeminjaman()
    {
        return $this->db->table('tbl_peminjaman')
                        ->select('id_peminjaman')
                        ->orderBy('id_peminjaman', 'DESC')
                        ->limit(1)
                        ->get()
                        ->getRowArray();
    }
}
?>