<?php
namespace App\Controllers\Admin\Logs;

use App\Controllers\Admin\PrivateController;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/logs/index";
        $this->data["active"] = "logs";
    }
}