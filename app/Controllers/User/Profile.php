<?php

namespace App\Controllers\User;

use App\Models\UsersModel;

class Profile extends PrivateController
{
    public function index()
    {
		$this->data['active'] = "profile";
        $this->data["content"] = "user/profile/index";
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
		$this->data["profileData"] = [
            "first_name" =>  $UserData->first_name,
            "last_name" =>  $UserData->last_name,
            "email" =>  $UserData->email,
            "profile_picture" =>  $UserData->profile_picture,
            "website" =>  $UserData->website,
        ];
    }
}