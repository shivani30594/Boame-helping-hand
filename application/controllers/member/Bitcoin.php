<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bitcoin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        // if (!$this->session->userdata('user_id'))
        // {
        //     show_404(current_url());
        //     exit;
        // }
    }

    public function index()
    {
        $this->load->library('CoinPaymnets');
        $this->coinpaymnets->load_form();
    }

    public function callback()
    {
        $this->load->library('CoinPaymnets');
        $this->coinpaymnets->callbackurl();
    }
}