<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email
{
    public function sendSmtpEmail($fromName, $subject, $message, $fromEmail = FROM_EMAIL, $toEmail = TO_EMAIL)
    {
        $this->from($fromEmail, $fromName);
        $this->to($toEmail);
        $this->subject($subject);
        $this->message($message);
        $this->send();
    }
}