<?php 
namespace App\Controllers\Rest\Admin\Orders;

use App\Controllers\Rest\PrivateController;
use App\Models\OrdersModel;
use App\Models\PlansModel;
use App\Models\UsersModel;

class Order extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $OrdersModel = new OrdersModel();
            $PlansModel = new PlansModel();
            $UsersModel = new UsersModel();
            $ReturnOrders = [];

            $AllPlans = $PlansModel->get()->getResultArray();

            $Orders = $OrdersModel->get()->getResultArray();
            foreach ($Orders as $Order) {
                if ($Order['plan_id'] > 0) {
                    $PlanDataId = array_search($Order['plan_id'], array_column($AllPlans, 'id'));
                    $PlanData = $AllPlans[$PlanDataId];

                    $PackageTitle = $PlanData['plan_title'];
                    $PackagePrice = '$' . $PlanData['plan_price'];
                } else {
                    $PackageTitle = 'Free';
                    $PackagePrice = '$0';
                }

                $UserData = $UsersModel->where('id', $Order['user_id'])->first();

                $ReturnOrders[] = [
                    'id'          =>  $Order['id'],
                    'created_at'  =>  $Order['created_at'],
                    'plan_title'  =>  $PackageTitle,
                    'plan_price'  =>  $PackagePrice,
                    'user_name'   =>  $UserData->first_name . ' ' . $UserData->last_name,
                    'user_email'  =>  $UserData->email,
                    'transaction_id' => $Order['transaction_id'],
                ];
            }
            
            $this->data['data'] = $ReturnOrders;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }

    public function statistics()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();

            if (!empty($postData['freq'])) {
                $StatisticsFrequency = $postData['freq'];

                // Init
                $CurrentDate = new \DateTime();
                $Statistics[] = [
                    'amount' => 0.00,
                    'date'  => $CurrentDate->format('M y')
                ];

                $OrdersModel = new OrdersModel();
                if ($StatisticsFrequency == 'all') {
                    $ReturnStatistics = [];

                    $Orders = $OrdersModel->asArray()->findAll();
                    foreach ($Orders as $Order) {
                        $OrderDate = (new\DateTime($Order['created_at']))->format('M y');
                        if (empty($ReturnStatistics[md5($OrderDate)])) {
                            $ReturnStatistics[md5($OrderDate)] = [
                                'amount' =>   $Order['order_amount'],
                                'date'  =>  $OrderDate
                            ];
                        } else {
                            $ReturnStatistics[md5($OrderDate)]['amount'] += $Order['order_amount'];
                        }
                    }
                }

                if (empty($ReturnStatistics)) {
                    $ReturnStatistics = $Statistics;
                } else {
                    if (count($ReturnStatistics) == 1) {
                        foreach ($ReturnStatistics as $ReturnStatistic) {
                            $StatisticData = \DateTime::createFromFormat('M y', $ReturnStatistic['date']);
                            $PreviousRecord = $StatisticData->modify('-1 months');
                            break;
                        }

                        $ReturnStatistics[0] = [
                            'date'  =>  $PreviousRecord->format('M y'),
                            'amount'    =>  0
                        ];
                    }

                    helper('misc');
                    usort($ReturnStatistics, 'sort_by_date');
                }

                $this->data['Status'] = 1;
                $this->data['Statistics'] = [
                    'months'    =>  array_column($ReturnStatistics, 'date'),
                    'data'      =>  array_column($ReturnStatistics, 'amount')
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

    public function extra()
    {
        if ($this->request->getMethod() == "get") {
            $OrdersModel = new OrdersModel();
            $AllOrders = $OrdersModel->countAllResults();
            $PaidOrders = $OrdersModel->where('order_amount >', '0')->countAllResults();
            $PaypalOrders = $OrdersModel->where('payment_method', '0')->countAllResults();

            $UsersModel = new UsersModel();
            $AllUsers = $UsersModel->where('account_type', 1)->countAllResults();
            $ActiveUsers = count($OrdersModel->asArray()->where('order_amount >', '0')->groupBy('user_id')->findAll());

            $chartDataIds = [
                [
                    'id'    => 'kt_chart_paypal-bitcoin',
                    'data'  => [
                        floatval($PaypalOrders/$AllOrders) * 100,
                        floatval(1-floatval($PaypalOrders/$AllOrders)) * 100
                    ],
                    'labels' => [
                        'Paypal',
                        'Bitcoin'
                    ]
                ],
                [
                    'id'    => 'kt_chart_free-paid',
                    'data'  => [
                        floatval(1-floatval($PaidOrders/$AllOrders)) * 100,
                        floatval(floatval($PaidOrders/$AllOrders)) * 100
                    ],
                    'labels' => [
                        'Free Orders',
                        'Paid Orders'
                    ]
                ],
                [
                    'id'    => 'kt_chart_active-passive',
                    'data'  => [
                        floatval(floatval($ActiveUsers/$AllUsers)) * 100,
                        floatval(1-floatval($ActiveUsers/$AllUsers)) * 100
                    ],
                    'labels' => [
                        'Active Users',
                        'Free Users'
                    ]
                ]
            ];

            $this->data['Status'] = 1;
            $this->data['cData'] = $chartDataIds;
            $this->data['Stats'] = [
                'freeOrdersStats'   =>  $AllOrders - $PaidOrders,
                'paidOrdersStats'   =>  $PaidOrders,
                'paypalOrdersStats' =>  $PaypalOrders,
                'bitcoinOrdersStats'=>  $AllOrders - $PaypalOrders,
                'activeUsers'       =>  $ActiveUsers,
                'freeUsers'         =>  $AllUsers - $ActiveUsers
            ];
            exit();
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }
}