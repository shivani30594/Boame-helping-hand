<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buy_usd extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('paymentUSD_m');
        $this->load->model('admin_m');
        $this->load->model('user_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }
    
	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/buy_usd/index';
        $this->data['script'] = 'admin/buy_usd/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->paymentUSD_m->get_relation('',$relation,true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->paymentUSD_m->all_admin($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->paymentUSD_m->search_admin($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->paymentUSD_m->search_count_admin($search);
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

    public function view($id)
    {
        if (isset($id) && $id != '')
        {
            $this->data['meta_title'] = "Buy USD Points - BOAME";
            $this->data['subview'] = 'member/buy_usd/view';
            $this->data['script'] = 'member/buy_usd/script';
            $this->data['address_detail'] = $this->paymentUSD_m->get($id);
            $this->load->view('admin_layout_main', $this->data);
        }
    }
}
