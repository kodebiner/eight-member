<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubPromo extends Migration
{
    public function up()
    {
        $fields = [
            'sub_type'      => ['type' => 'INT', 'constraint' => 11, 'after' => 'status_message']
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {        
        $fields = [
            'sub_type'
        ];
        $this->forge->dropColumn('users', $fields);
    }
}