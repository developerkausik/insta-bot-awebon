<?php 
namespace App\Controllers\Rest\Admin\Users;

use App\Controllers\Rest\PrivateController;
use App\Models\PlansModel;
use App\Models\ScrapsModel;
use App\Models\TasksModel;
use App\Models\UsersModel;

class User extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $UsersModel = new UsersModel();
            $ReturnUsers = [];

            $Users = $UsersModel->get()->getResultArray();
            foreach ($Users as $UserData) {
                $ReturnUsers[] = [
                    'id'          =>  $UserData['id'],
                    'full_name'  =>  $UserData['first_name'] . " " . $UserData['last_name'],
                    'first_name'  =>  $UserData['first_name'],
                    'last_name'  =>  $UserData['last_name'],
                    'email'  =>  $UserData['email'],
                    'account_type'        =>  $UserData['account_type'],
                    'user_status'    =>  $UserData['user_status'],
                    'user_ban_reason'    =>  $UserData['user_ban_reason'],
                    'user_credits'    =>  $UserData['user_credits'],
                    'created_at'    =>  $UserData['created_at'],
                    'updated_at' => $UserData['updated_at'],
                ];
            }
            
            $this->data['data'] = $ReturnUsers;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }

    public function create()
    {
        if ($this->request->getMethod() == "post") {
            $PlansModel = new PlansModel();
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
            } else if (!$validation->check($UserData['confirm_password'], 'required') ||
                $UserData['confirm_password'] != $UserData['password']
            ) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Password Confirmation doesn't match";
                return;
            } else if (!$validation->check($UserData['first_name'], 'required') ||
                !$validation->check($UserData['last_name'], 'required')
            ) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Full Name Required";
                return;
            }

            $UsersModel = new UsersModel();
            $UserEntity = new \App\Entities\Users();
            $UserEntity->first_name = $UserData['first_name'];
            $UserEntity->last_name = $UserData['last_name'];
            $UserEntity->email = $UserData['email'];
            $UserEntity->account_type = $UserData['account_type'];
            if (!empty($UserData['user_plan'])) {
                $SelectedPlan = $PlansModel->where('id', $UserData['user_plan'])->first();
                if (!empty($SelectedPlan)) {
                    $UserEntity->user_credits = $SelectedPlan->plan_credits;
                }
            }
            $UserEntity->password = password_hash($UserData['password'], PASSWORD_DEFAULT);

            if ($UsersModel->save($UserEntity)) {
                $this->data['Status'] = 1;
                $this->data['Message'] = 'New User has been Created!';
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

    public function delete()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            if (isset($postData['user_id'])) {
                $UsersModel = new UsersModel();
                $User = $UsersModel->find($postData['user_id']);
                if ($User) {
                    if ($UsersModel->delete($User->id)) {
                        // Delete Tasks
                        $TasksModel = new TasksModel();
                        $UserTasks = $TasksModel->asArray()->where('task_userid', $postData['user_id'])->findAll();

                        // Delete Scraps
                        if (!empty($UserTasks)) {
                            $UserTasksIds = array_column($UserTasks, 'id');
                            $TasksModel->where('task_userid', $postData['user_id'])->delete();

                            $ScrapsModel = new ScrapsModel();
                            $ScrapsModel->whereIn('task_id', $UserTasksIds)->delete();
                        }

                        $this->data['Status'] = 1;
                        $this->data['Message'] = "User has been deleted !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $UsersModel->errors());
                        return;
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "User not found";
                    return;
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Bad Request !";
                return;
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }

    public function edit()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            if (isset($postData['user_id'])) {
                $UsersModel = new UsersModel();
                $User = $UsersModel->find($postData['user_id']);
                if ($User) {
                    $editUserData = [];
                    $validation =  \Config\Services::validation();

                    if (!$validation->check($postData['email'], 'required|valid_email')) {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = "Valid Email Required";
                        return;
                    } else if (!$validation->check($postData['first_name'], 'required') ||
                        !$validation->check($postData['last_name'], 'required')
                    ) {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = "Full Name Required";
                        return;
                    }

                    if ($User->user_status == 1 && $postData['user_status'] == 0) {
                        $TasksModel = new TasksModel();
                        $TasksModel->unlockUserTasks($User->id);

                        $postData['user_ban_reason'] = '';
                    } else if ($User->user_status == 0 && $postData['user_status'] == 1) {
                        $TasksModel = new TasksModel();
                        $TasksModel->lockUserTasks($User->id);
                    }

                    $editUserData = [
                        'first_name' =>  $postData['first_name'],
                        'last_name'  =>  $postData['last_name'],
                        'email'  =>  $postData['email'],
                        'account_type'  =>  $postData['account_type'],
                        'user_status'  =>  $postData['user_status'],
                        'user_ban_reason'  =>  $postData['user_ban_reason'],
                        'user_credits'  =>  $postData['user_credits'],
                    ];


                    if (!empty($postData['password'])) {
                        if (!$validation->check($postData['confirm_password'], 'required') ||
                            $postData['confirm_password'] != $postData['password']
                        ) {
                            $this->data['Status'] = 0;
                            $this->data['Message'] = "Password Confirmation doesn't match";
                            return;
                        }

                        $editUserData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
                    }

                    if ($UsersModel->update($User->id, $editUserData)) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = "User has been edited !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $UsersModel->errors());
                        return;
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Plan not found";
                    return;
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Bad Request !";
                return;
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
}