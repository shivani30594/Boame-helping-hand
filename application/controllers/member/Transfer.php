<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('CallDemo');
        $this->load->model('setting_m');
        $this->load->model('user_m');
        $this->load->model('log_m');
        $this->load->model('userSecondary_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('TransferHistory_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "Transfer History - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $this->data['subview'] = 'member/transfer/index';
        $this->data['script'] = 'member/transfer/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'first_name',
                    2 => 'transferred_points',
                    3 => 'transfer_date'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->TransferHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->TransferHistory_m->all($limit,$start,$order,$dir);
            // echo $this->db->last_query();
            // die;
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->TransferHistory_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->TransferHistory_m->search_count($search);
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

     public function indexjsondebited()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'first_name',
                    2 => 'transferred_points',
                    3 => 'transfer_date'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "sender_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->TransferHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->TransferHistory_m->all_debited($limit,$start,$order,$dir);
            // echo $this->db->last_query();
            // die;
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->TransferHistory_m->search_debited($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->TransferHistory_m->search_count_debited($search);
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

    public function check_referral_code()
    {
        $relation = array(
        "fields" => "*",
        'conditions' => "user_id = " .$this->session->userdata('user_id')." AND refferal_code = ".$this->input->post('referral_code')
        );
        $secDetails = $this->refferalDetails_m->get_relation('', $relation, true);
        if ($secDetails == 0)
        {
            $sql = "SELECT * FROM crm_refferal_details WHERE refferal_code = ". $this->input->post('referral_code');
            $result = $this->db->query($sql);
            echo json_encode($result->num_rows());
        }
        else
        {
            echo json_encode('2');
        }
    }

    public function add_view()
    {
        $this->data['meta_title'] = "Transfer Points - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $this->data['subview'] = 'member/transfer/add';
        $this->data['script'] = 'member/transfer/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function add()
    {
        $referral_code = $this->input->post('referral_code');
        $points = $this->input->post('points');
        $sql = "SELECT * FROM crm_refferal_details WHERE refferal_code = '". $referral_code."'";
        $result = $this->db->query($sql)->result();
        if (isset($result) AND !empty($result))
        {
            $to_user_id = $result[0]->user_id;
        }
        else
        {
            $this->session->set_flashdata("error","Please enter valid referral code.");
            redirect('transfer');
            
        }
        $from_user_id = $this->session->userdata('user_id');
        $relation = array(
            "fields" => "*",
            'conditions' => " user_id = ".$from_user_id
        );
        $secDetails = $this->userSecondary_m->get_relation('', $relation, false);
        if ($secDetails[0]['total_bpoints'] >= $points)
        {
            // send text message
            $userDetail = $this->user_m->get($to_user_id);
            $body = "You received ".$points." from ".$this->session->userdata('name');
            $number_exists = $this->calldemo->send_message($userDetail->mtn_mobile_number, $body);
            // end sms notification
            if ($number_exists == 'true_number')
            {
                $transferArray['user_id'] = $to_user_id;
                $transferArray['sender_id'] = $from_user_id;
                $transferArray['transfer_date'] = date('Y-m-d H:i:s');
                $transferArray['transferred_points'] = $points;
                $id = $this->TransferHistory_m->save($transferArray);
                if ($id)
                {
                    $this->session->set_flashdata("success","Points are transferred successfully!");
                    //place entry into crm_log table
                    $this->insert_log($to_user_id, $from_user_id, $points);
                    //update the bpoints
                    $this->update_bpoints($to_user_id, $points, 'to');
                    //update bpoint of from (subtraxt)
                    $this->update_bpoints($from_user_id, $points, 'from');
                }
                else
                {
                    $this->session->set_flashdata("error","Please try again later");
                }
            }
            else {
                $this->session->set_flashdata("error","Please try again later");
            }
        }
        else
        {
            $this->session->set_flashdata("error","You dont have enough points to transfer. Please try again!");
            redirect('member/transfer/add_view');
        }
        redirect('transfer');
    }

    public function insert_log($to_id, $from_id, $points)
    {
        $to_details = $this->user_m->get($to_id);
        $from_details = $this->user_m->get($from_id);
        $insertLogArray['user_id'] = $to_id;
        $insertLogArray['message'] = serialize(
            array('to' => $to_id,
             'from' => $from_id,
             'message' => $from_details->first_name.' '.$from_details->last_name .' has transferred '.$points.'bpoints to '. $to_details->first_name.' '.$to_details->last_name));
        $insertLogArray['type'] = 'credited_points';
        $this->log_m->save($insertLogArray);

        $insertLogArray['user_id'] = $from_id;
        $insertLogArray['message'] = serialize(
            array('to' => $from_id,
             'from' => $to_id,
             'message' => $to_details->first_name.' '.$to_details->last_name .' has received '.$points.'bpoints from '. $from_details->first_name.' '.$from_details->last_name));
        $insertLogArray['type'] = 'debited_points';
        $this->log_m->save($insertLogArray);
    }

    public function update_bpoints($user_id, $points, $status)
    {
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $user_id
            );
        $total_bpoints = $this->userSecondary_m->get_relation('',$relation, false)[0]['total_bpoints'];
        if ($status == 'to')
        {
            $secArr['total_bpoints'] = $points + $total_bpoints;
        }
        else
        {
            $secArr['total_bpoints'] =  $total_bpoints - $points;
        }
        return $this->userSecondary_m->save($secArr, $user_id);
    }
}