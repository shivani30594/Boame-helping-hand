<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('contactUs_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
    	$this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/contact_us/index';
        $this->data['script'] = 'admin/contact_us/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
    	 $columns = array( 
                    0 => 'id', 
                    1 => 'name',
                    2 => 'email',
                    3 => 'subject',
                    4 => 'message',
                    5 => 'created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->contactUs_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->contactUs_m->all_inquirues($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->contactUs_m->inquiry_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->contactUs_m->inquiry_search_count($search);
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