<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMemberCategory extends Migration
{
    public function up()
    {
        // Category Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('member_category');

        // User Category Table
        $fields = [
            'category_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
                'default'       => 0,
                'after'         => 'sub_type'
            ]
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropTable('member_category');

        $fields = ['category_id'];
        $this->forge->dropColumn('users', $fields);
    }
}