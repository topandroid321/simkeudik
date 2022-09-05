<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_user';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'nama_lengkap', 'username', 'password', 'photo', 'role', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';



    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $db = \Config\Database::connect();
        $builder = $db->table('t_user');
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password']))
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }

    public function create($data)
    {
        $db = \Config\Database::connect();
        $db->table('t_user')->insert($data);
        return $this->db->affectedRows();
    }

    public function getDataUser()
    {
        $db = db_connect();
        $query = $db->query("select * from `m_user`");
        return $query;
    }
}
