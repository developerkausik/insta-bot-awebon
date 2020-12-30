<?php namespace App\Database\Seeds;

class CronSettingsUpdatedSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $delete_data = [
            [
                'cron_type'      =>  'posts_likes',
            ],
            [
                'cron_type'      =>  'posts_comments',
            ],
        ];
        $insert_data = [
            [
                'cron_name' =>  'cron23',
                'cron_type' =>  'location_likes',
            ],
            [
                'cron_name' =>  'cron24',
                'cron_type' =>  'location_comments',
            ],
            [
                'cron_name' =>  'cron25',
                'cron_type' =>  'location_posts',
            ],
        ];

        foreach ($insert_data as $seed_data) {
            // Using Query Builder
            $this->db->table('cron_settings')->insert($seed_data);
        }

        foreach ($delete_data as $seed_delete_data) {
            $this->db->table('cron_settings')->where('cron_type', $seed_delete_data['cron_type'])->delete();
        }
    }
}