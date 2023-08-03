<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'salutation'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => true,
            ],
            'first_name'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'middle_name'       => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'last_name'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'position'          => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'picture'           => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'user_name'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'user_email'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'contact_number'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'user_password'     => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'user_auth_code'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'user_status'       => [
                'type'              => 'ENUM',
                'constraint'        => ['1','0'],
                'null'              => true,
            ],
            'password_auth_code'=> [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => true,
            ],
            'role_id'           => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'admin'             => [
                'type'              => 'ENUM',
                'constraint'        => ['1','0'],
                'null'              => true,
            ],
            'created_by'        => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'created_date'      => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_by'        => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'updated_date'      => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
