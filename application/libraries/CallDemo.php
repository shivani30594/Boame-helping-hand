<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'vendor/autoload.php'; // Loads the library 
use Twilio\Rest\Client; 
use Twilio\Exceptions\TwilioException;

Class CallDemo
{
	function __construct()
	{
	}

	/**
	* To send the verification message we require verification code. 
	*/
	function send_msg($number, $flag = 'false')
	{
		$CI = & get_instance();
		$code = rand(100000, 900000);
		if ($flag == 'true')
		{
			$sql = "UPDATE crm_users_primary SET verification_code = ".$code." WHERE id = ".$_SESSION['user_id'];
			$updateError =  $CI->db->query($sql);
		}
		else
		{
			$updateError = $this->updateDatabase($number, $code);
		}
		if (strpos($updateError, 'ERROR:') !== false) {
			$this->returnError($updateError);
		} else {
			$response = $this->makeCall($number, $code);
			return $response;
		}
	}

	function send_msg_signup($number, $flag = 'false')
	{
		
		$CI = & get_instance();
		$code = rand(100000, 900000);
		$CI->session->set_userdata('verf_code', $code);
		$response = $this->makeCall($number, $code);
		return $response;
	}

	/**
	* Update the MTN infor + verification code 
	*/
	function updateDatabase($number, $code)
	{
		$CI = & get_instance();
		$sql = "UPDATE crm_users_primary SET verification_code = ".$code." , mtn_mobile_number = ".$number." WHERE id = ".$_SESSION['user_id'];
		return $CI->db->query($sql);
	}

	/**
	* If there is any error then throws it
	*/
 	function returnError($error)
	{
		$json = array();
		$json["error"] = $error;
		echo json_encode($json); 
	}


	public function send_message($mobile_number , $text_message)
	{
	        // Account details : SHP
			// $clientId = '5aebd675ecd27';
			// $applicationSecret = 'd0cd446d8f96137b72e72c07ce8972ca';

	        $clientId = '5ac33950c8e46';
	        $applicationSecret = '5bcf90580c9db6811e8d3d1e49b9dd6d';

			// Prepare data for POST request
	        $url = 'https://app.helliomessaging.com/api/v2/sms';
	        $currentTime = date('YmdH');
	        $hashedAuthKey = sha1($clientId . $applicationSecret . $currentTime);
	        $senderId = 'BOAME'; //Change this to your sender ID e.g. HellioSMS
	        $msisdn = $mobile_number; //Change this to the recipient you wish to send the message to
	        //$message = $text_message; //The message to be send here
	        $params = [
	            'clientId' => $clientId,
	            'authKey' => $hashedAuthKey,
	            'senderId' => $senderId,
	            'msisdn' => $msisdn,
	            'message' => $text_message
	        ];

			// Send the POST request with cURL
	        $ch = curl_init($url);
	        $payload = json_encode($params);
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	            'Content-Type: application/json',
	            'Content-Length: ' . strlen($payload)
	        ));

			// Process your response here
	        $result = curl_exec($ch);
	        //echo var_export($result, true);
	        //$decoded = json_decode($result);
			curl_close($ch);
			if (isset($decoded->errorMsg))
			{
				$flag = "false_number";
			}
			else
			{
				$flag = "true_number";
			}		
	        return $flag;
	    }


	public function makeCall($mobile_number , $code)
	{
		
        $clientId = '5ac33950c8e46';
        $applicationSecret = '5bcf90580c9db6811e8d3d1e49b9dd6d';
        $url = 'https://app.helliomessaging.com/api/v2/sms';
        $currentTime = date('YmdH');
        $hashedAuthKey = sha1($clientId . $applicationSecret . $currentTime);
        $senderId = 'BOAME'; //Change this to your sender ID e.g. HellioSMS
        $msisdn = $mobile_number; //Change this to the recipient you wish to send the message to
        $params = [
            'clientId' => $clientId,
            'authKey' => $hashedAuthKey,
            'senderId' => $senderId,
            'msisdn' => $msisdn,
            'message' => 'Your one time verification code is :'.$code
        ];

	
        $ch = curl_init($url);
        $payload = json_encode($params);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ));
		$result = curl_exec($ch);
		$decoded = json_decode($result);
		
		if (isset($decoded->errorMsg))
		{
			$flag = "false_number";
		}
		else
		{
			$flag = "true_number";
		}
	    return $flag;
	}
}
