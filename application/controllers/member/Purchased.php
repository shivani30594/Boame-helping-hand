<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchased extends MY_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        $this->load->model('userSecondary_m');
        $this->load->model('bonusPointsHistory_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function purchased_points()
    {
        $user_id = $this->session->userdata('user_id');
        $purchased_points = $this->input->post('purchased_input');
        // insert into crm_bonus_points_history, crm_log, crm_purchased_point_history, crm_purchased_transaction_history. Update crm_users_secondary
        // 1. insert into crm_bonus_points_history
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
            "message" => $this->session->userdata('name') . " has purchased GHS" . $purchased_points  
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
        //power bonus call itself call to two other functions
        $this->power_bonus($user_id, $purchased_points);
        // redirect to the ewallet page
        redirect('member/ewallet');
    }

    public function referral_bonus($user_id, $purchased_points)
    {
        $com_perc = array('10','8','4','2','2');
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
            $ewallet = $this->userSecondary_m->get_relation('',$relation, false)[0]['ewallet'];
            $usersec_ary['user_id'] = $parent_user_id;
            $usersec_ary['ewallet'] = $ewallet + $referral_comm;
            $this->userSecondary_m->save($usersec_ary, $parent_user_id);
            //echo $this->db->last_query();
            //insert record into crm_log
            $detail_ary = $this->get_name($parent_user_id); // method call
            $log_array['type'] = 'referral_points';
            $log_array['user_id'] = $this->session->userdata('user_id');
            $log_array['message'] = serialize(array(
                "from" => $this->session->userdata('user_id') ,
                "to" => $parent_user_id ,
                "message" => $detail_ary['first_name'] .' '. $detail_ary['last_name'] . " has earned " . $referral_comm . ' GHS as referral bonus from the '. $this->session->userdata('name')
            ));
            $this->log_m->save($log_array);
            //echo $this->db->last_query();
            //insert into e-wallet-history
            $ewallet_ary['user_id'] = $parent_user_id;
            $ewallet_ary['type'] = 'referral_points';
            $ewallet_ary['points'] = $referral_comm;
            $ewallet_ary['from_whom_user_id'] = $this->session->userdata('user_id');
            $this->ewallet_m->save($ewallet_ary);
            //echo $this->db->last_query();
            //----------------start- notification
            $user_detail = $this->user_m->get($parent_user_id);
            $user_detail_from = $this->user_m->get($user_id);
            $admin_notification = $user_detail->first_name. ' '. $user_detail->last_name.' earned '.$referral_comm.' bPoints as referral bonus from the '. $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('referral_bonus',"Member's joining","You earned ".$referral_comm." bPoints as referral bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
            $pay_load_data = set_payload('referral_bonus', $notification_id, "You earned ". $referral_comm." bPoints as referral bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
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
            $points_earned = ( $purchased_points * 5 ) / 100;
          /*  echo "\nLast user position : " . $last_user_position . "\n";
            echo "<pre>";
            print_r($details);*/
            if (($position > 2 && $last_user_position < 3 && !in_array("false",$last_given )) || ($last_user_position == 0 && $position > 2)) {
                //Then the current users direct parent is eligible for getting the bonus
                // shivani code start
                $this->call_insert_function($parent_user_id, $purchased_points, 'bonus_points', $points_earned);
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

    public function call_insert_function($parent_user_id, $points, $type , $points_earned)
    {
        $user_id = $this->session->userdata('user_id');
        // insert into log table
        $detail_arry = $this->user_m->get($parent_user_id); // method call
        $log_array['type'] = $type;
        $log_array['user_id'] = $this->session->userdata('user_id');
        $log_array['message'] = serialize(array(
            "from" => $user_id ,
            "to" => $parent_user_id,
            "message" => $detail_arry->first_name.' '.$detail_arry->last_name." has earned ". $points_earned . ' GHS as power bonus from the '. $this->session->userdata('name')
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
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned ".$points_earned." bPoints as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('power_bonus',"Member's joining","You earned ".$points_earned." bPoints as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
        $pay_load_data = set_payload('power_bonus', $notification_id, "You earned ". $points_earned." bPoints as power bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
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
        $ewallet = $this->userSecondary_m->get_relation('',$relation, false)[0]['ewallet'];
        $usersec_ary['user_id'] = $parent_user_id;
        $usersec_ary['ewallet'] = $ewallet + $points_earned;
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
        
        $detail_ary = $this->get_name($user_id);
        if ($detail_ary['parent_user_id'] == 0)
        {
            return false;
        }
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $detail_ary['parent_user_id']
        );
        $ewallet = $this->userSecondary_m->get_relation('',$relation, false)[0]['ewallet'];
        $usersec_ary['user_id'] = $detail_ary['parent_user_id'];
        $usersec_ary['ewallet'] = $ewallet + $points;
        $this->userSecondary_m->save($usersec_ary, $detail_ary['parent_user_id']);
        //echo $this->db->last_query();
        //insert record into crm_log
        $detail_arry = $this->get_name($detail_ary['parent_user_id']); // method call
        $log_array['type'] = $type;
        $log_array['user_id'] = $this->session->userdata('user_id');
        $log_array['message'] = serialize(array(
            "from" => $this->session->userdata('user_id') ,
            "to" => $detail_ary['parent_user_id'] ,
            "message" => $detail_arry['first_name'].' '.$detail_arry['last_name']." has earned ". $points . ' GHS as matching bonus from the '. $this->session->userdata('name')
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
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned ".$points." bPoints as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('matching_bonus',"Member's joining","You earned ".$points." bPoints as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification,$detail_ary['parent_user_id']); // common helper function
        $pay_load_data = set_payload('matching_bonus', $notification_id, "You earned ". $points." bPoints as matching bonus from the ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
        }
        //echo $this->db->last_query();
        unset($user_detail);
        unset($user_detail_from);
       // end notification
    }
}