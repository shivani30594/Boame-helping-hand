<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tree_list extends MY_Controller {

	 public function __construct() {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('userSecondary_m');
        $this->load->model('refferalDetails_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * To display downline of users with e-Wallet details
    */
    public function index($id = '')
    {
        $this->data['meta_title'] = "Tree-view - BOAME";
        $this->data['subview'] = 'member/tree-list/index';
        $this->data['script'] = 'member/tree-list/script';
        $current_user_details = $this->user_m->get($this->session->userdata('user_id'));
        $url = BASE_URL.'member/tree_list/index/'.$current_user_details->id;
        $ewallet_bpoints_user = $this->find_ewallet_bpoints($current_user_details->id);
        if ($current_user_details->parent_user_id != 0)
        {
            $parent_details = $this->user_m->get($current_user_details->parent_user_id);
            $html = "<ul><li><a><span data-html='true' style='line-height:35px' data-toggle='tooltip' title='Root<br>Name : ".$current_user_details->first_name.' '. $current_user_details->last_name."<br>Parent Name : ".$parent_details->first_name.' '.$parent_details->last_name."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."<br>Mobile No :".$current_user_details->mtn_mobile_number."' data-placement='right'>".$current_user_details->first_name.' '. $current_user_details->last_name."</span></a>";
        }
        else
        {
            $html = "<ul><li><a><span data-html='true'  style='line-height:35px' data-toggle='tooltip' title='Root<br>Name : ".$current_user_details->first_name.' '. $current_user_details->last_name."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."<br>Mobile No :".$current_user_details->mtn_mobile_number."' data-placement='right'>".$current_user_details->first_name.' '. $current_user_details->last_name."</span></a>";
        }
        $html .= $this->find_records_tree($current_user_details->id);
        $html .= "</li></ul>";
        $relation = array(
            "fields" => "*",
            'conditions' => "user_id = ".$this->session->userdata('user_id')
            );
        $array= $this->refferalDetails_m->get_relation('', $relation, false);

        $this->data['count']=isset($array) && !empty($array) ? $array[0]['refferal_count'] : '';
        $this->data['tree'] = $html;
        $this->load->view('_layout_main', $this->data);
    }

    public function find_records_tree($parent_id) 
    {
        $query = $this->db->query("select id, first_name, last_name,parent_user_id from crm_users_primary");
        $cat = array(
            'items' => array(),
            'parents' => array()
        );

        foreach ($query->result() as $cats) {
            $cat['items'][$cats->id] = $cats;
            $cat['parents'][$cats->parent_user_id][] = $cats->id;
        }
        if ($cat) {
        	$count = 0;
            $result = $this->build_tree($parent_id, $cat,$count);
            return $result;
        } else {
            return FALSE;
        }
    }
 
    // Menu builder function, parentId 0 is the root
    public function build_tree($parent, $menu,$count) {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $html .= "<ul>";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                     $ewallet_bpoints_user = $this->find_ewallet_bpoints($menu['items'][$itemId]->id);
                    // $refcode = isset($ref_user_details) && !empty($ref_user_details) ? $ref_user_details[0]['refferal_code'] :'';
                    // $parentcode = isset($ref_parent_details) && !empty($ref_parent_details) ? $ref_parent_details[0]['refferal_code']: '';
                    // $ewallet = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->ewallet : '';
                    // $total_bpoints = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->total_bpoints : '';
                    // $mtn = isset($current_user_details) && !empty($current_user_details) ? $current_user_details->mtn_mobile_number : '';
                    if ($menu['items'][$itemId]->parent_user_id != 0 )
                    {
                        $firstname = isset($menu['items'][$itemId]) && !empty($menu['items'][$itemId]) ? $menu['items'][$itemId]->first_name : '';
                        $lastname = isset($menu['items'][$itemId]) && !empty($menu['items'][$itemId]) ? $menu['items'][$itemId]->last_name : '';
                        $pfirstname = isset($parent_details) && !empty($parent_details) ? $parent_details->first_name :'';
                        $plastname = isset($parent_details) && !empty($parent_details) ? $parent_details->last_name :'';
                        $ewallet = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->ewallet : '';
                        $total_bpoints = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->total_bpoints : '';
                        $parent_details = $this->user_m->get($menu['items'][$itemId]->parent_user_id);
                        $html .= "<li><a><span data-html='true' data-toggle='tooltip' title='Level : ".$count."<br>Name : ".$firstname.' '.$lastname."<br>Parent Name : ".$pfirstname.' '.$plastname."<br>e-Wallet : ".$ewallet."<br>bPoints :".$total_bpoints."' data-placement='right'>" . $firstname .' '. $lastname . "</span></a></li>";
                    }
                    else
                    {
                        $html .= "<li><a><span data-html='true' data-toggle='tooltip' title='Level : ".$count."<br>Name : ".$menu['items'][$itemId]->first_name.' '. $menu['items'][$itemId]->last_name."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."' data-placement='right'>" . $menu['items'][$itemId]->first_name .' '. $menu['items'][$itemId]->last_name . "</span></a></li>";
                    }
                }
                if (isset($menu['parents'][$itemId])) {
                	$ewallet_bpoints_user = $this->find_ewallet_bpoints($menu['items'][$itemId]->id);
                    if ($menu['items'][$itemId]->parent_user_id != 0 )
                    {
                        $parent_details = $this->user_m->get($menu['items'][$itemId]->parent_user_id);
                        $html .= "<li><a><span data-html='true' data-toggle='tooltip' title='Level :".$count."<br>Name : ".$menu['items'][$itemId]->first_name.' '. $menu['items'][$itemId]->last_name."<br>Parent Name : ".$parent_details->first_name.' '.$parent_details->last_name."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."' data-placement='right'>" . $menu['items'][$itemId]->first_name .' '. $menu['items'][$itemId]->last_name. "</span></a>";
                    }
                    else
                    {
                        $html .= "<li><a><span data-html='true' data-toggle='tooltip' title='Level :".$count."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."' data-placement='right'>" . $menu['items'][$itemId]->first_name .' '. $menu['items'][$itemId]->last_name. "</span></a>";
                    }
                    $html .= $this->build_tree($itemId, $menu, $count+1);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }

    /**
    * Find the details of e-wallet and bPoints
    */
    public function find_ewallet_bpoints($id)
    {
        $result = $this->userSecondary_m->get($id);
        return $result;
    }
}