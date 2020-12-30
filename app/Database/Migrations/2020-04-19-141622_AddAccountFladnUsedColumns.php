<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountFladnUsedColumns extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts', [
            'account_flag'	=>	[
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'account_used'	=>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'account_status'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('accounts', 'account_flag');
        $this->forge->dropColumn('accounts', 'account_used');
	}
}
