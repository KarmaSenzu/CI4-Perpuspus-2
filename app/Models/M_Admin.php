<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Admin extends Model
{
   
    protected $table = 'tbl_admin';
    protected $primaryKey = 'id_admin';
    protected $allowedFields = [
        'id_admin', 'nama_admin', 'username_admin', 
        'password_admin', 'akses_level', 'is_delete_admin', 
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDataAdmin($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        if ($where !== false) {
            $builder->where($where);
        }
        $builder->orderBy('nama_admin', 'ASC');
        return $builder->get();
    }
    
    public function saveDataAdmin($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataAdmin($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_admin");
        $builder->orderBy("id_admin", "DESC");
        $builder->limit(1);
        return $builder->get();
    }

    public function restoreAdmin() 
    {
        return $this->where('is_delete_admin', '1')
                    ->set('is_delete_admin', '0')
                    ->update();
    }

    public function updateProfileData($data)
    {
        return $this->db->table('tbl_admin')->update($data, ['id_admin' => session()->get('ses_id')]);
    }
}
?>
