<?php namespace App\Controllers\Rest;

use \App\Controllers\BaseController;

class RestController extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        // if (!$request->isAJAX()) {
        //     $this->data['Status'] = 0;
        //     $this->data['Message'] = "Invalid Request";
        //     die();
        // }
    }
    
    public function __destruct() {
        header('Content-Type: application/json');
        die(json_encode($this->data));
    }

}