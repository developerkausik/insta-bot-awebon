<?php 
namespace App\Controllers\Rest\Admin\Logs;

use App\Controllers\Rest\PrivateController;
use App\Models\LogsModel;
use App\Models\UsersModel;

class Log extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $LogsModel = new LogsModel();
            $UsersModel = new UsersModel();
            $ReturnLogs = [];

            $Logs = $LogsModel->get()->getResultArray();
            foreach ($Logs as $Log) {
                $UserData = $UsersModel->where('id', $Log['user_id'])->first();
                $LogDetails = unserialize($Log['log_content']);

                $ReturnLogs[] = [
                    'id'          =>  $Log['id'],
                    'created_at'  =>  $Log['created_at'],
                    'user_name'   =>  !empty($UserData) ? $UserData->first_name . ' ' . $UserData->last_name : '-',
                    'user_email'  =>  !empty($UserData) ? $UserData->email : '-',
                    'log_type' => $Log['log_type'],
                    'log_details'   =>  $LogDetails
                ];
            }
            
            $this->data['data'] = $ReturnLogs;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
}