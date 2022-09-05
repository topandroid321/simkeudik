<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailTransaksi extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_detail_transaksi';
    protected $primaryKey       = 'id_detail_transaksi';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_detail_transaksi', 'id_transaksi_masuk', 'nisn', 'created_by', 'tgl_transaksi', 'status_verifikasi', 'jumlah_bayar', 'sisa_pembayaran', 'file'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getDataDetail($id_transaksi, $diklat_id)
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_masuk');
        $builder->select('*');
        $builder->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn');
        $builder->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id');
        $builder->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id');
        $builder->where('t_transaksi_masuk.id_transaksi_masuk', $id_transaksi);
        $builder->where('t_transaksi_masuk.diklat_id', $diklat_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDataTransaksi($id_transaksi, $diklat_id)
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_masuk');
        $builder->select('*');
        $builder->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn');
        $builder->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id');
        $builder->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id');
        $builder->where('t_transaksi_masuk.id_transaksi_masuk', $id_transaksi);
        $builder->where('t_transaksi_masuk.diklat_id', $diklat_id);
        $query = $builder->get();
        return $query->getRow();
    }
}
