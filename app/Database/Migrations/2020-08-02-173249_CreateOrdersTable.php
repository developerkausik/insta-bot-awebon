<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id'     	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'transaction_id'   		=> [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'plan_id'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'created_at'		 => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'		 => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('orders');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('orders');
	}
}
