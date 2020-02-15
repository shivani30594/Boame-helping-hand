<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscription_m');
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('userSubscription_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/subscription/index';
        $this->data['script'] = 'admin/subscription/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'plan_name',
            2 => 'plan_price',
            3 => 'plan_duration',
            4 => 'plan_description',
            5 => 'plan_price_currency',
            6 => 'created'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->Subscription_m->get());
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->Subscription_m->all($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->Subscription_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->Subscription_m->search_count($search);
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
            }
        }
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        echo json_encode($json_data);
    }

    public function edit()
    {
        $plan_details['plan_name'] = $this->input->post('plan_name');
        $plan_details['plan_price'] = $this->input->post('plan_price');
        $plan_details['plan_description'] = $this->input->post('plan_description');
        $plan_details['plan_price_currency'] = $this->input->post('plan_price_currency');
        $plan_details['plan_duration'] = $this->input->post('plan_duration');
        if ($this->input->post('plan_id') != '')
        {
            $result = $this->Subscription_m->save($plan_details, $this->input->post('plan_id'));
            if ($result)
            {
                $this->session->set_flashdata('success','Subscription Plan Updated Successfully');
            }
            else{
                $this->session->set_flashdata('danger','Something Happens Wrong!');
            }
            redirect('admin/subscription');
        }
        else
        {
            $result = $this->Subscription_m->save($plan_details);
            if ($result)
            {
                $this->session->set_flashdata('success','Subscription Plan Adeed Successfully');
            }
            else{
                $this->session->set_flashdata('danger','Something Happens Wrong!');
            }
            redirect('admin/subscription');
        }
      
    }

    public function add($id = '')
    { 
        if ($id)
        {
            $this->data['edit'] = true;
            $this->data['plan_details'] = $this->Subscription_m->get($id);
        }
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/subscription/add';
        $this->data['script'] = 'admin/subscription/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function delete()
    {
        if ($this->input->post('plan_id'))
        {
            $plan_id = $this->input->post('plan_id');
            $result = $this->Subscription_m->delete($plan_id);
            if ($result)
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => true, 'message' => 'Record deleted successfully')));
            }
            else
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }

        }
    }

    public function Subscription_history()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/subscription_history/index';
        $this->data['script'] = 'admin/subscription_history/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function history_indexjson()
    {
        $columns = array( 
            0 => 'up.first_name',
            1 => 's.plan_name',
            2 => 's.plan_description',
            3 => 's.plan_price',
            4 => 'sh.payment_mode',
            5 => 'sh.address',
            6 => 'sh.status',
            7 => 'sh.start_date',
            8 => 'sh.end_date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->userSubscription_m->get());
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->userSubscription_m->all_admin($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->userSubscription_m->search_admin($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->userSubscription_m->search_count_admin($search);
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
            }
        }
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        echo json_encode($json_data);
    }
}