<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddObjectProcessedColumn extends Migration
{
	public function up()
	{
        $this->forge->addColumn('scraps', [
            'object_processed'	 =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'object_extra'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('scraps', 'object_processed');
	}
}
