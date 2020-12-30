<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskTypesTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
        	],
            'task_name'     	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE
            ],
            'task_url'   		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'task_category'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
			'created_at'		 => [
				'type'       => 'DATETIME',
				'null'       => true,
			],
			'updated_at'		 => [
				'type'       => 'DATETIME',
				'null'       => true,
			],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('task_types');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('task_types');
	}
}
