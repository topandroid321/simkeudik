<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLemdik extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_lembaga_diklat';
    protected $primaryKey       = 'id_lembaga';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_lembaga', 'nama_lembaga', 'alamat', 'no_telp',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getDataLemdik()
    {
        $db = db_connect();
        $query = $db->query("select * from `m_lembaga_diklat`");
        return $query;
    }
}
