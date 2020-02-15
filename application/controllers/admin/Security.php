<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
    }

	public function index()
	{
        $this->session->sess_destroy();
        if ($this->session->userdata('loggedin')) {
            redirect('admin/dashboard');
            exit;
        }
        $this->load->view('admin/login');
    }

    public function login()
    {
        if ($this->session->userdata('loggedin')) {
            redirect('admin/dashboard');
            exit;
        }
        if ($this->admin_m->login() == FALSE)
        {
            $this->session->set_flashdata('error', "Password and email combination doesn't match");
            redirect('admin/security');
            exit;
        }
        else
        {
            redirect('admin/dashboard');
            exit;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/security');
    }
}