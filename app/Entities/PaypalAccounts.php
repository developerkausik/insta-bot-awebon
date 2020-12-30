<?php
namespace App\Entities;

use CodeIgniter\Entity;

class PaypalAccounts extends Entity
{
    protected $domain;
    protected $apiuser;
    protected $apipwd;
    protected $apisig;
    protected $ipn;
    protected $active;
    protected $enabled;
    protected $used;
    protected $secret;
    protected $funds;
    protected $maxfunds;
}
