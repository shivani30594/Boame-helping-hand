<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->model('log_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/allpoints/index';
        $this->data['script'] = 'admin/allpoints/script';
        $this->load->view('admin_layout_main', $this->data);
    }

      public function indexjson() 
      {

        $columns = array( 
                    0 => 'id', 
                    1 => 'type',
                    2 => 'message',
                    3 => 'created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = count($this->log_m->get());

        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $posts = $this->log_m->all($limit,$start,$order,$dir);
            //echo $this->db->last_query();
           /* print_r($posts);
            die;*/
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->log_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->log_m->search_count($search);
        }
        /*print_r($post);
        die;*/
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                 $data[] = array(
                    'id' => $post->id , 
                    'message' => unserialize($post->message)['message'], 
                    'type' => $post->type, 
                    'created' => $post->created );
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