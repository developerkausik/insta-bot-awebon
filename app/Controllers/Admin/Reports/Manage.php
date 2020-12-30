<?php
namespace App\Controllers\Admin\Reports;

use App\Controllers\Admin\PrivateController;
use App\Models\OrdersModel;
use App\Models\TasksModel;
use App\Models\UsersModel;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/reports/index";
        $this->data["active"] = "dashboard";

        $OrdersModel = new OrdersModel();
        $AllOrders = $OrdersModel->asArray()->findAll();
        $this->data["TotalEarning"] = array_sum(array_column($AllOrders, 'order_amount'));
        $this->data["TotalOrders"] = count($AllOrders);

        $UsersModel = new UsersModel();
        $this->data["TotalMembers"] = $UsersModel->where('account_type', 1)->countAllResults();

        $TaskModel = new TasksModel();
        $this->data["TotalTasks"] = $TaskModel->where('task_parent >', 0)->countAllResults();
    }
}