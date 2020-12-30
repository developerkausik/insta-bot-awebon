<?php 
namespace App\Controllers\Rest\Admin\Discounts;

use App\Controllers\Rest\PrivateController;
use App\Models\DiscountsModel;

class Discount extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $DiscountsModel = new DiscountsModel();
            $ReturnDiscounts = [];

            $Discounts = $DiscountsModel->get()->getResultArray();
            foreach ($Discounts as $Discount) {
                $ReturnDiscounts[] = [
                    'id'          =>  $Discount['id'],
                    'discount_name'  =>  $Discount['discount_name'],
                    'discount_type'        =>  $Discount['discount_type'],
                    'discount_amount'    =>  $Discount['discount_amount'],
                    'discount_code' =>  $Discount['discount_code'],
                    'discount_status'    =>  $Discount['discount_status'],
                    'created_at'    =>  $Discount['created_at'],
                    'updated_at' => $Discount['updated_at'],
                ];
            }
            
            $this->data['data'] = $ReturnDiscounts;
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
            $DiscountData = $this->request->getPost();

            $DiscountsModel = new DiscountsModel();
            $DiscountEntity = new \App\Entities\Discounts();
            $DiscountEntity->discount_name = $DiscountData['discount_name'];
            $DiscountEntity->discount_type = $DiscountData['discount_type'];
            $DiscountEntity->discount_amount = str_replace(',', '.', $DiscountData['discount_amount']);
            $DiscountEntity->discount_code = $DiscountData['discount_code'];
            $DiscountEntity->discount_status = $DiscountData['discount_status'] == 'off' ? 0 : 1;

            if ($DiscountsModel->save($DiscountEntity)) {
                $this->data['Status'] = 1;
                $this->data['Message'] = 'New Discount has been Created!';
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
            if (isset($postData['discount_id'])) {
                $DiscountsModel = new DiscountsModel();
                $Discount = $DiscountsModel->find($postData['discount_id']);
                if ($Discount) {
                    if ($DiscountsModel->delete($Discount->id)) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = "Discount has been deleted !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $DiscountsModel->errors());
                        return;
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Discount not found";
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
            if (isset($postData['discount_id'])) {
                $DiscountsModel = new DiscountsModel();
                $Discount = $DiscountsModel->find($postData['discount_id']);
                if ($Discount) {
                    if ($DiscountsModel->update($Discount->id, [
                        'discount_name' =>  $postData['discount_name'],
                        'discount_type'  =>  $postData['discount_type'],
                        'discount_amount'  =>  str_replace(',', '.', $postData['discount_amount']),
                        'discount_code' =>  $postData['discount_code'],
                        'discount_status'  =>  $postData['discount_status'] == 'off' ? 0 : 1,
                    ])) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = "Discount has been edited !";
                        return;
                    } else {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = implode("\r\n", $DiscountsModel->errors());
                        return;
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Discount not found";
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