<?php
class MY_Controller extends CI_Controller 
{
	public $data = array();
		
		function __construct() 
		{
			parent::__construct();
			/*date_default_timezone_set("Asia/Bangkok");*/
			$this->data['errors'] = array();
			$this->load->model('user_m');
			$this->load->model('admin_m');
        	$this->load->library('facebook');
			if ($this->session->userdata('admin_id'))
			{
				$this->data['admin_details'] = $this->admin_m->get($this->session->userdata('admin_id'), true);
			}
			if ($this->session->userdata('user_id')) {
				$this->data['user_id'] = $this->session->userdata('user_id');
				$this->data['member_details'] = $this->user_m->get($this->data['user_id'], true);
        		if ($this->user_m->get($this->data['user_id'])->fb_token_id != '')
				{
					$this->data['logout_url'] = $this->facebook->logout_url();
				}
			}
			
		}
}