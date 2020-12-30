<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCronSettingsTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'        		 => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'cron_name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '155',
                'null'			 =>	TRUE
            ],
            'cron_value'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'	     =>	0
            ],
            'cron_type'		     => [
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
        $this->forge->createTable('cron_settings');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('cron_settings');
	}
}
