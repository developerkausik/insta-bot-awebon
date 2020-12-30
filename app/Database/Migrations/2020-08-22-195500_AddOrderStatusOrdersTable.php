<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderStatusOrdersTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('orders', [
            'order_status'    =>	[
                'type'       => 'INTEGER',
                'constraint' => 20,
                'default'    => 0,
                'after'      => 'payment_method'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('users', 'order_status');
	}
}
