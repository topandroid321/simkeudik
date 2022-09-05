<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LembagaDiklat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lembaga'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
            ],

            'nama_lembaga'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'alamat'       => [
                'type'           => 'text',
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
        $this->forge->addPrimaryKey('id_lembaga', true);
        $this->forge->createTable('LembagaDiklat');
    }

    public function down()
    {
        //
    }
}
