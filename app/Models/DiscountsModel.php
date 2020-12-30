<?php 
namespace App\Models;

use CodeIgniter\Model;

class DiscountsModel extends Model {
    protected $table = "discounts";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Discounts";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "discount_name",
        "discount_type",
        "discount_amount",
        "discount_code",
        "discount_status",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
}