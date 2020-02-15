<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->library('CallDemo');
        $this->load->model('withdrawalRequest_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('log_m');
        $this->load->model('userSecondary_m');
        $this->load->model('ewallet_m');
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/withdraw/index';
        $this->data['script'] = 'admin/withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function cancel_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/cancel_withdraw/index';
        $this->data['script'] = 'admin/cancel_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function complete_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/complete_withdraw/index';
        $this->data['script'] = 'admin/complete_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function pending_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/pending_withdraw/index';
        $this->data['script'] = 'admin/pending_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

     public function u_pending_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/u_pending_withdraw/index';
        $this->data['script'] = 'admin/u_pending_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function u_complete_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/u_complete_withdraw/index';
        $this->data['script'] = 'admin/u_complete_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function u_cancel_index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/u_cancel_withdraw/index';
        $this->data['script'] = 'admin/u_cancel_withdraw/script';
        $this->load->view('admin_layout_main', $this->data);
    }
    
    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get());
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_admin($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_admin($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->withdrawalRequest_m->search_count_admin($search);
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

   
    public function cancel_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'cancel' AND type='GHS'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'cancel','GHS');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'cancel','GHS');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'cancel','GHS');
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

    public function pending_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'pending' AND type='GHS'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'pending','GHS');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'pending','GHS');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'pending','GHS');
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

    public function complete_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'complete' AND type='GHS'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'complete','GHS');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'complete','GHS');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'complete','GHS');
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

    public function u_pending_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'pending' AND type='USD'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'pending','USD');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'pending','USD');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'pending','USD');
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

    public function u_complete_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'complete' AND type='USD'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'complete','USD');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'complete','USD');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'complete','USD');
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

    public function u_cancel_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'user_id',
                    3 => 'type',
                    5 => 'bPoints'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'cancel' AND type='USD'"));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all_cancel_admin($limit,$start,$order,$dir,'cancel','USD');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search_cancel_admin($limit,$start,$search,$order,$dir,'cancel','USD');
            $totalFiltered = $this->withdrawalRequest_m->search_cancel_count_admin($search,'cancel','USD');
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
    
   public function cancel()
    {
        $id = $this->input->post('withdraw_id');
        $withArray = $this->withdrawalRequest_m->get($id);
        $relation = array(
            "fields" => "*",
            'conditions' => " user_id = ".$withArray->user_id
            );
        $secDetails = $this->userSecondary_m->get_relation('', $relation, false);
        if ($withArray->type == 'USD')
        {
            $wallet = $withArray->withdraw_amount + $secDetails[0]['ewallet_usd'];
        }
        else{
            $wallet = $withArray->withdraw_amount + $secDetails[0]['ewallet'];
        }
        if ($id)
        {
            $sql = "UPDATE crm_withdrawal_request SET is_withdraw = 'cancel' where id = $id";
            $result = $this->db->query($sql);
            if ($withArray->type == 'USD')
            {
                $sql1 = "UPDATE crm_users_secondary SET ewallet_usd = $wallet where user_id = $withArray->user_id";
            }
            else{
                $sql1 = "UPDATE crm_users_secondary SET ewallet = $wallet where user_id = $withArray->user_id";
            }
            $result1 = $this->db->query($sql1);
            // send notification
            $withdraw_history = $this->withdrawalRequest_m->get($id);
            $user_details = $this->user_m->get($withdraw_history->user_id);
            $admin_notification = "Admin cancelled the withdrawal request of ".$user_details->first_name.' '.$user_details->last_name;
            $notification_id = insert_notification_detail('request',"Withdrawal Request Cancellation","Withdrawal request has been cancelled by admin" ,$admin_notification, $user_details->id); // common helper function
            $pay_load_data = set_payload('request', $notification_id, "Withdrawal request has been cancelled by admin");
            if ($user_details->device_type == '0')
            {
                send_push_notification($user_details->device_token, false, $pay_load_data);//library notification
            }
            // end send notification
            if ($result)
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => 'Withdrawal request has been cancelled successfully')));
            }
            else
            {
               return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }
        }
    }

    public function confirm($id = '')
    {
        if ($id)
        {
            $sql = "UPDATE crm_withdrawal_request SET is_withdraw = 'complete' where id = $id";
            $result = $this->db->query($sql);
            $withdraw_history = $this->withdrawalRequest_m->get($id);
            $user_details = $this->user_m->get($withdraw_history->user_id);
            if ($result)
            {
                //*****************************send notification******************************
                $body = "CONGRATULATIONS, YOU JUST GOT PAID FROM BOAME. AN AMOUNT OF ".$withdraw_history->received_amount." HAS BEEN SENT TO YOUR MOBILE MONEY ACCOUNT. REFER MORE AND EARN MORE.";
                $result = $this->calldemo->send_message($user_details->mtn_mobile_number, $body);
                $this->session->set_flashdata("success","Withdrawal request is confirmed successfully");
            }
            else
            {
                $this->session->set_flashdata("error","Please try again later");
            }
            redirect("admin/withdraw/index");
        }
    }
}
