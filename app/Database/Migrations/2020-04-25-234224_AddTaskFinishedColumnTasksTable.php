<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTaskFinishedColumnTasksTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('tasks', [
            'task_finished'	    =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'task_done'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('tasks', 'task_finished');
	}
}
