<?php namespace App\Models;

use CodeIgniter\Model;

class ScrapsModel extends Model {
    protected $table = "scraps";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Scraps";
    protected $useSoftDeletes = false;

    protected $allowedFields = ["task_id", "object_id", "object_value", "object_extra", "object_processed", "object_processing",
                                "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}