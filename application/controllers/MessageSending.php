<?php 
// Get the PHP helper library from https://twilio.com/docs/libraries/php
// Loads the library
class MessageSending extends CI_Controller {

	 public function __construct() {
        parent::__construct();
    }

	public function index()
	{
		$this->load->library('SMSMessage');
		$this->smsmessage->sendmsg('+918511903810','Test message without body text is sent to you bae!!!!!!!!');//sms calling 
	}
}

 
