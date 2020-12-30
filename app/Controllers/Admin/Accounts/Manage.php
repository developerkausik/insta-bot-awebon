<?php
namespace App\Controllers\Admin\Accounts;

use App\Controllers\Admin\PrivateController;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class Manage extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "admin/accounts/index";
        $this->data["active"] = "accounts";
    }
}