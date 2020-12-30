<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitUserTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'first_name'     => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE
            ],
            'last_name'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE
            ],
            'account_type'  =>  [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'       => 1,
            ],
            'created_at'	=> [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'	=> [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('users');
	}
}
