<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsRecordsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'account_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'username_followers'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'username_followings'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'username_posts'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'username_likes'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'username_comments'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'hashtag_posts'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'hashtag_comments'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'hashtag_likes'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'location_posts'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'location_comments'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'location_likes'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'post_comments'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'post_likes'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '10000',
            ],
            'created_at'		 => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'		 => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounts_records');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('accounts_records');
    }
}
