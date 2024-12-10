<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Buku extends Model
{
    protected $table = 'tbl_buku';
    protected $primaryKey = 'id_buku';
    protected $allowedFields = [
        'id_buku', 'judul_buku', 'pengarang', 'penerbit', 'tahun',
        'jumlah_buku', 'isbn', 'id_kategori', 'keterangan', 'id_rak',
        'cover_buku', 'is_delete_buku', 'status_buku', 'created_at', 'updated_at'
    ];

    public function getDataBuku($where = [])
    {
        return $this->where($where)->get();
    }

    public function getDataBukuJoin($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_buku.*, tbl_kategori.nama_kategori, tbl_rak.nama_rak');
        $builder->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_buku.id_kategori', 'LEFT');
        $builder->join('tbl_rak', 'tbl_rak.id_rak = tbl_buku.id_rak', 'LEFT');
        $builder->orderBy('tbl_buku.judul_buku', 'ASC');
    
        if ($where !== false) {
            $builder->where($where);
        }
    
        return $builder->get();
    }    

    public function saveDataBuku($data)
    {
        return $this->insert($data);
    }

    public function updateDataBuku($data, $where)
    {
        return $this->where($where)->set($data)->update();
    }

    public function autoNumber()
    {
        return $this->select('id_buku')->orderBy('id_buku', 'DESC')->limit(1)->get();
    }

    public function restoreBuku() 
    {
        return $this->where('is_delete_buku', '1')
                    ->set('is_delete_buku', '0')
                    ->update();
    }
    
    public function countBukuByKategori($kategoriId)
    {
        return $this->where(['id_kategori' => $kategoriId, 'is_delete_buku' => '0'])->countAllResults();
    }

    public function countBukuByRak($rakId)
    {
        return $this->where(['id_rak' => $rakId, 'is_delete_buku' => '0'])->countAllResults();
    }
}
?>
