<?php
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';
if (!function_exists('generate_referal_code')) {
    
    function generate_referal_code() {
        $seed = str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, 9) as $k)
            $rand .= $seed[$k];
        return $rand.config_item('encryption_key');
    }
}

if (!function_exists('find_followers'))
{
    function find_followers($user_id)
    {
        $CI = & get_instance();
        $query = $CI->db->query("SELECT count(*) as total_followers FROM crm_users_primary WHERE parent_user_id = {$user_id} ");
        return $query->row()->total_followers;
    }
}

if ( ! function_exists('send_mail'))
{    
    function send_mail($to, $subject, $body) {
        $CI = & get_instance();
        $CI->load->library('PHPMailer_Library');
        $mail = new PHPMailer();
        $mail->debug = 2;
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host = "smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port = 587;     // SMTP port to connect to GMail
        $mail->Username = "demo.narola@gmail.com";  // user email address
        $mail->Password = "Narola@21";     // password in GMail
        $mail->Transport = 'Smtp';
        $mail->SetFrom('demo.narola@gmail.com', 'Spotashoot Support Team');  //Who is sending the email
        $mail->AddReplyTo("demo.narola@gmail.com", "Spotashoot Support Team");  //email address that receives the response
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "hello";
        $mail->AddAddress($to);
        // print_r($mail);
        // die;
        if (!$mail->send()) {
            print_r($mail->ErrorInfo);
            die;
           // print_r($mail->error_reporting());
            return 0;
        } else {
            echo "sent";
            die;
            return 1;
        }
    }
}

if ( ! function_exists('config_setting_item'))
{    
    function config_setting_item($item_name) 
    {
        $CI = & get_instance();
        $CI->db->select($item_name);
        $result = $CI->db->get('crm_settings')->row()->$item_name;
        return $result;
    }
}

if ( ! function_exists('allRecords'))
{
    function allRecords($limit,$start,$order,$dir,$table_name, $where_col = '', $where_value = '')
    {
        $CI = & get_instance();
        if (isset($where_value) && isset($where_col))
        {
             $query = $CI->db->limit($limit,$start)
                ->where($where_col, $where_value)
                ->order_by($order, $dir)
                ->get($table_name);
        }
        else
        {
            $query = $CI->db->limit($limit,$start)
                ->order_by($order, $dir)
                ->get($table_name);
        }
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
}

if ( ! function_exists('record_search'))
{
    function record_search($limit,$start,$search,$order,$dir,$table_name,$cols, $where_col = '', $where_value = '')
    {
        $CI = & get_instance();
        if (isset($where_value) && isset($where_col))
        {
            $CI->db->where($where_col, $where_value);
        }
        $query = '(';
        foreach ($cols as $key => $value) {
            $query = $query. "$value LIKE '%$search%' OR ";
        }
        $query = $query. "id LIKE '%$search%')";
        $CI->db->where($query);
        $CI->db->limit($limit,$start);
        $query = $CI->db->get($table_name);
          
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
}

if ( ! function_exists('record_search_count'))
{
    function record_search_count($search, $table_name,$cols,$where_col = '', $where_value = '')
    {
        $CI = & get_instance();
        if (isset($where_value) && isset($where_col))
        {
            $CI->db->where($where_col, $where_value);
        }
        $query = '(';
        foreach ($cols as $key => $value) {
            $query = $query. "$value LIKE '%$search%' OR ";
        }
        $query = $query. "id LIKE '%$search%')";
        $CI->db->where($query);
        $query = $CI->db->get($table_name);
        return $query->num_rows();
    }
}

function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;
    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

if (! function_exists('send_forex_robot'))
{
    function send_forex_robot($email)
    {
        require_once(APPPATH."third_party/PHPMailer/src/PHPMailer.php");
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "ssl://mail.boame.net";
        $mail->Port = 465; 
        $mail->IsHTML(true);
        $mail->Username = FROM_EMAIL; // SET YOUR GMAIL EMAIL ID 
        $mail->Password = FROM_PASSWORD; // SET YOUR GMAIL PASSWORD
        $mail->SetFrom(FROM_EMAIL);
        $mail->Subject = 'Forex Robot Subscription - BOAME TEAM';
        $mail->AddAddress($email);
        $mail->AddAttachment('ForexRobot.ex4');
        $mail->Body = '<p><strong>Hello,</strong></p>
        <p>Congratulations, You are subscribed for the Forex Robot successfully. As you are subscribed for the first time, We have sent you forex Robot file. Would you please save this file for the future use.</p>
        <p>Happy Trading !!</p>
        <p><strong>Thanks,</strong><br /><strong>BOAME TEAM</strong></p>';
        $file = 'ForexRobot.ex4';
        if ( $mail->send() ) {
            return "success";
            //redirect('member/pledge/index');
        } else {
            return "unsuccess";
            //redirect('member/pledge/index');
        }
    }
}

/*
    Send push notification on android device based on the device token
*/
function send_push_notification($reg_id, $isNotificationType, $payload)
{
    $fields = array();
    //$isNotificationType is Boolean value
    if ($isNotificationType) {

        if (is_array($reg_id)) {
            $fields['registration_ids'] = $reg_id;

        } else {
            $fields['to'] = $reg_id;
        }

        $fields['priority'] = "high";
        $fields['notification'] = $payload;

    } else {

        if (is_array($reg_id)) {
            $fields['registration_ids'] = $reg_id;

        } else {
            $fields['to'] = $reg_id;
        }

        $fields['priority'] = "high";
        $fields['data'] = $payload;
        //$fields[NOTIFICATION_BADGE] = $badgeCount;
    }
    $headers = array(
        'Authorization: key=' . FIRE_BASE_SERVER_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, FIRE_BASE_FCM_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Problem occurred: ' . curl_error($ch));
    }

    curl_close($ch);
    //$result;
    //echo $result;
    return $result;
}

/*
to make the entry into notificatyion tablr on each event
*/
function insert_notification_detail($type, $title, $message, $admin_notification, $user_id)
{
    $notification['notification_type'] = $type;
    $notification['notification_title'] = $title;
    $notification['notification_message'] = $message;
    $notification['admin_notification'] = $admin_notification;
    $notification['user_id'] = $user_id;
    $CI = & get_instance();
    $id = $CI->db->insert('crm_notification',$notification);
    return $id;
}

/*
Set the payload of the push notification for android device
*/
function set_payload($type, $notification_id, $message)
{
    $pay_load_data = array(
        'Notification_Type' => $type,
        'data' => array(
            'Notification_Type' => $type,
            'notification_id' => $notification_id, 
            'Notification_Message' => $message)
        );
    return $pay_load_data;
}

/**
* used to find the how many days ago event occured.
*/
function get_timeago_pledge( $ftime, $ptime )
{
    $estimate_time = $ftime - $ptime;
    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return  $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' remaining';
        }
    }
}

/**
* Generate the link using branch.io which can be used to generate the unique link for mobile and website. Based on the device type it will redirect. If App installed than it will redirect to app and if not than play store.
*/
function generate_link($desktop_url, $Referral_Code)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.branch.io/v1/url",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n  \"branch_key\": \"key_live_pdD7hhAFzX7s0vJaEZN83nbhuwnC5x7S\",\n  \"data\": {\n    \"\$desktop_url\": \"$desktop_url\"\n, \n    \"Referral_Code\": \"$Referral_Code\"\n  }\n}\n",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 835715be-fdc7-b2e6-ca97-b7b9b8f4555b"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      return false;
    } else {
      return $response;
    }
}

function receive_payment_to_merchant()
{
    $receive_momo_request = array(
    'CustomerName' => 'Customer Name',
    'CustomerMsisdn'=> '054XXXX',
    'CustomerEmail'=> 'customer@gmail.com',
    'Channel'=> 'mtn-gh',
    'Amount'=> 0.8,
    'PrimaryCallbackUrl'=> 'http://requestb.in/1minotz1',
    'SecondaryCallbackUrl'=> 'http://requestb.in/1minotz1',
    'Description'=> 'T Shirt',
    'ClientReference'=> '23213', // random string we can pass
    'FeesOnCustomer' => true
    );
    //API Keys
    $clientId = CLIENT_ID;
    $clientSecret = CLIENT_SECRECT;
    $basic_auth_key =  'Basic ' . base64_encode($clientId . ':' . $clientSecret);
    $request_url = 'https://api.hubtel.com/v1/merchantaccount/merchants/HMXXXXXXX/receive/mobilemoney';
    $receive_momo_request = json_encode($receive_momo_request);

    $ch =  curl_init($request_url);  
            curl_setopt( $ch, CURLOPT_POST, true );  
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $receive_momo_request);  
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );  
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: '.$basic_auth_key,
                'Cache-Control: no-cache',
                'Content-Type: application/json',
              ));

    $result = curl_exec($ch); 
    $err = curl_error($ch);
    curl_close($ch);

    if($err){
        echo $err;
    }else{
        echo $result;
    }
}

function expresspay_submit_data($first_name,$last_name,$email,$phone_no,$amount,$order_id)
{ 
    //send box
//    $url = 'https://sandbox.expresspaygh.com/api/submit.php';
//    $merchant_id = EXP_MERCHANT_SAND;
//    $api_key = EXP_APIKEY_SAND;
    
    //live
    $url = 'https://expresspaygh.com/api/submit.php';
    $merchant_id = EXP_MERCHANT;
    $api_key = EXP_APIKEY;

    $params = array(
        'merchant-id' => $merchant_id,
        'api-key' => $api_key,
        'firstname' => $first_name,
        'lastname' => $last_name,
        'email' => $email,
        'phonenumber' => $phone_no,
        'currency' => "GHS",
        'amount' => $amount,
        'order-id' => $order_id,
        'redirect-url' => base_url()."expresspayment_done",
        'post-url' => base_url()."expresspayment_posturl/".$order_id
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
    return $decoded;
}

