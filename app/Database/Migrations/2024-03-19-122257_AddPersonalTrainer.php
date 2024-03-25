<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPersonalTrainer extends Migration
{
    public function up()
    {
        $fields = [
            'pt' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
                'default'       => 0,
                'after'         => 'user_id'
            ]
        ];
        $this->forge->addColumn('checkin', $fields);
    }

    public function down()
    {
        $fields = ['pt'];
        $this->forge->dropColumn('checkin', $fields);
    }
}