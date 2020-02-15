<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pledge extends MY_Controller {

	public function __construct() 
    {
        parent::__construct();
        $this->load->model('pledgeLog_m');
        $this->load->model('WantsToDonateQueue_m');
        $this->load->model('pledgeLog_m');
        $this->load->model('pledgeType_m');
        $this->load->model('donatoresQueue_m');
        $this->load->model('user_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/pledge/index';
        $this->data['script'] = 'admin/pledge/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
            0 => 'pl.id', 
            1 => 'up.first_name',
            2 => 'pm.pledge_type',
            3 => 'wdq.pledge_title',
            4 => 'wdq.pledge_date',
            5 => 'Action'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_active = 'Y' AND is_confirmed = 'N'"
        );
        $totalData = $this->donatoresQueue_m->get_relation('', $relation, true);
        $totalFiltered = ($totalData); 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->pledgeLog_m->allpledge($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->pledgeLog_m->pledge_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->pledgeLog_m->pledge_search_count($search);
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

    public function active_pledge_view($id = '')
    {
        if ($id)
        {
            // id is the donatores queue id
           // $result = $this->pledgeLog_m->get($id);
            $donatores_arry = $this->donatoresQueue_m->get($id);
            $sql = " SELECT pm.pledge_type, wdq.pledge_title,up.first_name, up.last_name, up.picture, wdq.created FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary up on up.id = wdq.user_id  WHERE wdq.id = $donatores_arry->wants_to_donate_id ";
            $this->data['details'] = $this->db->query($sql)->result();
            $sql = "SELECT *, pl.id as pledge_log_id, pl.is_confirmed as confirmed FROM crm_pledge_log pl LEFT JOIN crm_wants_to_donate_queue wdq on wdq.id = pl.wants_to_donate_id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary um on pl.borrower_id = um.id WHERE pl.donetores_queue_id =".$id." AND pl.is_confirmed != 'CANCEL'";
            $this->data['matching_details'] = $this->db->query($sql)->result();
            $this->data['meta_title'] = "BOAME | Admin panel";
            $this->data['subview'] = 'admin/pledge/pledge_detail';
            $this->data['script'] = 'admin/pledge/script';
            $this->load->view('admin_layout_main', $this->data);
        }
    }

    public function confim_payment_of_pledge($id = '')
    {
        if ($id)
        {
            $pledge_array = $this->pledgeLog_m->get($id);
            $wants_to_donate_id = $pledge_array->wants_to_donate_id;
            //
            $sql_1 = "UPDATE crm_pledge_log set is_confirmed = 'Y' where id = ".$id;
            $result_1 = $this->db->query($sql_1);
            $sql_2 = "UPDATE crm_wants_to_donate_queue set is_confirmed = 'Y',  is_active = 'Y' where id = ".$wants_to_donate_id;
            $result_2 = $this->db->query($sql_2);
            $relation = array(
                'fields' => '*',
                "conditions" => "wants_to_donate_id = ". $wants_to_donate_id
            );
            $result = $this->pledgeLog_m->get_relation('', $relation, false);
            $relation = array(
                'fields' => '*',
                "conditions" => "donetores_queue_id = ". $result[0]['donetores_queue_id']. " AND is_confirmed = 'Y'"
            );
            $resultt = $this->pledgeLog_m->get_relation('', $relation, false);
            if (count($resultt) == 2)
            {
                $sql_2 = "UPDATE crm_donetores_queue set is_confirmed = 'Y', is_deleted = 'Y' where id = ".$result[0]['donetores_queue_id'];
                $result_2 = $this->db->query($sql_2);
            }
            if ($result_1 AND $result_2)
            {
                $this->session->set_flashdata('success','Payment confirmation is done successfully.');
            }
            else
            {
                $this->session->set_flashdata('danger','Please try again later.');
            }
            // send push notification for the owner
            $user_detail = $this->user_m->get($result[0]['investor_id']);
            $user_detail_to = $this->user_m->get($result[0]['borrower_id']);
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name;
            $notification_id = insert_notification_detail('pledge',"Members received donation","You just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name ,$admin_notification, $result[0]['investor_id']); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "You just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            unset($user_detail_to);
            // send push notification to opposite party
            $user_detail = $this->user_m->get($result[0]['borrower_id']);
            $user_detail_to = $this->user_m->get($result[0]['investor_id']);
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name;
            $notification_id = insert_notification_detail('pledge',"Member's pledge","You just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name , $admin_notification,$result[0]['borrower_id']); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "You just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            unset($user_detail_to);
            redirect('admin/pledge/index');
            //
        }
    }
}
