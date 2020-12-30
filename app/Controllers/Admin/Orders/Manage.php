<?php
namespace App\Controllers\Admin\Orders;

use App\Controllers\Admin\PrivateController;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/orders/index";
        $this->data["active"] = "orders";
    }
}