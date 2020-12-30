<?php
namespace App\Controllers\Rest\User\Orders;

use GuzzleHttp\Client;


use App\Controllers\Rest\PrivateController;
use App\Models\DiscountsModel;
use App\Models\OrdersModel;
use App\Models\PlansModel;
use App\Models\UsersModel;
use App\Models\PaypalAccountsModel;


class Order extends PrivateController
{
    public function create()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            $UserId = $this->session->user_id;

            if (!empty($postData['selected_plan']) && !empty($postData['payment_method'])) {
                $OrderEntity = new \App\Entities\Orders();
                $OrdersModel = new OrdersModel();

                $SelectedPlan = explode('|', $postData['selected_plan']);
                $PaymentMethod = PAYMENT_METHODS[$postData['payment_method']]['key'];

                if ($SelectedPlan[0] > 0) {
                    $PlansModel = new PlansModel();
                    $CurrentPlan = $PlansModel->where('id', $SelectedPlan[0])->first();

                    $CurrentAmount = $CurrentPlan->plan_price;

                    $NewAmount = $CurrentAmount;
                    $DiscountsModel = new DiscountsModel();
                    $AvailableDiscounts = $DiscountsModel->where('discount_status', 1)
                                                         ->where('discount_code', $postData['discount_code'])
                                                         ->first();

                    if (!empty($AvailableDiscounts)) {
                        $DiscountAmount = floatval($AvailableDiscounts->discount_amount);
                        switch ($AvailableDiscounts->discount_type) {
                            case 0:
                                $NewAmount = $NewAmount - (($DiscountAmount/100) * $CurrentAmount);
                                break;
                            case 1:
                                $NewAmount = $CurrentAmount - $DiscountAmount;
                                break;
                        }
                    }

                    $CurrentAmount = $NewAmount;
                } else {
                    $CurrentAmount = 0;
                }

                $OrderEntity->user_id = $UserId;
                $OrderEntity->plan_id = $SelectedPlan[0];
                $OrderEntity->transaction_id = $postData['transaction_id'];
                $OrderEntity->payment_method = $PaymentMethod;
                $OrderEntity->order_amount = floatval($CurrentAmount);
                $OrderEntity->order_status = $SelectedPlan[0] > 0 ? 0 : 1;

                if ($OrdersModel->save($OrderEntity)) {
                    if ($OrderEntity->plan_id == 0) {
                        $UsersModel = new UsersModel();
                        $CurrentUser = $UsersModel->where('id', $UserId)->first();
                        $CurrentBalance = $CurrentUser->user_credits;
                        $NewBalance = 100;

                        if ($UsersModel->update($UserId, [
                            'user_credits'  =>  intval($CurrentBalance) + intval($NewBalance)
                        ])) {
                            $this->data['Status'] = 1;
                            $this->data['Message'] = 'Order Created Successfully !';
                            exit();
                        }
                    } else {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = 'We Are Processing Your Order !';
                        exit();
                    }
                    /*$UsersModel = new UsersModel();
                    $CurrentUser = $UsersModel->where('id', $UserId)->first();
                    $CurrentBalance = $CurrentUser->user_credits;

                    if ($OrderEntity->plan_id > 0) {
                        $NewBalance = $CurrentPlan->plan_credits;
                    } else {
                        $NewBalance = 100;
                    }

                    if ($UsersModel->update($UserId, [
                        'user_credits'  =>  intval($CurrentBalance) + intval($NewBalance)
                    ])) {
                        $this->data['Status'] = 1;
                        $this->data['Message'] = 'Order Created Successfully !';
                        exit();
                    }*/
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'Something Went Wrong';
                    exit();
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'All Fields Are Required !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    public function discount()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();

            if (!empty($postData['base_price']) && !empty($postData['discount_code'])) {
                $BasePrice = floatval(str_replace(['$', ','], ['', '.'], $postData['base_price']));
                $NewPrice = $BasePrice;
                $AppliedDiscounts = 0;

                $DiscountsModel = new DiscountsModel();
                $AvailableDiscounts = $DiscountsModel->where('discount_status', 1)
                                                     ->where('discount_code', $postData['discount_code'])
                                                     ->first();

                if (!empty($AvailableDiscounts) && $BasePrice > 0) {
                    $DiscountAmount = floatval($AvailableDiscounts->discount_amount);
                    switch ($AvailableDiscounts->discount_type) {
                        case 0:
                            $NewPrice = $NewPrice - (($DiscountAmount/100) * $BasePrice);
                            $AppliedDiscounts += (($DiscountAmount/100) * $BasePrice);
                            break;
                        case 1:
                            $NewPrice = $BasePrice - $DiscountAmount;
                            $AppliedDiscounts += $DiscountAmount;
                            break;
                    }
                }

                $this->data['Status'] = 1;
                $this->data['Discount'] = [
                    'base_price'    =>  $BasePrice,
                    'new_price'     =>  $NewPrice >= 0 ? $NewPrice : 0,
                    'applied'       =>  $AppliedDiscounts
                ];
                exit();
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Bad Request !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    public function prepare()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();

            if (!empty($postData['payment_method'])) {
                switch ($postData['payment_method']) {
                    case 'btc':
                        $CoinPaymentsLibrary = new \Coinpayments();
                        $CallBackAddress = $CoinPaymentsLibrary->getCallbackAddress('LTCT');
                        if (!empty($CallBackAddress['result']['address'])) {
                            $this->data['Status'] = 1;
                            $this->data['Address'] = $CallBackAddress['result']['address'];
                            exit();
                        } else {
                            $this->data['Status'] = 0;
                            $this->data['Message'] = 'Something Went Wrong !';
                            exit();
                        }
                        break;
                        case 'paypal':
                            $PaypalAccountsModel = new PaypalAccountsModel();
                            $selectedPaypalAccount = $PaypalAccountsModel->where('enabled', 1)->orderBy('funds', 'asc')->first();
                            $orderPrice = floatval(str_replace(['$', ','], ['', '.'], $postData['order_price']));
                            if ($orderPrice + $selectedPaypalAccount->funds <= $selectedPaypalAccount->maxfunds) {
                                $apiuser =$selectedPaypalAccount->apiuser;
                                $apipwd = $selectedPaypalAccount->apipwd;
                                $apisig = $selectedPaypalAccount->apisig;
                                $UserId = $this->session->user_id;
                                $ppurl = "https://api-3t.sandbox.paypal.com/nvp";
                                //$ppurl = "https://api-3t.paypal.com/nvp";

                                $SetExpressCheckoutURL = "USER=".$apiuser."&PWD=".$apipwd."&SIGNATURE=".$apisig."&METHOD=SetExpressCheckout&VERSION=93&PAYMENTREQUEST_0_PAYMENTACTION=SALE&PAYMENTREQUEST_0_AMT=".$orderPrice."&PAYMENTREQUEST_0_ITEMAMT=".$orderPrice."&REQCONFIRMSHIPPING=0&PAYMENTREQUEST_0_CURRENCYCODE=USD&NOSHIPPING=1&CANCELURL=https://www.transip.nl&RETURNURL=http://104.237.9.19/ipn.php?id=".base64_encode($UserId."-".$postData['plan_id']."-".$orderPrice."-".$selectedPaypalAccount->id);
                                //$checkouturl = preg_replace('/\s+/', '', $SetExpressCheckoutURL);
                                parse_str($SetExpressCheckoutURL, $postParams);
                                $paypalClient = new Client();
                                try{
                                    $res = $paypalClient->request('POST',$ppurl,['form_params'=> $postParams]);
                                }catch(\Exception $e){
                                    $this->data['Status'] = 0;
                                    $this->data['Message'] = 'Something Went Wrong !';
                                    exit();
                                }
                                
                                $cats1 = urldecode($res->getBody());
                                if ($res->getStatusCode() == '200') {
                                    parse_str($cats1, $queryParams);
                                    if (preg_match("/Success/", $queryParams['ACK'])) {
                                        if (isset($queryParams['TOKEN'])) {
                                            //$longUrl = "https://dereferer.me/?".urlencode("https://www.sandbox.paypal.com/cgi-bin/webscr?useraction=commit&cmd=_express-checkout&token=".$queryParams['TOKEN']);
                                            //$longUrl = "https://www.paypal.com/cgi-bin/webscr?useraction=commit&cmd=_express-checkout&token=".$queryParams['TOKEN'];
                                            $longUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr?useraction=commit&cmd=_express-checkout&token=".$queryParams['TOKEN'];
					                        $this->data['Status'] = 1;
                                            $this->data['ForwardUrl'] = $longUrl;
                                        } else {
                                            $this->data['Status'] = 0;
                                            $this->data['Message'] = 'Something Went Wrong !';
                                            exit();
                                        }
                                    } else {
                                        $this->data['Status'] = 0;
                                        $this->data['Message'] = 'Something Went Wrong !';
                                        exit();
                                    }
                                } else {
                                    $this->data['Status'] = 0;
                                    $this->data['Message'] = 'Something Went Wrong !';
                                    exit();
                                }
                            } else {
                                $this->data['Status'] = 0;
                                $this->data['Message'] = 'Something Went Wrong !';
                                exit();
                            }
                        break;
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Bad Request !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }
}
