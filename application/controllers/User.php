<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\src\PHPMailer;

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        $this->load->model('refferalDetails_m');
        $this->load->model('bonusPointsHistory_m');
        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $this->load->model('log_m');
        $this->load->model('ewallet_m');
        $this->load->model('setting_m');
        $this->load->model('userSecondary_m');
        $this->load->library('form_validation');
    }

    public function signup()
    {
        $data['login_url'] = $this->facebook->login_url();
        $this->load->view('signup', $data);
    }

    public function signin()
    {
        $data['login_url'] = $this->facebook->login_url();
        $this->load->view('signin', $data);
    }

    public function is_username_exist()
    {
        $relation = array(
            "fields" => "*",
            'conditions' => "email ='" . $this->input->post('username') . "'"
        );
        $total = $this->user_m->get_relation('', $relation, true);
        if ($total > 0)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode(false);
        }
    }

    public function register()
    {
        $this->data['login_url'] = $this->facebook->login_url();
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['email'] = $this->input->post('username');
        $data['password'] = md5($this->input->post('password'));
        $data['mtn_mobile_number'] = $this->input->post('full_number');
        $data['device_type'] = '2'; // for website
        $referral_code = $this->input->post('referral_Code');
        $relation = array(
            "fields" => "*",
            'conditions' => "refferal_code ='" . $referral_code . "'"
        );
        $referral_Details = $this->refferalDetails_m->get_relation('', $relation, false);
        $data['parent_user_id'] = $referral_Details ? $referral_Details[0]['user_id'] : '';
        $relation = array(
            "fields" => "*",
            'conditions' => "user_id ='" . $referral_Details[0]['user_id'] . "'"
        );
        $position = $this->refferalDetails_m->get_relation('', $relation, false)[0]['refferal_count'];
        //$this->find_position($position, $referral_Details[0]['user_id']);
        //echo $position;
        $new_pos = $position + 1;
        //echo $new_pos;
        $sql = "UPDATE crm_refferal_details SET refferal_count = $new_pos WHERE user_id = '" . $referral_Details[0]['user_id'] . "'";
        $this->db->query($sql);
        $data['position'] = $new_pos;
        $data['is_active'] = 'Y';
        $data['is_mobile_verified'] = 'Y';
//        $data['is_email_verified'] = 1; // disabled email verification
        $data['verification_code'] = $this->session->userdata('verf_code');
        $data['verification_url'] = md5($data['email'] . rand() . time());
        // echo "<pre>";
        // print_r($_POST);
        // print_r($data);
        // die;
        $id = $this->user_m->save($data);

        if ($id)
        {
            // refreral_table entry
            $ref_code = generate_referal_code();
            $referal_detailsArray['refferal_code'] = $this->check_referal_code($ref_code);
            $referal_detailsArray['user_id'] = $id;
            $this->refferalDetails_m->save($referal_detailsArray);

            // secondary table enetry
            $secondary_details['total_bpoints'] = '0';
            $secondary_details['ewallet'] = '0';
            $secondary_details['user_id'] = $id;
            $this->db->insert('crm_users_secondary', $secondary_details);

            // send push notification to the parent user
            $pDetails = $this->user_m->get($referral_Details[0]['user_id']);
            $admin_message = $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ' just joined to ' . $pDetails->first_name . ' ' . $pDetails->last_name;
            $notification_id = insert_notification_detail('new_member_joining', "Member's joining", $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ' just joined to you', $admin_message, $referral_Details[0]['user_id']); // common helper function
            $pay_load_data = set_payload('new_member_joining', $notification_id, $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ' just joined to you');
            if ($pDetails->device_type == '0')
            {
                send_push_notification($pDetails->device_token, false, $pay_load_data); //library notification
            }
            unset($user_detail);

            //send verification email
            //send email varification email
            $varification_link = base_url('user') . "/verify_account?v_url=" . $data['verification_url'];
            // $body_mail = "<html><body>Welcome!!<br></br><br></br>
            //             Hello " . $data['first_name'] . ",<br></br>
            //             Thank you for registration on the <a href='https://www.boame.net'>Boame</a><br></br>Please click on below link to activate your account.<br></br><a href='" . $varification_link . "'>Link</a><br></br><br></br>";
            // $body_mail .= "Regards,<br></br>BOAME Team<br></br>";
            $body_mail = "<html><body><p><strong>Hello '".$data['first_name']."',</strong></p>
			<p>Welcome to BOAME-CONNECT, LEARN AND EARN.&nbsp;Thank you so much for joining us.&nbsp;You&rsquo;re on your way to super-productivity and beyond!</p>
			<p>Boame Team consists of selfless and motivated individuals who came together to help upgrade the living standards of its members and reduce poverty. We know that the only way we can change this world is to empower our members and teach them how to be self sustained. This we do by offering members educational materials which they can use to upgrade themselves.</p>
			<p>Our portfolios ranges from eBooks &ndash; Health, do it yourself books, motivational books among others. We have eBooks that teaches members how to start their own business from home, how to start home importation business with minimal money, how to start a fiverr business among others.</p>
			<p>Members also have access to our wide range of softwares that they can use or better still sell to third parties and keep 100% of proceeds from these sales. Members can also sell our audios, videos and eBooks at their own choice.</p>
			<p><strong>Verify link</strong>:&nbsp;<a title='Actiovation Link - BOAME Team' href='".$varification_link."' target='_blank' rel='noopener>$varification_link</a></p>
			<p>Verify your account by clicking on above link.</p>
			<p><small>If you are having any issues with your account, don't hesitate to contact us by replying to this email.</small></p>
			<p><strong>Thanks,</strong></p>
			<p><strong>BOAME TEAM</strong></p></body></html>";
            $subject = "Confirm Your Boame Account Registration";
            $this->send_mail($body_mail, $data['email'] ,$subject);
//            $this->send_mail($body_mail, "rsa@narola.email");

            $this->session->set_flashdata('success', 'Congratulations. Registration is successful. Please check your email (' . $data['email'] . ') for activate your account.');
            redirect('user/signin');
            
        }
        else
        {
            $this->session->set_flashdata('danger', 'Oops! Something went wrong. Please try again later');
            redirect('user/signin');
            
        }
        $this->load->view('signin', $this->data);
    }

    public function referal_exist()
    {
        $relation = array(
            "fields" => "*",
            'conditions' => "refferal_code ='" . $this->input->post('referral_code') . "'"
        );
        $total = $this->refferalDetails_m->get_relation('', $relation, true);
        if ($total > 0)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode(false);
        }
    }

    /**
     * Chek for the referal code.
     */
    public function index($id = '')
    {
        if ($id)
        {
            $this->session->set_userdata('referal_url', current_url());
            $this->session->set_userdata('ref_code', $this->uri->segment(3));
            $data['referal_code'] = $this->uri->segment(3);
            if ($data['referal_code'])
            {
                $relation = array(
                    "fields" => "*",
                    'conditions' => "refferal_code ='" . $data['referal_code'] . "'"
                );
                $totalRecords = $this->refferalDetails_m->get_relation('', $relation, true);
                if ($totalRecords == 0)
                {
                    $this->session->set_flashdata('danger', 'This referral link does not exist. Please check in once and come back!');
                    $redirect_url = $this->session->userdata('referal_url');
                    // header("Location: $redirect_url");
                    show_404(current_url());
                    exit;
                }
                else
                {
                     $this->session->set_userdata('web',false);
                     $data['login_url'] = $this->facebook->login_url();
                     $this->load->view('signup', $data);
//                    $this->load->view('components/maintaince_page');
                }
            }
        }
        else
        {
            //$this->load->view('comming_soon/home');
            redirect('home');
        }
    }

    public function facebook()
    {
        if ($this->facebook->is_authenticated())
        {
            unset($userProfile);
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture,birthday');
            // $this->session->sess_destroy();
            if (isset($userProfile['id']) && $userProfile['id'] != '')
            {
                $relation = array(
                    "fields" => "*",
                    "conditions" => "fb_token_id = '" . $userProfile['id'] . "'"
                );
                $totalUsers = $this->user_m->get_relation('', $relation, true);
                $relation = array(
                    "fields" => "*",
                    'conditions' => "is_deleted ='N' AND fb_token_id ='" . $userProfile['id'] . "' AND is_mobile_verified = 'Y'"
                );
                $Users = $this->user_m->get_relation('', $relation, false);
                $relation = array(
                    "fields" => "*",
                    'conditions' => "is_deleted ='Y' AND fb_token_id ='" . $userProfile['id'] . "'"
                );
                $delted_user = $this->user_m->get_relation('', $relation, false);
                $relation = array(
                    "fields" => "*",
                    'conditions' => "is_deleted ='N' AND fb_token_id ='" . $userProfile['id'] . "' AND is_mobile_verified = 'N'"
                );
                $not_active_users = $this->user_m->get_relation('', $relation, false);
                $relation = array(
                    "fields" => "*",
                    'conditions' => "fb_token_id ='" . $userProfile['id'] . "' AND parent_user_id != 0"
                );
                $found_parent_user = $this->user_m->get_relation('', $relation, false);
                if ($totalUsers == 0)
                {
                    $user_details['first_name'] = $userProfile['first_name'];
                    $user_details['last_name'] = $userProfile['last_name'];
                    $user_details['gender'] = $userProfile['gender'];
                    if (isset($userProfile['email']) && $userProfile['email'] != '')
                    {
                        $user_details['email'] = $userProfile['email'];
                    }
                    $user_details['fb_token_id'] = $userProfile['id'];
                    $user_details['picture'] = "http://graph.facebook.com/$userProfile[id]/picture?type=large";
                    $user_details['device_type'] = '2';
                    $user_details['is_email_verified'] = 1;
                    $user_id = $this->user_m->save($user_details);
                    $data = array(
                        'name' => $user_details['first_name'] . ' ' . $user_details['last_name'],
                        'user_id' => $user_id,
                        'loggedin_user' => TRUE
                    );
                    $this->session->set_userdata($data);
                    /* if ($user_id)
                      {
                      $ref_code = generate_referal_code();
                      $referal_details['refferal_code'] = $this->check_referal_code($ref_code);
                      $referal_details['user_id'] = $user_id;
                      $user_referal_id = $this->refferalDetails_m->save($referal_details);
                      } */
                    //$data['logout_url'] = $this->facebook->logout_url();
                    $this->session->set_flashdata('success', 'Only one Step ahead.Enter valid Referral code and becomes part of us.');
                    if ($this->session->userdata('ref_code') != '')
                    {
                        $this->data['referal_code'] = $this->session->userdata('ref_code');
                    }
                    else
                    {
                        $this->data['referal_code'] = '';
                    }
                    $this->load->view('referal_page', $this->data);
                }
                else if (count($Users) > 0)
                {
                    $data = array(
                        'email' => isset($Users[0]['email']) ? $Users[0]['email'] : '',
                        'name' => $Users[0]['first_name'] . ' ' . $Users[0]['last_name'],
                        'user_id' => $Users[0]['id'],
                        'loggedin_user' => TRUE,
                    );

                    $update_user_device_type["device_type"] = '2';
                    $this->user_m->save($update_user_device_type, $Users[0]['id']); // update the dveice type for push notification
                    $this->session->set_userdata($data);
                    $this->session->unset_userdata('referal_url');
                    redirect('dashboard');
                }
                elseif (count($delted_user) > 0)
                {
                    $this->session->set_flashdata('danger', 'Your account will be deactivated. Please contact admin to make account active');
                    $data['login_url'] = $this->facebook->login_url();
                    $this->load->view('signin', $data);
                }
                elseif (count($found_parent_user) > 0)
                {
                    $this->session->set_flashdata('success', 'Your are already the member of boame. Please verify your mobile number and enjoy!');

                    $data = array(
                        'email' => isset($found_parent_user[0]['email']) ? $found_parent_user[0]['email'] : '',
                        'name' => $found_parent_user[0]['first_name'] . ' ' . $found_parent_user[0]['last_name'],
                        'user_id' => $found_parent_user[0]['id'],
                        'loggedin_user' => TRUE,
                    );
                    $this->session->set_userdata($data);
                    $this->verify_phone();
                }
                else
                {
                    $data = array(
                        'email' => isset($not_active_users[0]['email']) ? $not_active_users[0]['email'] : '',
                        'name' => $not_active_users[0]['first_name'] . ' ' . $not_active_users[0]['last_name'],
                        'user_id' => $not_active_users[0]['id'],
                        'loggedin_user' => TRUE,
                    );
                    $this->session->set_userdata($data);
                    /* $relation = array(
                      "fields" => "*",
                      "conditions" => "refferal_code = '".$not_active_users[0]['refferal_code']."'"
                      );
                      $refArr = $this->refferalDetails_m->get_relation('', $relation, false); */
                    if ($this->session->userdata('ref_code') != '' AND $this->session->userdata('web') != 1)
                    {
                        $this->data['referal_code'] = $this->session->userdata('ref_code');
                    }
                    else
                    {
                        $this->data['referal_code'] = '';
                    }
                    $this->load->view('referal_page', $this->data);
                }
            }
            else
            {
                $this->session->set_flashdata('danger', 'Please Enter valid facebook credential. Try again');
                $data['login_url'] = $this->facebook->login_url();
                $this->load->view('signin', $data);
            }
        }
        else
        {
            echo "not";
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }

    public function isReferalExist()
    {
        if ($this->session->userdata('web') != 1)
        {
            if (!($this->session->userdata('referal_url')))
            {
                show_404(current_url());
            }
        }
        $usersDetail = $this->user_m->get($this->session->userdata('user_id'));
        if ($usersDetail->parent_user_id != 0)
        {
            $this->verify_phone();
        }
        $referal_code = $this->input->post('referal_code');
        $relation = array(
            "fields" => "*",
            'conditions' => "refferal_code ='" . $referal_code . "'"
        );
        $referal_details = $this->refferalDetails_m->get_relation('', $relation, false);
        if (count($referal_details) > 0)
        {
            // ---add the refereal code---
            $ref_code = generate_referal_code();
            $referal_detailsArray['refferal_code'] = $this->check_referal_code($ref_code);
            $referal_detailsArray['user_id'] = $this->session->userdata('user_id');
            $user_referal_id = $this->refferalDetails_m->save($referal_detailsArray);
            // ---end of referal code---
            $referal_details_array['parent_user_id'] = $referal_details[0]['user_id'];
            $referal_details_array['is_active'] = 'Y';
            $id = $this->user_m->save($referal_details_array, $this->session->userdata('user_id'));

            //add position
            $relation = array(
                "fields" => "*",
                'conditions' => "parent_user_id ='" . $referal_details[0]['user_id'] . "'"
            );
            $position = $this->user_m->get_relation('', $relation, true);
            $this->find_position($position, $referal_details[0]['user_id']);
            //send notification to parent id
            $pDetails = $this->user_m->get($referal_details[0]['user_id']);
            $admin_message = $this->session->userdata('name') . ' just joined to ' . $pDetails->first_name . ' ' . $pDetails->last_name;
            $notification_id = insert_notification_detail('new_member_joining', "Member's joining", $this->session->userdata('name') . ' just joined to you', $admin_message, $referal_details[0]['user_id']); // common helper function
            $pay_load_data = set_payload('new_member_joining', $notification_id, $this->session->userdata('name') . ' just joined to you');
            $user_detail = $this->user_m->get($referal_details[0]['user_id']);
            if ($user_detail->device_type == '0')
            {
                send_push_notification($user_detail->device_token, false, $pay_load_data); //library notification
            }
            unset($user_detail);
            if ($id)
            {
                $this->session->set_flashdata('success', 'Yeah! You are now member of BOAME. Verify your phone number. Enjoy!!');
                // $bonus_user_id = $this->addSignupPoints();
                // $log_id = $this->addLog();
                $user_secondary_details_id = $this->updateAllTotalPoints();
                $this->verify_phone();
            }
            else
            {
                $this->session->set_flashdata('danger', 'Something happens wrong!');
                $data['login_url'] = $this->facebook->login_url();
                $this->load->view('signin', $data);
            }
        }
        else
        {
            $this->session->set_flashdata('danger', 'Please enter valid referral code to join us!');
            $data['referal_code'] = $this->session->userdata('ref_code');
            $this->load->view('referal_page', $data);
        }
    }

    public function set_password($password)
    {
        $userArray['password'] = md5($password);
        $this->user_m->save($userArray, $this->session->userdata('user_id'));
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        
        if($this->user_m->login($email, $password) === 2)
        {   
            $this->session->set_flashdata('danger', 'Your Account is not activated yet!');
            redirect('user/signin');
        }
        if ($this->user_m->login($email, $password) == TRUE)
        {
            redirect('dashboard');
        }
        else
        {
            $this->session->set_flashdata('danger', 'That email/password combination does not exist');
            $data['login_url'] = $this->facebook->login_url();
            $this->load->view('signin', $data);
        }
    }

    public function updateAllTotalPoints()
    {
        $relation = array(
            "fields" => "*",
            'conditions' => "user_id = '" . $this->session->userdata('user_id') . "'"
        );
        $found_entry = $this->userSecondary_m->get_relation('', $relation, true);
        if ($found_entry == 0)
        {
            $id = $this->session->userdata('user_id');
            //$secondary_details['total_bpoints'] = $this->setting_m->get()[0]->signup_bonus;
            $secondary_details['total_bpoints'] = '0';
            $secondary_details['ewallet'] = '0';
            //$secondary_details['pledge_per_month'] = '0';
            $secondary_details['user_id'] = $id;
            return $this->db->insert('crm_users_secondary', $secondary_details);
        }
    }

    public function verify_phone()
    {
        $this->load->view('member/verification/index');
    }

    public function find_position($position, $parent_user_id)
    {
        $new_pos = ($position + 1);
        $sql = "UPDATE crm_refferal_details SET refferal_count = $new_pos WHERE user_id = $parent_user_id ";
        $this->db->query($sql);
        $user_primary['position'] = $position + 1;
        return $this->user_m->save($user_primary, $this->session->userdata('user_id'));
    }

    public function check_referal_code($referral_code)
    {
        $relation = array(
            "fields" => "*",
            'conditions' => "refferal_code = '" . $referral_code . "'"
        );
        $found = $this->refferalDetails_m->get_relation('', $relation, true);
        if ($found > 0)
        {
            return generate_referal_code();
        }
        else
        {
            return $referral_code;
        }
    }

    public function send_mail($body = '', $to , $subject)
    {
        require_once(APPPATH . "third_party/PHPMailer/src/PHPMailer.php");
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
        $mail->SetFrom("support@boame.net");
        $mail->Subject = $subject;
        $mail->AddAddress($to);
        $mail->Body = $body;
        if ($mail->send())
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }

    public function verify_account()
    {
        $url = $_GET['v_url'];
        $relation = array(
            "fields" => "*",
            'conditions' => "verification_url = '" . $url . "'"
        );
        $get_user = $this->user_m->get_relation('', $relation, false);
        if (empty($get_user))
        {
            $this->session->set_flashdata('danger', 'Invalid Activation link');
            redirect('user/signin');
        }
        if ($get_user[0]['is_email_verified'] == 1)
        {
            $this->session->set_flashdata('danger', 'This activation link is already verified.');
            redirect('user/signin');
        }
        $update_user["is_email_verified"] = 1;
        $this->user_m->save($update_user, $get_user[0]['id']);
        $this->session->set_flashdata('success', 'Your account is successfully verified. Please login now.');
        redirect('user/signin');
    }
    
    public function forgot_password()
    {
        if($this->input->post("submit"))
        {
                $email = $this->input->post("email");
                $relation = array(
                "fields" => "*",
                'conditions' => "email ='" . $email . "'"
            );
                $user = $this->user_m->get_relation('', $relation, false);
                if (!empty($user))
                {
                     //send link in mail
                    $link = md5($email . rand() . time());
                    
                    $update_user_link = array("forgot_password_link" => $link);
                    $this->user_m->save($update_user_link, $user[0]['id']);
                    
                    $varification_link = base_url('user') . "/change_password/" .$link;
                    $body_mail = "<html><body>
                    Hello " . $user[0]['first_name'] . ",<br></br>
                    Please click on below link to change your password.<br></br>Please note this link can be used only once.<br></br><a href='" . $varification_link . "'>Link</a><br></br><br></br>";
                    $body_mail .= "Regards,<br></br>BOAME Team<br></br>";
                    $subject = "Change Password for Your Boame Account";
                    $this->send_mail($body_mail, $email , $subject);

                    $this->session->set_flashdata('success', 'Change password link is sent successfully. Please check your email (' . $email . ').');
                    redirect('user/forgot_password');
                }
                else
                {
                    $this->session->set_flashdata('danger', 'Email address '. $email.' is not exists');
                    redirect('user/forgot_password');
                }
           
        }
        $this->load->view('forgotpassword');
    }
    
    public function change_password($link)
    {
        $relation = array(
                "fields" => "*",
                'conditions' => "forgot_password_link ='" . $link . "'"
            );
        $user = $this->user_m->get_relation('', $relation, false);
        if(empty($user))
        {
            show_404(current_url());
        }
        if($this->input->post("submit"))
        {
            $update_user_data = array("forgot_password_link" => NULL , "password" => md5($this->input->post('password')));
            $this->user_m->save($update_user_data, $user[0]['id']);
            $this->session->set_flashdata('success', 'Your password is successfully changed. Please login now');
            redirect('user/signin');
        }
        $this->load->view('changepassword');
    }

//    public function test_mail()
//    {
//        //send email varification email
//        This activation link is already verified.
//        $body_mail = "<html><body>Welcome!!</br></br>
//                    Hello Rsa,</br>
//                    Thank you for registration on the <a href='https://www.boame.net'>Boame</a></br>Please click on below link to activate your account.</br><a href='https://www.boame.net'>Link</a></br></br>";
//        $body_mail .= "Regards,</br>BOAME Team</br>";
////                        $this->send_mail($body, $data['email']);
//        echo $this->send_mail($body_mail, "rsa@narola.email");
//    }
    // public function addSignupPoints()
    // {
    // 	// start notification
    // 	$relation = array(
    //         "fields" => "*",
    //         'conditions' => "user_id = '".$this->session->userdata('user_id')."'"
    //     	);
    // 	$found_entry = $this->bonusPointsHistory_m->get_relation('', $relation, true);
    // 	// echo $this->db->last_query();
    // 	// echo $found_entry;
    // 	// die;
    // 	if ($found_entry == 0)
    // 	{
    // 		$admin_message = $this->session->userdata('name').' have earned 20BPoints as signup bonus points';
    // 		$notification_id = insert_notification_detail('signup_bonus',"Member's earnings",SIGNUP_NOTIFICAION, $admin_message, $this->session->userdata('user_id')); // common helper function
    // 		$pay_load_data = set_payload('signup_bonus', $notification_id, SIGNUP_NOTIFICAION);
    // 		$user_detail = $this->user_m->get($this->session->userdata('user_id'));
    //     	if ($user_detail->device_type == '0')
    //     	{
    //     		send_push_notification($user_detail->device_token, false, $pay_load_data);//library notification
    //     	}
    //     	// end notification
    // 		$bonus_point_array = array();
    // 		$bonus_point_array['user_id'] = $this->session->userdata('user_id');
    // 		$bonus_point_array['type'] = 'signup_points';
    // 		$bonus_point_array['bpoints'] = $this->setting_m->get()[0]->signup_bonus;
    // 		// print_r($_SESSION);
    // 		// die;
    // 		return $this->bonusPointsHistory_m->save($bonus_point_array);
    // 	}
    // }
    // public function addLog()
    // {
    // 	$relation = array(
    //     "fields" => "*",
    //     'conditions' => "user_id = '".$this->session->userdata('user_id')."' AND type = 'signup_points'"
    // 	);
    // 	$found_entry = $this->log_m->get_relation('', $relation, true);
    // 	if ($found_entry == 0)
    // 	{
    // 		$bonus_point_array = array();
    // 		$bonus_point_array['user_id'] = $this->session->userdata('user_id');
    // 		$bonus_point_array['type'] = 'signup_points';
    // 		$bonus_point_array['message'] = serialize(
    // 			array( 'from' => $this->session->userdata('user_id'), 
    // 		             'to' => $this->session->userdata('user_id'),
    // 				'message' => $this->session->userdata('name') . ' has earned ' . $this->setting_m->get()[0]->signup_bonus . ' signup points'   
    // 				)
    // 			);
    // 		return $this->log_m->save($bonus_point_array);
    // 	}
    // }
}
