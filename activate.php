<?php 

include 'header.php';
require_once 'db_connect.php';


$code = ($_GET["code"]);
$userID = ($_GET["userID"]);

$msg = "";

if (validateCode($code)) {
	$stmt = $con->prepare("UPDATE user_tbl SET active=1 WHERE ID = :userID");
	$stmt -> execute(array('userID' => $userID));
	$stmt = $con->prepare("UPDATE user_tbl SET activationURL=1 WHERE ID = :userID");
	$stmt -> execute(array('userID' => $userID));

	header('Location: login.php');
} else {
	$msg = "Error with Validation Code.";
}

if (isset($_POST['resend'])) {
	$stmt = $con->prepare("SELECT email FROM user_tbl WHERE ID= :userID");
	$stmt -> execute(array('userID' => $userID));
	$row = $stmt->fetch(PDO::FETCH_OBJe);
	$code = randomCodeGenerator(50); //get random code generated
    $subject = "Registration Activation"; //set email subject
	$body = 'Please click the url to activate your account. http://corsair.cs.iupui.edu:23041/CourseProject/BaciProjectAlt/activate.php?code='.$code.'&userID='.$user_id; //set email body
	//$body = 'Please click the url to activate your account. http://corsair.cs.iupui.edu:23151/BaciProjectAlt/activate.php?code='.$code.'&userID='.$user_id; //set email body
    $mailer = new Mail();
    if(($mailer->sendMail($row->email, "User", $subject, $body))){ //send email
    	$msg = "Email Sent";
    	Header ("Location:userConfirmation.php?email=".$row->email);
    }
}

 ?>

<section id="loginPage">
	
	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="activate.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="resend">Resend Activation Code<i class="fas fa-lock"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>