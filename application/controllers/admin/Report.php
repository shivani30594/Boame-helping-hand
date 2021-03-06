<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('report_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/report/index';
        $this->data['script'] = 'admin/report/script';
        $this->load->view('admin_layout_main', $this->data);
    }

     public function indexjson()
    {
        $columns = array( 
                    0 => 'ru.id', 
                    1 => 'pm.first_name',
                    2 => 'pmm.last_name',
                    3 => 'ru.report_comment',
                    4 => 'ru.transaction_id',
                    5 => 'ru.created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->report_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->report_m->all($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->report_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->report_m->search_count($search);
        }
        $data = array();
        if(!empty($newss))
        {
            foreach ($newss as $news)
            {
                $data[] = $news;
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
