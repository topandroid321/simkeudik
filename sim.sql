-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 5.7.33 - MySQL Community Server (GPL)
-- OS Server:                    Win64
-- HeidiSQL Versi:               11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_simkeudik
CREATE DATABASE IF NOT EXISTS `db_simkeudik` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_simkeudik`;

-- membuang struktur untuk table db_simkeudik.m_diklat
CREATE TABLE IF NOT EXISTS `m_diklat` (
  `id_diklat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_diklat` varchar(50) DEFAULT NULL,
  `lama_pelaksanaan` varchar(50) DEFAULT NULL,
  `deskripsi_diklat` text,
  KEY `Index 1` (`id_diklat`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.m_lembaga_diklat
CREATE TABLE IF NOT EXISTS `m_lembaga_diklat` (
  `id_lembaga` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lembaga` varchar(125) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(50) DEFAULT NULL,
  KEY `Index 1` (`id_lembaga`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.m_pengajar_diklat
CREATE TABLE IF NOT EXISTS `m_pengajar_diklat` (
  `id_pengajar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengajar` varchar(50) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `no_tlp` varchar(50) DEFAULT NULL,
  `alamat` text,
  `photo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengajar`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.m_peserta_didik
CREATE TABLE IF NOT EXISTS `m_peserta_didik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `tahun_masuk` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nisn` (`nisn`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.m_user
CREATE TABLE IF NOT EXISTS `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_detail_transaksi
CREATE TABLE IF NOT EXISTS `t_detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi_masuk` int(11) DEFAULT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `jumlah_bayar` bigint(20) DEFAULT NULL,
  `status_verifikasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_detail_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_gaji_pengajar
CREATE TABLE IF NOT EXISTS `t_gaji_pengajar` (
  `id_gaji` int(11) DEFAULT NULL,
  `pengajar_id` int(11) DEFAULT NULL,
  `diklat_id` int(11) DEFAULT NULL,
  `jumlah_jam` int(11) DEFAULT NULL,
  `gaji_total` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_perencanaan_diklat
CREATE TABLE IF NOT EXISTS `t_perencanaan_diklat` (
  `id_perencanaan` int(11) NOT NULL AUTO_INCREMENT,
  `diklat_id` int(11) DEFAULT NULL,
  `tanggal_pelaksanaan` date DEFAULT NULL,
  `lembaga_diklat_id` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_perencanaan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_peserta_diklat
CREATE TABLE IF NOT EXISTS `t_peserta_diklat` (
  `id` int(11) DEFAULT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `id_perencanaan` int(11) DEFAULT NULL,
  `status_pembayaran` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_transaksi_keluar
CREATE TABLE IF NOT EXISTS `t_transaksi_keluar` (
  `id_transaksi_keluar` int(20) DEFAULT NULL,
  `tgl_transaksi_keluar` date DEFAULT NULL,
  `diklat_id` int(11) DEFAULT NULL,
  `total_biaya` bigint(20) DEFAULT NULL,
  `ket` text,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_simkeudik.t_transaksi_masuk
CREATE TABLE IF NOT EXISTS `t_transaksi_masuk` (
  `id_transaksi_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(50) DEFAULT NULL,
  `diklat_id` int(11) DEFAULT NULL,
  `perencanaan_id` int(11) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
