<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRecordsDates extends Migration
{
	public function up()
	{
        $this->forge->addColumn('accounts_records', [
            'username_followers_date'    =>	[
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_followers'
            ],
            'username_followings_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_followings'
            ],
            'username_posts_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_posts'
            ],
            'username_likes_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_likes'
            ],
            'username_comments_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'username_comments'
            ],
            'hashtag_posts_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_posts'
            ],
            'hashtag_comments_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_comments'
            ],
            'hashtag_likes_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'hashtag_likes'
            ],
            'location_posts_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_posts'
            ],
            'location_comments_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_comments'
            ],
            'location_likes_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'location_likes'
            ],
            'post_comments_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'post_comments'
            ],
            'post_likes_date'    => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'post_likes'
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        //
	}
}
