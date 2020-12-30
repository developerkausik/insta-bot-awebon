<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class Plans extends Entity
{
    protected $plan_title;
    protected $plan_description;
    protected $plan_price;
    protected $plan_credits;
    protected $created_at;
    protected $updated_at;
}