<?php namespace App\Database\Seeds;

class CronSettingsSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'cron_name' =>  'cron1',
                'cron_type' =>  'username_followers',
            ],
            [
                'cron_name' =>  'cron2',
                'cron_type' =>  'username_followings',
            ],
            [
                'cron_name' =>  'cron3',
                'cron_type' =>  'username_posts',
            ],
            [
                'cron_name' =>  'cron4',
                'cron_type' =>  'username_comments',
            ],
            [
                'cron_name' =>  'cron5',
                'cron_type' =>  'username_likes',
            ],
            [
                'cron_name' =>  'cron6',
                'cron_type' =>  'hashtag_likes',
            ],
            [
                'cron_name' =>  'cron7',
                'cron_type' =>  'hashtag_comments',
            ],
            [
                'cron_name' =>  'cron8',
                'cron_type' =>  'hashtag_posts',
            ],
            [
                'cron_name' =>  'cron9',
                'cron_type' =>  'posts_likes',
            ],
            [
                'cron_name' =>  'cron10',
                'cron_type' =>  'posts_comments',
            ],
        ];

        foreach ($data as $seed_data) {
            $this->db->table('cron_settings')->insert($seed_data);
        }
    }
}