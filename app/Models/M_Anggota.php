<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Anggota extends Model
{
    protected $table = 'tbl_anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = [
        'id_anggota', 'nama_anggota', 'jenis_kelamin', 'no_tlp', 
        'email', 'password_anggota', 'alamat', 'is_delete_anggota', 
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDataAnggota($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_anggota','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_anggota','ASC');
            return $query = $builder->get();
        }
    }    
    
    public function saveDataAnggota($data)
    {
        return $this->insert($data);
    }

    public function updateDataAnggota($data, $id)
    {
        if (isset($data['email'])) {
            $currentData = $this->find($id);
            if ($currentData['email'] !== $data['email']) {
                $validationRules = [
                    'email' => 'is_unique[tbl_anggota.email]'
                ];

                $validationMessages = [
                    'email' => [
                        'is_unique' => 'Email sudah digunakan oleh anggota lain.'
                    ]
                ];

                $this->setValidationRules($validationRules);
                $this->setValidationMessages($validationMessages);
            }
        }

        return $this->update($id, $data);
    }

    public function autoNumber()
    {
        $query = $this->db->query("SELECT MAX(id_anggota) as max_id FROM tbl_anggota");
        $hasil = $query->getRowArray();
        return $hasil;
    }

    public function restoreAnggota() 
    {
        return $this->where('is_delete_anggota', '1')
                    ->set('is_delete_anggota', '0')
                    ->update();
    }

    public function updateProfileData($id, $data)
    {
        return $this->db->table($this->table)->update($data, ['id_anggota' => $id]);
    }    
}
