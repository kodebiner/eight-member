<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPromo extends Migration
{
    public function up()
    {
        // Promo Table
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
            'created_at' => [
                'type'          => 'datetime'
            ],
            'updated_at' => [
                'type'          => 'datetime'
            ],
            'deleted_at' => [
                'type'          => 'datetime'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('promo');

        // User Promo Table
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
            ],
            'promo_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
            ]
        ]);
        $this->forge->addKey(['user_id', 'promo_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('promo_id', 'promo', 'id', '', 'CASCADE');
        $this->forge->createTable('promo_user');
    }

    public function down()
    {
        $this->forge->dropTable('promo');
        $this->forge->dropTable('promo_user');
    }
}