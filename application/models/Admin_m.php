<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends My_Model{

    protected $_table_name     = 'crm_admin';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;
    
    public function login()
    {
    	  $user = $this->get_by(array(
            'username' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
             ), TRUE);
    	 if (count($user))
    	 {
    	 	$data = array(
    	 		'loggedin' => TRUE ,
    	 		'admin_id' => $user->id,
    	 		'username' => $user->password,
    	 		'user_type' => 'admin' );

    	 	$this->session->set_userdata($data);
            return TRUE;
    	 }
    	 return FALSE;
    }

    public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }

}

