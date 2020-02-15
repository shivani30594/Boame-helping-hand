<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->load->model('notification_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $relation = array(
        'fields' => '*',
        "conditions" => "is_admin_read = 'N'"
        );
        $notifications = $this->notification_m->get_relation('',$relation, false);
        if (count($notifications) > 0)
        {
            $ids = array_column($notifications, 'id');
            $id_string = implode(',', $ids);
            $sql = "UPDATE crm_notification SET is_admin_read = 'Y' WHERE id IN ($id_string)";
            $this->db->query($sql);
        }
        return $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('notifications' => $notifications)));
    }

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
             $html = $this->load->view('admin/notification/ajaxview',$this->data, TRUE);
             return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(array('success' => true, 'html' => $html)));
         }
    }

    public function check_status()
    {
         $post = $this->input->post();
         if ($post){
            $type = $post['type'];
            $data = array('is_admin_read' => 'Y');
            $this->notification_m->save($data, $post['id']);
            return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(array('success' => true)));
         }
     }
}