<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAmountOrdersTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('orders', [
            'order_amount'    =>	[
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00,
                'after'    => 'plan_id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('orders', 'order_amount');
	}
}
