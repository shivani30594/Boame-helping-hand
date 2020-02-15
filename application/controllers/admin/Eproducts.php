<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eproducts extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('eproduct_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

	public function index()
	{
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/eProducts/index';
        $this->data['script'] = 'admin/eProducts/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array( 
                    0 => 'product_name',
                    1 => 'product_type',
                    2 => 'download_link',
                    3 => 'Action'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*"
        );
        $totalData = $this->eproduct_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $products = $this->eproduct_m->allproducts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $products =  $this->eproduct_m->product_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->eproduct_m->product_search_count($search);
        }
        $data = array();
        if(!empty($products))
        {
            foreach ($products as $product)
            {
                $data[] = $product;
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
//
    public function edit($id = '')
    {
        if ($id)
        {
            $this->data['product_details'] = $this->eproduct_m->get($id);
            $this->data['edit'] = true;
        }
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/eProducts/products';
        $this->data['script'] = 'admin/eProducts/script';
        $this->load->view('admin_layout_main', $this->data);
    }
//
    public function edit_product()
    {
        $product_array['product_name'] = $this->input->post('product_name');
        $product_array['product_type'] = $this->input->post('product_type');
        $product_array['download_link'] = $this->input->post('download_link'); 
        $product_id = $this->input->post('product_id');
       
         
        $result = $this->eproduct_m->save($product_array, $product_id);
        if ($result)
        {
            $this->session->set_flashdata('success', 'Product details are updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/Eproducts');
        exit;
    }
//
    public function add_product()
    {
        $product_array['product_name'] = $this->input->post('product_name');
        $product_array['product_type'] = $this->input->post('product_type');
        $product_array['download_link'] = $this->input->post('download_link');
        $product_array['created_at'] = date("Y-m-d h:i:s");
        $result = $this->eproduct_m->save($product_array);
        if ($result)
        {
            $this->session->set_flashdata('success', 'eProduct details are added successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something happens wrong!');
        }
        redirect('admin/Eproducts');
        exit;
    }
//
    public function delete($id = '')
    {
        $id = $this->input->post('product_id');
        if ($id)
        {
            $result = $this->eproduct_m->delete($id);
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