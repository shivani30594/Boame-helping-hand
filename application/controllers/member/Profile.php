<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_m');
       // $this->load->model('refferalDetails_m');
       // $this->load->model('bonusPointsHistory_m');
        $this->load->library('facebook'); 
      //  $this->load->model('log_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * Profile
    */
    public function index()
    {
        $this->data['meta_title'] = "Profile - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $this->data['subview'] = 'member/profile/index';
        $this->data['script'] = 'member/profile/script';
        $this->load->view('_layout_main', $this->data);
    }

    /**
    * Edit user-profile functinality
    */
    public function edit_profile()
    {
        $profile_array['first_name'] = $this->input->post('first_name');
        $profile_array['last_name'] = $this->input->post('last_name');
        $profile_array['email'] = $this->input->post('email');
        $profile_array['gender'] = $this->input->post('gender');
        $result = $this->user_m->save($profile_array , $this->session->userdata('user_id'));
        if ($result != '')
        {
            $this->session->set_flashdata('success', 'Profile Updated Succesfully');
        }
        else
        {
            $this->session->set_flashdata('danger', 'Something happens wrong!!');
        }
        redirect("member/profile/index");
    }

    /**
    * Edit MTN details
    */
    public function edit_mtn_detail()
    {
        if ($this->input->post('mtn_mobile_number') != '')
        {
            $number = $this->input->post("full_number");
            $profile_array['mtn_mobile_number'] = substr($number, 1); 
           // $profile_array['mtn_mobile_number'] = $this->input->post('mtn_mobile_number');
        }
        if ($this->input->post('mtn_mobile_name') != '')
        {
            $profile_array['mtn_mobile_name'] = $this->input->post('mtn_mobile_name');
        }
        $result = $this->user_m->save($profile_array , $this->session->userdata('user_id'));
        if ($result != '')
        {
            $this->session->set_flashdata('success', 'MTN information Updated Succesfully');
        }
        else
        {
            $this->session->set_flashdata('danger', 'Something happens wrong!!');
        }
        redirect("member/profile/index");
    }

    /**
    * Check the verification code and MTN mobile number
    */
    public function edit_mtn_detail_jquery()
    {
        if ($this->input->post('mtn_mobile_number') != '')
        {
            $profile_array['mtn_mobile_number'] = $this->input->post('mtn_mobile_number');
        }
        $result = $this->user_m->save($profile_array , $this->session->userdata('user_id'));
        if ($result != '')
        {
            $flag = "success";
        }
        else
        {
            $flag = "error";
        }
        echo json_encode($flag);
    }
}