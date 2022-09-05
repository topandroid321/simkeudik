<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengajar extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_pengajar_diklat';
    protected $primaryKey       = 'id_pengajar';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pengajar', 'nama_pengajar', 'jk', 'no_tlp', 'alamat', 'photo'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getDataPengajar()
    {
        $db = db_connect();
        $query = $db->query("select * from `m_pengajar_diklat`");
        return $query;
    }
}
