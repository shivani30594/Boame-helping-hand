<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('refferalDetails_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * Display user's referral link on the user dashboard 
    */
	public function index()
	{
        $this->data['meta_title'] = "Referral - BOAME";
        $relation = array(
        "fields" => "refferal_code",
        'conditions' => "user_id = ". $this->data['user_id']
        );
        $refferal_code = $this->refferalDetails_m->get_relation('', $relation, false)[0]['refferal_code'];
        $result = generate_link(BASE_URL . 'user/index/'.$refferal_code, $refferal_code);
        if ($result != false)
        {
            $url = json_decode($result);
            $this->data['referral_link'] = $url->url;
        }
        $this->data['subview'] = 'member/refer_page';
        $this->data['script'] = 'member/script';
        $this->load->view('_layout_main', $this->data);
    }

}