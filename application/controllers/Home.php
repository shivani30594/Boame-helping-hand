<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';
class Home extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $this->load->model('news_m');
        $this->load->model('user_m');
        $this->load->model('contactUs_m');
        $this->load->model('notification_m');
        $this->load->model('donatoresQueue_m');
        $this->load->model('WantsToDonateQueue_m');
        $this->load->model('UserPayment_m');
        $this->load->model('userSecondary_m');
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        $this->load->model('withdrawalRequest_m');
        $this->load->model('testimonial_m');
        $this->load->library('CallDemo');
    }
    
    public function comming_soon()
    {
        $this->load->view('comming_soon/home');
    }

	public function index()
	{
		$this->session->set_userdata('web', true);
		$relation = array(
            "fields" => "*",
            );
        $old_gh_amount = $this->WantsToDonateQueue_m->get_relation('', $relation, true) * 100;
        $relationn = array(
            "fields" => "sum(withdraw_amount) as net_withdrawal",
            'conditions' => "is_withdraw LIKE 'complete'"
            );
        $net_withdrawal = $this->withdrawalRequest_m->get_relation('', $relationn, false)[0]['net_withdrawal'];
        $this->data['total_gh_amount'] = $old_gh_amount + $net_withdrawal ;

        $old_gHCount = $this->WantsToDonateQueue_m->get_relation('', $relation, true);
        $new_gHCount = count($this->withdrawalRequest_m->get_by("is_withdraw LIKE 'complete'"));
        $this->data['gHCount'] = $old_gHCount + $new_gHCount;

        $relation = array(
            "fields" => "*",
            );
        $this->data['total_ph_amount'] = $this->donatoresQueue_m->get_relation('', $relation, true) * 100;
        $old_pHCount = $this->donatoresQueue_m->get_relation('', $relation, true);
        $new_pHCount = count($this->user_m->get_by("is_eproduct_plan = '1'"));
        $this->data['pHCount'] = $old_pHCount + $new_pHCount;

        $relation = array(
            "fields" => "*",
            'conditions' => "is_deleted = 'N'"
            );
        $this->data['total_users'] = $this->user_m->get_relation('', $relation, true);
		$this->data['news'] = $this->news_m->get();
		
//        $query = "SELECT COUNT(*) as count , parent_user_id as id from crm_users_primary LEFT JOIN crm_users_secondary on crm_users_primary.`parent_user_id` = crm_users_secondary.user_id GROUP BY crm_users_primary.parent_user_id ORDER BY COUNT(*) DESC LIMIT 0,20";
//        $array1 = $this->db->query($query)->result_array();
//        $id_array = array_column($array1, 'id');
//        $string = implode(',', $id_array);
//        $query = "SELECT CONCAT(up.first_name,' ',up.last_name) as Name, up.id , rd.refferal_code as ReferralCode from crm_users_primary up LEFT JOIN crm_refferal_details rd on up.id = rd.user_id WHERE up.id IN ( $string )";
//        $array2 = $this->db->query($query)->result_array();
//        $data = array();
//        $arrayAB = array_merge($array1,$array2);
//        foreach ($arrayAB as $value) {
//          $id = $value['id'];
//          if (!isset($data[$id])) {
//            $data[$id] = array();
//          }
//          $data[$id] = array_merge($data[$id],$value);
//        }
                
        $query = "SELECT crm_refferal_details.refferal_count,crm_refferal_details.refferal_code,crm_users_primary.first_name,crm_users_primary.last_name,crm_users_primary.id FROM `crm_users_primary` LEFT JOIN crm_refferal_details on crm_users_primary.id = crm_refferal_details.user_id ORDER BY crm_refferal_details.refferal_count DESC LIMIT 0,20";   

        $data = $this->db->query($query)->result_array();
        $this->data['top_twenty_users'] = $data;

        $relation = array(
            "fields" => "*",
            'conditions' => "is_active = 'Y' AND is_mobile_verified = 'Y' "
            );
        $this->data['total_active_users'] = $this->user_m->get_relation('', $relation, true);

        $relation = array(
            "fields" => "*",
            'conditions' => "status ='approved'"
            );
        $this->data['testimonials'] = $this->testimonial_m->get_relation('', $relation, false);

        $this->data['login_url'] = $this->facebook->login_url();

        $this->load->view('front-end/home', $this->data);
	}

	public function login()
	{
		$this->load->view('components/maintaince_page');
	}
	public function opportunity()
	{
		$this->load->view('front-end/opportunity');
	}

	public function index_temp()
	{
		$this->session->set_userdata('web', true);
		$relation = array(
            "fields" => "*",
            'conditions' => "is_confirmed = 'Y'"
            );
        $this->data['total_gh_amount'] = $this->WantsToDonateQueue_m->get_relation('', $relation, true) * 100;
        $this->data['gHCount'] = $this->WantsToDonateQueue_m->get_relation('', $relation, true);
        $relation = array(
            "fields" => "*",
            'conditions' => "is_confirmed = 'Y'"
            );
        $this->data['total_ph_amount'] = $this->donatoresQueue_m->get_relation('', $relation, true) * 100;
        $this->data['pHCount'] = $this->donatoresQueue_m->get_relation('', $relation, true);
        $relation = array(
            "fields" => "*",
            'conditions' => "is_deleted = 'N'"
            );
        $this->data['total_users'] = $this->user_m->get_relation('', $relation, true);
        $this->data['news'] = $this->news_m->get();
        $sql = "SELECT CONCAT(up.first_name,' ',up.last_name) as Name, rd.refferal_code as ReferralCode, rd.refferal_count as count from crm_users_primary up LEFT JOIN crm_refferal_details rd on up.id = rd.user_id LEFT JOIN crm_users_secondary us on up.id = us.user_id WHERE up.is_deleted = 'N' AND up.is_active = 'Y' ORDER BY rd.refferal_count DESC LIMIT 20";
        $this->data['top_twenty_users'] = $this->db->query($sql)->result_array();
		/*$relation = array(
            "fields" => "*",
            'conditions' => "is_deleted = 'N'",
            'ORDER_BY' => array(
	            'field' => 'crm_notification.created',
	            'order' => 'DESC'
	        	),
            );
        $this->data['top_notification'] = $this->notification_m->get_relation('', $relation, false);
        print_r($this->data['top_notification']);
        die;*/
		$relation = array(
            "fields" => "*",
            'conditions' => "is_active = 'Y' AND is_mobile_verified = 'Y' "
            );
        $this->data['total_active_users'] = $this->user_m->get_relation('', $relation, true);
		$this->data['login_url'] = $this->facebook->login_url();
		$this->load->view('front-end/home_temp', $this->data);
	}

	public function facebook()
	{
		if ($this->facebook->is_authenticated()) {
			echo "here";
		}
	}
	public function contact_us()
	{
		$this->data['login_url'] = $this->facebook->login_url();
		$this->load->view('front-end/contact_us', $this->data);
	}

	public function how_it_work()
	{
		$this->data['login_url'] = $this->facebook->login_url();
		$this->load->view('front-end/how_it_work', $this->data);
	}

	public function view_all()
	{
		$this->data['news'] = $this->news_m->get();
		$this->data['login_url'] = $this->facebook->login_url();
		$this->load->view('front-end/view_all', $this->data);
	}

	public function add_contact_us()
	{
		$contact_array['name'] = $this->input->post('name');
		$contact_array['message'] = $this->input->post('message');
		$contact_array['email'] = $this->input->post('email');
		$contact_array['subject'] = $this->input->post('subject');
		$id = $this->contactUs_m->save($contact_array);
		if ($id)
		{
			$body = "<p><strong>Hello</strong> <strong>Kofi</strong>,</p>
				<p><strong>Subject</strong> : ".$contact_array['subject']."</p>
				<p><strong>Body</strong> : ".$contact_array['message']."</p>
				<p>We are waiting for your valid response!</p>
				<p><strong>Thank you</strong>,</p>
				<p>".$contact_array['name']."</p>
				<p>&nbsp;</p>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$contact_array['email']."\r\n".
			'Reply-To: '.$contact_array['email']."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			@mail('support@boame.net', $contact_array['subject'] , $body, $headers);
			$this->session->set_flashdata('success', 'Your message has been send successfully');
		}
		else
		{
			$this->session->set_flashdata('danger', 'Something happens wrong! Please try again later.');
		}
		redirect('home/contact_us');
	}

	public function single($id = ' ')
	{
		if ($id)
		{
			$this->data['news'] = $this->news_m->get($id);
			$this->data['login_url'] = $this->facebook->login_url();
			$this->load->view('front-end/single_news', $this->data);
		}
	}

	/**
	* function called from home page ajax view and this portion will refresh after every 2 mins
	*/
	public function notifications()
	{
		$this->db->from('crm_notification');
		$this->db->order_by("created", "desc");
		$this->db->limit(5, 0); 
		$query = $this->db->get(); 
		echo json_encode($query->result());
	}
        
        /*
         * 
         */
        
        public function expresspayment_done()
        {
            $order_id = $_GET['order-id'];
            $token =  $_GET['token']; 
            $relation = array(
            "fields" => "*",
            'conditions' => "order_id ='" . $order_id . "' AND token = '" . $token ."'"
            );
            $payment_details = $this->UserPayment_m->get_relation('', $relation, false);
            $payment_id = $payment_details[0]['id'];
            $payment_data = array("checkout_response" => 1);
            $this->UserPayment_m->save($payment_data ,$payment_id);
            $this->session->set_flashdata('success', 'Congratulations! You have completed payment process, Requested Bpoints will be added in your account once your payment will approved.');
            redirect('user/signin');
        }
        
        public function expresspayment_posturl($order_id)
        {
            $relation = array(
            "fields" => "*",
            'conditions' => "order_id ='" . $order_id . "'"
            );
            $payment_details = $this->UserPayment_m->get_relation('', $relation, false);
            $payment_id = $payment_details[0]['id'];
            $token = $payment_details[0]['token'];
            $user_id = $payment_details[0]['user_id'];
            $amount = $payment_details[0]['amount'];
            
             //send box
            //$url = 'https://sandbox.expresspaygh.com/api/query.php';
            //$merchant_id = EXP_MERCHANT_SAND;
            //$api_key = EXP_APIKEY_SAND;

            //live
            $url = 'https://expresspaygh.com/api/query.php';
            $merchant_id = EXP_MERCHANT;
            $api_key = EXP_APIKEY;

            $params = array(
                'merchant-id' => $merchant_id,
                'api-key' => $api_key,
                'token' => $token
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
                    'conditions' => "user_id = " . $user_id
                );
                $bpoints = $this->userSecondary_m->get_relation('', $relation, false)[0]['total_bpoints'];
                $user_data = array("total_bpoints" => $bpoints +  $amount);
                $result = $this->userSecondary_m->save($user_data, $user_id);
                
                $this->power_bonus($user_id, $amount);
                
                $body = "Your purchase request for Amount GHS".$amount." is successfully completed and BPoints are updated successfully";
                //*****************************send notification******************************
                $usrArry = $this->user_m->get($user_id);
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
            $this->UserPayment_m->save($savedata ,$payment_id);
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
    
    public function boame_fx()
    {
        $this->load->view('front-end/boame_fx');
    }
}