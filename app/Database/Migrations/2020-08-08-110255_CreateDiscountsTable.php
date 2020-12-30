<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDiscountsTable extends Migration
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
            'discount_name'     	=> [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'discount_type'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'discount_amount'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'discount_status'	=> [
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
        $this->forge->createTable('discounts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('discounts');
	}
}
