<?php
namespace App\Controllers\Rest\User\Tasks;

use App\Controllers\Rest\PrivateController;
use App\Models\AccountsModel;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class Helpers extends PrivateController
{
    public function autocomplete()
    {
        if ($this->request->getMethod() == "get") {
            $Suggestions = [];
            $Entity = $this->request->getVar('entity');
            $Query = $this->request->getVar('query');

            if (!empty($Entity) && !empty($Query)) {
                $AccountsModel = new AccountsModel();
                $ActiveAccount = $AccountsModel->where('account_status', 2)
                    ->where('account_autocomplete', 1)
                    ->first();
                if (!empty($ActiveAccount)) {
                    $Client = new Client([
                        'base_uri'  => 'https://www.instagram.com',
                        'cookies'   =>  $cookie_jar = new FileCookieJar(
                            APPPATH . 'Vendors/mgp25/instagram-php/sessions/' . $ActiveAccount->account_username .
                            '/' . $ActiveAccount->account_username . '-cookies.dat',
                            false
                        )
                    ]);
                    $SuggestionsRequest = $Client->request('GET', '/web/search/topsearch/?'.http_build_query([
                            'context'       =>  'blended',
                            'query'         =>  $Query,
                            'include_reel'  =>  'true'
                        ]), [
                        'allow_redirects'   => true,
                        'verify'            => false,
                        'headers'           => [
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36'
                        ]
                    ]);

                    if ($SuggestionsRequest->getStatusCode() == 200) {
                        $SuggestionsObject = json_decode($SuggestionsRequest->getBody(), 'true');
                        if (!empty($SuggestionsObject[$Entity])) {
                            $Suggestions = array_column($SuggestionsObject[$Entity], substr($Entity, 0, -1));
                        }
                    }
                }
            }

            $this->data['data'] = $Suggestions;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
}
