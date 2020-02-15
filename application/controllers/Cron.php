<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';

class Cron extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->load->model('userSecondary_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('purchasedPointHistory_m');
        $this->load->model('user_m');
        $this->load->model('paymentUSD_m');
        $this->load->model('UserPayment_m');
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        $this->load->model('setting_m');
        $this->load->model('UserSubscription_m');
        $this->load->model('subscription_m');
        $this->load->model('RefferalDetails_m');
        $this->load->library('CallDemo');
    }

    // public function send_mail()
    // {
    //     send_forex_robot('slibits2@gmail.com');
    // }
  
   
    public function postItem()
    {
        $form_data = array(
            'userId' => $this->input->post('userId'),
            'title' => $this->input->post('title'),
            'body' => $this->input->post('body')
            );
        $result = $this->db->insert('crm_items', $form_data);
        if ($result )
        {
            echo json_encode(array('status' => 'ok', 'message' => 'item added successfully')) ;
        }
        else{
            echo json_encode(array('status' => 'error', 'message' => 'Something happens worng')) ;
        }
    }

    public function getItem($id = '')
    {
       $this->db->where('id', $id);
       $result = $this->db->get('crm_items');
       echo json_encode(array('data'=>$result->result_array()[0]));
    }

    public function updateItem($id = '')
    {
        $form_data = array(
            'userId' => $this->input->post('userId'),
            'title' => $this->input->post('title'),
            'body' => $this->input->post('body')
        );
        $this->db->where('id', $id);
        $result = $this->db->update('crm_items', $form_data);
        if ($result)
        {
            echo json_encode(array('status' => 'ok', 'message' => 'item updated successfully')) ;
        }
        else{
            echo json_encode(array('status' => 'error', 'message' => 'Something happens worng')) ;
        }
    }

    public function getItems()
    {
        $searchData = json_decode($_GET['search']);
        $filterColumn = [
        	'id' => 'id',
        	'userId' =>  'userId',
        	'title' => 'title',
        	'body' => 'body',
        ];
        
        $pageSize = ( isset($searchData->pagesize) AND  $searchData->pagesize !='') ? $searchData->pagesize : 10;
        $page = ( isset($searchData->page) AND  $searchData->page !='' ) ? $searchData->page : 0;  

        if($page > 0) {
        	$page = ( $page ) * $pageSize;
        } 
        $where = [];
        if(isset($searchData->filtered) && !empty($searchData->filtered)) {
        	foreach ($searchData->filtered as $filter) {
                $value = trim($filter->value);
                if($value != '' && strlen($value) > 0)
                   $where[] =  "{$filterColumn[$filter->id]} LIKE '%{$value}%'";
        	}
        }
        if (count($where) > 0)
        {
            $where = (implode(' and ',$where));
            $where = 'WHERE '.$where.'';
        }
        else{
            $where = '';
        }
        $orderBy = "ORDER BY 'id' DESC";                

        if (isset($searchData->sorted) && !empty($searchData->sorted)){
        	$order = get_object_vars($searchData->sorted[0]);
        	$orderSort = 'desc';
        	if($order['desc'] === false){
        		$orderSort = 'ASC';
            }
            else{
                $orderSort = 'DESC';
            }
            $orderid = $order['id'];
        	$orderBy =  " ORDER BY $filterColumn[$orderid] $orderSort";
        }
        
        $transactions=  $this->db->query('SELECT * FROM `crm_items` '.$where.' '.$orderBy.' LIMIT '.$page.','.$pageSize.'');
        $transactions = $transactions->result_array();
        $transactionsCount = count($this->db->query('SELECT * FROM `crm_items` '.$where.' '.$orderBy.'')->result_array());
        echo json_encode([
            'status' => 'ok',
            'data' => $transactions,
            'total' => $transactionsCount
        ]);
    }

    public function mq5()
    {
        $rawdata = file_get_contents('php://input');
        $posted_data = explode(",", trim($rawdata));
        $result = $this->RefferalDetails_m->get_by('refferal_code = "'.$posted_data[0].'"');
        if (count($result) > 0)
        {
            $relation = array(
                'fields' => '*',
                "conditions" => "user_id = '". $result[0]->user_id. "' AND is_expired = '0' AND end_date >='".date('Y-m-d H:i:s')."'"
            );
            $subscription = $this->UserSubscription_m->get_relation('', $relation);
            if (count($subscription) > 0)
            {
                echo "subscribed";
            }
            else{
                echo "expired";
            }
        }
        else
        {
            echo "not_found";
        }
    }

    public function payForRobot()
    {
        $setting_details = $this->setting_m->get('1');
        $cp_merchant_id = $setting_details->merchant_id; 
        $cp_ipn_secret = $setting_details->secret_key; 

        function errorAndDie($error_msg) { 
            $file_name = "errormsg_".rand(1,100000).'.txt';
            $file1 = fopen($file_name, 'w');
            fwrite($file1,json_encode($_POST));
            fclose($file1);
        } 

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
            errorAndDie('IPN Mode is not HMAC.'); 
        } 

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
            errorAndDie('No HMAC signature sent.'); 
        } 

        $request = file_get_contents('php://input'); 
        if ($request === FALSE || empty($request)) { 
            errorAndDie('Error reading POST data'); 
        } 

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
            errorAndDie('No or incorrect Merchant ID passed'); 
        } 

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) { 
            errorAndDie('HMAC signature does not match'); 
        } 
     
        $ipn_id = $_POST['ipn_id'];
        $txn_id = $_POST['txn_id']; 
        $item_name = $_POST['item_name']; 
        $item_number = $_POST['item_number']; 
        $amount1 = floatval($_POST['amount1']); 
        $amount2 = floatval($_POST['amount2']); 
        $currency1 = $_POST['currency1']; 
        $currency2 = $_POST['currency2']; 
        $status = intval($_POST['status']); 
        $status_text = $_POST['status_text']; 
        $user_id = $_POST['custom'];
        $received_amount = $_POST['received_amount'];
     
        $relation = array(
            'fields' => '*',
            "conditions" => "transaction_id = '". $txn_id. "'"
        );
        $sql = $this->UserSubscription_m->get_relation('',$relation);
        
        if (count($sql) > 0)
        {
            $plan_details = $this->subscription_m->get($sql[0]['subscription_id']);
            $order_total = $plan_details->plan_price;
            $order_currency = $plan_details->plan_price_currency;
            $relation = array(
                "fields" => '*',
                "conditions" => 'user_id = '.$sql[0]['user_id']." AND is_expired = '0' AND status = 'complete' "
            );
            $record = $this->UserSubscription_m->get_relation('', $relation);
        }

        if ($currency1 != $order_currency) { 
            errorAndDie('Original currency mismatch!'); 
        }     
     
        if ($amount1 < $order_total) { 
            errorAndDie('Amount is less than order total!'); 
        } 
   
        if ($status >= 100 || $status == 2) 
        { 
            if (count($record) > 0)
            {
                $userSubArray['start_date'] = date('Y-m-d H:i:s', strtotime($record[0]['end_date']));
                $userSubArray['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", strtotime($record[0]['end_date'])));
                  
            }
            else{
                $userSubArray['start_date'] = date('Y-m-d H:i:s');
                $Date = strtotime($userSubArray['start_date']);
                $userSubArray['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
            }
            $userSubArray['status'] = 'complete';
            $userSubArray['received_amount'] = $received_amount;
            $this->UserSubscription_m->save($userSubArray, $sql[0]['id']);

            // Insert into the log table
            $usrArray = $this->user_m->get($sql[0]['user_id']);
            $log_array = array();
            $log_array['user_id'] = $sql[0]['user_id'];
            $log_array['type'] = 'plan_activated';
            $log_array['message'] = serialize(
                array( 'from' => $sql[0]['user_id'], 
                        'to' => $sql[0]['user_id'],
                    'message' => $usrArray->first_name. ' '. $usrArray->last_name . ',your plan was activated using pay online method'
                    )
                );
            $this->log_m->save($log_array);
            
            if (count($record) > 0)
            {
                $array['is_expired'] = '1';
                $this->UserSubscription_m->save($array, $record[0]['id']);
            }

            // Send mail with attahcment
            $result_subscription = $this->UserSubscription_m->get_by("user_id =  $sql[0]['user_id'] AND status ='complete'");
            if (count($result_subscription) == 0)
            {
                //send mail
                send_forex_robot($usrArray->email);
                $message = "Congratulations, Your subscription plan will be activated successfully. As you subscribed for the first time, we provide you ForexRobot.zip file which will be downloaded automatically. should you please save it? Happy Trading !!! ";

            }
            else{
                $message = "Congratulations, Your subscription will be upgradeded. Happy Trading !!!";
            }
            //Give the Commission
            $this->power_bonus($sql[0]['user_id'], $amount1, $type = 'usd');

            //Send Message
            $this->calldemo->send_message($usrArray->mtn_mobile_number, $body);
         
        } else if ($status == -1) { 
          
        } else if ($status == 1){ 
            $userSubArray['status'] = 'in-progress';
            $this->UserSubscription_m->save($userSubArray, $sql[0]['id']);
        } 
        else { 

           // insert the record for first time with status pending
            $sub_array['user_id'] = $user_id;
            $sub_array['payment_mode'] = "pay_online";
            $sql = $this->db->query("SELECT id from crm_subscription WHERE plan_price = $amount1 ")->result();
            $sub_array['subscription_id'] = $sql[0]->id;
            $sub_array['transaction_id'] = $txn_id;
            $sub_array['address'] = $ipn_id;
            $sub_array['received_amount'] = $received_amount;
            $this->UserSubscription_m->save($sub_array);
        } 
    }

    public function getPayments()
    {
		$setting_details = $this->setting_m->get('1');
        $cp_merchant_id = $setting_details->merchant_id; 
        $cp_ipn_secret = $setting_details->secret_key; 
        $order_currency = 'USD'; 
        $user_id = $_POST['custom'];
        $txn_id = $_POST['txn_id'];
        $relation = array(
            "fields" => "*",
            'conditions' => "transaction_id = '". $txn_id. "' AND user_id = ".$user_id
        );
        $payment_detailsArray = $this->paymentUSD_m->get_relation('', $relation);

        $order_total = isset($payment_detailsArray) ? $payment_detailsArray[0]['amount'] : ''; 

        function errorAndDie($error_msg) { 
            $file_name = "errormsg_".rand(1,100000).'.txt';
            $file1 = fopen($file_name, 'w');
            fwrite($file1,json_encode($_POST));
            fclose($file1);
        } 

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
            errorAndDie('IPN Mode is not HMAC.'); 
        } 

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
            errorAndDie('No HMAC signature sent.'); 
        } 

        $request = file_get_contents('php://input'); 
        if ($request === FALSE || empty($request)) { 
            errorAndDie('Error reading POST data'); 
        } 

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
            errorAndDie('No or incorrect Merchant ID passed'); 
        } 

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) { 
            errorAndDie('HMAC signature does not match'); 
        } 
     
     //   $txn_id = $_POST['txn_id']; 
        $item_name = $_POST['item_name']; 
        $item_number = $_POST['item_number']; 
        $amount1 = floatval($_POST['amount1']); 
        $amount2 = floatval($_POST['amount2']); 
        $currency1 = $_POST['currency1']; 
        $currency2 = $_POST['currency2']; 
        $status = intval($_POST['status']); 
        $status_text = $_POST['status_text']; 

        if ($currency1 != $order_currency) { 
            errorAndDie('Original currency mismatch!'); 
        }     
     
        if ($amount1 < $order_total) { 
            errorAndDie('Amount is less than order total!'); 
        } 
   
        if ($status >= 100 || $status == 2) { 
            $response = $this->paymentUSD_m->get_by("transaction_id = '".$txn_id."'");
            if ($response[0]->status != 'complete')
            {
                $usr_payment['status'] = 'complete';
                $usr_payment['payment_date'] = date('Y-m-d H:i:s');
                $this->paymentUSD_m->save($usr_payment, $response[0]->id);
                $relation = array(
                    "fields" => "*",
                    'conditions' => "user_id = " . $response[0]->user_id
                );
                $result = $this->userSecondary_m->get_relation('', $relation, false);
                $userSecondaryArray['total_bpoints_usd'] = $result[0]['total_bpoints_usd'] + $response[0]->purchased_amount;
                $this->userSecondary_m->save($userSecondaryArray, $result[0]['user_id']);
    
                //Give commissions
                $this->power_bonus($response[0]->user_id, $response[0]->purchased_amount,'usd');
    
                //Insert into log_histortu
                $usrArray = $this->user_m->get($response[0]->user_id);
                $log_array = array();
                $log_array['user_id'] = $response[0]->user_id;
                $log_array['type'] = 'purchased_usd_points';
                $log_array['message'] = serialize(
                    array( 'from' => $response[0]->user_id, 
                            'to' => $response[0]->user_id,
                        'message' => $usrArray->first_name. ' '. $usrArray->last_name . ' has purchased '.$response[0]->purchased_amount .' USDb-Points.'
                        )
                    );
                $this->log_m->save($log_array);
                
                // Insert into bpointshistory table
                $bonus_point_array = array();
                $bonus_point_array['user_id'] = $response[0]->user_id;
                $bonus_point_array['type'] = 'purchased_usd_points';
                $bonus_point_array['bpoints'] = $response[0]->purchased_amount;
                $this->bonusPointsHistory_m->save($bonus_point_array);
    
                //Send notification
                $usrArry = $this->user_m->get($response[0]->user_id);
                $body = "CONGRATULATIONS! YOUR PURCHASED REQUEST FOR AMOUNT USD".$response[0]->amount." IS SUCCESSFULLY COMPLETED AND USD-BPOINTS ARE ADDED SUCCESSFULLY";
                $this->calldemo->send_message($usrArry->mtn_mobile_number, $body);
            }
        } else if ($status == -1) { 
            $response = $this->paymentUSD_m->get_by("transaction_id = '".$txn_id."'");
            $usr_payment['status'] = 'cancel';
            $usr_payment['payment_date'] = date('Y-m-d H:i:s');
            $this->paymentUSD_m->save($usr_payment, $response[0]->id);
        } else if ($status == 1){ 
            $response = $this->paymentUSD_m->get_by("transaction_id = '".$txn_id."'");
            $usr_payment['status'] = 'in_progress';
            $usr_payment['payment_date'] = date('Y-m-d H:i:s');
            $this->paymentUSD_m->save($usr_payment, $response[0]->id);
        } 
        else { 
            $response = $this->paymentUSD_m->get_by("transaction_id = '".$txn_id."'");
            $usr_payment['status'] = 'pending';
            $usr_payment['payment_date'] = date('Y-m-d H:i:s');
            $this->paymentUSD_m->save($usr_payment, $response[0]->id);
        } 
    }

    public function check_expresspay_status()
    {
        //send box
        //$url = 'https://sandbox.expresspaygh.com/api/query.php';
        //$merchant_id = EXP_MERCHANT_SAND;
        //$api_key = EXP_APIKEY_SAND;

        //live
        $url = 'https://expresspaygh.com/api/query.php';
        $merchant_id = EXP_MERCHANT;
        $api_key = EXP_APIKEY;
        $relation = array(
            "fields" => "*",
            "conditions" => "status = 'pending'"
        );
        $pending_payments = $this->UserPayment_m->get_relation('',$relation,false);
        foreach ($pending_payments as $key => $value) 
        {
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
            
            if($decoded->result == 1)
            {
                $savedata['status'] = "approved";
                //add bpoints in user account
                $relation = array(
                    "fields" => "total_bpoints",
                    'conditions' => "user_id = " . $value['user_id']
                );
                $bpoints = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_bpoints'];
                $user_data = array("total_bpoints" => $bpoints +  $value['amount']);
                $result = $this->userSecondary_m->save($user_data, $value['user_id']);
                // Insert into bonuspoints history table
                $bonus_point_array = array();
                $bonus_point_array['user_id'] = $value['user_id'];
                $bonus_point_array['type'] = 'purchased_points';
                $bonus_point_array['bpoints'] = $value['amount'];
                $this->bonusPointsHistory_m->save($bonus_point_array);
                // Insert into Log history table
                $usrArray = $this->user_m->get($value['user_id']);
                $log_array = array();
                $log_array['user_id'] = $value['user_id'];
                $log_array['type'] = 'purchased_points';
                $log_array['message'] = serialize(
                    array( 'from' => $value['user_id'], 
                            'to' => $value['user_id'],
                        'message' => $usrArray->first_name. ' '.$usrArray->last_name . ' has purchased amount GHS'.$value['amount']
                        )
                    );               
                $this->log_m->save($log_array);
                // calculate the powerbonus
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
    
    
    public function power_bonus($user_id, $purchased_points, $type = 'ghs')
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

    public function two_days_before_auto_subcritpion()
    {
        $plan_details = $this->subscription_m->get(config_setting_item('default_subscription_plan_id'));
        $sql = "SELECT *,sh.id as sub_id,TIMESTAMPDIFF(DAY, sh.end_date, CURDATE()) as days_before from crm_user_subscription_history sh JOIN crm_users_primary u ON u.id = sh.user_id WHERE sh.is_expired = '0' AND u.auto_subscription = '1' HAVING days_before >= 2";
        $data = $this->db->query($sql)->result();
        
        foreach($data as $record)
        {
            $userSec = $this->userSecondary_m->get($record->user_id);
            if ($userSec->ewallet_usd - $plan_details->plan_price >= 0)
            {
               // expire the current plan
                $userSub['is_expired'] = '1';
                
                $this->UserSubscription_m->save($userSub, $record->sub_id);
                unset($userSub);
               
                // update the points from the USDewallet
                $userSecc['ewallet_usd'] = $userSec->ewallet_usd -  $plan_details->plan_price;
                $this->userSecondary_m->save($userSecc, $record->user_id);

                // update the subscription 
                $userSub['user_id'] = $record->user_id;
                $userSub['subscription_id'] = 1;
                $userSub['payment_mode'] = 'using_ewallet';
                $userSub['start_date'] = $record->end_date;
                $Date = strtotime($record->end_date);
                $userSub['status'] = 'complete';
                $userSub['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
                $this->UserSubscription_m->save($userSub);

                //send message to user that subscription plan is updated automatically
                $body = "Your upcoming subscription renewal. This is just friendly reminder that your ".$plan_details->plan_name." plan will be renew automatically on ". $userSub['start_date']. ". You may change your subscription plan.";
                $body = "As per your auto-subscription request, we updated plan for 1 month.Your subscription will be valid till ".date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
                $this->calldemo->send_message($record->mtn_mobile_number, $body);
                
                // Insert into Log table
                $log_array = array();
                $log_array['user_id'] = $record->user_id;
                $log_array['type'] = 'plan_auto_activated';
                $log_array['message'] = serialize(
                    array( 'from' => $record->user_id, 
                            'to' => $record->user_id,
                        'message' =>  $record->first_name . ' ' . $record->last_name . ', your plan was auto-subscribe using USD-eWallet for 1 month'
                        )
                    );
                $this->log_m->save($log_array);

                // give commission to the users [here we are giving commission on 35usd based on  ]
                $this->power_bonus($record->user_id, $plan_details->plan_price , $type = 'usd');
           }
           else if ($userSec->total_bpoints_usd - $plan_details->plan_price >= 0 )
           {
               // expire the current plan
                $userSub['is_expired'] = '1';
                $this->UserSubscription_m->save($userSub, $record->sub_id);
                unset($userSub);

                // update the points from the USDewallet
                $userSecc['total_bpoints_usd'] = ($userSec->total_bpoints_usd) - ($plan_details->plan_price);
                $this->userSecondary_m->save($userSecc, $record->user_id);

                // update the subscription 
                $userSub['user_id'] = $record->user_id;
                $userSub['subscription_id'] = 1;
                $userSub['start_date'] = $record->end_date;
                $sub_array['payment_mode'] = 'using_bpoints';
                $Date = strtotime($record->end_date);
                $userSub['status'] = 'complete';
                $userSub['end_date'] = date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
                $this->UserSubscription_m->save($userSub);

                //send message to user that subscription plan is updated automatically
                $body = "As per your auto-subscription request, we updated plan for 1 month. Your subscription will be valid till ".date('Y-m-d H:i:s', strtotime("+$plan_details->plan_duration", $Date));
                $this->calldemo->send_message($record->mtn_mobile_number, $body);
                
                // Insert into Log table
                $log_array = array();
                $log_array['user_id'] = $record->user_id;
                $log_array['type'] = 'plan_auto_activated';
                $log_array['message'] = serialize(
                    array( 'from' => $record->user_id, 
                            'to' => $record->user_id,
                        'message' =>  $record->first_name . ' ' . $record->last_name . ', your plan was auto-subscribe using USD-bPoints for 1 month'
                        )
                    );
                $this->log_m->save($log_array);

                // calculate the commission on 35[1 month subscription plan]
                $this->power_bonus($record->user_id, $plan_details->plan_price , $type = 'usd');
           }
           else{
                //send message to user that subscription plan is updated automatically
                $body = "Your eWallet doesn't contain enought points to auto-subscribe the plan. Your current plan will be deactivated at ".$record->end_date;
                $this->calldemo->send_message($record->mtn_mobile_number, $body);

                // Insert into Log table
                $log_array = array();
                $log_array['user_id'] = $record->user_id;
                $log_array['type'] = 'plan_auto_not_activated';
                $log_array['message'] = serialize(
                    array( 'from' => $record->user_id, 
                            'to' => $record->user_id,
                        'message' =>  $record->first_name . ' ' . $record->last_name . ", you didn't have 35USD into eWallet or into USD-bPoints. Please activate the plan as soons as possible to access the BOAME Forex"
                        )
                    );
                $this->log_m->save($log_array);
           }
        }
    }

    /*
    * This fyunction is used to send notification to those users whose subscription plan will be expired within 5 days 
    */
    public function five_days_before_notification()
    {
        $sql = "SELECT *,sh.id as sub_id,TIMESTAMPDIFF(DAY, sh.end_date, CURDATE()) as days_before from crm_user_subscription_history sh JOIN crm_users_primary u ON u.id = sh.user_id LEFT JOIN crm_subscription s ON s.id = sh.subscription_id WHERE sh.is_expired = '0' HAVING days_before >= 5";
        $data = $this->db->query($sql)->result();
        foreach($data as $record)
        {
            // send reminder
            $body = "Hi,".$record->first_name.' '.$record->last_name.'. We had like to take this opportunity to thank you for your support over the past '.$record->plan_duration.'. Your involvement is extremely important to us and very much appreciated.If you’re still deciding whether or not to renew, or just haven’t gotten around to it yet, please let us remind. Your subscription plan will be expired on '.date('M, D-Y h:i:s', strtotime($record->end_date));
            $this->calldemo->send_message($record->mtn_mobile_number, $body);

            // Save reminder into log
            $log_array = array();
            $log_array['user_id'] = $record->user_id;
            $log_array['type'] = '5_days_reminder';
            $log_array['message'] = serialize(
                array( 'from' => $record->user_id, 
                        'to' => $record->user_id,
                    'message' =>  $body
                    )
                );
            $this->log_m->save($log_array);
        }
    }

}