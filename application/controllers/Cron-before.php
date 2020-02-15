<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';
class Cron extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->load->model('WantsToDonateQueue_m');
        $this->load->model('DonatoresQueue_m');
        $this->load->model('userSecondary_m');
        $this->load->model('purchasedPointHistory_m');
        $this->load->model('PledgeLog_m');
        $this->load->model('user_m');
        $this->load->model('notification_m');
        $this->load->model('UserPayment_m');
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        $this->load->library('CallDemo');
    }

    public function give_money_back_for_matched()
    {
        $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N'"
        );
        $pledge_details = $this->DonatoresQueue_m->get_relation('', $relation);
        foreach($pledge_details as $key=>$value)
        {
            $sql = "UPDATE crm_users_secondary set total_bpoints = total_bpoints + 100 where id = $value[user_id]";
            $this->db->query($sql);
        }
    }

    public function give_money_back()
    {
        $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N' OR is_active = 'N'"
        );
        $pledge_details = $this->WantsToDonateQueue_m->get_relation('', $relation);
        foreach($pledge_details as $key=>$value)
        {
            $sql = "UPDATE crm_users_secondary set total_bpoints = total_bpoints + 20 where id = $value[user_id]";
            $this->db->query($sql);
        }
    }


    /**
    * Every day this function is called to reset the pledge_per_week field
    */
    public function reset_pledge_week()
    {
        /*$relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $pledge_details = $this->userSecondary_m->get_relation('', $relation);
        $start_date = date('Y-m-d H:i:s', strtotime('this monday'));
        $end_date = date('Y-m-d H:i:s', strtotime('next sunday'));
        echo $start_date;
        echo $end_date;
        die;
        if ($start_date > $pledge_details[0]['created'])
        {
            $sql = "UPDATE crm_users_secondary set created = date('Y-m-d H:i:s') , pledge_per_week = 0 where id = $pledge_details[0]['id']";
            $this->sb->query($sql);
        }*/
        
        $created  = date('Y-m-d H:i:s');
        $sql = "UPDATE crm_users_secondary set created = '".$created."', pledge_per_week = 0 ";
        $this->db->query($sql);
    }   

    /**
    * At every 1st day of the month, this function is called and reset the field 
    */
    public function reset_pledge_month() 
    {
        $created  = date('Y-m-d H:i:s');
        $sql = "UPDATE crm_users_secondary set created = '".$created."', pledge_per_month = 0 ";
        $this->db->query($sql);
    } 

    /**
    * At every 30 mins to find the matching user for the pledge.
    */
    public function manage_pledge_queue()
    {
        $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N' AND is_active = 'N'",
            "ORDER_BY" => array(
                    'field' => 'crm_wants_to_donate_queue.pledge_date',
                    'order' => 'ASC'),
        );
        $wants_pledge_array = $this->WantsToDonateQueue_m->get_relation('', $relation, false);
        // echo "<pre>";
        // print_r($wants_pledge_array);
        $relation = array(
            "fields" => "*",
            "conditions" => "is_deleted = 'N' AND is_confirmed = 'N' AND is_active='N'",
            "ORDER_BY" => array(
                    'field' => 'crm_donetores_queue.created',
                    'order' => 'ASC'),
        );
        $donatores_pledge_array = $this->DonatoresQueue_m->get_relation('', $relation, false);
        // echo "Donatores";
        // echo "<pre>";
        // print_r($donatores_pledge_array);
        $count = 0;
        $loop_index = 1;
        $loop_count = floor(count($wants_pledge_array) / 2);
        $new_array = array();
        if (count($donatores_pledge_array) > 0)
        {
            if (count($wants_pledge_array) > 0)
            { 
                for ($i=0; $i<count($donatores_pledge_array); $i++)
                {
                    /*echo("donatores---".$donatores_pledge_array[$i]['user_id']);
                                        echo "<br>";*/
                    $wants_index = 0;
                    $output = array();
                    for ($j=0;$j<count($wants_pledge_array);$j++)
                    {
                        if ($wants_index < 2)
                        {
                            if (!in_array($j, $new_array))
                            {
                                if ($wants_pledge_array[$j]['user_id'] != $donatores_pledge_array[$i]['user_id'])
                                {
                                   /* echo "wants-----".$wants_pledge_array[$j]['user_id'];*/
                                    array_push($new_array,$j);
                                    $wants_index++;
                                    array_push($output,$j);
                                }
                            }
                        }
                        else
                        {
                            break;
                        }
                    }
                    if (count($output) == 2)
                    {
                        for ($k = 0; $k < 2; $k++)
                        {
                            $new_count = $output[$k];
                            $pledge_log_array['investor_id'] = $donatores_pledge_array[$i]['user_id'];
                            $pledge_log_array['borrower_id'] = $wants_pledge_array[$new_count]['user_id'];
                            $pledge_log_array['start_date'] = date('Y:m:d H:i:s') ;
                            $add_hours = time() + (1 * 24 * 60 * 60);
                            $pledge_log_array['end_date'] = date('Y:m:d H:i:s',$add_hours);
                            $pledge_log_array['wants_to_donate_id'] = $wants_pledge_array[$new_count]['id'];
                            $pledge_log_array['donetores_queue_id'] = $donatores_pledge_array[$i]['id'];
                            $this->PledgeLog_m->save($pledge_log_array);
                            //update the status of donatores queue to is_active to 'Y'
                            $query = "UPDATE crm_donetores_queue set is_active ='Y' where id = ". $donatores_pledge_array[$i]['id'];
                            $this->db->query($query);
                            $query1 = "UPDATE crm_wants_to_donate_queue set is_active ='Y' where id = ". $wants_pledge_array[$new_count]['id'];
                            $this->db->query($query1);
                            $this->notification_insertion_to($donatores_pledge_array[$i]['user_id'], $wants_pledge_array[$new_count]['user_id']); // to ma from nu user_id
                            $this->notification_insertion_from($donatores_pledge_array[$i]['user_id'], $wants_pledge_array[$new_count]['user_id']); // from ma to nu 
                        }
                    } 
                }
            }
        }
    }

    /**
    * To send the notification + SMS to matching user (TO)
    */
    public function notification_insertion_to($to_id, $from_id)
    {
        $user_detail_to = $this->user_m->get($to_id);
        $user_detail_from = $this->user_m->get($from_id);
        $notification['notification_title'] = "Matching user found";
        $notification['notification_message'] = "You have to pay GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name ." within 24 hours from now";
        $notification['notification_type'] = "pledge";
        $notification['user_id'] = $from_id;
        $notification['admin_notification'] = $user_detail_from->first_name. ' '.$user_detail_from->last_name." have to pay GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name ." within 24 hours from now";
        $noti_id = $this->notification_m->save($notification);
       /* $body = "Congratulations. Your matching is found. Please pay GHS100 to ".$user_detail_to->first_name." " . $user_detail_to->last_name." within 24 hours from now.
                MoMo account name: ". $user_detail_to->mtn_mobile_name." 
                MoMo account number: ". $user_detail_to->mtn_mobile_number." 
                Thank you.";*/
        $message = "Congratulations. Your matching is found. Please pay GHS100 to ".$user_detail_to->first_name." " . $user_detail_to->last_name. "within 24 hours from now. ";
        $message .= ' MoMo account name : '.$user_detail_to->mtn_mobile_name;
        $message .= ' MoMo account number : '.$user_detail_to->mtn_mobile_number;
        $message .= ' Thank you';
        $this->send_text_message($user_detail_from->mtn_mobile_number, $message);
        $this->notify_user($from_id, $noti_id, $notification['notification_message']);
    }

    /**
    * To send the notification + SMS to matching user (FROM)
    */
    public function notification_insertion_from($to_id, $from_id)
    {
        $user_detail = $this->user_m->get($from_id);
        $user_detail_to = $this->user_m->get($to_id);
        $notification['notification_title'] = "Matching user found";
        $notification['notification_message'] = "You will be able to get GHS100 from ". $user_detail->first_name. ' '. $user_detail->last_name ." within 24 hours from now. ";
        $notification['notification_type'] = "pledge";
        $notification['user_id'] = $to_id;
        $notification['admin_notification'] = $user_detail_to->first_name. ' '.$user_detail_to->last_name." will be able to get GHS100 from ". $user_detail->first_name. ' '. $user_detail->last_name ." within 24 hours from now";
        $noti_id = $this->notification_m->save($notification);
      //  $body = "Your matching is found. You will be able to get GHS100 from ". $user_detail->first_name. ' '. $user_detail->last_name ." within 24 hours from now <br> Name: ". $user_detail->first_name. ' '. $user_detail->last_name. "<br> Contact No:".$user_detail->mtn_mobile_number;
        $message = "Congratulations. Your matching is found. You are Able to get GHS100 from ".$user_detail->first_name." " . $user_detail->last_name. "within 24 hours from now. ";
        $message .= ' MoMo account name : '.$user_detail->mtn_mobile_name;
        $message .= ' MoMo account number : '.$user_detail->mtn_mobile_number;
        $message .= ' Thank you';
        $this->send_text_message($user_detail_to->mtn_mobile_number, $message);
        $this->notify_user($to_id, $noti_id, $notification['notification_message']);
    }

    /**
    * If opposite is currently login as android user, send it using FCM 
    */
    public function notify_user($user_id, $notification_id, $message)
    {
        $user_detail = $this->user_m->get($user_id);
        $pay_load_data = set_payload('pledge', $notification_id, $message ); // helper
        if ($user_detail->device_type == '0')
        {
            send_push_notification($user_detail->device_token, false, $pay_load_data);//helper 
        }
    }

    /**
    * Send the text message. i.e. call the library of the Twilio
    */
    public function send_text_message($number , $body)
    {
        $this->calldemo->send_message($number, $body);
    }

    // 
    public function check_reminder()
    {
        $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N'"
        );
        $current_pledge = $this->PledgeLog_m->get_relation('', $relation, false);
        if (count($current_pledge) > 0)
        {
            foreach ($current_pledge as $key => $value) 
            {
                $date = date('Y-m-d H:i:s');
                $twel_hour =  12;
                $eight_hour = 18;
                $twen_hour =  20;
                $date1 = date_create($value['end_date']);
                $date2 = date_create($date);
                $diff=date_diff($date1,$date2);
                $hours_diff = $diff->format("%h");
                $record = $this->user_m->get($value['borrower_id']);
                $investor_record = $this->user_m->get($value['investor_id']);
                $mobilenumber = $record->mtn_mobile_number;
                $sms_flag_array = json_decode($value['is_sms_send']);
                if ($hours_diff == $twen_hour && $sms_flag_array[2] != '1')
                {
                    $sms_flag_array[2] = '1';
                    $message = "Please pay GHS100 to ".$investor_record->first_name.' '.$investor_record->last_name." within 20 hours from now. ";
                    $message .= ' MoMo account name : '.$investor_record->mtn_mobile_name;
                    $message .= ' MoMo account number : '.$investor_record->mtn_mobile_number;
                    $message .= ' Thank you';
                    $this->send_text_message($mobilenumber, $message);                                  
                }
                else if ($hours_diff == $eight_hour && $sms_flag_array[1] != '1' )
                {
                    $sms_flag_array[1] = '1';
                    $message = "Please pay GHS100 to ".$investor_record->first_name.' '.$investor_record->last_name." within 18 hours from now. ";
                    $message .= ' MoMo account name : '.$investor_record->mtn_mobile_name;
                    $message .= ' MoMo account number : '.$investor_record->mtn_mobile_number;
                    $message .= ' Thank you';
                    $this->send_text_message($mobilenumber, $message);
                }
                else if ($hours_diff == $twel_hour && $sms_flag_array[0] != '1'  )
                {
                    $sms_flag_array[0] = '1';
                    $message = "Please pay GHS100 to ".$investor_record->first_name.' '.$investor_record->last_name." within 12 hours from now. ";
                    $message .= ' MoMo account name : '.$investor_record->mtn_mobile_name;
                    $message .= ' MoMo account number : '.$investor_record->mtn_mobile_number;
                    $message .= ' Thank you';
                    $this->send_text_message($mobilenumber, $message);
                }
                $encde_value = json_encode($sms_flag_array);
                $sql = "update crm_pledge_log SET is_sms_send = '$encde_value' WHERE id = $value[id]";
                $this->db->query($sql);
            }
        }

        $relation = array(
            "fields" => "*",
            "conditions" => "is_approved = 'pending'"
        );

        $purchasedArr = $this->purchasedPointHistory_m->get_relation('',$relation,false);
        
        foreach ($purchasedArr as $key => $value) {
            $date1 = date_create($value['purchased_date']);
            $date2 = date_create(date('Y-m-d H:i:s'));
            $diff = date_diff($date2,$date1);
            $hours_diff = $diff->format("%d %h");
            if ($hours_diff == '3 0')
            {
                //$sql = "UPDATE crm_purchased_point_history set is_approved = 'cancel' WHERE id = $value[id]";
                $sql = "UPDATE crm_purchased_point_history set is_approved = 'cancel_system' WHERE id = $value[id]";
                $this->db->query($sql);
                //send text message
                $body = "As you have not transferred amount to admin account within 72 hours, your purchase point request for GHS".$purchasedArr->purchased_points." is canceled by admin.";
                $usrArry = $this->user_m->get($value['user_id']);
                $this->calldemo->send_message($usrArry->mtn_mobile_number, $body);
                //send web push notificatooin
                $notification['notification_title'] = "Purchase Point Request Cancellation";
                $notification['notification_message'] = "As you have not transferred amount to admin account within 72 hours, your purchase point request for GHS".$purchasedArr->purchased_points." is canceled by admin. ";
                $notification['notification_type'] = "request";
                $notification['user_id'] = $value['user_id'];
                $notification['admin_notification'] = $usrArry->first_name. ' '.$usrArry->last_name." has not transferred amount to within 72 hours. So, purchase request is canceled.";
                $noti_id = $this->notification_m->save($notification);
                $this->notify_user($value['user_id'], $noti_id, $notification['notification_message']);
            }
        }
    }

    public function backup_db()
    {
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'boame_adin');
        define('DB_USER', 'admin_321');
        define('DB_PASSWORD', 'boame_p2p_leading_dev');
        define('BACKUP_SAVE_TO', BASE_URL.'/assets/backup'); // without trailing slash

        $time = time();
        $day = date('j', $time);
        if ($day == 1) {
            $date = date('Y-m-d', $time);
        } else {
            $date = $day;
        }

        $backupFile = BACKUP_SAVE_TO . '/' . DB_NAME . '_' . $date . '.gz';
        if (file_exists($backupFile)) {
            unlink($backupFile);
        }
        $command = 'mysqldump --opt -h ' . DB_HOST . ' -u ' . DB_USER . ' -p\'' . DB_PASSWORD . '\' ' . DB_NAME . ' | gzip > ' . $backupFile;
        echo $command;
        system($command);
    }

    public function insert_Record()
    {
        $sql ="INSERT INTO `crm_stores`( `points`, `is_deleted`) VALUES (200,'Y')";
        $this->db->query($sql);
    }
    
    public function check_expresspay_status()
    {
        //live
        $url = 'https://expresspaygh.com/api/query.php';
        $merchant_id = EXP_MERCHANT;
        $api_key = EXP_APIKEY;
    
    
      $relation = array(
            "fields" => "*",
            "conditions" => "status = 'pending'"
        );

        $pending_payments = $this->UserPayment_m->get_relation('',$relation,false);
        
        foreach ($pending_payments as $key => $value) {
            $params = array(
                'merchant-id' => $merchant_id,
                'api-key' => $api_key,
                'token' => $value['token']
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_POST, count($params));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
            $result = curl_exec($ch);
            $decoded = json_decode($result);
            curl_close($ch);

            $savedata  = array("query_response" => $result, "updated_at" => date("Y-m-d h:i:s"));
           
            if($decoded->result == 1){
                $savedata['status'] = "approved";
                //add bpoints in user account
                $relation = array(
                    "fields" => "total_bpoints",
                    'conditions' => "user_id = " . $value['user_id']
                );
                $bpoints = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_bpoints'];
                $user_data = array("total_bpoints" => $bpoints +  $value['amount']);
                $result = $this->userSecondary_m->save($user_data, $value['user_id']);
                
                $this->power_bonus($value['user_id'], $value['amount']);
                
                $body = "Your purchase request for Amount GHS".$value['amount']." is successfully completed and BPoints are updated successfully";
                //*****************************send notification******************************
                $usrArry = $this->user_m->get($value['user_id']);
                $this->calldemo->send_message($usrArry->mtn_mobile_number, $body);
            }
            elseif($decoded->result == 2){
                $savedata['status'] = "declined";
            }
            elseif($decoded->result == 3){
                $savedata['status'] = "error";
            }
            else{
                $savedata['status'] = "pending";
            }
            $this->UserPayment_m->save($savedata ,$value['id']);
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


    public function getPayments()
    {
        $this->db->query("INSERT INTO crm_stores (points,is_deleted) VALUES (9900, 'Y')");

    }
}