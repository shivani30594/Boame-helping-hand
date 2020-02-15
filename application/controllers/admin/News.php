<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('news_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/news/index';
        $this->data['script'] = 'admin/news/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'title',
                    2 => 'description',
                    3 => 'image',
                    5 => 'Action'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->news_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $newss = $this->news_m->allnews($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $newss =  $this->news_m->news_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->news_m->news_search_count($search);
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
            $this->data['news_details'] = $this->news_m->get($id);
            $this->data['edit'] = true;
        }
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/news/news';
        $this->data['script'] = 'admin/news/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function edit_news()
    {
        $news_array['title'] = htmlspecialchars_decode($this->input->post('title'));
        $news_array['description'] = $this->input->post('description'); 
        $news_id = $this->input->post('news_id');
        $news_image_name = $this->input->post('news_image_name');
        if (!empty($_FILES['image']['name'])) 
        {
            $imagename = 'news_' . time() .'_'. $_FILES['image']['name'];
            $config['upload_path'] = 'assets/news/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $imagename;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $news_array['image'] = $imagename;
                unlink('assets/news/'.$news_image_name);
            }
        } 
        $result = $this->news_m->save($news_array, $news_id);
        if ($result)
        {
            $this->session->set_flashdata('success', 'News details are updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/news');
        exit;
    }

    public function add_news()
    {
        $news_array['title'] = $this->input->post('title');
        $news_array['description'] = $this->input->post('description');
        /*echo $this->input->post('description');
        die; */
        if (!empty($_FILES['image']['name'])) 
        {
            $imagename = 'news_' . time() .'_'. $_FILES['image']['name'];
            $config['upload_path'] = 'assets/news/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $imagename;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error',$error['error']);
                redirect('admin/news');
                exit;
            } else {
                $data = $this->upload->data();
                $news_array['image'] = $imagename;
            }
        } 
        $result = $this->news_m->save($news_array);
        if ($result)
        {
            $this->session->set_flashdata('success', 'News details are added successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/news');
        exit;
    }

    public function delete($id = '')
    {
        $id = $this->input->post('news_id');
        if ($id)
        {
            $news_image = $this->news_m->get($id)->image;
            unlink('assets/news/'.$news_image);
            $result = $this->news_m->delete($id);
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