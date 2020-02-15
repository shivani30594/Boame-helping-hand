<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('pledgeHistory_m');
        $this->load->model('TransferHistory_m');
        $this->load->model('userSecondary_m');
        $this->load->model('log_m');

        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/transfer/index';
        $this->data['script'] = 'admin/transfer/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function index_usd()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/transfer_usd/index';
        $this->data['script'] = 'admin/transfer_usd/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson_ghs()
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
        $totalData = count($this->log_m->get_by('type IN ("credited_points","debited_points")'));
        // print_r( $totalData );
        // die;
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->TransferHistory_m->all_a($limit,$start,$order,$dir,'credited_points','debited_points');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->TransferHistory_m->search_debited_a($limit,$start,$search,$order,$dir,'credited_points','debited_points');
            $totalFiltered = $this->TransferHistory_m->search_count_debited_a($search,'credited_points','debited_points');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = array(
                	'id' => $pledge->id , 
                	'message' => unserialize($pledge->message)['message'], 
                	'type' => $pledge->type, 
                	'created' => $pledge->created );
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

    public function indexjson_usd()
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
        $totalData = count($this->log_m->get_by('type IN ("credited_points_usd","debited_points_usd")'));
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->TransferHistory_m->all_a($limit,$start,$order,$dir,'credited_points_usd','debited_points_usd');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->TransferHistory_m->search_debited_a($limit,$start,$search,$order,$dir,'credited_points_usd','debited_points_usd');
            $totalFiltered = $this->TransferHistory_m->search_count_debited_a($search,'credited_points_usd','debited_points_usd');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = array(
                	'id' => $pledge->id , 
                	'message' => unserialize($pledge->message)['message'], 
                	'type' => $pledge->type, 
                	'created' => $pledge->created );
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