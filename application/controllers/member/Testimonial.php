<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('testimonial_m');
        $this->load->model('user_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
	{
		$this->data['meta_title'] = "Testimonial - BOAME";
		$this->data['logout_url'] = $this->facebook->logout_url();
		$this->data['subview'] = 'member/testimonials/index';
        $this->data['script'] = 'member/testimonials/script';
        $this->data['testimonial'] = $this->testimonial_m->get($this->session->userdata('user_id'));
        if ( $this->data['testimonial'])
        {
            $this->data['edit'] = true;
        }
		$this->load->view('_layout_main', $this->data);
    }

    public function edit_testimonial()
    {
        $news_array['user_id'] = $this->session->userdata('user_id');
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
        redirect('testimonial');
        exit;
    }

    public function add_testimonial()
    {
        $news_array['user_id'] = $this->session->userdata('user_id');
        $news_array['full_name'] = $this->input->post('full_name');
        $news_array['message'] = $this->input->post('message');
        /*echo $this->input->post('description');
        die; */
        if (!empty($_FILES['image']['name'])) 
        {
            $imagename = 'testimonial_' . time() .'_'. $_FILES['image']['name'];
            $config['upload_path'] = 'assets/testimonials/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $imagename;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error',$error['error']);
                redirect('testimonial');
                exit;
            } else {
                $data = $this->upload->data();
                $news_array['image'] = $imagename;
            }
        } 
        $result = $this->db->insert('crm_testimonial',$news_array);
        if ($result)
        {
            $this->session->set_flashdata('success', 'Testimonial details are added successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('testimonial');
        exit;
    }
}