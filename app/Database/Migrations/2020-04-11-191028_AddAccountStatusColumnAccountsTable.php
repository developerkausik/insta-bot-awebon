<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountStatusColumnAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts', [
			'account_status'	=>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'account_choice'
			]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('accounts', 'account_status');
	}
}
