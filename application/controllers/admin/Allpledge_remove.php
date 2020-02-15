<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allpledge extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('CallDemo');
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('pledgeHistory_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('userSecondary_m');
        $this->load->model('log_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('WantsToDonateQueue_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/allpledge/index';
        $this->data['script'] = 'admin/allpledge/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson() 
    {
        $columns = array( 
                    0 => 'id', 
                    3 => 'wdq.pledge_title',
                    2 => 'pm.pledge_type',
                    1 => 'up.first_name',
                    4 => 'wdq.pledge_date',
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N'"
        );
        $totalData = $this->WantsToDonateQueue_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $posts = $this->WantsToDonateQueue_m->allpledge_a($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->WantsToDonateQueue_m->pledge_searc_a($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->WantsToDonateQueue_m->pledge_search_count_a($search);
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $data[] = $post;
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

    public function confirm_payment($id = '')
    {
        if ($id)
        {
            $sql_2 = "UPDATE crm_wants_to_donate_queue set is_confirmed = 'Y' , is_active = 'Y' where id = ".$id;
            $result_2 = $this->db->query($sql_2);
               // send push notification for the owner
            $pledgArray = $this->WantsToDonateQueue_m->get($id);
            $userArr = $this->user_m->get($pledgArray->user_id);
            $admin_notification = "Admin just declared ".$userArr->first_name.' '.$userArr->last_name." as a paid member for the pledge. Now, ".$userArr->first_name.' '.$userArr->last_name." are able to get GHS100 from two users within 8 days.";
            $notification_id = insert_notification_detail('pledge',"Members received donation","Admin just declared you as a paid member for the pledge. Now, you are able to get GHS100 from two users within 8 days." ,$admin_notification, $userArr->id); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "Admin just declared you as a paid member for the pledge. Now, you are able to get GHS100 from two users within 8 days.");
            if ($userArr->device_type == '0')
            {
                send_push_notification($userArr->device_token, false, $pay_load_data);//library notification
            }
            unset($userArr);
            if ($result_2)
            {
                $this->session->set_flashdata('success','Payment confirmation is done successfully.');
            }
            else
            {
                $this->session->set_flashdata('danger','Please try again later.');
            }
            redirect("admin/allpledge");
        }
    }
}