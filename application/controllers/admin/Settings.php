<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('paymentUSD_m');
        $this->load->model('admin_m');
        $this->load->model('setting_m');
        $this->load->model('user_m');
        $this->load->model('subscription_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
     
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/settings/index';
        $this->data['script'] = 'admin/settings/script';
        $this->data['settting_details'] = $this->setting_m->get('1');
        $this->data['plan_details'] = $this->subscription_m->get();
        $this->load->view('admin_layout_main', $this->data);
    }

    public function update()
    {
            $settings['merchant_id'] = $this->input->post('merchant_id');
            $settings['public_key'] = $this->input->post('public_key');
            $settings['private_key'] = $this->input->post('private_key');
            $settings['secret_key'] = $this->input->post('secret_key');
            $settings['ghs_to_usd'] = $this->input->post('ghs_to_usd');
            $settings['usd_to_ghs'] = $this->input->post('usd_to_ghs');
            $settings['ipn_url'] = $this->input->post('ipn_url');
            $settings['default_subscription_plan_id'] = $this->input->post('default_subscription_plan_id');
            if ($this->input->post('setting_id') != '' )
            {
                $result = $this->setting_m->save($settings, $this->input->post('setting_id'));
            }
            else {
                $result = $this->setting_m->save($settings);
            }
            if ($result == 1)
            {
                $this->session->set_flashdata('success', 'Setting Updated Succesfully');
            }
            redirect('admin/settings');
    }
}
