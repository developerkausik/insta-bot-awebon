<?php namespace App\Database\Seeds;

class BaseUsersSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name' =>  'El',
                'last_name' =>  'Mehdi',
                'account_type' =>  '1',
                'email' =>  'user@test.com',
                'password' =>  '$2y$10$uaGGsMZp0rC5G2AonQ8Nbe77UdkD6PB9FEpFlnLIgKfbgUtXRhm6q',
            ],
            [
                'first_name' =>  'El',
                'last_name' =>  'Mehdi',
                'account_type' =>  '2',
                'email' =>  'admin@test.com',
                'password' =>  '$2y$10$uaGGsMZp0rC5G2AonQ8Nbe77UdkD6PB9FEpFlnLIgKfbgUtXRhm6q',
            ],
        ];

        foreach ($data as $seed_data) {
            $this->db->table('users')->insert($seed_data);
        }
    }
}