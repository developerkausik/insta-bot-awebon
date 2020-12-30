<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentMethodOrdersTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('orders', [
            'payment_method'    =>	[
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
                'after'			 => 'plan_id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('orders', 'payment_method');
	}
}
