<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Kategori extends Model
{
    protected $table = 'tbl_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = [
        'id_kategori', 'nama_kategori', 'is_delete_kategori', 'created_at', 'updated_at'
    ];

    public function getDataKategori($conditions = [])
    {
        return $this->where($conditions)->findAll();
    }

    public function saveDataKategori($data)
    {
        return $this->insert($data);
    }

    public function updateDataKategori($data, $conditions)
    {
        return $this->where($conditions)->set($data)->update();
    }
    
    public function autoNumber()
    {
        $query = $this->db->query("SELECT MAX(id_kategori) as max_id FROM tbl_kategori");
        $hasil = $query->getRowArray();
        return $hasil;
    }

    public function restoreKategori() 
    {
        return $this->where('is_delete_kategori', '1')
                    ->set('is_delete_kategori', '0')
                    ->update();
    }
}
