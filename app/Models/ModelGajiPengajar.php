<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGajiPengajar extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_gaji_pengajar';
    protected $primaryKey       = 'id_gaji';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_gaji', 'pengajar_id', 'diklat_id', 'tgl_pembayaran_gaji', 'jumlah_jam', 'gaji_perjam', 'gaji_total'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //get data gaji per id
    public function getDataGaji($id)
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar');
        $builder->select('*');
        $builder->join('m_pengajar_diklat', 'm_pengajar_diklat.id_pengajar = t_gaji_pengajar.pengajar_id');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_gaji_pengajar.diklat_id');
        $builder->where('t_gaji_pengajar.id_gaji', $id);
        $query = $builder->get();
        return $query->getRow();
    }

    //get data gaji all

    public function getAllDataGaji()
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar');
        $builder->select('*');
        $builder->join('m_pengajar_diklat', 'm_pengajar_diklat.id_pengajar = t_gaji_pengajar.pengajar_id');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_gaji_pengajar.diklat_id');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDataGajitgl($tgl_awal, $tgl_akhir)
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar');
        $builder->select('*');
        $builder->join('m_pengajar_diklat', 'm_pengajar_diklat.id_pengajar = t_gaji_pengajar.pengajar_id');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_gaji_pengajar.diklat_id');
        $builder->where('t_gaji_pengajar.tgl_pembayaran_gaji >=', $tgl_awal);
        $builder->where('t_gaji_pengajar.tgl_pembayaran_gaji <=', $tgl_akhir);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getJumlahgajiSum()
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar');
        $builder->selectSum('gaji_total');
        $query = $builder->get();
        return $query->getRow();
    }
    public function getJumlahgajiSumPertgl($tgl_awal, $tgl_akhir)
    {
        $db = db_connect();
        $builder = $db->table('t_gaji_pengajar');
        $builder->selectSum('gaji_total');
        $builder->where('t_gaji_pengajar.tgl_pembayaran_gaji >=', $tgl_awal);
        $builder->where('t_gaji_pengajar.tgl_pembayaran_gaji <=', $tgl_akhir);
        $query = $builder->get();
        return $query->getRow();
    }
}
