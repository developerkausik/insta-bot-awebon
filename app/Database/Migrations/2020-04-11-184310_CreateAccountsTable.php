<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        		 => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
        	],
            'account_username'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'account_password'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'account_id'		 => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'account_name'		 => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE
            ],
            'account_proxy'		 => [
                'type'           => 'INT',
                'constraint'     => '11',
                'default'		 =>	'0'
            ],
            'account_profile'	 => [
                'type'           => 'MEDIUMTEXT',
                'null'			 =>	TRUE
            ],
            'account_challenge'		 => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE
            ],
            'account_choice'	 => [
                'type'           => 'INT',
                'constraint'     => '11',
                'default'		 =>	'0'
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
        $this->forge->createTable('accounts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('accounts');
	}
}
