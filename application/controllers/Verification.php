<?php 

class Verification extends MY_Controller {

	 public function __construct() {
        parent::__construct();
        $this->load->model('user_m');
    }

	public function index()
	{
		$this->load->library('SMSMessage');
		$this->smsmessage->sendMsg();//sms calling 
	}

	public function callMethodSignup()
	{
		$this->load->library('CallDemo');
		if (isset($_POST['phone_number']) && $_POST['phone_number'] != '')
		{
			$number = $this->input->post("phone_number");
			$number = substr($number, 1); 
		}
		$response = $this->calldemo->send_msg_signup($number);
		//echo json_encode('true_number');
        echo json_encode($response);
	}

	public function verify_session(Type $var = null)
	{
		 if (isset($_POST['verification_code']) && $_POST['verification_code'] != '')
		 {
		 	//echo $this->session->userdata('verf_code');
		 	if ($this->session->userdata('verf_code') == $this->input->post("verification_code"))
		 	{
		 		echo json_encode('true');
		 	}
		 	else
		 	{
		 		echo json_encode('false');
		 	}
		 }
		 else
		 {
		 	echo json_encode('false');
		 }
//		echo json_encode('true');
	}
	/**
	* load the library and send the message. Based on the Twilio response, We will get the result that number is correct or not. 
	*/
	public function callMethod()
	{
		$this->load->library('CallDemo');
		if (isset($_POST['phone_number']) && $_POST['phone_number'] != '')
		{
			$number = $this->input->post("full_number");
			$number = substr($number, 1); 
		}
		else
		{
			$number = $this->user_m->get($this->session->userdata("user_id"))->mtn_mobile_number;
		}
		$response = $this->calldemo->send_msg($number);
		if ($response == 'wrong_number')
		{
			$this->session->set_flashdata('error', 'Please enter valid phone number');
            redirect($this->uri->uri_string());
		}
		$data['phone_number'] = $number;
		$this->load->view('member/verification/verify_phone', $data);
	}

	/**
	* Call through Ajax. If click on "Lets check the numnber"
	*/
	public function callMethodJquery()
	{
		// $sql = "UPDATE crm_users_primary SET is_mobile_verified = 'N' WHERE id = ".$_SESSION['user_id'];
		// $this->db->query($sql);
		$this->load->library('CallDemo');
		if (isset($_POST['phone_number']) && $_POST['phone_number'] != '')
		{
			$number = $this->input->post("phone_number");
			$number = substr($number, 1); 
		}
		else
		{
			$number = $this->user_m->get($this->session->userdata("user_id"))->mtn_mobile_number;
		}
		$response = $this->calldemo->send_msg($number, true);
		echo json_encode($response);
	}

	/**
	* check the verification code entered with database verification code. Give response according to it.
	*/
	public function verifyMessage()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") die;
		$code = $this->input->post("verification_code");
		$result = $this->user_m->get($this->session->userdata('user_id'));
		if ($result->verification_code == $code)
		{
			$sql = "UPDATE crm_users_primary SET is_mobile_verified = 'Y' WHERE id = ".$this->session->userdata('user_id');
			$respose = $this->db->query($sql);
			redirect('dashboard');
		}
		else{
			$data['phone_number'] = $this->user_m->get($this->session->userdata("user_id"))->mtn_mobile_number;
            $this->session->set_flashdata('error', 'Please enter valid verification which is again send to you.');
			$this->load->view('member/verification/verify_phone' , $data);
		}
		
	}

	/**
	* Call function through Ajax. If user click on not get verification code. Resend the code and update the table.
	*/
	public function verifyMessageJquery()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") die;
		$code = $this->input->post("verification_code");
		$result = $this->user_m->get($this->session->userdata('user_id'));
		if ($result->verification_code == $code)
		{
			$sql = "UPDATE crm_users_primary SET is_mobile_verified = 'Y' WHERE id = ".$this->session->userdata('user_id');
			$respose = $this->db->query($sql);
			echo json_encode($flag='true');
		}
		else{
			$data['phone_number'] = $this->user_m->get($this->session->userdata("user_id"))->mtn_mobile_number;
			echo json_encode($flag='false');
		}
	}

	/**
	* Load the verification page
	*/
	public function loadPage()
	{
		$this->load->view('member/verification/index');
	}
}

 
