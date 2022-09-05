<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesertaDidik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nisn'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],

            'nama_lengkap'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'Kelas'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'Jurusan'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],

            'username'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'role_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'constraint'     => '50',
            ],
            'photo'       => [
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
        $this->forge->addForeignKey('role_id', 'Role', 'id', 'CASCADE');
        $this->forge->createTable('JenisDiklat');
    }

    public function down()
    {
        //
    }
}
