<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThrottlingColumnsAccountsTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts', [
            'username_followers'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'account_used'
            ],
            'username_followings'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_followers'
            ],
            'username_posts'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_followings'
            ],
            'username_comments'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_posts'
            ],
            'username_likes'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_comments'
            ],
            'hashtag_likes'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_likes'
            ],
            'hashtag_comments'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_likes'
            ],
            'hashtag_posts'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_comments'
            ],
            'posts_likes'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_posts'
            ],
            'posts_comments'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'posts_likes'
            ],
            'username_data'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'posts_comments'
            ],
            'account_lastscraped'    =>	[
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'			 =>	TRUE,
                'after'      => 'username_data'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('accounts', 'username_followers');
        $this->forge->dropColumn('accounts', 'username_followings');
        $this->forge->dropColumn('accounts', 'username_posts');
        $this->forge->dropColumn('accounts', 'username_comments');
        $this->forge->dropColumn('accounts', 'username_likes');
        $this->forge->dropColumn('accounts', 'hashtag_likes');
        $this->forge->dropColumn('accounts', 'hashtag_comments');
        $this->forge->dropColumn('accounts', 'hashtag_posts');
        $this->forge->dropColumn('accounts', 'posts_likes');
        $this->forge->dropColumn('accounts', 'posts_comments');
        $this->forge->dropColumn('accounts', 'username_data');
        $this->forge->dropColumn('accounts', 'account_lastscraped');
	}
}
