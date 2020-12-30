<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTaskParentColumnTasksTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('tasks', [
			'task_parent'	=>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'afer'			 => 'id'
			]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('tasks', 'task_parent');
	}
}
