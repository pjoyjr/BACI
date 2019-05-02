<?php
/**
 * mail.class.php
 
 *
 * A class used to sending emails
 */

 

include "class.phpmailer.php";
include "class.smtp.php";


class Mail{

    private $mailUser;
    private $mailPass;
    private $mailFrom;
    private $mailFromName;
    private $mailHost;
    private $mailPort;
    private $mailCharSet;
    

	/**
	 * Get the username, password, and email host ... from the database
	 * @return array */
     function __construct() {

	    //usually you want to store these info in the database
           $this->mailUser = "n342class@gmail.com";
           $this->mailPass = "cscispring2013";
           $this->mailFrom = "n342class@gmail.com";
           $this->mailFromName = "Info";
           $this->mailHost = "ssl://smtp.gmail.com";
           $this->mailPort = "465"; //different mail server uses different ports
         
   
	}
 
 
     public function getFrom() {

            return $this->mailFrom;
	}
 
     public function getFromName() {

            return $this->mailFromName;
	}

     /*This is a general function of sending mails.
     *Return true means sending successful.
     */
     public function sendMail($recipient, $recipient_name, $subject, $mail_html_body) {

		
       $mail = new PHPMailer();
       $mail -> IsSMTP();
       $mail -> IsHTML(true);
       $mail -> SMTPAuth = true;

       $mail -> Username = $this->mailUser;
       $mail -> Password = $this->mailPass;


       $mail -> From = $this->mailFrom;
       $mail -> FromName = $this->mailFromName;


	$mail->SMTPSecure = ""; // sets the prefix to the servier
       $mail->Host = $this->mailHost;
       $mail->Port = $this->mailPort;
        


	$mail->Subject = $subject;
	$mail->Body = $mail_html_body;
	$mail->CharSet = "utf-8";
  
       
	$mail->WordWrap = 50; // set word wrap

	$mail->AddAddress($recipient, $recipient_name);
		
	if(!$mail->Send()) {
		      return false;
	} else {
			                 
	 	return true;
	}


}
 
 

}
