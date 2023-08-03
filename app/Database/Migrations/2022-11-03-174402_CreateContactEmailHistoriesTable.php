<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactEmailHistoriesTable extends Migration
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
            'email_subject'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'email_content'             => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'email_status'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'sent_to'                   => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'sent_by'                   => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'created_date'              => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_date'              => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sent_to', 'contacts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sent_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contact_email_histories');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('contact_email_histories');
    }
}
