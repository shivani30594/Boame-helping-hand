<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Points extends MY_Controller {

	public function __construct() 
    {
        parent::__construct();
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('ewallet_m');
        $this->load->model('log_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    /**
    * Used to display net-eWallet values and purchased points into point transaction report.
    */
	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/points/net_transaction';
        $this->data['script'] = 'admin/points/script';
        $relation = array(
            "fields" => "sum(points) as total_referral_bonus",
            'conditions' => "type LIKE 'referral_points'"
            );
        $this->data['total_referral_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_referral_bonus'];
        $relation = array(
            "fields" => "sum(points) as total_power_bonus",
            'conditions' => "type LIKE 'bonus_points'"
            );
        $this->data['total_power_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_power_bonus'];
        $relation = array(
            "fields" => "sum(points) as total_matching_bonus",
            'conditions' => "type LIKE 'matching_points'"
            );
        $this->data['total_matching_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_matching_bonus'];
        $relation = array(
            "fields" => "sum(bpoints) as total_purchased_points",
            'conditions' => "type LIKE 'purchased_points'"
            );
        $total_purchased_points = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_points'];
        $relation = array(
            "fields" => "sum(bpoints) as total_purchased_points",
            'conditions' => "type LIKE 'admin_points'"
            );
        $admin_points = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_points'];
        $this->data['total_purchased_points'] = $total_purchased_points + $admin_points;
        $this->data['ewallet'] = $this->data['total_matching_bonus'] + $this->data['total_power_bonus'] + $this->data['total_referral_bonus'];
        $this->load->view('admin_layout_main', $this->data);
    }
}