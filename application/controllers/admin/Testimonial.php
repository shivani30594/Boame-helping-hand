<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('testimonial_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/testimonials/index';
        $this->data['script'] = 'admin/testimonials/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'image',
                    2 => 'full_name',
                    3 => 'message',
                    5 => 'status',
                    6 => 'action'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->testimonial_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->testimonial_m->alltestimonials($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->testimonial_m->testimonial_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->testimonial_m->testimonial_search_count($search);
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

    public function edit_testimonial()
    {
        $news_array['status'] = $this->input->post('status');
        $news_array['user_id'] = $this->input->post('user_id');
        $news_array['full_name'] = htmlspecialchars_decode($this->input->post('full_name'));
        $news_array['message'] = $this->input->post('message'); 
        $news_id = $this->input->post('testimonial_id');
        $news_image_name = $this->input->post('news_image_name');
        if (!empty($_FILES['image']['name'])) 
        {
            $imagename = 'testimonial_' . time() .'_'. $_FILES['image']['name'];
            $config['upload_path'] = 'assets/testimonials/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $imagename;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $news_array['image'] = $imagename;
                unlink('assets/testimonials/'.$news_image_name);
            }
        } 
        $result = $this->testimonial_m->save($news_array, $news_array['user_id']);
        if ($result)
        {
            $this->session->set_flashdata('success', 'Testimonial details are updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/testimonial');
        exit;
    }

    public function edit($id)
    {
        if(isset($id))
        {
            $this->data['testimonial']  = $this->testimonial_m->get($id);
            $this->data['edit'] = true;
            $this->data['meta_title'] = "BOAME | Admin panel";
            $this->data['subview'] = 'admin/testimonials/edit_testimonial';
            $this->data['script'] = 'admin/testimonials/script';
            $this->load->view('admin_layout_main', $this->data);
        }
    }
    
    public function delete($id = '')
    {
        $id = $this->input->post('test_user_id');
        if ($id)
        {
            $news_image = $this->testimonial_m->get($id)->image;
            unlink('assets/testimonials/'.$news_image);
            $result = $this->testimonial_m->delete($id);
            if ($result)
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => 'Record deleted successfully')));
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
