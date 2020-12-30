<?php
namespace App\Controllers\Admin\Users;

use App\Controllers\Admin\PrivateController;
use App\Models\PlansModel;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/users/index";
        $this->data["active"] = "users";

        $PlansModel = new PlansModel();
        $this->data["UserPlans"] = $PlansModel->asArray()->findAll();
    }
}