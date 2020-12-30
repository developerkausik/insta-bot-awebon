<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBanReasonUsersTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('users', [
            'user_ban_reason'    =>	[
                'type'           => 'MEDIUMTEXT',
                'null'           => TRUE,
                'after'			 => 'user_status'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('users', 'user_ban_reason');
	}
}
