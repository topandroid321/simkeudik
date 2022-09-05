<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiKeluar extends Model
{
   protected $DBGroup          = 'default';
   protected $table            = 't_transaksi_keluar';
   protected $primaryKey       = 'id_transaksi_keluar';
   protected $useAutoIncrement = true;
   protected $insertID         = 0;
   protected $returnType       = 'array';
   protected $useSoftDeletes   = false;
   protected $protectFields    = true;
   protected $allowedFields    = [
      'id_transaksi_keluar', 'tgl_transaksi_keluar', 'diklat_id', 'perencanaan_id', 'total_biaya', 'keterangan', 'created_by'
   ];

   // Dates
   protected $useTimestamps = false;
   protected $dateFormat    = 'datetime';
   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';


   public function getTransaksiKeluar()
   {
      $db = db_connect();
      $builder = $db->table('t_transaksi_keluar');
      $builder->select('*');
      $builder->join('m_diklat', 'm_diklat.id_diklat = t_transaksi_keluar.diklat_id');
      $builder->join('t_perencanaan_diklat', 't_perencanaan_diklat.id_perencanaan = t_transaksi_keluar.perencanaan_id');
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
}
