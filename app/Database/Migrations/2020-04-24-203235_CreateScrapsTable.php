<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScrapsTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'task_id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'	     =>	0
            ],
            'object_id'     => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'object_value'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'object_extra'  =>  [
                'type'           => 'LONGTEXT',
                'null'           => TRUE,
            ],
            'created_at'	=> [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'	=> [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('scraps');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('scraps');
	}
}
