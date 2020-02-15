<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class User_payment extends MY_Controller

{



    public function __construct()

    {

        parent::__construct();

        $this->load->model('UserPayment_m');

        $this->load->library('facebook');

        $this->load->model('user_m');

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

        

    }

    

    public function submit_request()

    {

       $amount = $this->input->post("amount_to_be_purchased");

       $user_id = $this->session->userdata('user_id');

       $user_info = $this->user_m->get($user_id);

       $order_id = md5($user_info->email . rand() . time());

       $check_data = expresspay_submit_data($user_info->first_name,$user_info->last_name,$user_info->email,$user_info->mtn_mobile_number,$amount,$order_id);

     

       if($check_data->status == 1){

            $payment_data = array("user_id" => $user_id,

             "order_id" => $order_id,

             "amount" => $amount,

             "token" => $check_data->token,

             "submit_response" => json_encode($check_data),

             "created_at" => date("Y-m-d h:i:s")

            );

            $this->UserPayment_m->save($payment_data);

            

            //sandbox

//            $url = "https://sandbox.expresspaygh.com/api/checkout.php?token=".$check_data->token; 

            

            //live

            $url = "https://expresspaygh.com/api/checkout.php?token=".$check_data->token; 

            

            redirect($url);

            exit();

	}else{

	   $this->session->set_flashdata('error', $check_data->message);

           redirect('member/store/make_request');

	}

       

       #35 (9) { ["status"]=> int(1) ["order-id"]=> string(32) "2133a154d2e698eebaf771ea264b9c27" ["guest-checkout"]=> string(4) "TRUE" ["merchantservice-name"]=> string(3) "EPS" ["merchantservice-srvrtid"]=> string(20) "54245b17d152c1d6a5b1" ["message"]=> string(7) "Success" ["token"]=> string(64) "91655b34b116dac814.566801315b34b116dac887.9699868450995b34b116da" ["redirect-url"]=> string(41) "https://www.boame.net/expresspayment_done" ["user-key"]=> NULL }

    }





}

