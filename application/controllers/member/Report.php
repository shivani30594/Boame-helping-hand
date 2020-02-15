<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('ewallet_m');
        $this->load->model('user_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
    	$this->data['meta_title'] = "Commission Report - BOAME";
        $this->data['subview'] = 'member/report/index';
        $this->data['script'] = 'member/report/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function indexjson()
    {
    	$columns = array( 
                    0 => 'id', 
                    1 => 'type',
                    2 => 'from_whom_user_id',
                    3 => 'points',
                    4 => 'created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
      /*  echo $dir;
        echo $order;
        die;*/
       // echo $this->db->last_query();
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->ewallet_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->ewallet_m->all($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->ewallet_m->ewallet_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ewallet_m->ewallet_search_count($search);
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

    public function joining()
    {
        $this->data['meta_title'] = "Joining Report - BOAME";
        $this->data['subview'] = 'member/join_report/index';
        $this->data['script'] = 'member/join_report/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function joingindexjson()
    {
        $columns = array( 
                    0 => 'id',
                    1 => 'last_name', 
                    2 => 'first_name',
                    3 => 'gender',
                    4 => 'email',
                    5 => 'is_active',
                    6 => 'created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "parent_user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->user_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = allRecords($limit,$start,$order,$dir,'crm_users_primary','parent_user_id',$this->session->userdata('user_id'));
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  record_search($limit,$start,$search,$order,$dir,'crm_users_primary',$columns,'parent_user_id',$this->session->userdata('user_id'));
            $totalFiltered = record_search_count($search,'crm_users_primary',$columns,'parent_user_id',$this->session->userdata('user_id'));
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
