<?php namespace App\Database\Seeds;

class TaskTypesSeeder extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
            $data = [
                [
                    'task_name'     =>  'Scrap Username Followers',
                    'task_url'      =>  'username_followers',
                    'task_category' =>  'Username'
                ],
                [
                    'task_name'     =>  'Scrap Username Followings',
                    'task_url'      =>  'username_followings',
                    'task_category' =>  'Username'
                ],
                [
                    'task_name'     =>  'Scrap Username Posts',
                    'task_url'      =>  'username_posts',
                    'task_category' =>  'Username'
                ],
                [
                    'task_name'     =>  'Scrap Username Comments',
                    'task_url'      =>  'username_comments',
                    'task_category' =>  'Username'
                ],
                [
                    'task_name'     =>  'Scrap Username Likes',
                    'task_url'      =>  'username_likes',
                    'task_category' =>  'Username'
                ],
                [
                    'task_name'     =>  'Scrap Hashtag Likes',
                    'task_url'      =>  'hashtag_likes',
                    'task_category' =>  'Hashtag'
                ],
                [
                    'task_name'     =>  'Scrap Hashtag Comments',
                    'task_url'      =>  'hashtag_comments',
                    'task_category' =>  'Hashtag'
                ],
                [
                    'task_name'     =>  'Scrap Hashtag Posts',
                    'task_url'      =>  'hashtag_posts',
                    'task_category' =>  'Hashtag'
                ],
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
            
            foreach ($data as $seed_data) {
                // Using Query Builder
                $this->db->table('task_types')->insert($seed_data);
            }
        }
}