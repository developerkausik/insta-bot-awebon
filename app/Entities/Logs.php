<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class Logs extends Entity
{
    protected $user_id;
    protected $account_id;
    protected $log_type;
    protected $log_content;
    protected $created_at;
    protected $updated_at;
}