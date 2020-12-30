<?php 
namespace App\Controllers\Rest\Admin\Plans;

use App\Controllers\Rest\PrivateController;
use App\Models\PlansModel;

class Plan extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $PlansModel = new PlansModel();
            $ReturnPlans = [];

            $Plans = $PlansModel->get()->getResultArray();
            foreach ($Plans as $PlanData) {
                $ReturnPlans[] = [
                    'id'          =>  $PlanData['id'],
                    'plan_title'  =>  $PlanData['plan_title'],
                    'plan_description'        =>  $PlanData['plan_description'],
                    'plan_price'    =>  $PlanData['plan_price'],
                    'plan_credits'    =>  $PlanData['plan_credits'],
                    'created_at'    =>  $PlanData['created_at'],
                    'updated_at' => $PlanData['updated_at'],
                ];
            }
            
            $this->data['data'] = $ReturnPlans;
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
            $PlanData = $this->request->getPost();

            $PlansModel = new PlansModel();
            $PlanEntity = new \App\Entities\Plans();
            $PlanEntity->plan_title = $PlanData['plan_title'];
            $PlanEntity->plan_description = $PlanData['plan_description'];
            $PlanEntity->plan_price = floatval(str_replace(',', '.', $PlanData['plan_price']));
            $PlanEntity->plan_credits = intval($PlanData['plan_credits']);

            if ($PlansModel->save($PlanEntity)) {
                $this->data['Status'] = 1;
                $this->data['Message'] = 'New Plan has been Created!';
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
            if (isset($postData['plan_id'])) {
                $PlansModel = new Plansmodel();
                $Plan = $PlansModel->find($postData['plan_id']);
                if ($Plan) {
                    if ($PlansModel->delete($Plan->id)) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = "Plan has been deleted !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $PlansModel->errors());
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

    public function edit()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            if (isset($postData['plan_id'])) {
                $PlansModel = new PlansModel();
                $Plan = $PlansModel->find($postData['plan_id']);
                if ($Plan) {
                    if ($PlansModel->update($Plan->id, [
                        'plan_title' =>  $postData['plan_title'],
                        'plan_description'  =>  $postData['plan_description'],
                        'plan_price'  =>  intval($postData['plan_price']),
                        'plan_credits'  =>  floatval(str_replace(',', '.', $postData['plan_credits'])),
                    ])) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = "Plan has been Edited !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $PlansModel->errors());
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