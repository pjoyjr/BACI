<?php 
include 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$user = $_SESSION['user'];
$priv = $user->getUserPrivilege();

if ($priv != 2) {
	if ($priv != 3)
 		header('Location: dashboard.php');
}

$formType = 2;

$msg = "";

$userName = "";
$userNameReq = "*";

$userType = "";

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

$fbLink = "";
$twLink = "";
$lkdLink = "";

$address1 = "";
$address2 = "";
$city = "";
$state = "";
$zip = "";
$country = "";

if (isset($_POST['enter'])) {
	$userName = trim($_POST['userName']);
	$userName = strtolower($userName);
	$checkUserName = $con->prepare('SELECT username FROM user_tbl WHERE username = :username');
	$checkUserName->execute(array('username'=>$userName));
	if ($checkUserName->rowCount() > 0) {
		$userNameReq = '<span style="color:red">User Name Taken</span>';
	} else {
		$userType = trim($_POST['userType']);
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
		$registrationDate = date("Y/m/d");
		if ($confirmEmailReq != "*"|| $confirmPasswordReq != "*" || $userNameReq != "*") {
			$msg = "Please enter valid data";
		} else {
			$stmtAddress = $con->prepare("INSERT INTO address_tbl (ID, street1, street2, city, stateID, zipCode) VALUES (NULL, :street1, :street2, :city, :stateID, :zipCode)");
			$stmtAddress->execute(array('street1'=>$address1, 'street2'=>$address2, 'city'=>$city, 'stateID'=>$state, 'zipCode'=>$zip));
			$address_id = $con->lastInsertID();
			$stmtID = $con->prepare('INSERT INTO identity_tbl (employment, field, employer) VALUES (:employment, :field, :employer)');
        	$stmtID->execute(array('employment'=>$employment, 'field'=>$field, 'employer'=>$employer));
        	$identity_id = $con->lastInsertId();
			$stmtUser = $con->prepare("INSERT INTO user_tbl (`ID`, `username`, `email`, `password`, `firstName`, `lastName`, `gender`, `birthYear`,`addressID`, `phone`, `identityID`, `fbLink`, `twLink`, `lkdLink`, `resumeID`, `pictureID`, `registerDate`, `activationURL`, `active`, `privilege`, `userStatus`) VALUES (NULL, :username, :email, :password, :firstName, :lastName, :gender, :birthYear, :addressID, :phone, :identityID, :fbLink, :twLink, :lkdLink, 1, 1, :registerDate, :activationURL, :active, :privilege, :userStatus)");
			$stmtUser->execute(array('username'=>$userName, 'email'=>$email, 'password'=>$password, 'firstName'=>$firstName, 'lastName'=>$lastName, 'gender'=>$gender, 'birthYear'=>$birthYear, 'addressID'=>$address_id, 'phone'=>$phoneNumber, 'identityID'=>$identity_id, 'fbLink'=>"", 'twLink'=>"", 'lkdLink'=>"", 'registerDate'=>$registrationDate, 'activationURL'=>"adminAdded", 'active'=>1, 'privilege'=>$userType, 'userStatus'=>$userStatus));
			$user_id = $con->lastInsertID();
			$stmtEdu = $con->prepare("INSERT INTO education_tbl (degreeType, major, schoolName, completionYear, userID) VALUES (:degree, :major, :school, :yearCompleted, :userID)");
			while(!empty($degree)) {
				$stmtEdu->execute(array('degree'=>array_pop($degree), 'major'=>array_pop($major), 'school'=>array_pop($school),  'yearCompleted'=>array_pop($yearCompleted), 'userID'=>$user_id));
			}
			$msg = "User Added Successfully";
		}
	}
}

?>

<div class="container" id="registration">
	<section id="registrationHeader">
		<h2>Add User, Coordinator<?php if ($priv == 3) { ?>, or Admin <?php } ?></h2>
	</section>

	<?php include 'form.php'; ?>
</div>

<?php include 'footer.php'; ?>