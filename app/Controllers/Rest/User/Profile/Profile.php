<?php
namespace App\Controllers\Rest\User\Profile;

use GuzzleHttp\Client;


use App\Controllers\Rest\PrivateController;
use App\Models\UsersModel;
use App\Models\PaypalAccountsModel;


class Profile extends PrivateController
{
	//change password
    public function changepassword(){
		if ($this->request->getMethod() == "post") {
			
			$UsersModel = new UsersModel();
        	$UserDataFetch = $UsersModel->where('id', $this->session->user_id)->first();
			$currentPassword = $UserDataFetch->password;
            
            $UserData = $this->request->getPost();
			$editUserData = [];
            $validation =  \Config\Services::validation();
			
			/*if($validation->check($UserData['current_password'], 'required')){
				$prevPassHash = password_hash($UserData['current_password'], PASSWORD_DEFAULT);
			}*/
			
			if (!$validation->check($UserData['current_password'], 'required')) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Current Password Required";
                return;
            } else if (!$validation->check($UserData['password'], 'required')) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Password Required";
                return;
            } else if (!$validation->check($UserData['confirm_password'], 'required') ||
                $UserData['confirm_password'] != $UserData['password']
            ) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Password Confirmation doesn't match";
                return;
            } else if(password_verify($UserData['current_password'], $currentPassword)){
				
				$editUserData = [
					'password' =>  password_hash($UserData['password'], PASSWORD_DEFAULT)
				];

				if ($UsersModel->update($this->session->user_id, $editUserData)) {
					$this->data['Status'] = 1;
					$this->data['Message'] = "New Password has been updated !";
					return;
				} else {
					$this->data['Status'] = 0;
					$this->data['Message'] = implode("\r\n", $UsersModel->errors());
					return;
				}
			}else{
				$this->data['Status'] = 0;
                $this->data['Message'] = "Current Password doesn't match";
                return;
			}
			
			

            $this->data['Status'] = 0;
            $this->data['Message'] = 'Something Went wrong, please try again !';
            return;

        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
	}
	
	//update profile
    public function updateprofile(){
		if ($this->request->getMethod() == "post") {
			
			$UsersModel = new UsersModel();
        	$UserDataFetch = $UsersModel->find($this->session->user_id);
            
			if($UserDataFetch){
				$UserData = $this->request->getPost();
				$editUserData = [];
				$validation =  \Config\Services::validation();

				if (!$validation->check($UserData['first_name'], 'required') ||
                        !$validation->check($UserData['last_name'], 'required')
                    ) {
					$this->data['Status'] = 0;
					$this->data['Message'] = "Full Name Required";
					return;
				} 
				
				$editUserData = [
					'first_name' =>  $UserData['first_name'],
					'last_name' =>  $UserData['last_name'],
					'website' =>  $UserData['website'],
				];

				if ($UsersModel->update($this->session->user_id, $editUserData)) {
					
					$this->session->set('first_name', $UserData['first_name']);
                    $this->session->set('last_name', $UserData['last_name']);
					
					$this->data['Status'] = 1;
					$this->data['Message'] = "Profile has been updated !";
					return;
				} else {
					$this->data['Status'] = 0;
					$this->data['Message'] = implode("\r\n", $UsersModel->errors());
					return;
				}



				$this->data['Status'] = 0;
				$this->data['Message'] = 'Something Went wrong, please try again !';
				return;
			} else {
				$this->data['Status'] = 0;
				$this->data['Message'] = "No User found !";
				return;
			}

        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
	}
	
	//update profile picture
	public function updateprofilepicture(){
		if ($this->request->getMethod() == "post") {
			if(!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['name'] == ""){
				$this->data['Status'] = 0;
				$this->data['Message'] = "Please select file !";
				return;
			}else{
				$input = $this->validate([
					'file' => [
						'uploaded[profile_picture]',
						'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
					]
				]);

				if (!$input) {
					$this->data['Status'] = 0;
					$this->data['Message'] = "Chose a valid file !";
					return;
				}else{
					$UsersModel = new UsersModel();
					$UserDataFetch = $UsersModel->find($this->session->user_id);

					if($UserDataFetch){
						$UserData = $this->request->getPost();
						$editUserData = [];
						
						$img = $this->request->getFile('profile_picture');

						$newName = $img->getRandomName();
						$img->move(ROOTPATH.'public/assets/uploads/', $newName);
						$imgName = $img->getName();
						
						$profile_picture = 'assets/uploads/'.$imgName;
						
						$editUserData = [
							'profile_picture' =>  $profile_picture,
						];

						if ($UsersModel->update($this->session->user_id, $editUserData)) {

							$this->session->set('profile_picture', $profile_picture);

							$this->data['Status'] = 1;
							$this->data['Message'] = "Profile picture has been updated !";
							return;
						} else {
							$this->data['Status'] = 0;
							$this->data['Message'] = implode("\r\n", $UsersModel->errors());
							return;
						}



						$this->data['Status'] = 0;
						$this->data['Message'] = 'Something Went wrong, please try again !';
						return;
					} else {
						$this->data['Status'] = 0;
						$this->data['Message'] = "No User found !";
						return;
					}
					
					
				}
			}
			
		} else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
	}
	
	function random_strings($length_of_string) 
	{ 

		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 

		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),  
						   0, $length_of_string); 
	} 
	
	//Change Email
    public function updateemail(){
		if ($this->request->getMethod() == "post") {
			
			$UsersModel = new UsersModel();
        	$UserDataFetch = $UsersModel->find($this->session->user_id);
            
			if($UserDataFetch){
				$UserData = $this->request->getPost();
				$editUserData = [];
				$validation =  \Config\Services::validation();

				if (!$validation->check($UserData['current_email'], 'required|valid_email')) {
					$this->data['Status'] = 0;
					$this->data['Message'] = "Valid current email Required";
					return;
				}else if (!$validation->check($UserData['new_email'], 'required|valid_email')) {
					$this->data['Status'] = 0;
					$this->data['Message'] = "Valid new email Required";
					return;
				} else if($UserDataFetch->email !== $UserData['current_email']){
					$this->data['Status'] = 0;
					$this->data['Message'] = "Current email doesn't match";
					return;
				}else{
					$newData['changeEMail']['verifystring'] = $this->random_strings(20);
					$newData['changeEMail']['new_email'] = $UserData['new_email'];
					$newData['changeEMail']['user_id'] = $UserDataFetch->id;
					
					$this->session->set($newData);
					
					$email = \Config\Services::email();

					$email->setFrom('your@example.com', 'Your Name');
					$email->setTo($UserData['new_email']);

					$email->setSubject('Verify your email');
					$email->setMessage('<p>Hi, '.$UserDataFetch->first_name.' '.$UserDataFetch->last_name.'</p>
					<p>Please verify your email</p>
					<p><button type="button" id="changeEmail" class="btn btn-brand" onclick="location.href=\"'.base_url().'/user/changeemailconfirm/'.$newData['changeEMail']['verifystring'].'\"">Confirm Email Change</button></p>');

					$email->send();
					
					$this->data['Status'] = 1;
					$this->data['Message'] = "An email hase been sent to your new email id !";
					return;
				}
				
				/*$editUserData = [
					'first_name' =>  $UserData['first_name'],
					'last_name' =>  $UserData['last_name'],
					'website' =>  $UserData['website'],
				];

				if ($UsersModel->update($this->session->user_id, $editUserData)) {
					
					$this->session->set('first_name', $UserData['first_name']);
                    $this->session->set('last_name', $UserData['last_name']);
					
					$this->data['Status'] = 1;
					$this->data['Message'] = "Profile has been updated !";
					return;
				} else {
					$this->data['Status'] = 0;
					$this->data['Message'] = implode("\r\n", $UsersModel->errors());
					return;
				}*/



				$this->data['Status'] = 0;
				$this->data['Message'] = 'Something Went wrong, please try again !';
				return;
			} else {
				$this->data['Status'] = 0;
				$this->data['Message'] = "No User found !";
				return;
			}

        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
	}
}
