<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('setting_m');
        $this->load->model('log_m');
        $this->load->model('exchangeHistory_m');
        $this->load->model('userSecondary_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "Exchange eWallet - BOAME";
        $this->data['subview'] = 'member/exchange/index';
        $this->data['script'] = 'member/exchange/script';
        $this->data['userSecondaryArray'] = $this->userSecondary_m->get_by("user_id = ".$this->session->userdata('user_id'))[0];;
        $this->load->view('_layout_main', $this->data);
    }

    public function exchange_ewallet()
    {
        $userSecondaryArray = $this->userSecondary_m->get_by("user_id = ".$this->session->userdata('user_id'))[0];
        $exchangeArray['exchage_amount'] = $this->input->post('amount');
        $exchangeArray['user_id'] = $this->session->userdata('user_id');
        $exchangeArray['type'] = ($this->input->post('type') == 'ghs') ? 'ghs_to_usd' : 'usd_to_ghs';
        if ($this->input->post('type') == 'ghs')
        {
            if (($userSecondaryArray->ewallet - $exchangeArray['exchage_amount']) <= 0)
            {
                $this->session->set_flashdata('error',"Your GHS-ewallet doesn't contains enough points");
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('status'=>200,'error'=>1,'message'=>"Your GHS-ewallet doesn't contains enough points")));
            }
            $exchangeArray['getting_amount'] = $exchangeArray['exchage_amount'] / $this->setting_m->get()[0]->ghs_to_usd;
            $text = "You have exchanged GHS".$exchangeArray['exchage_amount'].' into USD'.$exchangeArray['getting_amount'] ;
        }else if ($this->input->post('type') == 'usd')
        {
            if (($userSecondaryArray->ewallet_usd - $exchangeArray['exchage_amount']) <= 0)
            {
                $this->session->set_flashdata('error',"Your USD-ewallet doesn't contains enough points");
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('status'=>200,'error'=>1,'message'=>"Your USD-ewallet doesn't contains enough points")));
            }
            $exchangeArray['getting_amount'] = $exchangeArray['exchage_amount'] * $this->setting_m->get()[0]->usd_to_ghs;
            $text = "You have exchanged USD".$exchangeArray['exchage_amount'].' into GHS'.$exchangeArray['getting_amount'] ;
        }
        $result = $this->exchangeHistory_m->save($exchangeArray);
        if ($result)
        {
            $this->session->set_flashdata('success','Ewallet points are exchanged successfully');
            if ($this->input->post('type') == 'ghs')
            {
                $uSecArray['ewallet'] = $userSecondaryArray->ewallet - $exchangeArray['exchage_amount'];
                $uSecArray['ewallet_usd'] = $userSecondaryArray->ewallet_usd + $exchangeArray['getting_amount'];
            }
            else {
                $uSecArray['ewallet'] = $userSecondaryArray->ewallet + $exchangeArray['getting_amount'];
                $uSecArray['ewallet_usd'] = $userSecondaryArray->ewallet_usd - $exchangeArray['exchage_amount'];
            }
            $this->userSecondary_m->save($uSecArray, $this->session->userdata('user_id'));
            // insert into log table
            $logArray = array();
            $logArray['user_id'] = $this->session->userdata('user_id');
            $logArray['type'] = ( $this->input->post('type') == 'ghs' ) ? 'exchangeto_usd' : 'exchangeto_ghs';
            $logArray['message'] = serialize(
                array('from'=>$this->session->userdata('user_id'),
                    'to'=>$this->session->userdata('user_id') ,
                    'message'=> $text)
            );
            $this->log_m->save($logArray);
            return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('status'=>200,'error'=>0,'message'=>"Ewallet points are exchanged successfully")));
        }
        else{
            $this->session->set_flashdata('error','Something happens worng!');
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('status'=>200,'error'=>1,'message'=>"Something happens worng!")));
        }
    }

    public function exchange_history()
    {
        $this->data['meta_title'] = "Exchange History - BOAME";
        $this->data['subview'] = 'member/exchange/history';
        $this->data['script'] = 'member/exchange/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function history_indexjason()
    {
        $columns = array( 
            0 => 'id', 
            1 => 'exchage_amount',
            2 => 'getting_amount',
            3 => 'type',
            4 => 'type',
            5 => 'created',
            6 => 'created'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->exchangeHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->exchangeHistory_m->all($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->exchangeHistory_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->exchangeHistory_m->search_count($search);
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