<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUser extends Migration
{
    public function up()
    {
        $fields = [
            'memberid'      => ['type' => 'INT', 'constraint' => 11, 'after' => 'id'],
            'firstname'     => ['type' => 'varchar', 'constraint' => 255, 'after' => 'memberid'],
            'lastname'      => ['type' => 'varchar', 'constraint' => 255, 'after' => 'firstname'],
            'phone'         => ['type' => 'varchar', 'constraint' => 255, 'after' => 'lastname'],
            'photo'         => ['type' => 'varchar', 'constraint' => 255, 'after' => 'username'],
            'membercard'    => ['type' => 'varchar', 'constraint' => 255, 'after' => 'photo'],
            'expired_at'    => ['type' => 'datetime', 'after' => 'deleted_at'],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {        
        $fields = [
            'memberid',
            'firstname',
            'lastname',
            'phone',
            'membercard',
            'photo',
            'expired_at',
        ];
        $this->forge->dropColumn('users', $fields);
    }
}