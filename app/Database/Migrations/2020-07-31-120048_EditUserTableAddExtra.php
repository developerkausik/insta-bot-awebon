<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EditUserTableAddExtra extends Migration
{
	public function up()
	{
        $this->forge->addColumn('users', [
            'user_status'    =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'account_type'
            ],
            'user_plan'    =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'user_status'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('users', 'user_status');
        $this->forge->dropColumn('users', 'user_plan');
	}
}
