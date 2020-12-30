<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailPassword extends Migration
{
	public function up()
	{
        $this->forge->addColumn('users', [
            'email'    =>	[
                'type'       => 'MEDIUMTEXT',
                'null'       => true,
                'after'      => 'account_type'
            ],
            'password'    =>	[
                'type'       => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true,
                'after'      => 'email'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('users', 'email');
        $this->forge->dropColumn('accounts', 'password');
	}
}
