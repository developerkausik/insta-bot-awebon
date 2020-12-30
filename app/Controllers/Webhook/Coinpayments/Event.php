<?php

namespace App\Controllers\Webhook\Coinpayments;

use App\Controllers\Webhook\PrivateController;

class Event extends PrivateController
{
    public function trigger()
    {
        log_message('info', json_encode($_POST));
        $cp_merchant_id = '471d1f56c93a341cb1639df493128290';
        $cp_ipn_secret = '123456aa';

        $order_currency = 'USD';
        $order_total = 10.00;

        function errorAndDie($error_msg) {
            global $cp_debug_email;
            if (!empty($cp_debug_email)) {
                $report = 'Error: '.$error_msg."\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                }
                mail($cp_debug_email, 'CoinPayments IPN Error', $report);
            }
            die('IPN Error: '.$error_msg);
        }

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            log_message('info', 'IPN Mode is not HMAC');
            die();
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            log_message('info', 'No HMAC signature sent.');
            die();
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            log_message('info', 'Error reading POST data');
            die();
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            log_message('info', 'No or incorrect Merchant ID passed');
            die();
        }

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            log_message('info', 'HMAC signature does not match');
            die();
        }

        // HMAC Signature verified at this point, load some variables.

        $ipn_type = $_POST['ipn_type'];
        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $amount1 = floatval($_POST['amount1']);
        $amount2 = floatval($_POST['amount2']);
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];

        if ($ipn_type != 'button') {
            die("IPN OK: Not a button payment");
        }

        //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

        // Check the original currency to make sure the buyer didn't change it.
        if ($currency1 != $order_currency) {
            log_message('info', 'Original currency mismatch');
            die();
        }

        // Check amount against order total
        if ($amount1 < $order_total) {
            log_message('info', 'Amount is less than order total!');
            die();
        }

        if ($status >= 100 || $status == 2) {
            // payment is complete or queued for nightly payout, success
        } else if ($status < 0) {
            //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
        } else {
            //payment is pending, you can optionally add a note to the order page
        }
        die('IPN OK');
    }
}