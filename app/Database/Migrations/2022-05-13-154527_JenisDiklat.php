<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisDiklat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenis_diklat'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
            ],

            'nama_diklat'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'lembaga_id'       => [
                'type'           => 'INT',
                'constraint'     => '10',
            ],
            'harga_diklat'       => [
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
        $this->forge->addPrimaryKey('id_jenis_diklat', true);
        $this->forge->addForeignKey('lembaga_id', 'LembagaDiklat', 'id_lembaga', 'CASCADE');
        $this->forge->createTable('JenisDiklat');
    }

    public function down()
    {
        //
    }
}
