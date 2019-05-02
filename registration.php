<?php 
include 'header.php';
require_once 'db_connect.php';

$formType = 1;

$msg = "";

$userName = "";
$userNameReq = "*";

$firstName = "";
$firstNameReq = "*";

$lastName = "";
$lastNameReq = "*";

$email = "";
$emailReq = "*";

$confirmEmail = "";
$confirmEmailReq = "*";

$password = "";
$passwordReq = "*";

$confirmPassword = "";
$confirmPasswordReq = "*";

$phoneNumber = "";
$gender = "";
$birthYear = "";

$userStatus = "";

$address1 = "";
$address2 = "";
$city = "";
$state = "";
$zip = "";
$country = "";

$tosre = "*";

$fbLink = "";
$twLink = "";
$lkdLink = "";

if (isset($_POST['enter'])) {
	$userName = trim($_POST['userName']);
	$userName = strtolower($userName);
	$checkUserName = $con->prepare('SELECT username FROM user_tbl WHERE username = :username');
	$checkUserName->execute(array('username'=>$userName));
	if ($checkUserName->rowCount() > 0) {
		$userNameReq = '<span style="color:red">User Name Taken</span>';
	} else {
		$firstName = trim($_POST['firstName']);
		$lastName = trim($_POST['lastName']);
		if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
			$emailReq = '<span style="color:red">*</span>';
		else 
			$email = trim($_POST['email']);
		$confirmEmail = trim($_POST['confirmEmail']);
		if(strcmp($email,$confirmEmail) != 0){
			$confirmEmailReq = '<span style="color:red">Does Not Match</span>';
			$confirmEmail = "";
		}
		$password = trim($_POST['password']);
		$confirmPassword = trim($_POST['confirmPassword']);
		if(strcmp($password,$confirmPassword) != 0){
			$confirmPasswordReq = '<span style="color:red">Does Not Match</span>';
			$confirmPassword = "";
		}
		$phoneNumber = trim($_POST['phoneNumber']);
		$gender = trim($_POST['gender']);
		$birthYear = trim($_POST['birthYear']);
		$userStatus = trim($_POST['userStatus']);
		$address1 = trim($_POST['address1']);
		$address2 = trim($_POST['address2']);
		$city = trim($_POST['city']);
		$state = trim($_POST['state']);
		$zip = trim($_POST['zip']);
		$country = trim($_POST['country']);
		$degree = array();
		$major = array();
		$school = array();
		$yearCompleted = array();
		$eduNum = 1;
		while (isset($_POST["degree".$eduNum])) {
			array_push($degree, trim($_POST["degree".$eduNum]));
			array_push($major, trim($_POST["major".$eduNum]));
			array_push($school, trim($_POST["school".$eduNum]));
			array_push($yearCompleted, trim($_POST["yearCompleted".$eduNum]));
			$eduNum++;
		}
		$employment = trim($_POST['employment']);
		$field = trim($_POST['field']);
		$employer = trim($_POST['employer']);
		$fbLink = trim($_POST['fbLink']);
		$twLink = trim($_POST['twLink']);
		$lkdLink = trim($_POST['lkdLink']);
		$registrationDate = date("Y/m/d");
		
		if(!isset($_POST['tos']))
			$tosre = '<span style="color:red">*</span>';
		if ($confirmEmailReq != "*"|| $confirmPasswordReq != "*" || $userNameReq != "*" || $tosre != "*") {
			$msg = "Please enter valid data";
		} else {
			$code = randomCodeGenerator(50); //get random code generated
			$stmtAddress = $con->prepare("INSERT INTO address_tbl (ID, street1, street2, city, stateID, zipCode) VALUES (NULL, :street1, :street2, :city, :stateID, :zipCode)");
			$stmtAddress->execute(array('street1'=>$address1, 'street2'=>$address2, 'city'=>$city, 'stateID'=>$state, 'zipCode'=>$zip));
			$address_id = $con->lastInsertID();
			$stmtID = $con->prepare("INSERT INTO identity_tbl (employment, field, employer) VALUES (:employment, :field, :employer)");
        	$stmtID->execute(array('employment'=>$employment, 'field'=>$field, 'employer'=>$employer));
        	$identity_id = $con->lastInsertId();
			/* Header ("Location:blankPage.php?username=".$username."?email=".$email."?password=".$password."?firstName=".$firstName."?lastName=".$lastName."?gender=".$gender."?addressID=".$address_id."?phone=".$phoneNumber."?identityID=".$identity_id."?registerDate=".$registrationDate."?activationURL=".$code."?active=0"."?privilege=0"."?userStatus=".$userStatus); */
			$stmtUser = $con->prepare("INSERT INTO user_tbl (`ID`, `username`, `email`, `password`, `firstName`, `lastName`, `gender`, `birthYear` , `addressID`, `phone`, `identityID`, `fbLink`, `twLink`, `lkdLink`, `resumeID`, `pictureID`, `registerDate`, `activationURL`, `active`, `privilege`, `userStatus`) VALUES (NULL, :username, :email, :password, :firstName, :lastName, :gender, :birthYear, :addressID, :phone, :identityID, :fbLink, :twLink, :lkdLink, 1, 1, :registerDate, :activationURL, :active, :privilege, :userStatus)");
			$stmtUser->execute(array('username'=>$userName, 'email'=>$email, 'password'=>$password, 'firstName'=>$firstName, 'lastName'=>$lastName, 'gender'=>$gender, 'birthYear'=>$birthYear, 'addressID'=>$address_id, 'phone'=>$phoneNumber, 'identityID'=>$identity_id, 'fbLink'=>$fbLink, 'twLink'=>$twLink, 'lkdLink'=>$lkdLink, 'registerDate'=>$registrationDate, 'activationURL'=>$code, 'active'=>0, 'privilege'=>0, 'userStatus'=>$userStatus));
			$user_id = $con->lastInsertID();
			$stmtEdu = $con->prepare("INSERT INTO education_tbl (degreeType, major, schoolName, completionYear, userID) VALUES (:degree, :major, :school, :yearCompleted, :userID)");
			while(!empty($degree)) {
				$stmtEdu->execute(array('degree'=>array_pop($degree), 'major'=>array_pop($major), 'school'=>array_pop($school),  'yearCompleted'=>array_pop($yearCompleted), 'userID'=>$user_id));
			}
	        $subject = "Registration Activation"; //set email subject
	        $body = 'Please click the url to activate your account. http://corsair.cs.iupui.edu:23041/CourseProject/BaciProjectAlt/activate.php?code='.$code.'&userID='.$user_id; //set email body
	        $mailer = new Mail();
	        if(($mailer->sendMail($email, $firstName, $subject, $body))){ //send email
	        	$msg = "Email Sent";
	        	Header ("Location:userConfirmation.php?email=".$email);
	        }
		}
	}
}
?>

<div class="container" id="registration">
	<section id="registrationHeader">
		<h2>Registration</h2>
	</section>
	
	<?php include 'form.php'; ?>
	
</div>

<?php include 'footer.php'; ?>