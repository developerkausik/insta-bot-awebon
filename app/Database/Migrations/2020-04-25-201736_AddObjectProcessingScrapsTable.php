<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddObjectProcessingScrapsTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('scraps', [
            'object_processing'	 =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'object_processed'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('scraps', 'object_processing');
	}
}
