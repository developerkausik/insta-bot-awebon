<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiscountCodeColumn extends Migration
{
	public function up()
	{
        $this->forge->addColumn('discounts', [
            'discount_code'    =>	[
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'			 =>	TRUE,
                'after'    => 'discount_amount'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('discounts', 'discount_code');
	}
}
