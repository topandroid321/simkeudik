<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiMasuk extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_transaksi_masuk';
    protected $primaryKey       = 'id_transaksi_masuk';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_transaksi_masuk', 'nisn', 'diklat_id', 'perencanaan_id', 'user_id', 'status_pembayaran'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // public function getAll()
    // {
    //     $db = db_connect();
    //     $builder = $db->table('t_transaksi_masuk');
    //     $builder->select('*');
    //     $builder->join('t_user', 't_user.id = t_transaksi_masuk.user_id');
    //     $builder->join('t_peserta_didik', 't_peserta_didik.nisn = t_transaksi_masuk.nisn');
    //     $builder->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk');
    //     $builder->join('t_jenis_diklat', 't_jenis_diklat.id_jenis_diklat = t_detail_transaksi.id_jenis_diklat');
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    public function getDataTransaksi()
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_masuk');
        $builder->select('*');
        $builder->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn');
        $builder->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id');
        $builder->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id');
        $builder->where('t_detail_transaksi.status_verifikasi', "Sudah Terverifikasi");

        $query = $builder->get();
        return $query->getResult();
    }

    public function getDataPerTgl($tgl_awal, $tgl_akhir)
    {
        $db = db_connect();
        $builder = $db->table('t_transaksi_masuk');
        $builder->select('*');
        $builder->join('m_peserta_didik', 'm_peserta_didik.nisn = t_transaksi_masuk.nisn');
        $builder->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_masuk.perencanaan_id');
        $builder->join('t_detail_transaksi', 't_detail_transaksi.id_transaksi_masuk = t_transaksi_masuk.id_transaksi_masuk');
        $builder->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_masuk.diklat_id');
        $builder->where('t_detail_transaksi.tgl_transaksi >=', $tgl_awal);
        $builder->where('t_detail_transaksi.tgl_transaksi <=', $tgl_akhir);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getJumlahTransaksiSum()
    {
        $db = db_connect();
        $builder = $db->table('t_detail_transaksi');
        $builder->selectSum('jumlah_bayar');
        $builder->where('t_detail_transaksi.status_verifikasi', "Sudah Terverifikasi");
        $query = $builder->get();
        return $query->getRow();
    }

    public function getJumlahBarangSumPerTgl($tgl_awal, $tgl_akhir)
    {
        $db = db_connect();
        $builder = $db->table('t_detail_transaksi');
        $builder->selectSum('jumlah_bayar');
        $builder->where('t_detail_transaksi.tgl_transaksi >=', $tgl_awal);
        $builder->where('t_detail_transaksi.tgl_transaksi <=', $tgl_akhir);
        $query = $builder->get();
        return $query->getRow();
    }
}
