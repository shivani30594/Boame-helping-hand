<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php'; // Loads the library 
 
use Twilio\Rest\Client; 

Class SMSMessage {

	function __construct()
	{
	}

	public function sendmsg($to, $body)
	{
		$account_sid = 'AC13fffd93485f4e8123cfda49b6cc559f'; 
		$auth_token = '7810d0e44bd98ded44753e5b4ab627ee'; 
		$client = new Client($account_sid, $auth_token); 
		$messages = $client->messages->create(
		// Where to send a text message (your cell phone?)
		$to,
			array (
			'from' => '+12023356082',
			'body' => $body,
			'MessagingServiceSid' => 'MGc96af62e5ad6eafb1ededc70713dbf33'
			)
		);
		echo "<pre>";
		print_r($messages);
		die();
	}
}