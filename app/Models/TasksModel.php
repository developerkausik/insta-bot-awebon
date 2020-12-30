<?php namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model {
    protected $table = "tasks";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Tasks";
    protected $useSoftDeletes = false;

    protected $allowedFields = ["task_parent", "task_name", "task_action", "task_fuids_queue", "task_fuids_done", "task_userid", "task_typeid", "task_typecat", 
                                "task_type", "task_pagination", "task_message", "task_done", "task_finished", "task_stop", "task_failed", "task_failed_reason", "task_threads",
                                "task_max", "task_processing", "task_scrap_elements", "task_destination", "to_delete", "processing", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = ["task_name" => "required", "task_action" => "required"];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function unlockUserTasks($UserId)
    {
        $this->where('task_userid', $UserId)
              ->where('task_failed', 1)
              ->where('task_failed_reason', 'banned')
              ->set([
                  'task_failed' => 0,
                  'task_failed_reason' => ''
              ])->update();
    }

    public function lockUserTasks($UserId)
    {
        $this->where('task_userid', $UserId)
            ->where('task_failed', 0)
            ->set([
                'task_failed' => 1,
                'task_failed_reason' => 'banned'
            ])->update();
    }
}