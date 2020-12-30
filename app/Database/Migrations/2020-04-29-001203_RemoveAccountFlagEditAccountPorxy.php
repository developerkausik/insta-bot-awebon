<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveAccountFlagEditAccountPorxy extends Migration
{
	public function up()
	{
	    // Delete Account Flag
        $this->forge->dropColumn('accounts', 'account_flag');
        $this->forge->modifyColumn('accounts', [
            'account_proxy'    =>	[
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
