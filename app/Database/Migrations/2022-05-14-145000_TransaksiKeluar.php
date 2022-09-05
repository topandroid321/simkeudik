<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiKeluar extends Migration
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

            'user_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => '10',
            ],

            'lembaga_id'       => [
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
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE');
        $this->forge->addForeignKey('lembaga_id', 'LembagaDiklat', 'id_lembaga', 'CASCADE');
        $this->forge->createTable('TransaksiKeluar');
    }

    public function down()
    {
        //
    }
}
