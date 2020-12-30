<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddToDeleteQueueForTasks extends Migration
{
	public function up()
	{
        $this->forge->addColumn('tasks', [
            'to_delete'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'      => 'task_parent'
            ],
            'processing'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'      => 'to_delete'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
