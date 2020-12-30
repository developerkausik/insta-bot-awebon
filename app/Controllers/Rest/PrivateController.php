<?php namespace App\Controllers\Rest;

use App\Controllers\Rest\RestController;
use App\Models\ProfileModel;
use App\Models\UserModel;

class PrivateController extends RestController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if ($this->session->LoggedIn != true) {
            $this->data['Message'] = "Not Logged In!";
            $this->data['Status'] = 0;
            $this->data['Redirect'] = '/dashboard/suspended/account';
            die();
        }
    }
}
