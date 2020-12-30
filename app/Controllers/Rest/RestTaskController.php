<?php namespace App\Controllers\Rest;

use App\Controllers\Rest\RestController;
use App\Models\AccountsModel;
use App\Models\ScrapsModel;
use App\Models\TasksModel;

class RestTaskController extends RestController
{
    protected $Task;
    protected $Account;
    protected $QueryDb;
    protected $ProgressingProfiles;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (empty($this->request->getVar('taskToken'))) {
            $this->data['Message'] = "Not Logged In!";
            $this->data['Status'] = 0;
            die();
        }

        if ( (!empty($this->request->getVar('TaskId')) && !empty($this->request->getVar('AccountId'))) ||
            (!empty($this->request->getVar('Profiles')) && !empty($this->request->getVar('AccountId')))
        ) {
            $AccountsModel = new AccountsModel();
            $this->Account = $AccountsModel->where('id', $this->request->getVar('AccountId'))->first();

            if (!empty($this->request->getVar('TaskId'))) {
                $TasksModel = new TasksModel();
                $this->Task = $TasksModel->where('id', $this->request->getVar('TaskId'))->first();
            }

            if (!empty($this->request->getVar('Profiles'))) {
                $ScrapsModel = new ScrapsModel();
                $Profiles = json_decode($this->request->getVar('Profiles'));
                $this->ProgressingProfiles = $ScrapsModel->asArray()->where('id IN ('. implode(',', $Profiles) . ')')->findAll();
            }

            $this->QueryDb  = \Config\Database::connect();

           // \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        } else {
            $this->data['Message'] = "Bad Request !";
            $this->data['Status'] = 0;
            die();
        }
    }
}
