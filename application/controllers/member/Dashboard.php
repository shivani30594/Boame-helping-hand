<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('purchasedHistory_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('ewallet_m');
        $this->load->model('userSecondary_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('withdrawalRequest_m');
        $this->load->library('facebook');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
     * Display dashboard page with necessary details
     */
    public function index()
    {
        $this->data['meta_title'] = "Dashboard - BOAME";
        $this->data['subview'] = 'member/dashboard/index';
        $this->data['script'] = 'member/dashboard/script';
       
        $user_id = $this->session->userdata('user_id');

        $relation = array(
            "fields" => "sum(points) as total_referral_bonus",
            'conditions' => "user_id = " . $user_id . " AND type LIKE 'referral_points'"
        );
        $this->data['total_referral_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_referral_bonus'];
        $relation = array(
            "fields" => "sum(points) as total_power_bonus",
            'conditions' => "user_id = " . $user_id . " AND type LIKE 'bonus_points'"
        );
        $this->data['total_power_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_power_bonus'];
        $relation = array(
            "fields" => "sum(points) as total_matching_bonus",
            'conditions' => "user_id = " . $user_id . " AND type LIKE 'matching_points'"
        );
        $this->data['total_matching_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_matching_bonus'];
       
        $this->data['total_followers'] = find_followers($user_id);
        $relation = array(
            "fields" => "sum(bpoints) as total_purchased_points",
            'conditions' => "user_id = " . $user_id . " AND type LIKE 'purchased_points'"
        );
        $this->data['total_purchased_points'] = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_points'];
        $relation = array(
            "fields" => "*",
            'conditions' => "user_id = " . $user_id
        );
        $userSecondaryArray = $this->userSecondary_m->get_relation('', $relation, false);
        $this->data['bpoints'] = $userSecondaryArray[0]['total_bpoints'];
        $this->data['ewallet'] = $userSecondaryArray[0]['ewallet'];
        $this->data['ewallet_usd'] = $userSecondaryArray[0]['ewallet_usd'];
        $this->data['total_bpoints_usd'] = $userSecondaryArray[0]['total_bpoints_usd'];
        $relation = array(
            "fields" => "refferal_code",
            'conditions' => "user_id = " . $user_id
        );
        $refferal_code = $this->refferalDetails_m->get_relation('', $relation, false)[0]['refferal_code'];
        $this->data['referral_code'] = $refferal_code;
        
        //total pending withdrawal
        $relation = array(
            "fields" => "sum(withdraw_amount) as total_pending_withdrawals",
            'conditions' => "is_withdraw LIKE 'pending' AND user_id = " . $user_id
            );
        $this->data['total_pending_withdrawals'] = $this->withdrawalRequest_m->get_relation('', $relation, false)[0]['total_pending_withdrawals'];
        
        // net withdrawl
        $relation = array(
            "fields" => "sum(withdraw_amount) as total_pending_withdrawals",
            'conditions' => "is_withdraw LIKE 'complete' AND user_id = " . $user_id
            );
        $this->data['net_withdrawal'] = $this->withdrawalRequest_m->get_relation('', $relation, false)[0]['total_pending_withdrawals'];
       
        $result = generate_link(BASE_URL . 'user/index/' . $refferal_code, $refferal_code);
        if ($result != false)
        {
            $url = json_decode($result);
            $this->data['referral_link'] = $url->url;
        }
        
        $this->data['user_info'] = $this->user_m->get($user_id);
        $this->load->view('_layout_main', $this->data);
    }

    public function edit_mtn_detail()
    {
        if ($this->input->post('mtn_mobile_number') != '')
        {
            $number = $this->input->post("full_number");

            $profile_array['mtn_mobile_number'] = substr($number, 1);
            //$profile_array['mtn_mobile_number'] = $this->input->post('mtn_mobile_number');
        }
        if ($this->input->post('mtn_mobile_name') != '')
        {
            $profile_array['mtn_mobile_name'] = $this->input->post('mtn_mobile_name');
        }
        $result = $this->user_m->save($profile_array, $this->session->userdata('user_id'));
        if ($result != '')
        {
            $this->session->set_flashdata('success', 'MTN information Updated Succesfully');
        }
        else
        {
            $this->session->set_flashdata('danger', 'Something happens wrong!!');
        }
        redirect("dashboard");
    }

}
