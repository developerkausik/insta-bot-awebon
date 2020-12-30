<?php
namespace App\Controllers\Webhook;

use App\Controllers\Webhook\WebhookController;

class PrivateController extends WebhookController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
}
