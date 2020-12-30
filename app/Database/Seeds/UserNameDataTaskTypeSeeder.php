<?php namespace App\Database\Seeds;

class UserNameDataTaskTypeSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $cron_settings_data = [
            [
                'cron_name' =>  'cron11',
                'cron_type' =>  'username_data',
            ],
        ];
        $task_types_data = [
            [
                'task_name'     =>  'Scrap Username Data',
                'task_url'      =>  'username_data',
                'task_category' =>  'Username'
            ]
        ];

        foreach ($cron_settings_data as $seed_data) {
            $this->db->table('cron_settings')->insert($seed_data);
        }
        foreach ($task_types_data as $seed_data) {
            $this->db->table('task_types')->insert($seed_data);
        }
    }
}