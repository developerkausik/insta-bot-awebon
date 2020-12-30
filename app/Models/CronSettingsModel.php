<?php namespace App\Models;

use CodeIgniter\Model;

class CronSettingsModel extends Model {
    protected $table = "cron_settings";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\CronSettings";
    protected $useSoftDeletes = false;

    protected $allowedFields = ["cron_name", "cron_value", "cron_type", "created_at", "updated_at"];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}