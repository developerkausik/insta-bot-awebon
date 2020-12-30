<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class Discounts extends Entity
{
    protected $discount_name;
    protected $discount_type;
    protected $discount_amount;
    protected $discount_code;
    protected $discount_status;
    protected $created_at;
    protected $updated_at;
}