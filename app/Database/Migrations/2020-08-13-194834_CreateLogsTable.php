<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogsTable extends Migration
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
            'user_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'account_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'log_type'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE
            ],
            'log_content'	=> [
                'type'           => 'LONGTEXT',
                'null'           => TRUE,
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
        $this->forge->createTable('logs');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('logs');
	}
}
