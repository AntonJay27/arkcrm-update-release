<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactAddressDetailsTable extends Migration
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
            'contact_id'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'mailing_street'            => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'mailing_po_box'            => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'mailing_city'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'mailing_state'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'mailing_zip'               => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'mailing_country'           => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'other_street'              => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'other_po_box'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'other_city'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'other_state'               => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'other_zip'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'other_country'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
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
        $this->forge->addForeignKey('contact_id', 'contacts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contact_address_details');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('contact_address_details');
    }
}
