<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Eproducts extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('eproduct_m');
        $this->load->library('facebook');
        $this->load->model('user_m');
        $this->load->model('userSecondary_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**

     * Display dashboard page with necessary details

     */
    public function index()
    {
        $usrArray = $this->user_m->get($this->session->userdata('user_id'));
        if ($usrArray->is_eproduct_plan == '0')
        {
            $this->session->set_flashdata('danger', 'You have not activated the eProducts plan yet. Please activate the eProducts and able to access it.');
            redirect('dashboard');
        }
        $this->data['meta_title'] = "eProducts - BOAME";
        $this->data['subview'] = 'member/eproducts/index';
        $this->data['script'] = 'member/eproducts/script';
        $this->load->view('_layout_main', $this->data);
    }
    public function indexjson()
    {
        $columns = array(
            0 => 'product_name',
            1 => 'product_type',
            2 => 'download_link'
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
            $products = $this->eproduct_m->allproducts($limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->input->post('search')['value'];
            $products = $this->eproduct_m->product_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->eproduct_m->product_search_count($search);
        }
        $data = array();
        if (!empty($products))
        {
            foreach ($products as $product)
            {
                $data[] = $product;
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function activate_eproduct_plan()
    {
        $user_id = $this->session->userdata('user_id');
        $relation = array(
            "fields" => "total_bpoints",
            'conditions' => "user_id = " . $user_id
        );
        $bpoints = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_bpoints'];
        $data1 = array("is_eproduct_plan" => 1);
        $this->user_m->save($data1, $user_id);
        $data = array("total_bpoints" => $bpoints - 150);
        $purchased_points = 150;
        $this->power_bonus($user_id, $purchased_points);
        $usrArray = $this->user_m->get($user_id);
        $result = $this->userSecondary_m->save($data, $user_id);
        $log_array = array();
        $log_array['user_id'] = $user_id;
        $log_array['type'] = 'eproduct_activated';
        $log_array['message'] = serialize(
            array( 'from' => $user_id, 
                    'to' => $user_id,
                'message' => $usrArray->first_name. ' '. $usrArray->last_name . ' has activated the eProduct plan'
                )
            );
        $this->log_m->save($log_array);
        $result = $this->userSecondary_m->save($data, $user_id);

        if ($result)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }

    public function activate_referral()
    {
        $this->data['meta_title'] = "eProducts Plan - BOAME";
        $this->data['subview'] = 'member/eproducts/activate_referral';
        $this->data['script'] = 'member/eproducts/script';
        $this->load->view('_layout_main', $this->data);
    }

    public function active_plan_referral()
    {
        $user_id = $this->session->userdata('user_id');
        $relation = array(
            "fields" => "total_bpoints",
            'conditions' => "user_id = " . $user_id
        );
        $bpoints = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_bpoints'];
        if ($bpoints < 150)
        {
            $this->session->set_flashdata('danger', 'You must required 150 BPoints to activate eProduct plan!');
            redirect('member/eproducts/activate_referral');
        }
        $relation = array(
            "fields" => "user_id",
            'conditions' => "refferal_code ='" . $this->input->post('referral_code') . "'"
        );
        $user_id_plan = $this->refferalDetails_m->get_relation('', $relation, false);
        if (!empty($user_id_plan))
        {
            $plan_user_id = $user_id_plan[0]['user_id'];
            //check if plan is already exists
            $relation = array(
                "fields" => "is_eproduct_plan",
                'conditions' => "id = " . $plan_user_id
            );
            $is_plan = $this->user_m->get_relation('', $relation, false)[0]['is_eproduct_plan'];
            if($is_plan == 1){
                $this->session->set_flashdata('danger', 'eProduct plan is already activated for ' . $this->input->post('referral_code') . ' .');
                redirect('member/eproducts/activate_referral');
            }
          
            $data1 = array("is_eproduct_plan" => 1, "eplan_activated_by" => $user_id);
            $result1 = $this->user_m->save($data1, $plan_user_id);
            //shp
            $usrArray = $this->user_m->get($user_id);
            $planUsrArray = $this->user_m->get($plan_user_id);
            $log_array = array();
            $log_array['user_id'] = $user_id;
            $log_array['type'] = 'eproduct_activated';
            $log_array['message'] = serialize(
                array( 'from' => $user_id, 
                        'to' => $plan_user_id,
                    'message' => $usrArray->first_name. ' '. $usrArray->last_name . ' has activated the eProduct plan of '.$planUsrArray->first_name.' '.$planUsrArray->last_name
                    )
                );
            $this->log_m->save($log_array);
            //shp

            $data = array("total_bpoints" => $bpoints - 150);
            $result = $this->userSecondary_m->save($data, $user_id);
            $purchased_points = 150;
            $this->power_bonus($plan_user_id, $purchased_points);

            if ($result != '' && $result1 != '')
            {
                $this->session->set_flashdata('success', 'eProduct plan successfully activated for ' . $this->input->post('referral_code') . ' .');
                redirect('member/eproducts/activate_referral');
            }
            else
            {
                $this->session->set_flashdata('danger', 'Something happens wrong!');
                redirect('member/eproducts/activate_referral');
            }
        }
        else
        {
            $this->session->set_flashdata('danger', 'You have entered wrong Referral code!');
            redirect('member/eproducts/activate_referral');
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
                "message" => $detail_ary['first_name'] .' '. $detail_ary['last_name'] . " has earned GHS" . $referral_comm . ' as a referral commission from '.$ary['first_name'].' '.$ary['last_name'] 
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
            $admin_notification = $user_detail->first_name. ' '. $user_detail->last_name.' earned GHS'.$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
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
            "message" => $detail_arry->first_name.' '.$detail_arry->last_name." has earned GHS". $points_earned.' as power bonus from '. $ary['first_name'].' '. $ary['last_name']
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
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('power_bonus',"Member's joining","You earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
        $pay_load_data = set_payload('power_bonus', $notification_id, "You earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
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
    
    public function get_name($id)
    {
        $ary['parent_user_id'] = $this->user_m->get($id)->parent_user_id;
        $ary['first_name'] = $this->user_m->get($id)->first_name;
        $ary['last_name'] = $this->user_m->get($id)->last_name;
        return $ary;
    }
    
    public function matching_bonus($user_id, $matching_bonus)
    {
        // call function to insert the log and update the bpoints and ewallet result.
       $this->trigger_insertion($user_id,'matching_points',$matching_bonus);
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
            "message" => $detail_arry['first_name'].' '.$detail_arry['last_name']." has earned GHS". $points.' as matching bonus from '. $ary['first_name'].' '. $ary['last_name']
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
        $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
        $notification_id = insert_notification_detail('matching_bonus',"Member's Earning","You earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification,$detail_ary['parent_user_id']); // common helper function
        $pay_load_data = set_payload('matching_bonus', $notification_id, "You earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
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
