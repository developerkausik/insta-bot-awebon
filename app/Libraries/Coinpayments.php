<?php

/**
 * CoinPayments.net API CodeIgniter Library - v1.0
 * @author	Jonathan Lamim
 * @copyright	Copyright (c) 2020 . (https://jonathanlamim.com.br/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://github.com/jlamim/codeigniter-coinpayments-api
 * @since	Version 1.0.0
 * @filesource
 */

use \Config\CoinpaymentsConfig;

class Coinpayments
{
    public $private_key     = '';
    public $public_key      = '';
    public $merchant_id     = '';
    public $api_url         = '';
    public $format_returned = '';
    public $ch              = null;

    /**
     * Constructor - Sets CoinPayments Keys
     *
     * The constructor
     *
     * @return	void
     */
    public function __construct()
    {
        $CoinPaymentsInstance = new CoinpaymentsConfig();
        $coinpayments_conf =  $CoinPaymentsInstance->config;
        $this->initialize($coinpayments_conf);
    }

    /**
     * Initialize preferences
     *
     * @param	array	$config
     * @return	Coinpayments
     */
    public function initialize(array $config = array())
    {
        $this->clear();
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $method = 'set_' . $key;

                if (method_exists($this, $method)) {
                    $this->$method($val);
                } else {
                    $this->$key = $val;
                }
            }
        }

        return $this;
    }

    /**
     * Initialize the Email Data
     *
     * @param	bool
     * @return	Coinpayments
     */
    public function clear()
    {
        $this->public_key      = '';
        $this->private_key     = '';
        $this->merchant_id     = '';
        $this->api_url              = '';
        $this->format_returned = '';

        return $this;
    }

    /**
     * Gets your current CoinPayments.net basic infos.
     */
    public function getAccountInfo()
    {
        return $this->api_call('get_basic_info');
    }

    /**
     * Gets the current CoinPayments.net exchange rate. Output includes both crypto and fiat currencies.
     * @param short If short == TRUE (the default), the output won't include the currency names and confirms needed to save bandwidth.
     */
    public function getRates($short = TRUE)
    {
        $short = $short ? 1 : 0;
        return $this->api_call('rates', array('short' => $short));
    }

    /**
     * Gets your current coin balances (only includes coins with a balance unless all = TRUE).<br />
     * @param all If all = TRUE then it will return all coins, even those with a 0 balance.
     */
    public function getBalances($all = FALSE)
    {
        return $this->api_call('balances', array('all' => $all ? 1 : 0));
    }

    /**
     * Returns the address for deposit in personal wallet.
     * @param currency The currency the buyer will be sending.
     */
    public function getDepositAddress($currency = 'BTC')
    {
        return $this->api_call('get_deposit_address', array('currency' => $currency));
    }

    /**
     * Creates a basic transaction with minimal parameters.<br />
     * See CreateTransaction for more advanced features.
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency1 The source currency (ie. USD), this is used to calculate the exchange rate for you.
     * @param currency2 The cryptocurrency of the transaction. currency1 and currency2 can be the same if you don't want any exchange rate conversion.
     * @param buyer_email Set the buyer's email so they can automatically claim refunds if there is an issue with their payment.
     * @param address Optionally set the payout address of the transaction. If address is empty then it will follow your payout settings for that coin.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     */
    public function createTransactionSimple($amount, $currency1, $currency2, $buyer_email, $address = '', $ipn_url = '')
    {
        $req = array(
            'amount' => $amount,
            'currency1' => $currency1,
            'currency2' => $currency2,
            'buyer_email' => $buyer_email,
            'address' => $address,
            'ipn_url' => $ipn_url,
        );
        return $this->api_call('create_transaction', $req);
    }

    public function createTransaction($req)
    {
        // See https://www.coinpayments.net/apidoc-create-transaction for parameters
        return $this->api_call('create_transaction', $req);
    }

    /**
     * Creates an address for receiving payments into your CoinPayments Wallet.<br />
     * @param currency The cryptocurrency to create a receiving address for.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     */
    public function getCallbackAddress($currency, $ipn_url = '')
    {
        $req = array(
            'currency' => $currency,
            'ipn_url' => $ipn_url,
        );
        return $this->api_call('get_callback_address', $req);
    }

    /**
     * Get List Of Transaction IDs
     * @param limit The maximum number of transaction IDs to return from 1-100. (default: 25)
     * @param start What transaction # to start from (for iteration/pagination.) (default: 0, starts with your newest transactions.)
     * @param newer Return transactions started at the given Unix timestamp or later. (default: 0)
     */
    public function getTransactionIds($currency, $limit = 25, $start = 0, $newer = 0)
    {
        $req = array(
            'currency' => $currency,
            'limit' => $limit,
            'start' => $start,
            'newer' =>  $newer
        );
        return $this->api_call('get_tx_ids', $req);
    }

    /**
     * Get Transaction Information
     * @param TransactionId The transaction ID to query (API key must belong to the seller.) Note: It is recommended to
     * handle IPNs instead of using this command when possible, it is more efficient and places less load on our servers.
     */
    public function getTransactionInfo($currency, $TransactionId)
    {
        $req = array(
            'currency' => $currency,
            'txid' => $TransactionId,
        );
        return $this->api_call('get_tx_info', $req);
    }

    /**
     * Get Multiple Transaction Information
     * @param TransactionIds Lets you query up to 25 transaction ID(s) (API key must belong to the seller.)
     * Transaction IDs should be separated with a | (pipe symbol.) Note: It is recommended to handle IPNs instead of
     * using this command when possible, it is more efficient and places less load on our servers.
     */
    public function getMultiTransactionInfo($TransactionIds)
    {
        $req = array(
            'txid' => $TransactionIds,
        );
        return $this->api_call('get_tx_info_multi', $req);
    }

    /**
     * Creates a withdrawal from your account to a specified address.<br />
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param address The address to send the coins to.
     * @param auto_confirm If auto_confirm is TRUE, then the withdrawal will be performed without an email confirmation.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     */
    public function createWithdrawal($amount, $currency, $address, $auto_confirm = FALSE, $ipn_url = '')
    {
        $req = array(
            'amount' => $amount,
            'currency' => $currency,
            'address' => $address,
            'auto_confirm' => $auto_confirm ? 1 : 0,
            'ipn_url' => $ipn_url,
        );
        return $this->api_call('create_withdrawal', $req);
    }

    /**
     * Creates a transfer from your account to a specified merchant.<br />
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param merchant The merchant ID to send the coins to.
     * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
     */
    public function createTransfer($amount, $currency, $merchant, $auto_confirm = FALSE)
    {
        $req = array(
            'amount' => $amount,
            'currency' => $currency,
            'merchant' => $merchant,
            'auto_confirm' => $auto_confirm ? 1 : 0,
        );
        return $this->api_call('create_transfer', $req);
    }

    /**
     * Creates a transfer from your account to a specified $PayByName tag.<br />
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param pbntag The $PayByName tag to send funds to.
     * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
     */
    public function sendToPayByName($amount, $currency, $pbntag, $auto_confirm = FALSE)
    {
        $req = array(
            'amount' => $amount,
            'currency' => $currency,
            'pbntag' => $pbntag,
            'auto_confirm' => $auto_confirm ? 1 : 0,
        );
        return $this->api_call('create_transfer', $req);
    }

    private function is_setup()
    {
        return (!empty($this->private_key) && !empty($this->public_key));
    }

    private function api_call($cmd, $req = array())
    {
        if (!$this->is_setup()) {
            return array('error' => 'You have not called the Setup function with your private and public keys!');
        }

        if ($this->api_url == '') {
            return array('error' => 'You have not defined API URL!');
        }

        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = $cmd;
        $req['key'] = $this->public_key;
        $req['format'] = $this->format_returned;

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $this->private_key);

        // Create cURL handle and initialize (if needed)
        if ($this->ch === null) {
            $this->ch = curl_init($this->api_url);
            curl_setopt($this->ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);

        $data = curl_exec($this->ch);
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, TRUE);
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result (' . json_last_error() . ')');
            }
        } else {
            return array('error' => 'cURL error: ' . curl_error($this->ch));
        }
    }
};