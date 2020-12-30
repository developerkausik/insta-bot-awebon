<?php namespace App\Models;

use CodeIgniter\Model;

class TaskTypesModel extends Model {
    protected $table = "task_types";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\TaskTypes";
    protected $useSoftDeletes = false;

    protected $allowedFields = ["task_name", "task_url", "task_category", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = ["task_name" => "required", "task_url" => "required"];
    protected $validationMessages = [];
    protected $skipValidation = false;
}