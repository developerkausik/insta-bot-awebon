<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPostScrapType extends Migration
{
	public function up()
	{
	    // Adding Post To Accounts Table
        $this->forge->addColumn('accounts', [
            'post_likes'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_posts'
            ],
            'post_comments'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'post_likes'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('accounts', 'post_likes');
        $this->forge->dropColumn('accounts', 'post_comments');
	}
}
