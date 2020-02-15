<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('userSecondary_m');
        $this->load->model('withdrawalRequest_m');
        $this->load->model('resource_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/resource/index';
        $this->data['script'] = 'admin/resource/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'type',
                    2 => 'document_title',
                    3 => 'document_path',
                    4 => 'Action'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->resource_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->resource_m->all($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->resource_m->search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->resource_m->search_count($search);
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

    public function edit($id = '')
    {
        if ($id)
        {
            $this->data['resource_details'] = $this->resource_m->get($id);
            $this->data['edit'] = true;
        }
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/resource/add';
        $this->data['script'] = 'admin/resource/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function add_resource()
    {
        $resourc_array['document_title'] = $this->input->post('document_title');
        $resourc_array['type'] = $this->input->post('resource_type');
        if (!empty($_FILES['document']['name'])) 
        {
            $doucmentname = $resourc_array['type'].'_' . time() .'_'. preg_replace('/[^A-Za-z0-9\-\.]/',"",str_replace(' ', '-', $_FILES['document']['name']));
            $config['upload_path'] = 'assets/resource/'.$resourc_array['type'].'/';
            if ($resourc_array['type'] == 'banner')
            {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
            }
            else if ($resourc_array['type'] == 'pdf')
            {
                $config['allowed_types'] = 'pdf';
            }
            else if ($resourc_array['type'] == 'ppt')
            {
                $config['allowed_types'] = 'ppt|pptx';
            }
            else if ($resourc_array['type'] == 'video')
            {
                $config['allowed_types'] = 'mp4|wmv|avi|3gp';
            }
            else if ($resourc_array['type'] == 'html')
            {
                $config['allowed_types'] = 'html';
            }
            $config['file_name'] = $doucmentname;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('document')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error',$error['error']);
                redirect('admin/resource');
                exit;
            } else {
                $data = $this->upload->data();
                $resourc_array['document_path'] = $doucmentname;
            }
        } 
        $result = $this->resource_m->save($resourc_array);
        if ($result)
        {
            $this->session->set_flashdata('success', 'Resource details are added successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/resource');
        exit;
    }

    public function edit_resource()
    {
        $resourc_array['document_title'] = $this->input->post('document_title');
        $resourc_array['type'] = $this->input->post('resource_type');
        $resource_id = $this->input->post('resource_id');
        $resource_document_path = $this->input->post('resource_document_path');
        if (!empty($_FILES['document']['name'])) 
        {
            $doucmentname = $resourc_array['type'].'_' . time() .'_'. preg_replace('/[^A-Za-z0-9\-\.]/',"",str_replace(' ', '-', $_FILES['document']['name']));
            $config['upload_path'] = 'assets/resource/'.$resourc_array['type'].'/';
            if ($resourc_array['type'] == 'banner')
            {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
            }
            else if ($resourc_array['type'] == 'pdf')
            {
                $config['allowed_types'] = 'pdf';
            }
            else if ($resourc_array['type'] == 'ppt')
            {
                $config['allowed_types'] = 'ppt|pptx';
            }
            else if ($resourc_array['type'] == 'video')
            {
                $config['allowed_types'] = 'mp4|wmv|avi|3gp';
            }
            else if ($resourc_array['type'] == 'html')
            {
                $config['allowed_types'] = 'html';
            }
            $config['file_name'] = $doucmentname;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('document')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $resourc_array['document_path'] = $doucmentname;
                unlink('assets/resource/'.$resourc_array['type'].'/'.$resource_document_path);
            }
        } 
        $result = $this->resource_m->save($resourc_array, $resource_id);
        if ($result)
        {
            $this->session->set_flashdata('success', 'Resource details are updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/resource');
        exit;
    }

    public function delete($id = '')
    {
        $id = $this->input->post('resource_id');
        if ($id)
        {
            $resource = $this->resource_m->get($id);
            $document_path = $resource->document_path;
            $type = $resource->type;
            unlink('assets/resource/'.$type.'/'.$document_path);
            $result = $this->resource_m->delete($id);
            if ($result)
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => 'Resource deleted successfully')));
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