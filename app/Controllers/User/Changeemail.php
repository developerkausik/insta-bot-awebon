<?php

namespace App\Controllers\User;

use App\Models\UsersModel;

class Changeemail extends PrivateController
{
    public function index()
    {
		$this->data['active'] = "changeEmail";
        $this->data["content"] = "user/changeemail/index";
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
		
		$this->data['errorMsg'] = $this->session->getFlashdata('error');
		$this->data['successMsg'] = $this->session->getFlashdata('successMsg');
		
    }
	
	public function confirmemail($verifyString){
		$newData = $this->session->get('changeEMail');
		/*print_r($newData);
		die();*/
		if(isset($verifyString,$newData['verifystring']) && $verifyString == $newData['verifystring']){
			$editUserData = [];
			$UsersModel = new UsersModel();
			$editUserData = [
				'email' =>  $newData['new_email'],
			];
			$UsersModel->update($this->session->user_id, $editUserData);
			$this->session->setFlashdata('successMsg','Successfully updated');
			return redirect()->to(base_url().'/user/changeemail');				
		}else{
			$this->session->setFlashdata('error','Sorry!! verification failed');
			return redirect()->to(base_url().'/user/changeemail');
		}
	}
}