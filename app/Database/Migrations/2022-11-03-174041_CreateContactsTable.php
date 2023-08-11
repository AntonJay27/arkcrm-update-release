<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactsTable extends Migration
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
            'salutation'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => false,
            ],
            'first_name'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'last_name'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => false,
            ],
            'position'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'organization_id'           => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'primary_email'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => false,
            ],
            'secondary_email'           => [
                'type'              => 'VARCHAR',
                'constraint'        => 150,
                'null'              => true,
            ],
            'office_phone'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'mobile_phone'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'home_phone'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'secondary_phone'           => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'fax'                       => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'do_not_call'               => [
                'type'              => 'INT',
                'constraint'        => 11,
                'null'              => true,
            ],
            'date_of_birth'             => [
                'type'              => 'DATE',
                'null'              => true,
            ],
            'intro_letter'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true,
            ],
            'linkedin_url'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'twitter_url'               => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'facebook_url'              => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'instagram_url'             => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'lead_source'               => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'department'                => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'reports_to'                => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'email_opt_out'             => [
                'type'              => 'INT',
                'constraint'        => 11,
                'null'              => true,
            ],
            'unsubscribe_auth_code'     => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'assigned_to'               => [
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
            'description'               => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'picture'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
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
        $this->forge->addForeignKey('organization_id', 'organizations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reports_to', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('assigned_to', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contacts');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('contacts');
    }
}
