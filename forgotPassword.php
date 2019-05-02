<!--
	forgotPassword.php - Allows user/admin to send an email with user's password
-->

<?php

include "header.php";
require_once 'db_connect.php';

//initialize variables to be used

$un = ""; //username

$code = randomCodeGenerator(50);
	
$msg = "Enter your username to recieve <br>an email to reset your password"; //message to user

if (isset($_POST['reset'])){
	
	$un = trim($_POST['username']);
	$un = strtolower($un);

	$stmtCode = $con->prepare("UPDATE user_tbl SET activationURL = '$code' WHERE username = :un");
	$stmtCode->execute(array('un' => $un));
	
	$stmtEmail = $con->prepare("SELECT email FROM user_tbl WHERE username = :un");
	$stmtEmail -> execute(array('un' => $un));
	$row = $stmtEmail->fetch(PDO::FETCH_OBJ);

	
	$body = "Please follow this link to reset your BACI password: http://corsair.cs.iupui.edu:23041/CourseProject/BaciProjectAlt/resetPassword.php?code=".$code;
	//$body = "Please follow this link to reset your BACI password: http://corsair.cs.iupui.edu:23151/BaciProjectAlt/resetPassword.php?code=".$code;
	$mailer = new Mail();
	if(($mailer->sendMail($row->email, "User", "BACI email reset", $body))){
			$msg = "An email has been sent to the corresponding email. Please follow the link to reset your password.";
	}

}

?>

<section id="loginPage">

	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="forgotPassword.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="text" class="form-control" id="username" name="username" placeholder="User Name" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-danger btn-sm" name="reset">Reset <i class="fas fa-sync"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>