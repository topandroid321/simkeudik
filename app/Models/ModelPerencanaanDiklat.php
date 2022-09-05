<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPerencanaanDiklat extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_perencanaan_diklat';
    protected $primaryKey       = 'id_perencanaan';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_perencanaan', 'diklat_id', 'tanggal_pelaksanaan', 'lembaga_diklat_id', 'harga', 'ket'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getDataPerencanaan()
    {
        $db = db_connect();
        $query = $db->query("select * from `t_perencanaan_diklat` INNER JOIN m_diklat ON t_perencanaan_diklat.diklat_id=m_diklat.id_diklat;");
        return $query;
    }
}
