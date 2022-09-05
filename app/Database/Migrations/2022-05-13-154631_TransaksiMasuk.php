<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'          => [
                'type'           => 'INT',
                'constraint'     => 20,
            ],

            'tgl_transaksi'          => [
                'type'           => 'DATE',
                'constraint'     => '50',
            ],

            'nisn'       => [
                'type'           => 'VARCHAR',
                'unsigned'       => true,
                'constraint'     => '20',
            ],
            'user_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => '10',
            ],

            'jenis_diklat_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => '10',
            ],
            'bukti_pembayaran'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'            => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'            => true,
            ]

        ]);
        $this->forge->addPrimaryKey('id_transaksi', true);
        $this->forge->addForeignKey('nisn', 'PesertaDidik', 'nisn', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE');
        $this->forge->addForeignKey('jenis_diklat_id', 'JenisDiklat', 'id_jenis_diklat', 'CASCADE');
        $this->forge->createTable('TransaksiMasuk');
    }

    public function down()
    {
        //
    }
}
