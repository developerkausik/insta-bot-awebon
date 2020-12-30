<?php namespace App\Entities;

use CodeIgniter\Entity;

class Users extends Entity
{
    protected $first_name;
    protected $last_name;
    protected $account_type;
    protected $user_status;
    protected $user_ban_reason;
    protected $user_credits;
    protected $locked_credits;
    protected $email;
    protected $password;
    protected $profile_picture;
    protected $website;
    protected $created_at;
    protected $updated_at;
}