<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDiklat extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_diklat';
    protected $primaryKey       = 'id_diklat';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_diklat', 'nama_diklat', 'lama_pelaksanaan', 'deskripsi',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getDataDiklat()
    {
        $db = db_connect();
        $query = $db->query("select * from `m_diklat`");
        return $query;
    }

    public function search($title)
    {
        $db = db_connect();
        $query = $db->query(`select * from 'm_diklat' LIKE $title`);
        return $query;
    }
}
