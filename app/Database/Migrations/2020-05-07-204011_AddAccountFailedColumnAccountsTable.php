<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountFailedColumnAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts', [
            'account_fail_reason'    =>	[
                'type'       => 'MEDIUMTEXT',
                'null'       => true,
                'after'      => 'account_lastscraped'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('account_fail_reason', 'accounts');
	}
}
