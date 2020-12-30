<?php

namespace App\Controllers\User;

use App\Models\UsersModel;

class Billinghistory extends PrivateController
{
    public function index()
    {
		$this->data['active'] = "billing";
        $this->data["content"] = "user/billinghistory/index";
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
		
		$db      = \Config\Database::connect();
		$builder = $db->table('orders');
		
		$builder->select('orders.id,
						plans.plan_title, 
						orders.transaction_id, 
						orders.payment_method, 
						orders.order_amount, 
						orders.created_at');
		$builder->join('plans', 'plans.id = orders.plan_id');
		$builder->where('user_id', $this->session->user_id);
		$query = $builder->get();
		$result = $query->getResultObject();
		$this->data['orderData'] = $result;
    }
}