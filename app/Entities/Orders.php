<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class Orders extends Entity
{
    protected $user_id;
    protected $transaction_id;
    protected $plan_id;
    protected $payment_method;
    protected $order_amount;
    protected $order_status;
    protected $created_at;
    protected $updated_at;
}