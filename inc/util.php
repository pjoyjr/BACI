<?php
	//code here

//check password for length, has letter, has number
function passwordChecker($password) {
    $password = trim($password);
    if (strlen($password) < 5) {
        return false;
    } else {
        $letter = false;
        $number = false;
        $charPwd = str_split($password);
        
        for ($i = 0; $i < strlen($password); $i++) {
            if(preg_match("/[A-Za-z]/",$charPwd[$i])) {
                $letter = true;
            } else if (preg_match("/[0-9]/",$charPwd[$i])) {
                $number = true;
            }
        }
        
        if($letter && $number) {
            return true;
        } else {
            return false;
        }
        
    }
}

//confirm both passwords are the same
function confirmPassword($password, $confirmPassword){
    if(strcmp($password,$confirmPassword) == 0){
        return true;
    } else {
        return false;
    }
}

//convert int to char
function toChar($digit) {
    $char = "";
    switch ($digit){
        case 1: $char = "A"; break;
        case 2: $char = "B"; break;
        case 3: $char = "C"; break;
        case 4: $char = "D"; break;
        case 5: $char = "E"; break;
        case 6: $char = "F"; break;
        case 7: $char = "G"; break;
        case 8: $char = "H"; break;
        case 9: $char = "I"; break;
        case 10: $char = "J"; break;
        case 11: $char = "K"; break;
        case 12: $char = "L"; break;
        case 13: $char = "M"; break;
        case 14: $char = "N"; break;
        case 15: $char = "O"; break;
        case 16: $char = "P"; break;
        case 17: $char = "Q"; break;
        case 18: $char = "R"; break;
        case 19: $char = "S"; break;
        case 20: $char = "T"; break;
        case 21: $char = "U"; break;
        case 22: $char = "V"; break;
        case 23: $char = "W"; break;
        case 24: $char = "X"; break;
        case 25: $char = "Y"; break;
        case 26: $char = "Z"; break;
        default: "A";
    }
    return $char;
}

//randomly generate a code of $size with numbers and chars
function randomCodeGenerator($size) {
    $strCode = "";
    for($i = 0; $i < $size; $i++) {
        $r = mt_rand(1,35);
        if($r > 26) {
            $r = $r - 26;
            $strCode = $strCode.$r;
        } else {
            $strCode = $strCode.toChar($r);
        }
    }
    return $strCode;
}

//Check received code for length and if it has numbers and letters
function validateCode($code) {
    if (strlen($code) < 50) {
        return false;
    }
    $charPwd = str_split($code);

    for ($i = 0; $i < strlen($code); $i++) {
        if(!preg_match("/[A-Za-z]/",$charPwd[$i]) and !preg_match("/[0-9]/",$charPwd[$i]) ) {
            return false;
        }
    }
    return true;  
}

/*This function prevents malicious users enter multiple email addresses into the email box
*It makes sure that only one email is entered into the email box.
*/
function spamcheck($field)
{
    //filter_var() sanitizes the e-mail
    //address using FILTER_SANITIZE_EMAIL
    $field=filter_var($field, FILTER_SANITIZE_EMAIL);

    //filter_var() validates the e-mail
    //address using FILTER_VALIDATE_EMAIL
    if(filter_var($field, FILTER_VALIDATE_EMAIL))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function emailSend($em, $fn){
		
		$code = randomCodeGenerator(50);
				
		//format email
		$subject = "Email Activation";
							
		$body = 'Please click on this url to activate your account. <br/>
			 http://corsair.cs.iupui.edu:23061/lab2/activate.php?a='.$code;
		
		//send email
		$mailer = new Mail();
		if (($mailer->sendMail($em, $fn, $subject, $body))==true)
			$msg = "<b>Thank you for registering. A welcome message has been sent to the address you have just registered.</b>";
		else $msg = "Email not sent. " . $em.' '. $fn.' '. $subject.' '. $body;
}


/* This function will generate a list of $y years from the current year. */
function pastYearList($y){

      $today = getdate();
      $thisYear = $today['year'];
      $list = "";
      for($i = $thisYear; $i > ($thisYear - $y); $i--){
             if ($i == $y)
                $list = $list."<option value=\"".$i."\" selected = \"selected\">".$i."</option>" ;
             else  $list = $list."<option value=\"".$i."\">".$i."</option>" ;
      }
      return $list;

}
