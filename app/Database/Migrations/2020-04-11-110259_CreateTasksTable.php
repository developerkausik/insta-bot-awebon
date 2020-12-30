<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
                'id'        	  => [
                       'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                ],
                'task_name'       => [
                        'type'           => 'VARCHAR',
                        'constraint'     => '155',
                        'null'			 =>	TRUE
                ],
                'task_action'       => [
                        'type'           => 'VARCHAR',
                        'constraint'     => '50',
                        'null'			 =>	TRUE
                ],
                'task_fuids_queue' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'           => TRUE,
                ],
                'task_fuids_done' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'           => TRUE,
                ],
                'task_userid' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_typeid' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_typecat' => [
                        'type'           => 'VARCHAR',
                        'constraint'     => '100',
                        'null'			 =>	TRUE
                ],
                'task_type' => [
                        'type'           => 'VARCHAR',
                        'constraint'     => '255',
                        'null'			 =>	TRUE
                ],
                'task_pagination' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'			 =>	TRUE
                ],
                'task_message' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'			 =>	TRUE
                ],
                'task_done' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_stop' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_failed' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_failed_reason' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'			 =>	TRUE
                ],
                'task_threads' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'5'
                ],
                'task_max' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'10'
                ],
                'task_processing' => [
                        'type'           => 'INT',
                        'constraint'     => '11',
                        'default'		 =>	'0'
                ],
                'task_scrap_elements' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'			 =>	TRUE
                ],
                'task_destination' => [
                        'type'           => 'MEDIUMTEXT',
                        'null'			 =>	TRUE
                ],
        'created_at' => [
            'type'       => 'DATETIME',
            'null'       => true,
        ],
        'updated_at' => [
            'type'       => 'DATETIME',
            'null'       => true,
        ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tasks');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tasks');
	}
}
