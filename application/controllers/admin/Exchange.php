<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('exchangeHistory_m');
        
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/exchange/index';
        $this->data['script'] = 'admin/exchange/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'usr.first_name',
                    2 => 'pph.exchange_amount',
                    3 => 'pph.getting_amount',
                    4 => 'pph.type',
                    5 => 'pph.type',
                    6 => 'pph.getting_amount',
                    7 => 'pph.created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->exchangeHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->exchangeHistory_m->all_admin($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->exchangeHistory_m->search_admin($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->exchangeHistory_m->search_count_admin($search);
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