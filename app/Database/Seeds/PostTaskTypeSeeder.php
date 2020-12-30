<?php namespace App\Database\Seeds;

class PostTaskTypeSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $task_types_data = [
            [
                'task_name'     =>  'Scrap Post Likes',
                'task_url'      =>  'post_likes',
                'task_category' =>  'Post'
            ],
            [
                'task_name'     =>  'Scrap Post Comments',
                'task_url'      =>  'post_comments',
                'task_category' =>  'Post'
            ]
        ];

        foreach ($task_types_data as $seed_data) {
            $this->db->table('task_types')->insert($seed_data);
        }
    }
}