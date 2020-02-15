<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchased extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->library('CallDemo');
        $this->load->model('purchasedPointHistory_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('log_m');
        $this->load->model('userSecondary_m');
        $this->load->model('ewallet_m');
        $this->load->model('UserPayment_m');

    }

    public function index()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/purchased/index';
        $this->data['script'] = 'admin/purchased/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function cancel_user()
    {
    	$this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/canUser/index';
        $this->data['script'] = 'admin/canUser/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function cancel_admin()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/canAdmin/index';
        $this->data['script'] = 'admin/canAdmin/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function cancel_system()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/canSystem/index';
        $this->data['script'] = 'admin/canSystem/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function completed()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/completed/index';
        $this->data['script'] = 'admin/completed/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function inprogress()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/inprogress/index';
        $this->data['script'] = 'admin/inprogress/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function pending()
    {
        $this->data['meta_title'] = "BOAME | Admin panel";
        $this->data['subview'] = 'admin/pending/index';
        $this->data['script'] = 'admin/pending/script';
        $this->load->view('admin_layout_main', $this->data);
    }

    public function indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "status = 'approved' OR status = 'declined' OR status = 'error' OR status = 'pending'" 
        );
        $totalData = $this->UserPayment_m->get_relation('',$relation,true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->UserPayment_m->all_admin($limit,$start,$order,$dir);
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->UserPayment_m->search_admin($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->UserPayment_m->search_count_admin($search);
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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
    
    public function cancel_user_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'cancel'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'cancel');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'cancel');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'cancel');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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

    public function cancel_admin_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'cancel_admin'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'cancel_admin');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'cancel_admin');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'cancel_admin');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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

    public function cancel_system_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'cancel_system'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'cancel_system');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'cancel_system');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'cancel_system');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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

    public function completed_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'complete'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'complete');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'complete');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'complete');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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

    public function inprogress_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'in-progress'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'in-progress');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'in-progress');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'in-progress');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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

     public function pending_indexjson()
    {
         $columns = array( 
            0 => 'id', 
            1 => 'first_name',
            2 => 'last_name',
            3 => 'amount',
            4 => 'date'
            );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[0];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'pending'"
        );
        $totalData = $this->purchasedPointHistory_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->purchasedPointHistory_m->all_cancel_user($limit,$start,$order,$dir,'pending');
        }
        else 
        {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->purchasedPointHistory_m->search_cancel_user($limit,$start,$search,$order,$dir,'pending');
            $totalFiltered = $this->purchasedPointHistory_m->search_count_cancel_user($search,'pending');
        }
        $data = array();
        if(!empty($pledge_list))
        {
            foreach ($pledge_list as $pledge)
            {
                $data[] = $pledge;
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


    public function delete()
    {
        $id = $this->input->post('purchased_id');
        if ($id)
        {
            //$sql = "UPDATE crm_purchased_point_history SET is_approved = 'cancel' , is_deleted = 'Y' where id = $id";
            $sql = "UPDATE crm_purchased_point_history SET is_approved = 'cancel_admin' , is_deleted = 'Y' where id = $id";
            $result = $this->db->query($sql);
            // send notification
            $purchased_history = $this->purchasedPointHistory_m->get($id);
            $user_details = $this->user_m->get($purchased_history->user_id);
            $admin_notification = "Admin cancelled the purchase point request of ".$user_details->first_name.' '.$user_details->last_name;
            $notification_id = insert_notification_detail('request',"Purchase Point Request Cancellation","Purchase point request has been cancelled by admin for ".$purchased_history->purchased_points."GHS" ,$admin_notification, $user_details->id); // common helper function
            $pay_load_data = set_payload('request', $notification_id, "Purchase point request has been cancelled by admin for ".$purchased_history->purchased_points."GHS");
            if ($user_details->device_type == '0')
            {
                send_push_notification($user_details->device_token, false, $pay_load_data);//library notification
            }
            if ($result)
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => 'Purchase point request deleted successfully')));
            }
            else
            {
               return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }
        }
    }

    public function view($id = '')
    {
    	if($id)
    	{
    		$this->data['meta_title'] = "BOAME | Admin panel";
	        $this->data['subview'] = 'admin/purchased/view';
	        $this->data['script'] = 'admin/purchased/script';
		    $sql = "SELECT usr.id as user_id , pph.sender_name, pph.sender_number, pph.id, usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE pph.id = $id";
	        $query =  $this->db->query($sql);
	        if ($query->num_rows()>0)
	        {
	            $this->data['payment_details'] = $query->result(); 
	        }
	        $this->load->view('admin_layout_main', $this->data);
    	}
    }

    public function confirm_payment($purchased_id = '')
    {
        if ($purchased_id == '' OR $purchased_id == null)
        {
            $purchased_id = $this->input->post('purchased_id');
        }
        $history = $this->purchasedPointHistory_m->get($purchased_id);
        $user_details = $this->user_m->get($history->user_id);
        $body = "Your purchase request for Amount GHS".$history->purchased_points." is confirmed by admin successfully and BPoints are updated successfully";
        //*****************************send notification******************************
        $result = $this->calldemo->send_message($user_details->mtn_mobile_number, $body);
        //******************************Insert purchased point history****************
        $this->purchased_points($user_details, $history->purchased_points);
        //******************************Commision calculation*************************
        $this->power_bonus($user_details->id, $history->purchased_points);
        //***********************************update the status of this request as complete****************
        $this->update($purchased_id);
        //****************************************return to purchased list
        redirect('admin/purchased/inprogress');
    }

    public function purchased_points($user_details, $purchased_points)
    {
        // insert into crm_bonus_points_history, crm_log, crm_purchased_point_history, crm_purchased_transaction_history. Update crm_users_secondary
        // 1. insert into crm_bonus_points_history
        $user_id = $user_details->id;
        $bonus_array['type'] = 'purchased_points';
        $bonus_array['user_id'] = $user_id;
        $bonus_array['bpoints'] = $purchased_points;
        $this->bonusPointsHistory_m->save($bonus_array);
        // 2. insert into crm_log
        $log_array['type'] = 'purchased_points';
        $log_array['user_id'] = $user_id;
        $log_array['message'] = serialize(array(
            "from" => $user_id ,
            "to" => $user_id ,
            "message" => $user_details->first_name . ' '. $user_details->last_name . " has purchased " . $purchased_points ."Points"  
        ));
        $this->log_m->save($log_array);
        //3. purchase point history ===> need to discuss with the android app developer that actually needed this 
        //4. After integrating slaypday API entry made into this table
        //5. Update the bpoints into user_secondary table
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $user_id
            );
        $total_bpoints = $this->userSecondary_m->get_relation('',$relation, false)[0]['total_bpoints'];
        $usersec_ary['user_id'] = $user_id;
        $usersec_ary['total_bpoints'] = $total_bpoints + $purchased_points;
        $this->userSecondary_m->save($usersec_ary, $user_id);
    }

    public function referral_bonus($user_id, $purchased_points)
    {
        $tmp = $user_id;
        $com_perc = array('10','8','5','2','2');
        for ($i=0; $i <count($com_perc) ; $i++) 
        { 
            $parent_user_id = $this->user_m->get($user_id)->parent_user_id;
            if ($parent_user_id == 0)
            {
                break;
            }
            $referral_comm = ($purchased_points * $com_perc[$i]) / 100;
            $relation = array(
                'fields' => '*',
                "conditions" => "user_id = ". $parent_user_id
            );
            $uSecArray = $this->userSecondary_m->get_relation('',$relation, false);
            // $thirty_per = ($referral_comm * 30) / 100;
            // $seventy_per = ($referral_comm * 70) / 100;
            $usersec_ary['user_id'] = $parent_user_id;
            $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $referral_comm;
           // $usersec_ary['total_bpoints'] = $uSecArray[0]['total_bpoints'] + $seventy_per;
            $this->userSecondary_m->save($usersec_ary, $parent_user_id);
            //echo $this->db->last_query();
            //insert record into crm_log
            $detail_ary = $this->get_name($parent_user_id); // method call
            $ary = $this->get_name($tmp);
            $log_array['type'] = 'referral_points';
            $log_array['user_id'] = $parent_user_id;
            $log_array['message'] = serialize(array(
                "from" => $tmp ,
                "to" => $parent_user_id ,
                "message" => $detail_ary['first_name'] .' '. $detail_ary['last_name'] . " has earned GHS" . $referral_comm . ' as a referral commission from the '.$ary['first_name'].' '.$ary['last_name'] 
            ));
            $this->log_m->save($log_array);
            //echo $this->db->last_query();
            //insert into e-wallet-history
            $ewallet_ary['user_id'] = $parent_user_id;
            $ewallet_ary['type'] = 'referral_points';
            $ewallet_ary['points'] = $referral_comm;
            $ewallet_ary['from_whom_user_id'] = $tmp;
            $this->ewallet_m->save($ewallet_ary);
            //echo $this->db->last_query();
            //----------------start- notification
            $user_detail = $this->user_m->get($parent_user_id);
            $user_detail_from = $this->user_m->get($user_id);
            $admin_notification = $user_detail->first_name. ' '. $user_detail->last_name.' earned GHS'.$referral_comm." as a referral commission from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('referral_bonus',"Member's earning","You have earned GHS".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
            $pay_load_data = set_payload('referral_bonus', $notification_id, "You have earned GHS".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name);
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            //echo $this->db->last_query();
            unset($user_detail);
            unset($user_detail_from);
            // end-notification
            //-------------------
            //to give benifit to other levels
            $user_id = $parent_user_id;
        }
    }

    public function power_bonus($user_id, $purchased_points)
    {
        //--------------------------------------------------
        //referral bonus calculation
        //---------------------------------------------------
        $this->referral_bonus($user_id, $purchased_points);
        //--------------------------------------------------
        // power bonus calculation
        //--------------------------------------------------
        $main_user_id = $user_id;
        $user_details_array = $this->user_m->get($user_id);
        $parent_user_id = $user_details_array->parent_user_id;
        $last_user_position = 0;
        $last_given = [];// = false;

        while ($parent_user_id != "" || $parent_user_id != null) 
        {
            $details =  $this->user_m->get($user_id);
            $parent_user_id = $details->parent_user_id;
            $position = $details->position;
            $points_earned = ( $purchased_points * 15 ) / 100;
          /*  echo "\nLast user position : " . $last_user_position . "\n";
            echo "<pre>";
            print_r($details);*/
            if (($position > 2 && $last_user_position < 3 && !in_array("false",$last_given )) || ($last_user_position == 0 && $position > 2)) {
                //Then the current users direct parent is eligible for getting the bonus
                // shivani code start
                $this->call_insert_function($parent_user_id, $purchased_points, 'bonus_points', $points_earned, $main_user_id);
                $this->matching_bonus($parent_user_id, $points_earned);
                // shivani code end
               // echo "\n Give points - " . $parent_user_id . "\n";
                $last_user_position = $position;
                $last_given[] = true;
            } else {
                //Current users direct parent is not eligible for bonus so skip that user with proper flag to check
               // echo "\n No points - " . $parent_user_id . "\n";
                $last_user_position = $position;
                $last_given[] = false;
            }
            $user_id = $parent_user_id;
            if ($parent_user_id == 0) {
                break;
            }
        }
    }

    public function call_insert_function($parent_user_id, $points, $type , $points_earned, $user_id)
    {
       // $user_id = $this->session->userdata('user_id');
        $ary = $this->get_name($user_id);
        // $thirty_per = ($points_earned * 30) / 100;
        // $seventy_per = ($points_earned * 70) / 100;
        // insert into log table
        $detail_arry = $this->user_m->get($parent_user_id); // method call
        $log_array['type'] = $type;
        $log_array['user_id'] = $parent_user_id;
        $log_array['message'] = serialize(array(
            "from" => $user_id ,
            "to" => $parent_user_id,
            "message" => $detail_arry->first_name.' '.$detail_arry->last_name." has earned GHS". $points_earned.' as power bonus from the '. $ary['first_name'].' '. $ary['last_name']
        ));
        $this->log_m->save($log_array);
        //echo $this->db->last_query();
        //insert into ewallet table
        $ewallet_ary['user_id'] = $parent_user_id;
        $ewallet_ary['type'] = $type;
        $ewallet_ary['points'] = $points_earned;
        $ewallet_ary['from_whom_user_id'] = $user_id;
        $this->ewallet_m->save($ewallet_ary);
        //echo $this->db->last_query();
        //insert into notification table
        $user_detail = $this->user_m->get($parent_user_id);
        $user_detail_from = $this->user_m->get($user_id);
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS".$points_earned." as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('power_bonus',"Member's joining","You earned GHS".$points_earned." as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
        $pay_load_data = set_payload('power_bonus', $notification_id, "You earned GHS".$points_earned." as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
        }
        //echo $this->db->last_query();
        // Update the ewallet history
        $relation = array(
        'fields' => '*',
        "conditions" => "user_id = ". $parent_user_id
        );
        $uSecArray = $this->userSecondary_m->get_relation('',$relation, false);
        $usersec_ary['user_id'] = $parent_user_id;
        $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $points_earned;
        $this->userSecondary_m->save($usersec_ary, $parent_user_id);
        //echo $this->db->last_query();
    }

   
    public function matching_bonus($user_id, $matching_bonus)
    {
        // call function to insert the log and update the bpoints and ewallet result.
       $this->trigger_insertion($user_id,'matching_points',$matching_bonus);
    }

    public function get_name($id)
    {
        $ary['parent_user_id'] = $this->user_m->get($id)->parent_user_id;
        $ary['first_name'] = $this->user_m->get($id)->first_name;
        $ary['last_name'] = $this->user_m->get($id)->last_name;
        return $ary;
    }

    public function trigger_insertion($user_id, $type, $points)
    {
        //update total points
        $ary = $this->get_name($user_id);
        // $thirty_per = ($points * 30) / 100;
        // $seventy_per = ($points * 70) / 100;
        $detail_ary = $this->get_name($user_id);
        if ($detail_ary['parent_user_id'] == 0)
        {
            return false;
        }
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $detail_ary['parent_user_id']
        );
        $uSecArray = $this->userSecondary_m->get_relation('',$relation, false);
        $usersec_ary['user_id'] = $detail_ary['parent_user_id'];
        $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $points;
        //$usersec_ary['total_bpoints'] = $uSecArray[0]['total_bpoints'] + $seventy_per;
        $this->userSecondary_m->save($usersec_ary, $detail_ary['parent_user_id']);
        //echo $this->db->last_query();
        //insert record into crm_log
        $detail_arry = $this->get_name($detail_ary['parent_user_id']); // method call
        $log_array['type'] = $type;
        $log_array['user_id'] = $detail_ary['parent_user_id'];
        $log_array['message'] = serialize(array(
            "from" => $user_id,
            "to" => $detail_ary['parent_user_id'] ,
            "message" => $detail_arry['first_name'].' '.$detail_arry['last_name']." has earned GHS". $points.' as matching bonus from the '. $ary['first_name'].' '. $ary['last_name']
        ));
        $this->log_m->save($log_array);
        //echo $this->db->last_query();
        //insert into ewallet
        $ewallet_ary['user_id'] = $detail_ary['parent_user_id'];
        $ewallet_ary['type'] = $type;
        $ewallet_ary['points'] = $points;
        $ewallet_ary['from_whom_user_id'] = $user_id;
        $this->ewallet_m->save($ewallet_ary);
        //echo $this->db->last_query();
           // start notification
        $user_detail = $this->user_m->get($detail_ary['parent_user_id']);
        $user_detail_from = $this->user_m->get($user_id);
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS". $points." as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('matching_bonus',"Member's Earning","You earned GHS". $points." as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification,$detail_ary['parent_user_id']); // common helper function
        $pay_load_data = set_payload('matching_bonus', $notification_id, "You earned GHS". $points." as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
        }
        //echo $this->db->last_query();
        unset($user_detail);
        unset($user_detail_from);
       // end notification
    }

    public function update($purchased_id)
    {
        $sql = "UPDATE crm_purchased_point_history SET is_approved = 'complete' , is_deleted = 'Y' WHERE id = ". $purchased_id;
        $result = $this->db->query($sql);
        if ($result)
        {
            $this->session->set_flashdata('success','Payment request is completed successfully and purchased points are added to users account respectively.');
        }
        else
        {
            $this->session->set_flashdata('error','Please try again later');
        }
    }
}