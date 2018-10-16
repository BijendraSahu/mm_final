<?php
/**
 * Created by Bijendra Sahu.
 * User: dubeyamit
 * Date: 27-01-2017
 * Time: 06:58 PM
 */

namespace App;


class Mail
{
    public $to;
    public $subject;
    public $body;

    public function send_mail()
    {
        if (!class_exists("phpmailer")) {
            require_once('class.phpmailer.php');
        }
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
//        $mail->Host = 'smtpout.secureserver.net:80';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->Username = 'mailprofile2016@gmail.com';
        $mail->Password = 'JABALPUR_2017';
        $mail->From = $mail->Username;
        $mail->FromName = "Mangal Mandap - Support Team";
        foreach (explode(",", $this->to) as $recepient)
            $mail->AddAddress($recepient);
        $mail->Subject = $this->subject;
        $mail->Body = $this->body;
        $mail->IsHTML(true);
        if (!$mail->Send()) {
            return false;

        } else {
            return true;
        }
    }
}