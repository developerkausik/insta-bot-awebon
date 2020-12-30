<?php
namespace App\Controllers\Admin\Plans;

use App\Controllers\Admin\PrivateController;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/plans/index";
        $this->data["active"] = "plans";
    }
}