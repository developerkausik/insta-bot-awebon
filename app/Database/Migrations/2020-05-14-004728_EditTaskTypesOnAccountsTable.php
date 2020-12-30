<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EditTaskTypesOnAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->dropColumn('accounts', 'posts_likes');
        $this->forge->dropColumn('accounts', 'posts_comments');

        $this->forge->addColumn('accounts', [
            'location_likes'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_posts'
            ],
            'location_comments'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_likes'
            ],
            'location_posts'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_comments'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('accounts', 'location_likes');
        $this->forge->dropColumn('accounts', 'location_comments');
        $this->forge->dropColumn('accounts', 'location_posts');
	}
}
