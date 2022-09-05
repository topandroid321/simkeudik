<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
            ],

            'username'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'nama_lengkap'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'photo'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'role_id'       => [
                'type'           => 'INT',
                'constraint'     => '10',
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
        $this->forge->addPrimaryKey('id', true);
        $this->forge->addForeignKey('role_id', 'Role', 'id', 'CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
