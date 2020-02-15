<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ewallet extends MY_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('userSecondary_m');
        $this->load->model('log_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }
 
    /**
    * Display E-wallet information to the user. Also, display the records of the user who earn points.
    */
    public function index($page = ' ')
    {
        $this->data['meta_title'] = "Ewallet - BOAME";
        $this->data['subview'] = 'member/ewallet/index';
        $this->data['script'] = 'member/ewallet/script';
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ".$this->session->userdata('user_id') 
           
        );
        $this->data['result'] = $this->userSecondary_m->get_relation('', $relation, false);
       
        // $start_date = date('Y-m-01 00:00:00',strtotime('this month'));
        // $end_date = date('Y-m-t 12:59:59',strtotime('this month'));
        //Pagination configuration
        $config = array();
        $config["base_url"] = base_url() . "ewallet";
        $relation = array(
            "fields" => "*",
            "conditions" => "type != 'signup_points' AND type != 'credited_points' AND type !='debited_points' AND type !='purchased_points' AND user_id = ".$this->session->userdata('user_id')."",
            "ORDER_BY" => array(
                        'field' => 'crm_log.created',
                        'order' => 'DESC'),
        );
        $total_row = $this->log_m->get_relation('', $relation, true);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $this->pagination->initialize($config);
        if($this->uri->segment(2)){
            $page = ($this->uri->segment(2)) ;
        }
        else{
             $page = 1;
        }
        $relation = array(
            "fields" => "*",
            "conditions" => "type != 'signup_points' AND type != 'credited_points' AND type !='debited_points' AND type !='purchased_points' AND user_id = ".$this->session->userdata('user_id')."",
            "ORDER_BY" => array(
                        'field' => 'crm_log.created',
                        'order' => 'DESC'),
        );
        $relation['LIMIT']['start'] = $config["per_page"];
        $relation['LIMIT']['end'] = $page;
        $this->data["log_history"] = $this->log_m->get_relation('', $relation, false);
        $str_links = $this->pagination->create_links();
        $this->data["links"] = explode('&nbsp;',$str_links );
        // View data according to array.
        $this->load->view("_layout_main", $this->data);
    }
}