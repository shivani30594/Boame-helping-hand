<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subscription_m');
        $this->load->model('log_m');
        $this->load->model('user_m');
        $this->load->model('ewallet_m');
        $this->load->model('userSecondary_m');
        $this->load->model('UserSubscription_m');
        $this->load->library('CallDemo');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    public function index()
    {
        $this->data['meta_title'] = 'BOAME Forex - BOAME';
        $this->data['subview'] = 'member/subscription/index';
        $this->data['script'] = 'member/subscription/script';
        $relation = array(
            "fields" => '*',
            "conditions" => 'user_id = '.$this->session->userdata('user_id')." AND is_expired = '0'"
        );
        $this->data['record'] = $this->UserSubscription_m->get_relation('', $relation);
        $this->data['subscriptions'] = $this->subscription_m->get();
        $this->data['user_sec'] = $this->userSecondary_m->get($this->session->userdata('user_id'));
        $this->load->view('_layout_main', $this->data);
    }

    public function indexjson()
    {
        $columns = array(
            0 => 's.plan_name',
            1 => 's.plan_description',
            2 => 's.plan_price',
            3 => 'sh.payment_mode',
            4 => 'sh.address',
            5 => 'sh.status',
            6 => 'sh.start_date',
            7 => 'sh.end_date'

        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ".$this->session->userdata('user_id')
        );
        $totalData = $this->UserSubscription_m->get_relation('', $relation, true);
        $totalFiltered = $totalData;
        if (empty($this->input->post('search')['value']))
        {
            $products = $this->UserSubscription_m->all($limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->input->post('search')['value'];
            $products = $this->UserSubscription_m->search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->UserSubscription_m->search_count($search);
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

    public function change_auto_subscription()
    {
        $auto_subscription = $this->input->post('auto_subscription');
        if ($auto_subscription == "true")
        {
            $userPriamry['auto_subscription'] = '1';
            $result = $this->user_m->save($userPriamry, $this->session->userdata('user_id')); 
            if ($result)
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => true, 'message' => 'You are successfully activated Auto subscription')));
            }
            else
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }
        }
        else{
            $userPriamry['auto_subscription'] = '0';
            $result = $this->user_m->save($userPriamry, $this->session->userdata('user_id')); 
            if ($result)
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => true, 'message' => 'You are successfully deactivated Auto subscription')));
            }
            else
            {
                return  $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong!')));
            }
        }
    }

    public function select_subscription()
    {
        $user_id = $this->session->userdata('user_id');
        $usrArry = $this->user_m->get($user_id);
        $payment_mode = $this->input->post('payment_mode');
        $plan_id = $this->input->post('plan_id');
        $relation = array(
            "fields" => '*',
            "conditions" => 'user_id = '.$this->session->userdata('user_id')." AND is_expired = '0'"
        );
        $record = $this->UserSubscription_m->get_relation('', $relation);
        if ($payment_mode == 'ghs_bpoints' OR $payment_mode == 'usd_bpoints' OR $payment_mode == 'usd_ewallet' OR $payment_mode == 'ghs_ewallet')
        {
            $user_sec = $this->userSecondary_m->get($user_id);
            $plan_details = $this->subscription_m->get($plan_id);
            
            if ($payment_mode == 'ghs_bpoints')
            {
                $point_value = $user_sec->total_bpoints;
                $plan_price = ($plan_details->plan_price * 150 ) / 35 ;
                $userSec_array['total_bpoints'] = $user_sec->total_bpoints - $plan_price;
                $sub_array['payment_mode'] = 'ghs_bpoints';
                $power_bonus_type = 'ghs';
                $message =  'GHS-bPoints does not contians GHS'.$plan_price. '. Please purchase the GHS-bpoints more and try again!';

            }
            else if ($payment_mode == 'usd_bpoints')
            {
                $point_value = $user_sec->total_bpoints_usd;
                $plan_price = $plan_details->plan_price;
                $userSec_array['total_bpoints_usd'] = $user_sec->total_bpoints_usd - $plan_price;
                $sub_array['payment_mode'] = 'usd_bpoints';
                $power_bonus_type = 'usd';
                $message =  'USD-bPoints does not contians $'.$plan_price. '. Please purchase the USD-bpoints more and try again!';

            }
            else if ($payment_mode == 'usd_ewallet')
            {
                $point_value = $user_sec->ewallet_usd;
                $plan_price = $plan_details->plan_price;
                $userSec_array['ewallet_usd'] = $user_sec->ewallet_usd - $plan_price;
                $sub_array['payment_mode'] = 'usd_ewallet';
                $power_bonus_type = 'usd';
                $message =  'USD-eWallet does not contians $'.$plan_price. '. Please collect more USD-eWallet and try again later!';

            }
            else{
                $point_value = $user_sec->ewallet;
                $plan_price = ($plan_details->plan_price * 150 ) / 35 ;
                $userSec_array['ewallet'] = $user_sec->ewallet - $plan_price;
                $sub_array['payment_mode'] = 'ghs_ewallet';
                $power_bonus_type = 'ghs';
                $message =  'GHS-eWallet does not contians GHS'.$plan_price. '. Please collect more GHS-eWallet and try again later!';
            }

            if ($point_value - $plan_price > 0)
            {
                if (count($record) > 0)
                {
                    $array['is_expired'] = '1';
                    $this->UserSubscription_m->save($array, $record[0]['id']);
                }

                //point will be set befor based on the type of payment mode
                $result = $this->userSecondary_m->save($userSec_array, $user_id);

                if ($result)
                {
                    $result = $this->UserSubscription_m->get_by("user_id = $user_id AND status ='complete'");
                    if (count($result) == 0) {
                        $message = "Congratulations, Your subscription plan will be activated successfully. As you subscribed for the first time, we provide you ForexRobot.zip file which will be downloaded automatically. should you please save it? Happy Trading !!! ";
                        // Send mail with attchment
                        send_forex_robot($usrArry->email);
                        $isDownload = true;
                    }
                    else {
                        $message = "Congratulations, Your subscription will be upgradeded. Happy Trading !!!";
                        $isDownload = false;
                    }

                    // insert the record into subscription history table
                    $sub_array['user_id'] = $user_id;
                    $sub_array['payment_mode'] = $payment_mode;
                    if (count($record) > 0)
                    {
                        $sub_array['start_date'] = date('Y-m-d H:i:s', strtotime($record[0]['end_date']));
                        $sub_array['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", strtotime($record[0]['end_date'])));
                    }
                    else
                    {
                        $sub_array['start_date'] = date('Y-m-d H:i:s');
                        $Date = strtotime($sub_array['start_date']);
                        $sub_array['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
                    }
                    $sub_array['status'] = 'complete';
                    $sub_array['subscription_id'] = $plan_id;
                    $this->UserSubscription_m->save($sub_array);

                    //insert log subscription
                    $log_array = array();
                    $log_array['user_id'] = $user_id;
                    $log_array['type'] = 'plan_activated';
                    $log_array['message'] = serialize(
                        array( 'from' => $user_id, 
                                'to' => $user_id,
                            'message' => $usrArry->first_name.' '.$usrArry->last_name . ', your plan was activated using USD-bpoints '
                            )
                        );
                    $this->log_m->save($log_array);
                    
                    // send message that plan is activatedand expired on this day
                    $body = "Your subscription plan for ".$plan_details->plan_duration." is activated. Your subscription plan will be expired on ".$sub_array['end_date']." Happy Trading!!";
                    $this->calldemo->send_message($usrArry->mtn_mobile_number, $body);

                    // calcualte the commission
                    $this->power_bonus($user_id, $plan_price, $power_bonus_type);

                    return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'message' => $message, 'isDownload'=>$isDownload)));
                }
                else
                {
                    return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => true, 'message' => 'Something happens wrong. Would you please check your USD-bPoint balance')));
                }
            }
            else
            {
                return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => true, 'message' => $message)));
            }
        }
       
    }

    public function download()
    {
        $this->load->library('zip');
        $this->zip->read_file(FCPATH.DOWNLOAD_ROBOT_URL);
        $this->zip->download('ForexRobot.zip');
        $this->zip->close();
    }

    public function power_bonus($user_id, $purchased_points, $type = 'usd')
    {
        //--------------------------------------------------
        //referral bonus calculation
        //---------------------------------------------------
        $this->referral_bonus($user_id, $purchased_points, $type);
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
            if (($position > 2 && $last_user_position < 3 && !in_array("false",$last_given )) || ($last_user_position == 0 && $position > 2)) {
                $this->call_insert_function($parent_user_id, $purchased_points, 'bonus_points', $points_earned, $main_user_id, $type);
                $this->matching_bonus($parent_user_id, $points_earned, $type);
                $last_user_position = $position;
                $last_given[] = true;
            } else {
                $last_user_position = $position;
                $last_given[] = false;
            }
            $user_id = $parent_user_id;
            if ($parent_user_id == 0) {
                break;
            }
        }
    }
    
    public function referral_bonus($user_id, $purchased_points, $type)
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
            $usersec_ary['user_id'] = $parent_user_id;
            $detail_ary = $this->get_name($parent_user_id); // method call
            $ary = $this->get_name($tmp);
            $user_detail = $this->user_m->get($parent_user_id);
            $user_detail_from = $this->user_m->get($user_id);
            if ($type == 'ghs')
            {
                $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $referral_comm;
                $message = $detail_ary['first_name'] .' '. $detail_ary['last_name'] . " has earned GHS" . $referral_comm . ' as a referral commission from '.$ary['first_name'].' '.$ary['last_name'] ; 
                $ewallet_ary['ewallet_type'] = 'ghs';
                $admin_notification = $user_detail->first_name. ' '. $user_detail->last_name.' earned GHS'.$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
                $notification_id = insert_notification_detail('referral_bonus',"Member's earning","You have earned GHS".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
                $pay_load_data = set_payload('referral_bonus', $notification_id, "You have earned GHS".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name);
               
            }
            else if ($type == 'usd')
            {
                $usersec_ary['ewallet_usd'] = $uSecArray[0]['ewallet_usd'] + $referral_comm;
                $message = $detail_ary['first_name'] .' '. $detail_ary['last_name'] . " has earned USD" . $referral_comm . ' as a referral commission from '.$ary['first_name'].' '.$ary['last_name'] ;
                $ewallet_ary['ewallet_type'] = 'usd';
                $admin_notification = $user_detail->first_name. ' '. $user_detail->last_name.' earned USD'.$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
                $notification_id = insert_notification_detail('referral_bonus',"Member's earning","You have earned USD".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
                $pay_load_data = set_payload('referral_bonus', $notification_id, "You have earned USD".$referral_comm." as a referral commission from ". $user_detail_from->first_name.' '.$user_detail_from->last_name);
               
            }
            $this->userSecondary_m->save($usersec_ary, $parent_user_id);

            //insert record into crm_log
            $ary = $this->get_name($tmp);
            $log_array['type'] = 'referral_points';
            $log_array['user_id'] = $parent_user_id;
            $log_array['message'] = serialize(array(
                "from" => $tmp ,
                "to" => $parent_user_id ,
                "message" => $message
            ));
            $this->log_m->save($log_array);

            //insert into e-wallet-history
            $ewallet_ary['user_id'] = $parent_user_id;
            $ewallet_ary['type'] = 'referral_points';
            $ewallet_ary['points'] = $referral_comm;
            $ewallet_ary['from_whom_user_id'] = $tmp;
            $this->ewallet_m->save($ewallet_ary);

            //----------------start- notification
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            unset($user_detail_from);
            // end-notification

            //-------------------
            //to give benifit to other levels
            $user_id = $parent_user_id;
        }
    }
    
    public function call_insert_function($parent_user_id, $points, $type , $points_earned, $user_id, $ewallet_type)
    {
       // $user_id = $this->session->userdata('user_id');
        $ary = $this->get_name($user_id);
        $detail_arry = $this->user_m->get($parent_user_id); // method call
        $user_detail = $this->user_m->get($parent_user_id);
        $user_detail_from = $this->user_m->get($user_id);
        $uSecArray = $this->userSecondary_m->get_relation('',$relation, false);
        if ($ewallet_ary == 'ghs')
        {
            $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $points_earned;
            $ewallet_ary['ewallet_type'] = 'ghs';
            $message =  $detail_arry->first_name.' '.$detail_arry->last_name." has earned GHS". $points_earned.' as power bonus from '. $ary['first_name'].' '. $ary['last_name'];
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('power_bonus',"Member's joining","You earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
            $pay_load_data = set_payload('power_bonus', $notification_id, "You earned GHS".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        }
        else if ($ewallet_ary == 'usd')
        {
            $usersec_ary['ewallet_usd'] = $uSecArray[0]['ewallet_usd'] + $points_earned;
            $ewallet_ary['ewallet_type'] = 'usd';
            $message = $detail_arry->first_name.' '.$detail_arry->last_name." has earned USD". $points_earned.' as power bonus from '. $ary['first_name'].' '. $ary['last_name'];
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned USD".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('power_bonus',"Member's joining","You earned USD".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification, $parent_user_id); // common helper function
            $pay_load_data = set_payload('power_bonus', $notification_id, "You earned USD".$points_earned." as power bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        }

        // insert into log table
        $log_array['type'] = $type;
        $log_array['user_id'] = $parent_user_id;
        $log_array['message'] = serialize(array(
            "from" => $user_id ,
            "to" => $parent_user_id,
            "message" => $message
        ));
        $this->log_m->save($log_array);

        //insert into ewallet table
        $ewallet_ary['user_id'] = $parent_user_id;
        $ewallet_ary['type'] = $type;
        $ewallet_ary['points'] = $points_earned;
        $ewallet_ary['from_whom_user_id'] = $user_id;
        $this->ewallet_m->save($ewallet_ary);
        
        //insert into notification table
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
        }
        // Update the ewallet history
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $parent_user_id
        );
        $usersec_ary['user_id'] = $parent_user_id;
        $this->userSecondary_m->save($usersec_ary, $parent_user_id);
    }
    
    public function get_name($id)
    {
        $ary['parent_user_id'] = $this->user_m->get($id)->parent_user_id;
        $ary['first_name'] = $this->user_m->get($id)->first_name;
        $ary['last_name'] = $this->user_m->get($id)->last_name;
        return $ary;
    }
    
    public function matching_bonus($user_id, $matching_bonus, $type)
    {
        // call function to insert the log and update the bpoints and ewallet result.
       $this->trigger_insertion($user_id,'matching_points',$matching_bonus, $type);
    }
    
    public function trigger_insertion($user_id, $type, $points, $ewallet_type)
    {
        //update total points
        $ary = $this->get_name($user_id);
        $detail_ary = $this->get_name($user_id);
        $detail_arry = $this->get_name($detail_ary['parent_user_id']); // method call
        $user_detail = $this->user_m->get($detail_ary['parent_user_id']);
        $user_detail_from = $this->user_m->get($user_id);
        if ($detail_ary['parent_user_id'] == 0)
        {
            return false;
        }
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $detail_ary['parent_user_id']
        );
        $uSecArray = $this->userSecondary_m->get_relation('',$relation, false);
        if ($ewallet_type == 'ghs')
        {
            $usersec_ary['ewallet'] = $uSecArray[0]['ewallet'] + $points;
            $message = $detail_arry['first_name'].' '.$detail_arry['last_name']." has earned GHS". $points.' as matching bonus from '. $ary['first_name'].' '. $ary['last_name'];
            $ewallet_ary['ewallet_type'] = 'ghs';
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('matching_bonus',"Member's Earning","You earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification,$detail_ary['parent_user_id']); // common helper function
            $pay_load_data = set_payload('matching_bonus', $notification_id, "You earned GHS". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        }
        else if ($ewallet_type == 'usd')
        {
            $usersec_ary['ewallet_usd'] = $uSecArray[0]['ewallet_usd'] + $points;
            $message = $detail_arry['first_name'].' '.$detail_arry['last_name']." has earned USD". $points.' as matching bonus from '. $ary['first_name'].' '. $ary['last_name'];
            $ewallet_ary['ewallet_type'] = 'usd';
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." earned USD". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name;
            $notification_id = insert_notification_detail('matching_bonus',"Member's Earning","You earned USD". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name, $admin_notification,$detail_ary['parent_user_id']); // common helper function
            $pay_load_data = set_payload('matching_bonus', $notification_id, "You earned USD". $points." as matching bonus from ". $user_detail_from->first_name.' '.$user_detail_from->last_name );
        }
        $usersec_ary['user_id'] = $detail_ary['parent_user_id'];
        $this->userSecondary_m->save($usersec_ary, $detail_ary['parent_user_id']);

        //insert record into crm_log
        $log_array['type'] = $type;
        $log_array['user_id'] = $detail_ary['parent_user_id'];
        $log_array['message'] = serialize(array(
            "from" => $user_id,
            "to" => $detail_ary['parent_user_id'] ,
            "message" => $message
        ));
        $this->log_m->save($log_array);

        //insert into ewallet
        $ewallet_ary['user_id'] = $detail_ary['parent_user_id'];
        $ewallet_ary['type'] = $type;
        $ewallet_ary['points'] = $points;
        $ewallet_ary['from_whom_user_id'] = $user_id;
        $this->ewallet_m->save($ewallet_ary);

        // start notification
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
        }
        unset($user_detail);
        unset($user_detail_from);
       // end notification
    }

    public function list_plan()
    {
        $this->data['meta_title'] = 'BOAME Forex - BOAME';
        $this->data['subview'] = 'member/subscription/list';
        $this->data['script'] = 'member/subscription/script';
        $relation = array(
            "fields" => '*',
            "conditions" => 'user_id = '.$this->session->userdata('user_id')." AND is_expired = '0'"
        );
        $this->data['record'] = $this->UserSubscription_m->get_relation('', $relation);
        $this->data['subscriptions'] = $this->subscription_m->get();
        $this->data['user_sec'] = $this->userSecondary_m->get($this->session->userdata('user_id'));
        $this->load->view('_layout_main', $this->data);
    }

    public function get_upgrade_plan_details()
    {
        $plan_id = $this->input->post('plan_id');
        $plandetails = $this->subscription_m->get($plan_id);
        $relation = array(
            "fields" => '*',
            "conditions" => 'user_id = '.$this->session->userdata('user_id')." AND is_expired = '0'"
        );
        $record = $this->UserSubscription_m->get_relation('', $relation);
        $Date = strtotime($record[0]['end_date']);
        $start_date = date('M d,Y h:i A',$Date);
        $end_date = date('M d,Y h:i A',strtotime("+$plandetails->plan_duration",strtotime($record[0]['end_date'])));
        $msg = "Your upgraded plan will be started from <b>$start_date </b>to <b>$end_date</b> ";
        return  $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => true, 'message' => $msg)));
    }

    public function readme()
    {
        $this->data['meta_title'] = 'BOAME Forex - BOAME';
        $this->data['subview'] = 'member/subscription/readme';
        $this->load->view('_layout_main', $this->data);
    }
}