<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id'                        => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'document_number'           => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => true,
            ],
            'title'                     => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => false,
            ],
            'type'                      => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'file_name'                 => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'file_url'                  => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'file_type'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => true,
            ],
            'file_size'                 => [
                'type'              => 'DECIMAL',
                'constraint'        => [20,2],
                'null'              => true,
            ],
            'download_count'            => [
                'type'              => 'DECIMAL',
                'constraint'        => [20,2],
                'null'              => true,
            ],
            'notes'                     => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'assigned_to'               => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'created_by'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'created_date'              => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_by'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'updated_date'              => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('assigned_to', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('documents');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('documents');
    }
}
