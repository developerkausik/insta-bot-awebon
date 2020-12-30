<?php 
namespace App\Models;

use CodeIgniter\Model;

class PlansModel extends Model {
    protected $table = "plans";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Plans";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "plan_title",
        "plan_description",
        "plan_price",
        "plan_credits",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    public function getPlanTitle($PlanId)
    {
        $PlanName = 'N/A';
        $PlanData = $this->where('id', $PlanId)->first();
        if (!empty($PlanData)) {
            $PlanName = $PlanData->plan_title;
        }

        return $PlanName;
    }
}