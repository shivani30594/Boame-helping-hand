<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('setting_m');
        $this->load->model('store_m');
        $this->load->model('user_m');
        $this->load->model('userSecondary_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('withdrawalRequest_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
	{
        $this->data['transaction_charges'] = $this->setting_m->get()[0]->withdraw_fees;
        $this->data['meta_title'] = "Withdraw EWallet - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $user_id = $this->session->userdata('user_id');
        $relation = array(
                    "fields" => "ewallet, ewallet_usd",
                    'conditions' => "user_id = " . $user_id
                );
        $user_secArray = $this->userSecondary_m->get_relation('', $relation, false)[0];
        $this->data['total_ewallet'] = $user_secArray['ewallet'];
        $this->data['total_ewallet_usd'] = $user_secArray['ewallet_usd'];
        $this->data['subview'] = 'member/withdraw/index';
        $this->data['script'] = 'member/withdraw/script';
        $this->load->view('_layout_main', $this->data);
    }
    
    public function usd_index()
	{
        $this->data['transaction_charges'] = $this->setting_m->get()[0]->withdraw_fees;
        $this->data['meta_title'] = "Withdraw EWallet - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $user_id = $this->session->userdata('user_id');
        $relation = array(
                    "fields" => "ewallet, ewallet_usd",
                    'conditions' => "user_id = " . $user_id
                );
        $user_secArray = $this->userSecondary_m->get_relation('', $relation, false)[0];
        $this->data['total_ewallet'] = $user_secArray['ewallet'];
        $this->data['total_ewallet_usd'] = $user_secArray['ewallet_usd'];
        $this->data['subview'] = 'member/withdraw_usd/index';
        $this->data['script'] = 'member/withdraw_usd/script';
        $this->load->view('_layout_main', $this->data);
	}

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'withdraw_amount',
                    2 => 'received_amount',
                    4 => 'is_withdraw',
                    3 => 'withdraw_date'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id') . " AND type = 'GHS'"
        );
        $totalData = $this->withdrawalRequest_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all($limit,$start,$order,$dir, 'GHS');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search($limit,$start,$search,$order,$dir,'GHS');
            $totalFiltered = $this->withdrawalRequest_m->search_count($search, 'GHS');
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

    public function usd_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'withdraw_amount',
                    2 => 'received_amount',
                    4 => 'is_withdraw',
                    3 => 'withdraw_date'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id'). " AND type = 'USD'"
        );
        $totalData = $this->withdrawalRequest_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->withdrawalRequest_m->all($limit,$start,$order,$dir,'USD');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->withdrawalRequest_m->search($limit,$start,$search,$order,$dir,'USD');
            $totalFiltered = $this->withdrawalRequest_m->search_count($search,'USD');
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
        $wallet = $withArray->withdraw_amount + $secDetails[0]['ewallet'];
        if ($id)
        {
            $sql = "UPDATE crm_withdrawal_request SET is_withdraw = 'cancel' where id = $id";
            $result = $this->db->query($sql);
            $sql1 = "UPDATE crm_users_secondary SET ewallet = $wallet where user_id = $withArray->user_id";
            $result1 = $this->db->query($sql1);
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

    public function add()
    {
        $user_id = $this->session->userdata('user_id');
        $relation = array(
        "fields" => "*",
        'conditions' => " user_id = ".$user_id
        );
        $secDetails = $this->userSecondary_m->get_relation('', $relation, false);
        $sql = "SELECT * FROM crm_withdrawal_request WHERE user_id = $user_id AND created BETWEEN '".date('Y-m-d 00:00:00')."' AND '".date('Y-m-d 23:59:59')."'";
        $record_found =  $this->db->query($sql)->num_rows();
        $userDetails = $this->user_m->get($user_id);
        if ($record_found <= 0)
        {
            if ($userDetails->is_eproduct_plan == '0')
            {
                $this->session->set_flashdata("error","You have not activated eProduct Plan yet. Please activate the eProduct plan and get back to withdraw amount. Enjoy!");
            }
            else
            {
                $ewllaet = $this->input->post('type') == 'USD' ? $secDetails[0]['ewallet_usd'] : $secDetails[0]['ewallet'] ;
                if ($this->input->post('requested_amount') <= $ewllaet)
                {
                    $withdrawArry['withdraw_amount'] = $this->input->post('requested_amount');
                    $fees = $this->setting_m->get();
                    $percentage = $fees[0]->withdraw_fees;
                    $withdrawArry['received_amount'] = $this->input->post('requested_amount') - ($this->input->post('requested_amount') * $percentage ) / 100 ;
                    $withdrawArry['user_id'] = $this->session->userdata('user_id');
                    $withdrawArry['withdraw_date'] = date('Y-m-d H:i:s');
                    $withdrawArry['address'] = $this->input->post('type') == 'USD' ? $this->input->post('address') : '' ;
                    $withdrawArry['type'] = $this->input->post('type') == 'USD' ? 'USD' : 'GHS' ;
                    $id = $this->withdrawalRequest_m->save($withdrawArry);
                    if ($this->input->post('type') == 'USD')
                    {
                        $wallet = $secDetails[0]['ewallet_usd'] - $this->input->post('requested_amount');
                        $sql = "UPDATE crm_users_secondary SET ewallet_usd = $wallet where user_id = $user_id";
                    }
                    else{
                        $wallet = $secDetails[0]['ewallet'] - $this->input->post('requested_amount');
                        $sql = "UPDATE crm_users_secondary SET ewallet = $wallet where user_id = $user_id";
                    }
                    $iid = $this->db->query($sql);
                    if ($id)
                    {
                        $this->session->set_flashdata("success","You have successfully place the withdrawal request. Admin will transfer amount to you account soon. Enjoy!");
                    }
                    else
                    {
                        $this->session->set_flashdata("error","Please try again later!!!");
                    }
                }
                else
                {
                    $this->session->set_flashdata("error","You don't have that much money to withdraw. Please try with lesser amount than eWallet amount");
                }
            }
        }
        else
        {
            $this->session->set_flashdata("error","You can make withdrawal request once a day. See you tommorrow!");
        }
        
        redirect('withdraw');
    }

    // public function getTimeCheck($timeZone)
    // {
    //     date_default_timezone_set($timeZone);// $timeZone = "Asia/Kolkata";
    //     $today = date('Y-m-d H:i:s');
    //     $day = date('D', strtotime($today));
    //     $flag = true;
    //     if($day == "Fri") {
    //         $flag = "true";
    //     }else{
    //         $flag = "false";
    //     }
    //     date_default_timezone_set('Africa/Accra');
    //     return $flag;
    // }

}