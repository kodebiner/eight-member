<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivity extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'activity' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'done_at' => [
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('activity');
    }

    public function down()
    {
        $this->forge->dropTable('activity');
    }
}