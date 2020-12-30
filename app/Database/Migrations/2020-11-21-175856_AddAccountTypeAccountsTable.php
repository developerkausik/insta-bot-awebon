<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountTypeAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts', [
            'account_autocomplete'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'      => 'account_challenge'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
