<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->load->model('notification_m');
       // $this->load->model('log_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * Display notification on every page load
    */
    public function index()
    {
        $relation = array(
        'fields' => '*',
        "conditions" => "user_id = ". $this->session->userdata('user_id') . " AND is_read = 'N'"
        );
        $notifications = $this->notification_m->get_relation('',$relation, false);
        if (count($notifications) > 0)
        {
            $ids = array_column($notifications, 'id');
            $id_string = implode(',', $ids);
            $sql = "UPDATE crm_notification SET is_read = 'Y' WHERE id IN ($id_string)";
            $this->db->query($sql);
        }
        return $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('notifications' => $notifications)));
    }

    /**
    * When click on the notification then display notification details
    */
    public function ajaxview()
    {
        $post = $this->input->post();
        if($post){
             $type = $post['type'];
             $id = $post['id'];
             $this->data['type'] = $type;
             $this->data['id'] = $id;
             $this->data['title'] = $post['title'];
             $this->data['notification'] = $this->notification_m->get($id);
             $html = $this->load->view('member/notification/ajaxview',$this->data, TRUE);
             return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(array('success' => true, 'html' => $html)));
         }
    }

    /**
    * If click on the dismiss button, then change the status of the notification from unread to read.
    */
    public function check_status()
    {
         $post = $this->input->post();
         if ($post){
            $type = $post['type'];
            $data = array('is_read' => 'Y');
            $this->notification_m->save($data, $post['id']);
            return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(array('success' => true)));
         }
    }
}