<?php

namespace App\Controllers\Admin;

use App\Controllers\User\UserController;

class PrivateController extends UserController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if ($this->session->LoggedIn != true) {
            header('Location: ' . base_url('logout'));
            die();
        }
        // If the account type is of user, check account and profile status
        if ($this->session->account_type != INSTABOT_ADMIN) {
            header('Location: ' . base_url('user/dashboard'));
            die();
        }

        set_cookie('last_page', current_url(), '0');
        helper('inflector');
        $this->data['first_name'] = humanize($this->session->first_name);
        $this->data['last_name'] = humanize($this->session->last_name);
        $this->data['account_type'] = $this->session->account_type;
    }
}
