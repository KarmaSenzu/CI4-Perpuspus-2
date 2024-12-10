<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Rak extends Model
{
    protected $table = 'tbl_rak';
    protected $primaryKey = 'id_rak';
    protected $allowedFields = [
        'id_rak', 'nama_rak', 'is_delete_rak', 'created_at', 'updated_at'
    ];

    public function getDataRak($conditions = [])
    {
        return $this->where($conditions)->findAll();
    }

    public function saveDataRak($data)
    {
        return $this->insert($data);
    }

    public function updateDataRak($data, $conditions)
    {
        return $this->where($conditions)->set($data)->update();
    }
    
    public function autoNumber()
    {
        $query = $this->db->query("SELECT MAX(id_rak) as max_id FROM tbl_rak");
        $hasil = $query->getRowArray();
        return $hasil;
    }

    public function restoreRak() 
    {
        return $this->where('is_delete_rak', '1')
                    ->set('is_delete_rak', '0')
                    ->update();
    }
}
