<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\src\PHPMailer;
require 'vendor/autoload.php';
class Mail_library
{
    public function __construct()
    {
        require_once(APPPATH."third_party/PHPMailer/src/PHPMailer.php");
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->IsHTML(true);
        $mail->Username = "demo.narola@gmail.com"; // SET YOUR GMAIL EMAIL ID 
        $mail->Password = "Narola21!"; // SET YOUR GMAIL PASSWORD
        $mail->SetFrom("demo.narola@gmail.com");
        $mail->Subject = "Test Mail";
        $mail->Body = "<p>Hello eww</p>
                        <p>Hope! you are doing well. </p>
                        <p>We would like to inform you that we are celebrating our 12th anniversary So we request you to send us some of your valuable Video testimonials which can encourage us to provide you more better service.</p>
                        <p>Looking forward to hearing back from you.</p>
                        <p>Thanks,</p>
                        <p>Maulik</p>";
		//$mail->Body = $massage;
		$mail->AddAddress('shp@narola.email');
        print_r($mail);
        die;
		if ( $mail->send() ) {
		    echo "successfully";
		} else{
            print_r($mail->errorInfo)
		    echo "unsuccesfull";
		}
    }
}