<?php
namespace App\Models;

use CodeIgniter\Model;

class PaypalAccountsModel extends Model
{
    protected $table = "paypalaccounts";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\PaypalAccounts";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "domain",
        "apiuser",
        "apipwd",
        "apisig",
        "ipn",
        "active",
        "enabled",
        "used",
        "secret",
        "funds",
        "maxfunds",
    ];

    protected $useTimestamps = false;
}
