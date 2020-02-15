<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('resource_m');
        $this->load->library('facebook');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "Resource Management - BOAME";
        $this->data['subview'] = 'member/resource/index';
        $this->data['script'] = 'member/resource/script';
        $this->data['banners'] = $this->resource_m->get_by("type LIKE 'banner'");
        $this->data['videos'] = $this->resource_m->get_by("type LIKE 'video'");
        $this->data['ppts'] = $this->resource_m->get_by("type LIKE 'ppt'");
        $this->data['pdfs'] = $this->resource_m->get_by("type LIKE 'pdf'");
        $this->data['htmls'] = $this->resource_m->get_by("type LIKE 'html'");
        $this->load->view('_layout_main', $this->data);
    }
}
