<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/coinPayments.class.php';

Class CallBack{

    function __construct()
	{
       
    }

	public function callbackurl()
	{
		$CP = new \MineSQL\coinPayments();
        $file1 = fopen("call_back_file_16_07_2018.txt", 'w');
        fwrite($file1,'call_back');
        fclose($file1);
		// Set your Merchant ID
		$CP->setMerchantId('10a723ca880ce3216fe57a94faca3404');
		// Set your secret IPN Key (in Account Settings on Coinpayments)
		$CP->setSecretKey('Narola21#');

		// Payment Validator. Usually you would call this  
		// from a database to fetch the billing information based on the $_POST['custom'] variable
        // 
       
		if($CP->validatePayment(0.1000, 'LTCT')) {
            // $str = json_encode($_POST);
			$file1 = fopen("ipn_success_16_07_2018.txt", 'w');
			fwrite($file1,'suv');
			fclose($file1);
			// The payment is successful and passed all security measures
		}

		// The payment for some reason did not successfully complete
		// All the errors generated are gathered into an array and can be accessed by $CP->getErrors();

		$file = fopen("ipn_log_16_07_2018.txt", 'w');
		fwrite($file, print_r($CP->getErrors()));
		fclose($file);							

	}
}
