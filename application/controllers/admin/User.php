<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('CallDemo');
        $this->load->model('admin_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('pledgeHistory_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('userSecondary_m');
        $this->load->model('log_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('purchasedPointHistory_m');
        if ($this->admin_m->loggedin() == FALSE) {
            redirect('admin/security');
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/users/index';
        $this->data['script'] = 'admin/users/script';
        $this->load->view('admin_layout_main', $this->data);
    }

      public function indexjson() 
      {
        $columns = array( 
                    0 => 'id', 
                    1 => 'first_name',
                    2 => 'last_name',
                    3 => 'gender',
                    4 => 'email',
                    5 => 'mtn_mobile_number',
                    6 => 'mtn_mobile_name',
                    7 => 'created',
                    8 => 'Action'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "* , CONCAT(first_name,' ', last_name) as name, email, DATE_FORMAT(created, '%m/%d/%Y') as created",
            "conditions" => "is_active = 'Y' AND is_mobile_verified = 'Y'"
        );
        $totalData = $this->user_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $posts = $this->user_m->allusers($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->user_m->user_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->user_m->user_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $data[] = $post;
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

    public function edit($id)
    {
        if ($id)
        {
            $this->data['meta_title'] = "BOAME | Admin panel";
            $this->data['subview'] = 'admin/users/profile';
            $this->data['script'] = 'admin/users/script';
            $this->data['user_details'] = $this->user_m->get($id);
            $this->load->view('admin_layout_main', $this->data);
        }
    }

    public function edit_profile()
    {
        $profile_array['first_name'] = htmlspecialchars_decode($this->input->post('first_name'));
        $profile_array['last_name'] = htmlspecialchars_decode($this->input->post('last_name'));
        if ($this->input->post('mtn_mobile_number') != '')
        {
            $profile_array['mtn_mobile_number'] = $this->input->post('mtn_mobile_number');
        }
        if ($this->input->post('mtn_mobile_name') != '')
        {
            $profile_array['mtn_mobile_name'] = htmlspecialchars_decode($this->input->post('mtn_mobile_name'));
        }
        $profile_array['gender'] = $this->input->post('gender');
        if ($this->input->post('email') != '')
        {
            $profile_array['email'] = $this->input->post('email');
        }

        $result = $this->user_m->save($profile_array , $this->input->post('user_id'));
        if ($result != '')
        {
            $this->session->set_flashdata('success', 'User details are Updated Succesfully');
        }
        else
        {
            $this->session->set_flashdata('danger', 'Something happens wrong!!');
        }
        redirect("admin/user");
    }

    public function action($id)
    {
       $user_status = $this->user_m->get($id)->is_deleted;
       if ($user_status == 'N')
       {
            $user_detail['is_deleted'] = 'Y';
            $status = 'deactivated';
       }
       else if ($user_status == 'Y')
       {
             $user_detail['is_deleted'] = 'N';
            $status = 'activated';
       }
       $result = $this->user_m->save($user_detail, $id);
        if ($result != '')
        {
            $this->session->set_flashdata('success', 'User '.$status.' Succesfully');
        }
        else
        {
            $this->session->set_flashdata('danger', 'Something happens wrong!!');
        }
        redirect("admin/user");
    }

     public function view_tree($id = '')
    {
        if($id)
        {
            $this->data['meta_title'] = "BOAME | Admin panel";
            $this->data['subview'] = 'admin/users/view_tree';
            $this->data['script'] = 'admin/users/script';
            $current_user_details = $this->user_m->get($id);
            $url = BASE_URL.'admin/user/view_tree/'.$current_user_details->id;
            $ewallet_bpoints_user = $this->find_ewallet_bpoints($current_user_details->id);
            $relation = array(
                    "fields" => "*",
                    'conditions' => "user_id =".$current_user_details->id
                    );
            $ref_user_details = $this->refferalDetails_m->get_relation('', $relation, false);
            if ($current_user_details->parent_user_id != 0)
            {
              
                $relation = array(
                    "fields" => "*",
                    'conditions' => "user_id =".$current_user_details->parent_user_id
                    );
                $ref_parent_details = $this->refferalDetails_m->get_relation('', $relation, false);
                $parent_details = $this->user_m->get($current_user_details->parent_user_id);
                $html = "<ul><li><a><span data-html='true' data-toggle='tooltip' title='Root<br>User Code : ".$ref_user_details[0]['refferal_code']."<br>Parent Code : ".$ref_parent_details[0]['refferal_code']."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."<br>Mobile No :".$current_user_details->mtn_mobile_number."' data-placement='right'>".$ref_user_details[0]['refferal_code']."</span></a>";
            }
            else
            {
                $html = "<ul><li><a><span data-html='true' data-toggle='tooltip' title='Root<br>User Code : ".$ref_user_details[0]['refferal_code']."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."<br>Mobile No :".$current_user_details->mtn_mobile_number."' data-placement='right'>".$current_user_details->mtn_mobile_number."</span></a>";
            }
            $html .= $this->find_records_tree($id);
            $html .= "</li></ul>";
            $this->data['tree'] = $html;
            $this->load->view('admin_layout_main', $this->data);
        }
    }


    public function find_records_tree($parent_id) {
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
            $result = $this->build_tree($parent_id, $cat, $count);
            return $result;
        } else {
            return FALSE;
        }
    }
 
    // Menu builder function, parentId 0 is the root
    public function build_tree($parent, $menu, $count) {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $html .= "<ul>";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $relation = array(
                        "fields" => "*",
                        'conditions' => "user_id =".$menu['items'][$itemId]->id
                        );
                    $ref_user_details = $this->refferalDetails_m->get_relation('', $relation, false);
                    $current_user_details = $this->user_m->get($menu['items'][$itemId]->id);
                    //$ref_user_details = $this->refferalDetails_m->get($menu['items'][$itemId]->id);
                 //   $parent_details = $this->user_m->get($menu['items'][$itemId]->parent_user_id);
                    $relation = array(
                        "fields" => "*",
                        'conditions' => "user_id =".$menu['items'][$itemId]->parent_user_id
                        );
                    $ref_parent_details = $this->refferalDetails_m->get_relation('', $relation, false);
                   // $ref_parent_details = $this->refferalDetails_m->get($menu['items'][$itemId]->parent_user_id);
                    $ewallet_bpoints_user = $this->find_ewallet_bpoints($menu['items'][$itemId]->id);
                    $url = BASE_URL.'admin/user/view_tree/'.$menu['items'][$itemId]->id;
                    $refcode = isset($ref_user_details) && !empty($ref_user_details) ? $ref_user_details[0]['refferal_code'] :'';
                    $parentcode = isset($ref_parent_details) && !empty($ref_parent_details) ? $ref_parent_details[0]['refferal_code']: '';
                    $ewallet = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->ewallet : '';
                    $total_bpoints = isset($ewallet_bpoints_user) && !empty($ewallet_bpoints_user) ? $ewallet_bpoints_user->total_bpoints : '';
                    $mtn = isset($current_user_details) && !empty($current_user_details) ? $current_user_details->mtn_mobile_number : '';
                    $html .= "<li><a href=".$url."><span data-html='true' data-toggle='tooltip' title='Level : ".$count."<br>User Code : ".$refcode."<br>Parent Code : ".$parentcode."<br>e-Wallet : ".$ewallet."<br>bPoints :".$total_bpoints."<br>Mobile No :".$mtn."' data-placement='right'>".$refcode."</span></a></li>";
                }
                if (isset($menu['parents'][$itemId])) {
                    $relation = array(
                        "fields" => "*",
                        'conditions' => "user_id =".$menu['items'][$itemId]->id
                        );
                    $ref_user_details = $this->refferalDetails_m->get_relation('', $relation, false);
                    $relation = array(
                        "fields" => "*",
                        'conditions' => "user_id =".$menu['items'][$itemId]->parent_user_id
                        );
                    $current_user_details = $this->user_m->get($menu['items'][$itemId]->id);

                    $ref_parent_details = $this->refferalDetails_m->get_relation('', $relation, false);
                    $ewallet_bpoints_user = $this->find_ewallet_bpoints($menu['items'][$itemId]->id);
                  //  $parent_details = $this->user_m->get($menu['items'][$itemId]->parent_user_id);
                    $url = BASE_URL.'admin/user/view_tree/'.$menu['items'][$itemId]->id;
                    $html .= "<li><a href=".$url."><span data-html='true' data-toggle='tooltip' title='Level : ".$count."<br>User Code : ".$ref_user_details[0]['refferal_code']."<br>Parent Code : ".$ref_parent_details[0]['refferal_code']."<br>e-Wallet : ".$ewallet_bpoints_user->ewallet."<br>bPoints :".$ewallet_bpoints_user->total_bpoints."<br>Mobile No :".$current_user_details->mtn_mobile_number."' data-placement='right'>" . $ref_user_details[0]['refferal_code'] ."</span></a>";
                    $html .= $this->build_tree($itemId, $menu, $count+1);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }

    public function point_history($user_id = '')
    {
        if ($user_id)
        {
            $this->data['meta_title'] = "BOAME | Admin panel";
            $this->data['subview'] = 'admin/points/index';
            $this->data['script'] = 'admin/points/script';
            $this->data['user_details'] = $this->user_m->get($user_id);
            $relation = array(
                "fields" => "sum(points) as total_referral_bonus",
                'conditions' => "user_id = ". $user_id . " AND type LIKE 'referral_points'"
                );
            $this->data['total_referral_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_referral_bonus'];
            $relation = array(
                "fields" => "sum(points) as total_power_bonus",
                'conditions' => "user_id = ". $user_id . " AND type LIKE 'bonus_points'"
                );
            $this->data['total_power_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_power_bonus'];
            $relation = array(
                "fields" => "sum(points) as total_matching_bonus",
                'conditions' => "user_id = ". $user_id . " AND type LIKE 'matching_points'"
                );
            $this->data['total_matching_bonus'] = $this->ewallet_m->get_relation('', $relation, false)[0]['total_matching_bonus'];
            // $relation = array(
            //     "fields" => "sum(bpoints) as total_purchased_points",
            //     'conditions' => "user_id = ". $user_id ." AND type LIKE 'purchased_points'"
            //     );
            // $total_purchased_points = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_points'];
            // $relation = array(
            //     "fields" => "sum(bpoints) as total_purchased_points",
            //     'conditions' => "user_id = ". $user_id ." AND type LIKE 'admin_points'"
            //     );
            // $admin_points = $this->bonusPointsHistory_m->get_relation('', $relation, false)[0]['total_purchased_points'];
            $query = "SELECT * FROM crm_users_secondary where user_id = $user_id";
            $result = $this->db->query($query)->result_array();
           
            $this->data['total_purchased_points'] =$result[0]['total_bpoints'];
            $this->data['ewallet'] = $this->data['total_matching_bonus'] + $this->data['total_power_bonus'] + $this->data['total_referral_bonus'];
            $this->load->view('admin_layout_main', $this->data);
        }
    }

    public function find_ewallet_bpoints($id)
    {
        $result = $this->userSecondary_m->get($id);
        return $result;
    }

    public function add_points ()
    {
        $userid = $this->input->post('userid');
       // $user_id = '1';
        $points_added = $this->input->post('points_added');
        // add bonus points
        $bonus_point_array = array();
        $bonus_point_array['user_id'] = $userid;
        $bonus_point_array['type'] = 'admin_points';
        $bonus_point_array['bpoints'] = $points_added;
        $this->bonusPointsHistory_m->save($bonus_point_array);
        // add log
        unset($bonus_point_array);
        $bonus_point_array = array();
        $bonus_point_array['user_id'] = $userid;
        $bonus_point_array['type'] = 'admin_points';
        $bonus_point_array['message'] = serialize(
            array( 'from' => $userid, 
                     'to' => $userid,
                'message' => 'Admin' . ' has added GHS' .  $points_added    
                )
            );
        $this->log_m->save($bonus_point_array);
        unset($bonus_point_array);

        $user_details = $this->user_m->get($userid);
        $body = "Congratulations. Admin has added GHS".$points_added." succesfully to your account.";
        $result = $this->calldemo->send_message($user_details->mtn_mobile_number, $body);
       //update the points
        $relation = array(
        "fields" => "*",
        'conditions' => "user_id = '".$userid."'"
        );
        $found_entry = $this->userSecondary_m->get_relation('', $relation, false);
        if ($found_entry > 0)
        {
            $id = $userid;
            $secondary_details['total_bpoints'] = $found_entry[0]['total_bpoints'] + $points_added;
            $id = $this->userSecondary_m->save($secondary_details,$userid);
            if ($id)
            {
                $this->session->set_flashdata('success', 'Points added successfully');
            }
            else {
                $this->session->set_flashdata('danger', 'Please try again later');
            }
            redirect("admin/user/index");
        }
        //
    }

    
}