<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';
class Pledge extends MY_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('pledgeType_m');
        $this->load->model('user_m');
        $this->load->model('userSecondary_m');
        $this->load->model('pledgeHistory_m');
        $this->load->model('donatoresQueue_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->model('pledgeLog_m');
        $this->load->model('ewallet_m');
        $this->load->model('WantsToDonateQueue_m');
        $this->load->model('setting_m');
        $this->load->model('report_m');
        $this->load->model('pledgeDetails_m');
        $this->load->library('CallDemo');
        $this->session->keep_flashdata('message');
        if (!$this->session->userdata('user_id'))
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * Initially we load all the pledge created by current user
    */
    public function index()
    {
        $this->data['meta_title'] = "Pledge - BOAME";
        $this->data['subview'] = 'member/pledge/index';
        $this->data['script'] = 'member/pledge/script';
        $this->load->view('_layout_main', $this->data);
    }

    /**
    * Call through Ajax, which will take the data from the database and display it.
    */
    public function indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'pm.pledge_type',
                    2 => 'wdq.pledge_title',
                    3 => 'wdq.pledge_date',
                    4 => 'wdq.created'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->WantsToDonateQueue_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->WantsToDonateQueue_m->allpledge($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->WantsToDonateQueue_m->pledge_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->WantsToDonateQueue_m->pledge_search_count($search);
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

    /**
    * When any user click on the create pledge, it will take the pledge count detail and load the view
    */
    public function create_pledge()
    {
        $this->data['meta_title'] = "Create Pledge - BOAME";
        $this->data['pledge_detail_options'] = $this->pledgeDetails_m->get();
        $this->data['subview'] = 'member/pledge_create/index';
        $this->data['script'] = 'member/pledge_create/script';
        $relation = array(
            'fields' => '*',
            "conditions" => "is_deleted = 'N'"
        );
        $this->data['pledge_types'] = $this->pledgeType_m->get_relation('',$relation, false);
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $pledge_details = $this->userSecondary_m->get_relation('', $relation, false);
        $this->data['pledge_per_week']  = $pledge_details[0]['pledge_per_week'];
        $this->data['pledge_per_month']  = $pledge_details[0]['pledge_per_month'];
        $this->load->view('_layout_main', $this->data);
    }

    /**
    * Submit the pledge data into database
    */
    public function add_pledge()
    {
        $user_id = $this->session->userdata('user_id');
        $flag = false;
        $uDetails = $this->user_m->get($user_id);
        if (isset($uDetails) AND ($uDetails->mtn_mobile_name == '' OR $uDetails->mtn_mobile_number == ''))
        {
            $this->session->set_flashdata('error', 'Please update your MTN details by editing user profile and get back to create the pledge');
            redirect('pledge_history');
        }
        $relation = array(
            'fields' => '*',
            "conditions" => "user_id = ". $user_id
        );
        $ewallet = $this->userSecondary_m->get_relation('',$relation, false)[0]['ewallet'];
        $pledge_per_month = $this->userSecondary_m->get_relation('',$relation, false)[0]['pledge_per_month'];
        $user_sec_array = $this->userSecondary_m->get_relation('',$relation, false);
        $points_required_for_one_pledge = $this->setting_m->get()[0]->points_required_for_one_pledge;
        $max_pledge_per_month = $this->setting_m->get()[0]->max_pledge_per_month;
        if ($pledge_per_month == $max_pledge_per_month OR $user_sec_array[0]['pledge_per_week'] == 5)
        {
            $admin_notification = $this->session->userdata('name'). " has reached to maximum pledge per week." ;
            $notification_id = insert_notification_detail('pledge',"Pledge Limitation","You have reached your maximum pledge per week. Please check again next week." ,$admin_notification, $user_id); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "You have reached your maximum pledge per week. Please check again next week.");
            $user_detail = $this->user_m->get($user_id);
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            $this->session->set_flashdata('error', 'You have reached your maximum pledge per week. Please check again next week');
            redirect('pledge_history');
        }
        $relation = array(
        'fields' => '*',
        "conditions" => "user_id = ". $user_id
        );
        $total_bpoints = $this->userSecondary_m->get_relation('',$relation, false)[0]['total_bpoints'];
        if (($total_bpoints - $points_required_for_one_pledge) >= 0)
        {
            $user_sec['total_bpoints'] = $total_bpoints - $points_required_for_one_pledge;
            $user_sec['pledge_per_month'] = $user_sec_array[0]['pledge_per_month'] + 1;
            $user_sec['pledge_per_week'] = $user_sec_array[0]['pledge_per_week'] + 1;
            $user_sec['total_pledge_count'] = $user_sec_array[0]['total_pledge_count'] + 1;
            //update total bonus points and pledge per month 
            $id = $this->savePledgeQueue(); //insert pledge details into wants_to_plege_queue tabel
            $result = $this->userSecondary_m->save($user_sec, $user_id);
            if ($result)
            {
                $flag = true;
                $this->session->set_flashdata('success','Pledge created successfully');
                // send notification
                  // send push notification for the owner
                $user_detail = $this->user_m->get($user_id);
                $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just created pledge";
                $notification_id = insert_notification_detail('pledge',"Pledge creation","You have pledged. Please have patience as we match you with others to pay to you. Process is undergoing so you will be paired with any user soon. Enjoy!",$admin_notification, $user_id); // common helper function
                $pay_load_data = set_payload('pledge', $notification_id, "You have pledged. Please have patience as we match you with others to pay to you. Process is undergoing so you will be paired with any user soon. Enjoy!");
                if ($user_detail->device_type == '0')
                {
                    send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
                }
                unset($user_detail);

                redirect('pledge_history');
            } 
        }
        if ($flag == false)
        {
            if (($ewallet - $points_required_for_one_pledge) >= 0)
            {
                $user_sec['ewallet'] = $ewallet - $points_required_for_one_pledge;
                $user_sec['pledge_per_month'] = $user_sec_array[0]['pledge_per_month'] + 1;
                $user_sec['pledge_per_week'] = $user_sec_array[0]['pledge_per_week'] + 1;
                $user_sec['total_pledge_count'] = $user_sec_array[0]['total_pledge_count'] + 1;
              //  $user_sec['created'] = date('Y-m-d H:i:s', strtotime(time()));
                //update total bonus points and pledge per month 
                $id = $this->savePledgeQueue(); //insert pledge details into wants_to_plege_queue tabel
                $result = $this->userSecondary_m->save($user_sec, $user_id);
                if ($result)
                {
                    $this->session->set_flashdata('success','Pledge created successfully');
                    // send notification
                      // send push notification for the owner
                    $user_detail = $this->user_m->get($user_id);
                    $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just created pledge.";
                    $notification_id = insert_notification_detail('pledge',"Pledge creation","You have pledged. Please have patience as we match you with others to pay to you. Process is undergoing so you will be paired with any user soon. Enjoy!",$admin_notification, $user_id); // common helper function
                    $pay_load_data = set_payload('pledge', $notification_id, "You have pledged. Please have patience as we match you with others to pay to you. Process is undergoing so you will be paired with any user soon. Enjoy!");
                    if ($user_detail->device_type == '0')
                    {
                        send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
                    }
                    unset($user_detail);

                    redirect('pledge_history');
                    //redirect
                }
                else
                {
                    $this->session->set_flashdata('error','Pledge can not be created. Please check you BPoints and ewallet balance');
                    redirect('pledge_history');
                    //redirect
                }
            }
            else
            {
                $this->session->set_flashdata('error','You dont have enough BPoints and ewallet points to create the pledge. Please purchased some points from the EMALL');
                redirect('pledge_history');
                exit;
            }
        }
    }

    /** 
    * This function is used for add the plede into wants to donate queue table 
    */
    public function savePledgeQueue()
    {
        $want_pledge_arr['user_id'] = $this->session->userdata('user_id');
        $want_pledge_arr['pledge_title'] = $this->input->post('pledge_title');
        if ($this->input->post('pledge_title') && $this->input->post('pledge_title') == 'Others')
        {
            $want_pledge_arr['pledge_title'] = $this->input->post('pledge_other_details');
        }
        $want_pledge_arr['pledge_type_id'] = $this->input->post('pledge_type');
        $want_pledge_arr['pledge_date'] = date("Y-m-d H:i:s");
        $pledge_queue_id = $this->WantsToDonateQueue_m->save($want_pledge_arr);
        return $pledge_queue_id;
    }

    // When click on report button mail is send i.e for active pledge. Ex. kofi will be able to get GHS100 from two users after matching found this will be displayed.  
    public function report_complain()
    {
        $pledge_id = $this->input->post('pledge_id');
        $body = $this->input->post('reason');
        $relation = array(
            'fields' => '*',
            "conditions" => "wants_to_donate_id = ". $pledge_id
            );
        $array = $this->pledgeLog_m->get_relation('',$relation, false);
        $user_by = $this->user_m->get($array[0]['borrower_id']);
        $user_to = $this->user_m->get($array[0]['investor_id']);
        $body_mail = "<html><body>
                    Hello admin,<br>
                    <br>Report Reason : " . $body . "</br>
                    <br>Reported by : " . $user_by->first_name . " " . $user_by->last_name . "  ( +".$user_by->mtn_mobile_number ." )</br>
                    <br>Reported to : " . $user_to->first_name . " " . $user_to->last_name. " ( + ".$user_to->mtn_mobile_number ." )</br>";
        $body_mail .=  "Regards,</br>BOAME Team</br>";
        $flag = $this->send_mail($body_mail);
        if ($array && $flag == 'success')
        {
            $report_array['report_by_id'] = $array[0]['investor_id'];
            $report_array['report_to_id'] = $array[0]['borrower_id'];
            $report_array['report_comment'] = $body;
            $report_array['report_donetores_queue_id'] = $array[0]['donetores_queue_id'];
            $report_array['report_wants_to_donate_id'] = $array[0]['wants_to_donate_id'];
            $id = $this->report_m->save($report_array);
            if ($id)
            {
               
                $this->session->set_flashdata('success','Your complain will be reported to the admin successfully');
                redirect('pledge_history');
            }
            else
            {
                $this->session->set_flashdata('error','Please complain again after some time.');
                redirect('pledge_history');
            }
        }
        else
        {
            $this->session->set_flashdata('error','Please complain again after some time.');
            redirect('pledge_history');
        }
    }

    // Send the complain report to admin. This is for the user who already pay GHS100 to matching user but matching user didn't confirm the payment.
    public function report_complain_pending()
    {
        $pledge_id = $this->input->post('pledge_id');
        $body = $this->input->post('reason');
        if ($this->input->post('transaction_id'))
        {
            $transaction_id = $this->input->post('transaction_id');
        }
        else
        {
            $transaction_id = ' ';
        }
        $array = $this->pledgeLog_m->get($pledge_id);
        $user_by = $this->user_m->get($array->borrower_id);
        $user_to = $this->user_m->get($array->investor_id);
        $body_mail = "<html><body>
                    Hello admin,<br>
                    <br>Report Reason : " . $body . "</br>
                    <br>Reported by : " . $user_by->first_name . " " . $user_by->last_name . "  ( +".$user_by->mtn_mobile_number ." )</br>
                    <br>Reported to : " . $user_to->first_name . " " . $user_to->last_name. " ( + ".$user_to->mtn_mobile_number ." )</br>";
        $body_mail .= $transaction_id != ' ' ? "<br>Transaction id : ".$transaction_id."</br></br>" : " ";
        $body_mail .=  "Regards,</br>BOAME Team</br>";
        $flag = $this->send_mail($body_mail); // if flag == true then mail sent successfuly
        if ($array && $flag == "success")
        {
            $report_array['report_by_id'] = $array->investor_id;
            $report_array['report_to_id'] = $array->borrower_id;
            $report_array['report_comment'] = $body;
            $report_array['report_donetores_queue_id'] = $array->donetores_queue_id;
            $report_array['report_wants_to_donate_id'] = $array->wants_to_donate_id;
            $report_array['transaction_id'] = $transaction_id;
            $id = $this->report_m->save($report_array);
            if ($id)
            {
                $this->session->set_flashdata('success','Your complain will be reported to the admin successfully');
                redirect('pledge_history');
                
            }
            else
            {
                $this->session->set_flashdata('error','Please complain again after some time.');
                redirect('pledge_history');
            }
        }
        else
        {
            $this->session->set_flashdata('error','Something happen wrong.Try again Later.');
            redirect('pledge_history');
        }
        exit;

    }

    // Display complain report form for active pledge 
    public function report($id = '')
    {
        $this->data['meta_title'] = "Report - BOAME";
        $this->data['subview'] = 'member/pledge_report/index';
        $this->data['script'] = 'member/pledge_report/script';
        $this->data['pledge_id'] = $id;
        $this->load->view('_layout_main', $this->data);
    }

    // Display complain report form for plegde who requires transaction id.
    public function complaint($id = '')
    {
        $this->data['meta_title'] = "Report - BOAME";
        $this->data['subview'] = 'member/complaint/index';
        $this->data['script'] = 'member/complaint/script';
        $this->data['pledge_id'] = $id;
        $this->load->view('_layout_main', $this->data);
    }

    /**
    * Send report complain to the user
    */
    public function send_mail($body = '')
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
        $mail->Subject = SUBJECT;
        $mail->AddAddress(TO_EMAIL);
        $mail->Body = $body;
        if ( $mail->send() ) {
            return "success";
            //redirect('member/pledge/index');
        } else {
            return "unsuccess";
            //redirect('member/pledge/index');
        }
    }

    public function view_details($id = '')
    {
        if ($id)
        {
            $pledge_id = $id; 
            $relation = array(
                'fields' => '*',
                "conditions" => "id = ". $pledge_id
                );
            $total = $this->donatoresQueue_m->get_relation('',$relation, true);
            if ($total > 0)
            {
                $this->active_pledge_view($pledge_id);
            }
            else
            {
                $this->data['meta_title'] = "BOAME Referral| Web Application";
                $relation = array(
                    'fields' => '*',
                    "conditions" => "borrower_id = ". $this->session->userdata('user_id'). " AND wants_to_donate_id = ".$pledge_id
                );
                $result = $this->pledgeLog_m->get_relation('', $relation, false);
                if (count($result) > 0)
                {
                    $this->data['borrower_array'] = $this->user_m->get($result[0]['borrower_id']);
                    $this->data['investore_array'] = $this->user_m->get($result[0]['investor_id']); 
                    $ary = $this->donatoresQueue_m->get($result[0]['donetores_queue_id']);
                    $sql = "SELECT * from crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id WHERE wdq.id = ".$ary->wants_to_donate_id;
                    $this->data['opposite_pledge_detail'] = $this->db->query($sql)->result();
                    $this->data['detail'] = $result;
                }
                else
                {
                    $this->data['borrower_array'] = $this->user_m->get($this->session->userdata('user_id'));
                }
                $sql = "SELECT * from crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id WHERE wdq.id = ".$pledge_id;
                $this->data['pledge_detail'] = $this->db->query($sql)->result();
                $this->data['subview'] = 'member/pledge/pending_pledge_index';   
                $this->load->view('_layout_main', $this->data);  
            }
        }
    }
    
    /**
    * i.e. If I am found as matching pair of kofi. So, this function will find the details of the user to whom i hvae to pay GHS100.
    */ 
    public function view($id = '')
    {
        if ($id)
        {
            $pledge_id = $id; 
            $relation = array(
                'fields' => '*',
                "conditions" => "wants_to_donate_id = ". $pledge_id
                );
            $total = $this->donatoresQueue_m->get_relation('',$relation, true);
            if ($total > 0)
            {
                $this->active_pledge_view($pledge_id);
            }
            else
            {
                $this->data['meta_title'] = "BOAME Referral| Web Application";
                $relation = array(
                    'fields' => '*',
                    "conditions" => "borrower_id = ". $this->session->userdata('user_id'). " AND wants_to_donate_id = ".$pledge_id
                );
                $result = $this->pledgeLog_m->get_relation('', $relation, false);
                if (count($result) > 0)
                {
                    $this->data['borrower_array'] = $this->user_m->get($result[0]['borrower_id']);
                    $this->data['investore_array'] = $this->user_m->get($result[0]['investor_id']); 
                    $ary = $this->donatoresQueue_m->get($result[0]['donetores_queue_id']);
                    $sql = "SELECT * from crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id WHERE wdq.id = ".$ary->wants_to_donate_id;
                    $this->data['opposite_pledge_detail'] = $this->db->query($sql)->result();
                    $this->data['detail'] = $result;
                }
                else
                {
                    $this->data['borrower_array'] = $this->user_m->get($this->session->userdata('user_id'));
                }
                $sql = "SELECT * from crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id WHERE wdq.id = ".$pledge_id;
                $this->data['pledge_detail'] = $this->db->query($sql)->result();
                $this->data['subview'] = 'member/pledge/pending_pledge_index';   
                $this->load->view('_layout_main', $this->data);  
            }
        }
    }

    /**
    * To display active pledge index page.
    */ 
    public function active_pledge()
    {
        $this->data['meta_title'] = "Active Pledge - BOAME";
        $this->data['subview'] = 'member/active_pledge/index';
        $this->data['script'] = 'member/active_pledge/script';
        $this->load->view('_layout_main', $this->data);
    }

    /**
    * Ajax function which will load the data into datatable, search functionality and pagination
    */
    public function active_pledge_indexjson()
    {
        $columns = array( 
                    0 => 'id', 
                    1 => 'pledge_type_id',
                    2 => 'pledge_title',
                    3 => 'pledge_date'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $relation = array(
            "fields" => "*",
            "conditions" => "user_id = ". $this->session->userdata('user_id')
        );
        $totalData = $this->donatoresQueue_m->get_relation('', $relation, true);
        $totalFiltered = $totalData; 
        if (empty($this->input->post('search')['value']))
        {            
            $pledge_list = $this->donatoresQueue_m->active_allpledge($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $pledge_list =  $this->donatoresQueue_m->active_pledge_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->donatoresQueue_m->active_pledge_search_count($search);
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

    /**
    * i.e. kofi able to get GHS100 from 2 users. So, this function will find out the details of these two user and display it as matching users
    */
    public function active_pledge_view($id = '')
    {
        if ($id)
        {
            $donatores = $this->donatoresQueue_m->get($id);
            $this->data['own_pledge_detail'] = $this->WantsToDonateQueue_m->get($donatores->wants_to_donate_id);
            $this->data['pledge_type_detail'] = $this->pledgeType_m->get($this->data['own_pledge_detail']->pledge_type_id);
            $user_id = $this->session->userdata('user_id');
            $sql = "SELECT wdq.id, up.first_name, up.last_name, up.picture, cpl.start_date, cpl.end_date, up.mtn_mobile_number, cpl.is_confirmed, wdq.pledge_title, pm.pledge_type FROM crm_pledge_log cpl LEFT JOIN crm_wants_to_donate_queue wdq on cpl.wants_to_donate_id = wdq.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary up on wdq.user_id = up.id WHERE cpl.is_confirmed != 'CANCEL' AND cpl.investor_id = $user_id AND cpl.donetores_queue_id = $id";
            $result = $this->db->query($sql);
            if ($result->num_rows()>0)
            {
               $this->data['pledge_listing'] =  $result->result();
            }
            $this->data['meta_title'] = "BOAME Referral| Web Application";
            $this->data['subview'] = 'member/active_pledge/pledge_detail';
            $this->data['script'] = 'member/active_pledge/script';
            $this->data['details'] = $this->user_m->get($user_id);
            $this->load->view('_layout_main', $this->data);
        }
    }

    /**
    * When kofi click for confirm payment for the opposite user then change the status and send notification to both and admin.
    */
    public function confim_payment_of_pledge($id = '')
    {
        if ($id)
        {
            $sql_1 = "UPDATE crm_pledge_log set is_confirmed = 'Y' where wants_to_donate_id = ".$id;
            $result_1 = $this->db->query($sql_1);
            $sql_2 = "UPDATE crm_wants_to_donate_queue set is_confirmed = 'Y' where id = ".$id;
            $result_2 = $this->db->query($sql_2);
            $relation = array(
                'fields' => '*',
                "conditions" => "wants_to_donate_id = ". $id
            );
            $result = $this->pledgeLog_m->get_relation('', $relation, false);
            $relation = array(
                'fields' => '*',
                "conditions" => "donetores_queue_id = ". $result[0]['donetores_queue_id']. " AND is_confirmed = 'Y'"
            );
            $resultt = $this->pledgeLog_m->get_relation('', $relation, false);
            if (count($resultt) == 2)
            {
                $sql_2 = "UPDATE crm_donetores_queue set is_confirmed = 'Y', is_deleted = 'Y' where id = ".$result[0]['donetores_queue_id'];
                $result_2 = $this->db->query($sql_2);
            }
            if ($result_1 AND $result_2)
            {
                $this->session->set_flashdata('success','Payment confirmation is done successfully.');
            }
            else
            {
                $this->session->set_flashdata('danger','Please try again later.');
            }
            // send push notification for the owner
            $user_detail = $this->user_m->get($result[0]['investor_id']);
            $user_detail_to = $this->user_m->get($result[0]['borrower_id']);
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name;
            $notification_id = insert_notification_detail('pledge',"Members received donation","You just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name ,$admin_notification, $result[0]['investor_id']); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "You just received GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            unset($user_detail_to);
            // send push notification to opposite party
            $user_detail = $this->user_m->get($result[0]['borrower_id']);
            $user_detail_to = $this->user_m->get($result[0]['investor_id']);
            $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name;
            $notification_id = insert_notification_detail('pledge',"Member's pledge","You just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name , $admin_notification,$result[0]['borrower_id']); // common helper function
            $pay_load_data = set_payload('pledge', $notification_id, "You just donated GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
            }
            unset($user_detail);
            unset($user_detail_to);
            redirect('pledge_history');
        }
        else
        {
            show_404(current_url());
            exit;
        }
    }

    /**
    * Within 24 hours if any user dont pay to opposite party then kofi will click on the rematch functionality. It will update the report count and find out the other matching user.
    */
    public function rematch($id = '')
    {
        if ($id)
        {
            $relation = array(
                'fields' => '*',
                "conditions" => " wants_to_donate_id = ".$id
            );
            $pledge_array = $this->pledgeLog_m->get_relation('', $relation, false);
            $relation = array(
            "fields" => "*",
            "conditions" => "is_confirmed = 'N' AND is_active = 'N' AND user_id != ".$pledge_array[0]['investor_id'],
            "ORDER_BY" => array(
                    'field' => 'crm_wants_to_donate_queue.pledge_date',
                    'order' => 'ASC'),
            );
            $wants_pledge_array = $this->WantsToDonateQueue_m->get_relation('', $relation, false);
            if (count($wants_pledge_array) > 0)
            {
                $this->session->set_flashdata('success','Your matching will be found successfully.');
                //take the first record and match the entry into crm_pledge_log and updte previous to cancel
                $sql = "UPDATE crm_pledge_log set is_confirmed = 'CANCEL' where wants_to_donate_id = ".$id;
                $result_1 = $this->db->query($sql);
                //insert
                $pledge_log_array['investor_id'] = $pledge_array[0]['investor_id'];
                $pledge_log_array['borrower_id'] = $wants_pledge_array[0]['user_id'];
                $pledge_log_array['start_date'] = date('Y:m:d H:i:s') ;
                $add_hours = time() + (1 * 24 * 60 * 60);
                $pledge_log_array['end_date'] = date('Y:m:d H:i:s',$add_hours);
                $pledge_log_array['wants_to_donate_id'] = $wants_pledge_array[0]['id'];
                $pledge_log_array['donetores_queue_id'] = $pledge_array[0]['donetores_queue_id'];
                $this->pledgeLog_m->save($pledge_log_array);
                // as this pledge is placed into the log table we will make this field as active field.
                $sql_1 = "UPDATE crm_wants_to_donate_queue set is_active = 'Y' where id = ".$wants_pledge_array[0]['id'];
                $result_1 = $this->db->query($sql_1);
                 // send push notification for the owner
                $user_detail = $this->user_m->get($wants_pledge_array[0]['user_id']);
                $user_detail_to = $this->user_m->get($pledge_array[0]['investor_id']);
                $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." have to pay GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name ;
                $notification_id = insert_notification_detail('pledge',"Matching user found","You have to pay GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name , $admin_notification, $wants_pledge_array[0]['user_id']); // common helper function
                $pay_load_data = set_payload('pledge', $notification_id, "You have to pay GHS100 to ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
                $message = "Congratulations. Your matching is found. Please pay GHS100 to ".$user_detail_to->first_name." " . $user_detail_to->last_name. " within 24 hours from now. ";
                $message .= ' MoMo account name : '.$user_detail_to->mtn_mobile_name;
                $message .= ' MoMo account number : '.$user_detail_to->mtn_mobile_number;
                $message .= ' Thank you';
                $this->send_text_message($user_detail->mtn_mobile_number, $message);
                if ($user_detail->device_type == '0')
                {
                    send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
                }
                unset($user_detail);
                unset($user_detail_to);
                // send push notification to opposite party
                $user_detail = $this->user_m->get($pledge_array[0]['investor_id']);
                $user_detail_to = $this->user_m->get($wants_pledge_array[0]['user_id']);
                $admin_notification = $user_detail->first_name.' '.$user_detail->last_name." will be able to get GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name;
                $notification_id = insert_notification_detail('pledge',"Matching user found","You will be able to get GHS100 from ". $user_detail_to->first_name. ' '. $user_detail_to->last_name , $admin_notification, $pledge_array[0]['investor_id']); // common helper function
                $message = "Congratulations. Your Re-matching is found. You are Able to get GHS100 from ".$user_detail_to->first_name." " . $user_detail_to->last_name. " within 24 hours from now. ";
                $message .= ' MoMo account name : '.$user_detail_to->mtn_mobile_name;
                $message .= ' MoMo account number : '.$user_detail_to->mtn_mobile_number;
                $message .= ' Thank you';
                $this->send_text_message($user_detail->mtn_mobile_number, $message);
                $pay_load_data = set_payload('pledge', $notification_id, "You will be able to get GHS100 from  ". $user_detail_to->first_name. ' '. $user_detail_to->last_name );
                if ($user_detail->device_type == '0')
                {
                    send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
                }
                unset($user_detail);
                unset($user_detail_to);
                //
                $userAry = $this->user_m->get($pledge_array[0]['borrower_id']);
                $user_arry['report_count'] = ($userAry->report_count) + 1;
                $this->user_m->save($user_arry,$pledge_array[0]['borrower_id']);
                if ($user_arry['report_count'] == 3)
                {
                    $user_arry['is_deleted'] = 'Y';
                    $this->user_m->save($user_arry,$pledge_array[0]['borrower_id']);
                }

            }
            else
            {
                $this->session->set_flashdata('danger','No user available in the queue for you. Please try again after some.');
            }
            redirect('active_pledge');
        }
    }

     /**
    * Send the text message. i.e. call the library of the Twilio
    */
    public function send_text_message($number , $body)
    {
        $this->calldemo->send_message($number, $body);
    }
}