<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLockedCreditsUsersTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('users', [
            'locked_credits'    =>	[
                'type'       => 'INTEGER',
                'constraint' => 20,
                'default'       => 0,
                'after'    => 'user_credits'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('users', 'locked_credits');
	}
}
