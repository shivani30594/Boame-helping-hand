<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buy_usd extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('paymentUSD_m');
        $this->load->model('userSecondary_m');
        $this->load->model('setting_m');
        $this->load->library('facebook');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "Buy USD Points - BOAME";
        $this->data['subview'] = 'member/buy_usd/index';
        $this->data['script'] = 'member/buy_usd/script';
        $relation = array(
            "fields" => "*",
            'conditions' => "user_id = " . $this->session->userdata('user_id')
        );
        $userSecondaryArray = $this->userSecondary_m->get_relation('', $relation, false);
        $this->data['usdbpoints'] = $userSecondaryArray[0]['total_bpoints_usd'];
        $this->load->view('_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'amount',
                    1 => 'transaction_id',
                    2 => 'address',
                    3 => 'status',
                    4 => 'purchase_date',
                    5 => 'created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->paymentUSD_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->paymentUSD_m->all($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->paymentUSD_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->paymentUSD_m->search_count($search);
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

    public function request()
    {
        $this->data['meta_title'] = "Buy USD Points - BOAME";
        $this->data['subview'] = 'member/buy_usd/make_request';
        $this->data['script'] = 'member/buy_usd/script';
        $this->load->view('_layout_main', $this->data);
    }

    // public function call_coinpayment_api()
    // {	
    //     $setting_details = $this->setting_m->get('1');
    //     $this->load->library('CoinPayment');
    //     $result = $this->coinpayment->get_address($setting_details->private_key, $setting_details->public_key, $setting_details->ipn_url);
    //     // print_r($result);
    //     // die;
    //     $usd_array['user_id'] = $this->session->userdata("user_id");
    //     $usd_array['amount'] = $result['result']['amount'];
    //     $usd_array['status_url'] = $result['result']['status_url'];
    //     $usd_array['qrcode_url'] = $result['result']['qrcode_url'];
    //     $usd_array['transaction_id'] = $result['result']['txn_id'];
    //     $usd_array['address'] = $result['result']['address'];
    //     $this->paymentUSD_m->save($usd_array);
    //     echo json_encode($result);
    // }

    public function call_coinpayment_api()
    {	
        $usd_array['purchased_amount']  = $this->input->post('purchased_bpoints');
        $setting_details = $this->setting_m->get('1');
        $this->load->library('CoinPayment');
        $result = $this->coinpayment->get_address($setting_details->private_key, $setting_details->public_key, $setting_details->ipn_url, $this->input->post('purchased_bpoints'));
        $usd_array['user_id'] = $this->session->userdata("user_id");
        $usd_array['amount'] = $result['result']['amount'];
        $usd_array['status_url'] = $result['result']['status_url'];
        $usd_array['qrcode_url'] = $result['result']['qrcode_url'];
        $usd_array['transaction_id'] = $result['result']['txn_id'];
        $usd_array['address'] = $result['result']['address'];
        $this->paymentUSD_m->save($usd_array);
        echo json_encode($result);
    }

    public function view($id)
    {
        if (isset($id) && $id != '')
        {
            $this->data['meta_title'] = "Buy USD Points - BOAME";
            $this->data['subview'] = 'member/buy_usd/view';
            $this->data['script'] = 'member/buy_usd/script';
            $this->data['address_detail'] = $this->paymentUSD_m->get($id);
            $this->load->view('_layout_main', $this->data);
        }
    }
}