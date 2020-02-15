<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('userSecondary_m');
        $this->load->model('withdrawalRequest_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/dashboard';
        $relation = array(
            "fields" => "*",
            'conditions' => "is_mobile_verified = 'Y' AND is_active ='Y' AND is_deleted = 'N'"
            );
        $this->data['total_active_users'] = $this->user_m->get_relation('', $relation, true);
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
        $relation = array(
            "fields" => "sum(bpoints) as total_purchased_usd_points",
            'conditions' => "type LIKE 'purchased_usd_points'"
            );
        $this->data['total_purchased_usd_points'] = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_usd_points'];
        $relation = array(
            "fields" => "sum(ewallet) as total_ewallets",
            'conditions' => ""
            );
        $this->data['total_ewallets'] = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_ewallets'];
        $relation = array(
            "fields" => "sum(ewallet_usd) as total_ewallet_usd",
            'conditions' => ""
            );
        $this->data['total_ewallet_usd'] = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_ewallet_usd'];
        $relation = array(
            "fields" => "sum(withdraw_amount) as total_pending_withdrawals",
            'conditions' => "is_withdraw LIKE 'pending'"
            );
        $this->data['total_pending_withdrawals'] = $this->withdrawalRequest_m->get_relation('', $relation, false)[0]['total_pending_withdrawals'];
        $this->data['total_purchased_points'] = $total_purchased_points + $admin_points;
        $this->data['ewallet'] = $this->data['total_matching_bonus'] + $this->data['total_power_bonus'] + $this->data['total_referral_bonus'];
        $relation = array(
            "fields" => "sum(withdraw_amount) as net_withdrawal",
            'conditions' => "is_withdraw LIKE 'complete'"
            );
        $this->data['net_withdrawal'] = $this->withdrawalRequest_m->get_relation('', $relation, false)[0]['net_withdrawal'];
        $this->data['total_registered_users'] = count($this->user_m->get());
        $this->load->view('admin_layout_main', $this->data);
    }
}