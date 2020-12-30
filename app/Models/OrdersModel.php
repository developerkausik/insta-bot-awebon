<?php 
namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model {
    protected $table = "orders";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Orders";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "user_id",
        "plan_id",
        "transaction_id",
        "payment_method",
        "order_amount",
        "order_status",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
}