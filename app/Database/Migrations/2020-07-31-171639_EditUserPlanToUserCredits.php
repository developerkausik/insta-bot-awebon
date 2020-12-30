<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EditUserPlanToUserCredits extends Migration
{
	public function up()
	{
        $this->forge->modifyColumn('users', [
            'user_plan'    =>	[
                'name'      =>  'user_credits',
                'type'       => 'INTEGER',
                'constraint' => 20,
                'default'       => 0,
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
