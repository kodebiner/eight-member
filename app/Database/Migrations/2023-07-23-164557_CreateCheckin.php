<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCheckin extends Migration
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
            'checked_at' => [
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('checkin');
    }

    public function down()
    {
        $this->forge->dropTable('checkin');
    }
}