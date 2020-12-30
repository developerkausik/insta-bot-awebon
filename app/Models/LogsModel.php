<?php 
namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model {
    protected $table = "logs";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Logs";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "user_id",
        "account_id",
        "log_type",
        "log_content",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
}