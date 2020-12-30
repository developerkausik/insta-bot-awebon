<?php namespace App\Database\Seeds;

class TaskTypesUpdatedSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $delete_data = [
            [
                'task_name'     =>  'Scrap Post Likes',
                'task_url'      =>  'posts_likes',
                'task_category' =>  'Posts'
            ],
            [
                'task_name'     =>  'Scrap Post Comments',
                'task_url'      =>  'posts_comments',
                'task_category' =>  'Posts'
            ],
        ];
        $insert_data = [
            [
                'task_name'     =>  'Scrap Location Likes',
                'task_url'      =>  'location_likes',
                'task_category' =>  'Location'
            ],
            [
                'task_name'     =>  'Scrap Location Comments',
                'task_url'      =>  'location_comments',
                'task_category' =>  'Location'
            ],
            [
                'task_name'     =>  'Scrap Location Posts',
                'task_url'      =>  'location_posts',
                'task_category' =>  'Location'
            ],
        ];

        foreach ($insert_data as $seed_data) {
            // Using Query Builder
            $this->db->table('task_types')->insert($seed_data);
        }

        foreach ($delete_data as $seed_delete_data) {
            $this->db->table('task_types')->where('task_url', $seed_delete_data['task_url'])->delete();
        }
    }
}