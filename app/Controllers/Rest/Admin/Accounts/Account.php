<?php 
namespace App\Controllers\Rest\Admin\Accounts;

use App\Controllers\Rest\PrivateController;
use App\Models\AccountsModel;
use App\Models\AccountsRecordsModel;

class Account extends PrivateController
{
    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $AccountsModel = new AccountsModel();

            $Accounts = $AccountsModel->get()->getResultArray();
            foreach ($Accounts as $AccountData) {
                $ReturnAccounts[] = [
                    'RecordID'          =>  $AccountData['id'],
                    'account_username'  =>  $AccountData['account_username'],
                    'created_at'        =>  $AccountData['created_at'],
                    'account_status'    =>  $AccountData['account_status'],
                    'account_fail_reason'    =>  $AccountData['account_fail_reason']
                ];
            }
            
            $this->data['data'] = $ReturnAccounts;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
    
    public function upload()
    {
        if ($this->request->getMethod() == "post") {
            $file = $this->request->getFile('file');
            $AccountUsernameField =  'account_username';
            $AccountPasswordField =  'account_password';
            $AccountProxyField =  'account_proxy';
            $AccountAutocompleteField =  'account_autocomplete';

            if (!$file->isValid()) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Invalid File !";
                return;
            }
            
            if ($file->getExtension() !== "csv") {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Only CSV Extension allowed !";
                return;
            }
            
            if (($handle = fopen($file->getTempName(), "rb")) !== false) {
                $row = 0;
                $AccountsModel = new AccountsModel();
                $Accounts = [];
                $Headers = [];

                while (($data = fgetcsv($handle, 0, ";")) !== false) {
                    $num = count($data);
                    if ($row == 0) {
                        for ($i = 0; $i < $num; $i++) {
                            $Headers[$i] = trim($data[$i]);
                        }
                        $row++;
                    } else {
                        $Account['account_username'] = '';
                        $Account['account_password'] = '';
                        $Account['account_proxy'] = '';
                        $Account['account_autocomplete'] = 0;

                        for ($j = 0; $j < $num; $j++) {
                            if (trim($Headers[$j]) == trim($AccountUsernameField)) {
                                $Account['account_username'] = trim($data[$j]);
                            } else if (trim($Headers[$j]) == trim($AccountPasswordField)) {
                                $Account['account_password'] = trim($data[$j]);
                            } else if (trim($Headers[$j]) == trim($AccountProxyField)) {
                                $Account['account_proxy'] = trim($data[$j]);
                            } else if (trim($Headers[$j]) == trim($AccountAutocompleteField)) {
                                if (!empty($data[$j])) {
                                    $Account['account_autocomplete'] = 1;
                                }
                            }
                        }
                        $Accounts[] = $Account;
                        $row++;
                    }
                }
            }
            fclose($handle);
            
            if (count($Accounts) > 0) {
                $FailedAccounts = [];
                foreach ($Accounts as $IgAccount) {
                    $IgAccount = array_merge($IgAccount, [
                        'account_choice'    =>  1,
                        'created_at'        =>  (new \DateTime())->format('Y-m-d H:i:s')
                    ]);

                    if (!$AccountsModel->insert($IgAccount)) {
                        $FailedAccounts[] = "[".$IgAccount['account_username']."] : ".implode(" ", $AccountsModel->errors());
                    }
                }
            }

            if (empty($FailedAccounts)) {
                $this->data['Status'] = 1;
                $this->data['Message'] = "Mass import Success";
                return;
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = '<div class="alert alert-solid-success alert-bold" role="alert">
                    <div class="alert-text">Successfully imported  : ' . count($Accounts) . '</div>
				</div>
				<div class="alert alert-solid-danger alert-bold" role="alert">
				'.implode("<hr>", $FailedAccounts).'
                </div>';
                return;
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }

    public function uploadBis()
    {
        if ($this->request->getMethod() == "post") {
            $file = $this->request->getFile('file');
            $AccountUsernameField =  'account_username';
            $AccountPasswordField =  'account_password';
            $AccountProxyField =  'account_proxy';

            if (!$file->isValid()) {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Invalid File !";
                return;
            }

            if ($file->getExtension() !== "csv") {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Only CSV Extension allowed !";
                return;
            }

            if (($handle = fopen($file->getTempName(), "rb")) !== false) {
                $row = 0;
                $AccountsModel = new AccountsModel();
                $Accounts = [];
                $Headers = [];

                while (($data = fgetcsv($handle, 0, ";")) !== false) {
                    $num = count($data);
                    if ($row == 0) {
                        for ($i = 0; $i < $num; $i++) {
                            $Headers[$i] = trim($data[$i]);
                        }
                        $row++;
                    } else {
                        $Account['account_username'] = '';
                        $Account['account_password'] = '';
                        $Account['account_proxy'] = '';

                        for ($j = 0; $j < $num; $j++) {
                            if (trim($Headers[$j]) == trim($AccountUsernameField)) {
                                $Account['account_username'] = trim($data[$j]);
                            } else if (trim($Headers[$j]) == trim($AccountPasswordField)) {
                                $Account['account_password'] = trim($data[$j]);
                            } else if (trim($Headers[$j]) == trim($AccountProxyField)) {
                                $Account['account_proxy'] = trim($data[$j]);
                            }
                        }
                        $Accounts[] = $Account;
                        $row++;
                    }
                }
            }
            fclose($handle);

            if (count($Accounts) > 0) {
                $FailedAccounts = [];
                foreach ($Accounts as $IgKey => $IgAccount) {
                    $Response = $this->activateIgAccount([
                        'username'  =>  $IgAccount['account_username'],
                        'password'  =>  $IgAccount['account_password'],
                        'proxy'     =>  $IgAccount['account_proxy']
                    ]);

                    if ($Response['error'] !== false) {
                        $FailedAccounts[] = "[".$IgAccount['account_username']."] : ".$Response['error'];
                        unset($Accounts[$IgKey]);
                    } else {
                        $Accounts[$IgKey] = array_merge($Accounts[$IgKey], $Response['response']);
                    }
                }

                foreach ($Accounts as $IgAccount) {
                    if (!$AccountsModel->insert($IgAccount)) {
                        $FailedAccounts[] = "[".$IgAccount['account_username']."] : ".implode(" ", $AccountsModel->errors());
                    }
                }
            }

            if (empty($FailedAccounts)) {
                $this->data['Status'] = 1;
                $this->data['Message'] = "Mass import Success";
                return;
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = '<div class="alert alert-solid-success alert-bold" role="alert">
                    <div class="alert-text">Successfully imported  : ' . count($Accounts) . '</div>
				</div>
				<div class="alert alert-solid-danger alert-bold" role="alert">
				'.implode("<hr>", $FailedAccounts).'
                </div>';
                return;
            }
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
            if (isset($postData['account_id'])) {
                $AccountsModel = new AccountsModel();
                $AccountExists = $AccountsModel->find($postData['account_id']);
                if ($AccountExists) {
                    helper('accounts');
                    if (\delete_session($AccountExists->account_username)) {
                        $AccountsRecordsModel = new AccountsRecordsModel();
                        $AccountsRecordsExists = $AccountsRecordsModel->where('account_id', $AccountExists->id)->first();
                        if (!empty($AccountsRecordsExists)) $AccountsRecordsModel->delete($AccountsRecordsExists->id);
                        if ($AccountsModel->delete($AccountExists->id)) {
                            $this->data['Status'] = 1;
                            $this->data['Message'] = "Account has been deleted !";
                            return;
                        } else {
                            $this->data['Status'] = 0;
                            $this->data['Message'] = implode("\r\n", $AccountsModel->errors());
                            return;
                        }
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Account not found";
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

    public function verify()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            if (isset($postData['captcha_verification']) && isset($postData['account_id'])) {
                \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

                $AccountsModel = new AccountsModel();
                $IgAccount = $AccountsModel->find($postData['account_id']);

                if (!empty($IgAccount)) {
                    $instaID = $IgAccount->account_id;
                    $challenge = $IgAccount->account_challenge;
                    $captcha = $postData['captcha_verification'];

                    try {
                        $ig = new \InstagramAPI\Instagram();
                        if(!empty($IgAccount->account_proxy)) {
                            $ig->setProxy($IgAccount->account_proxy);
                        }
                        $ig->setUser($IgAccount->account_username, $IgAccount->account_password);
                        try {
                            $resp = $ig->approveChallengeVerificationCode(
                                $instaID,
                                $challenge,
                                $captcha);

                            try {
                                $nIig = new \InstagramAPI\Instagram();
                                $nIig->login($IgAccount->account_username, $IgAccount->account_password);
                                $response = $nIig->people->getInfoById($instaID);

                                $IgAccount->account_name = utf8_encode($response->getUser()->getFullName());
                                $IgAccount->account_profile = $response->getUser()->getHdProfilePicUrlInfo()->getUrl();
                                $IgAccount->account_status = 2;

                                if ($AccountsModel->save($IgAccount)) {
                                    $this->data['Status'] = 1;
                                    $this->data['Message'] = "Account Verified Successfully !";
                                    return;
                                }
                            } catch(\Exception $e) {
                                $this->data['Status'] = 0;
                                $this->data['Message'] = $e->getMessage();
                                return;
                            }
                        } catch (\Exception $e) {
                            $this->data['Status'] = 0;
                            $this->data['Message'] = $e->getMessage();
                            return;
                        }
                    } catch (\Exception $e) {
                        $this->data['Status'] = 0;
                        $this->data['Message'] = $e->getMessage();
                        return;
                    }
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = "Account not found !";
                    return;
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = "Missing Captcha Verification !";
                return;
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
}