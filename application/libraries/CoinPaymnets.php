<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/coinPayments.class.php';

Class CoinPaymnets
{
	function __construct()
	{
       
    }

    public function load_form()
    {
       
        // test httpauth and hmac then publish to github bb
        // You need to set a callback URL if you want the IPN to work
       // $callbackUrl ="https://www.boame.net/member/bitcoin/callback";
        $callbackUrl = "http://localhost/coinpayments-ipn-master/index.php";
        $sucessURL = BASE_URL.'dashboard';
      
        // Create an instance of the class
        
        $CP = new \MineSQL\coinPayments();
        // Set the merchant ID and secret key (can be found in account settings on CoinPayments.net)
        $CP->setMerchantId('10a723ca880ce3216fe57a94faca3404');
        $CP->setSecretKey('Narola21#');

        // Create a payment button with item name, currency, cost, custom variable, and the callback URL
        $form = $CP->createPayment('Test Product', 'LTCT', 0.10, '123', $callbackUrl, $sucessURL);
        
        // Display the button suce
        echo $form;

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
       
		if($CP->validatePayment(0.10, 'LTCT')) {
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