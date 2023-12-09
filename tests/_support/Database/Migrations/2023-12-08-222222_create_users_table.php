<?php

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsers extends Migration
{
    protected $DBGroup = 'tests';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'picture' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'last_login' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
