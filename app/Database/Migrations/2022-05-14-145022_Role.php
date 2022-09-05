<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 20,
                'auto_increment' => true,
            ],

            'nama_role'          => [
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
        $this->forge->addPrimaryKey('nisn', true);
        $this->forge->createTable('JenisDiklat');
    }

    public function down()
    {
        //
    }
}
