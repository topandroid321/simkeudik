<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPesertaDidik extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_peserta_didik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'nisn', 'nama_lengkap', 'kelas', 'jk', 'tahun_masuk', 'jurusan', 'username', 'password', 'role', 'photo'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getDataPeserta()
    {
        $db = db_connect();
        $query = $db->query("select * from `m_peserta_didik`");
        return $query;
    }
}
