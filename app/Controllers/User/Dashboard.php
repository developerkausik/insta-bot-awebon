<?php

namespace App\Controllers\User;

use App\Models\UsersModel;

class Dashboard extends PrivateController
{
    public function index()
    {
        $this->data["content"] = "user/dashboard/index";
        $this->data["css"] = [
            "/assets/css/pages/wizard/wizard-2.css",
            "/assets/css/pages/wizard/wizard-3.css"
        ];

        $UserModel = new UsersModel();
        $UserData = $UserModel->where('id', $this->session->user_id)->first();
        $this->data["statistics"] = [
            "total_credits" =>  $UserData->user_credits
        ];
		$this->data["profile_picture"] = $UserData->profile_picture;
    }
}