<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlansTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        	  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'plan_title'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'plan_description' => [
                'type'           => 'MEDIUMTEXT',
                'null'           => TRUE,
            ],
            'plan_price' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'plan_credits' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'		 =>	'0'
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('plans');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('plans');
	}
}
