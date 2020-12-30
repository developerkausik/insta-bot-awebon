<?php
namespace App\Controllers\Admin\Discounts;

use App\Controllers\Admin\PrivateController;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/discounts/index";
        $this->data["active"] = "discounts";
    }
}