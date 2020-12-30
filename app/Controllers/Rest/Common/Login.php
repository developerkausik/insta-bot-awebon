<?php namespace App\Controllers\Rest\Common;

use App\Models\LogsModel;
use App\Models\UsersModel;
use App\Entities\Users;
use App\Controllers\Rest\PublicController;

class Login extends PublicController
{
    public function login()
    {
        if ($this->request->getMethod() == "post") {
            try {
                $UserModel = new UsersModel();

                $email = $this->request->getVar("email");
                $password = $this->request->getVar("password");

                $validation =  \Config\Services::validation();

                if (!$validation->check($email, 'required|valid_email')) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Valid Email Required";
                    return;
                } else if (!$validation->check($password, 'required')) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Password Required";
                    return;
                }

                $user = $UserModel->where('email', $email)->first();
				
                if (!$user) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Invalid Email or Password";
                    return;
                }
                if (!empty($user) && password_verify($password, $user->password)) {
                    if ($user->user_status == 1) {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = "User Banned !";
                        return;
                    }

                    if ($user->account_type == INSTABOT_USER) {
                        $redirect = site_url() . "user/dashboard";
                    } else if ($user->account_type == INSTABOT_ADMIN) {
                        $redirect = site_url() . "admin/reports/manage";
                    }

                    if ($this->request->getUserAgent()->isReferral()) {
                        $redirect = $this->request->getUserAgent()->getReferrer();
                    } elseif ($this->session->has('redirect') && $this->session->get('redirect') != site_url()) {
                        $redirect = $this->session->get('redirect');
                    }
                    $this->data['login'] = true;
                    $this->data['redirect'] = $redirect;
                    $this->session->set('first_name', $user->first_name);
                    $this->session->set('last_name', $user->last_name);
                    $this->session->set('profile_picture', $user->profile_picture);
                    $this->session->set('user_id', $user->id);
                    $this->session->set('account_type', $user->account_type);
                    $this->session->set('LoggedIn', true);

                    helper('user');
                    $LogsModel = new LogsModel();
                    $LogEntity = new \App\Entities\Logs();
                    $LogEntity->user_id = $user->id;
                    $LogEntity->log_type = 'access';
                    $AccessDetails = [
                        'uBrowser'  =>  getBrowser()['userAgent'],
                        'uIp'       =>  $_SERVER['REMOTE_ADDR'],
                        'uCountry'  =>  ip_info($_SERVER['REMOTE_ADDR'], "Country")
                    ];
                    $LogEntity->log_content = serialize($AccessDetails);

                    $LogsModel->save($LogEntity);
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'Invalid Email or Password';
                }
            } catch (\Exception $e) {
                $this->data['Status'] = 0;
                $this->data['Message'] = $e->getMessage();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Invalid Request Method';
        }
    }

    public function signup()
    {
        if ($this->request->getMethod() == "post") {
            try {
                $UserModel = new UsersModel();
                $UserEntity = new Users();

                $UserData = $this->request->getPost();
                $validation =  \Config\Services::validation();

                if (!$validation->check($UserData['email'], 'required|valid_email')) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Valid Email Required";
                    return;
                } else if (!$validation->check($UserData['password'], 'required')) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Password Required";
                    return;
                } else if (!$validation->check($UserData['rpassword'], 'required')) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Password Required";
                    return;
                } else if (!$validation->check($UserData['first_name'], 'required') ||
                    !$validation->check($UserData['last_name'], 'required')
                ) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Full Name Required";
                    return;
                }

                $user = $UserModel->where('email', $UserData['email'])->first();
                if ($user) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "This Email Already Exists !";
                    return;
                }

                $UserEntity->fill($UserData);
                $UserEntity->password = password_hash($UserEntity->password, PASSWORD_DEFAULT);
                $UserEntity->account_type = INSTABOT_USER;

                if ($UserModel->save($UserEntity)) {
                    $this->data['Status'] = 1;
                    $this->data['Message'] = 'Thank you. You can login now.';
                    return;
                }

                $this->data['Status'] = 0;
                $this->data['Message'] = 'Something Went wrong, please try again !';
                return;
            } catch (\Exception $e) {
                $this->data['Status'] = 0;
                $this->data['Message'] = $e->getMessage();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Invalid Request Method';
        }
    }
}
