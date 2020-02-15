<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('refferalDetails_m');
        $this->load->model('purchasedPointHistory_m');
        $this->load->model('UserPayment_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
	{
		$this->data['meta_title'] = "Store - BOAME";
		$this->data['logout_url'] = $this->facebook->logout_url();
		$this->data['subview'] = 'member/store/index';
        $this->data['script'] = 'member/store/script';
       
		$this->load->view('_layout_main', $this->data);
	}

    public function indexjson()
    {
        $columns = array( 
                    0 => 'amount',
                    1 => 'status',
                    2 => 'created_at'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->UserPayment_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->UserPayment_m->all($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->UserPayment_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->UserPayment_m->search_count($search);
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

    public function place_purchase_request($value='')
    {
        $this->data['meta_title'] = "Store - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $this->data['subview'] = 'member/store/instruction';
        $this->data['script'] = 'member/store/script';
        $pucrhasedArr['purchased_points'] = $this->input->post('amount_to_be_purchased');
        $pucrhasedArr['user_id'] = $this->session->userdata('user_id');
        $pucrhasedArr['purchased_date'] = date('Y-m-d H:i:s');
        $result = $this->purchasedPointHistory_m->save($pucrhasedArr);
        if ($result)
        {
            $this->session->set_flashdata('success','Payment request is sent to admin successfully. Below are the payment instruction');
        }
        else
        {
            $this->session->set_flashdata('error','Please try again later');
        }
        $this->data['instruction'] = $this->db->query('SELECT * FROM crm_payment_instruction LIMIT 1')->row()->payment_instructions;
        $this->load->view('_layout_main', $this->data);
    }

    public function make_request($value='')
    {
        $this->data['meta_title'] = "Store - BOAME";
        $this->data['logout_url'] = $this->facebook->logout_url();
        $this->data['subview'] = 'member/store/make_request';
        $this->data['script'] = 'member/store/script';
        $relation = array(
        "fields" => "refferal_code",
        'conditions' => "user_id = ". $this->session->userdata('user_id')
        );
        $this->data['refferal_code'] = $this->refferalDetails_m->get_relation('', $relation, false)[0]['refferal_code'];
        $this->load->view('_layout_main', $this->data);
    }

    public function confirm_payment($id = '')
    {
        if ($id)
        {
            $this->data['meta_title'] = "Purchase Point - BOAME";
            $this->data['logout_url'] = $this->facebook->logout_url();
            $this->data['subview'] = 'member/store/confirm_payment';
            $this->data['script'] = 'member/store/script';
            $this->data['purchased_id'] = $id;
            $this->data['purchased_array'] = $this->purchasedPointHistory_m->get($id);
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function update()
    {
        $purchased_id = $this->input->post('purchased_id');
        $purchasedArr['transaction_id'] = $this->input->post('transaction_id');
        $purchasedArr['purchased_points'] = $this->input->post('sent_amount');
        $purchasedArr['sender_name'] = $this->input->post('sender_name');
        $purchasedArr['sender_number'] = $this->input->post('sender_number');
        $purchasedArr['is_approved'] = 'in-progress';
        $result = $this->purchasedPointHistory_m->save($purchasedArr, $purchased_id);
       /* echo $this->db->last_query();
        die;*/
        if ($result)
        {
            $this->session->set_flashdata('success','Payment details are sent to admin successfully');
        }
        else
        {
            $this->session->set_flashdata('error','Please try again later');
        }
        redirect('purchased');
    }

    public function delete()
    {
        $id = $this->input->post('purchased_id');
        if ($id)
        {
            $sql = "UPDATE crm_purchased_point_history SET is_approved = 'cancel' , is_deleted = 'Y' where id = $id";
            $result = $this->db->query($sql);
            // send notification
            if ($result)
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => 'Purchase point request deleted successfully')));
            }
            else
            {
               return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }
        }
    }
}