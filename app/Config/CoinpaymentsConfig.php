<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class CoinpaymentsConfig extends BaseConfig
{
    public $config = [
        'public_key' => 'b4febacacbd36249821d697c2805fc2a0f240fe6d51c85f5984a71639a5824b6',
        'private_key' => '0722793E92C2f4333d7EB35AC42d4aB87513eB0Bf879f12EED6e71f68279F674',
        'merchant_id' => '471d1f56c93a341cb1639df493128290',
        'api_url' => 'https://www.coinpayments.net/api.php',
        'format_returned' => 'json'
    ];
}