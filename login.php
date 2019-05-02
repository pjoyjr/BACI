<?php 
include 'header.php';
require_once 'db_connect.php';

$userName = "";
$password = "";

$msg = "Login";

$user = new User();
$address = new Address();

if (isset($_POST['login'])) {

	$userName = trim($_POST['userName']);
	$password = trim($_POST['password']);


	$loginStmt = $con->prepare('SELECT * FROM user_tbl WHERE userName = :userName AND password = :password');
	$loginStmt->execute(array('userName'=>$userName, 'password'=>$password));
	$row = $loginStmt->fetch(PDO::FETCH_OBJ);

	if($loginStmt->rowCount() != 1) {
		$msg = "Login Unsuccessful. Please Try Again.";
	} else {
		if ($row->active == 0)
			$msg = "Login Unsuccessful. Account isnt Activated.";
		else {
			$_SESSION['loggedin'] = true;
			$user->setID($row->ID);
			$user->setUserName($row->username);
			$user->setPassword($row->password);
			$user->setEmail($row->email);
			$user->setFirstName($row->firstName);
			$user->setLastName($row->lastName);
			$user->setPhoneNumber($row->phone);
			$user->setGender($row->gender);
			$user->setBirthYear($row->birthYear);
			$user->setUserStatus($row->userStatus);
			$user->setAddressID($row->addressID);
			$user->setUserPrivilege($row->privilege);
			$user->setIdentityID($row->identityID);
			$user->setFbLink($row->fbLink);
			$user->setTwLink($row->twLink);
			$user->setLkLink($row->lkdLink);

			$imageSTMT = $con->prepare('SELECT * FROM picture_tbl WHERE ID = :ID');
			$imageSTMT->execute(array('ID'=>$row->pictureID));
			$imageRow = $imageSTMT->fetch(PDO::FETCH_OBJ);

			$user->setImagePath($imageRow->location);

			$resumeSTMT = $con->prepare('SELECT * FROM resume_tbl WHERE ID = :ID');
			$resumeSTMT->execute(array('ID'=>$row->resumeID));
			$resumeRow = $resumeSTMT->fetch(PDO::FETCH_OBJ);

			$user->setResumePath($resumeRow->location);

			$_SESSION['user'] = $user;

			$addressSTMT = $con->prepare('SELECT * FROM address_tbl WHERE ID = :ID');
			$addressSTMT->execute(array('ID'=>$user->getAddressID()));
			$addressRow = $addressSTMT->fetch(PDO::FETCH_OBJ);

			$stateSTMT = $con->prepare('SELECT * FROM state_tbl WHERE ID = :ID');
			$stateSTMT->execute(array('ID'=>$addressRow->stateID));
			$stateRow = $stateSTMT->fetch(PDO::FETCH_OBJ);

			$countrySTMT = $con->prepare('SELECT * FROM country_tbl WHERE ID = :ID');
			$countrySTMT->execute(array('ID'=>$stateRow->countryID));
			$countryRow = $countrySTMT->fetch(PDO::FETCH_OBJ);

			$address->setID($addressRow->ID);
			$address->setStreet1($addressRow->street1);
			$address->setStreet2($addressRow->street2);
			$address->setCity($addressRow->city);
			$address->setState($stateRow->name);
			$address->setStateID($addressRow->stateID);
			$address->setZipCode($addressRow->zipCode);
			$address->setCountry($countryRow->name);
			$address->setCountryID($stateRow->countryID);

			$_SESSION['address'] = $address;

			Header ("Location:dashboard.php");
		}
	}

}
?>

<section id="loginPage">
	
	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="login.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="text" class="form-control" id="userName" name="userName" placeholder="User Name" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="login">Login <i class="far fa-arrow-alt-circle-right"></i></button>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<hr id="loginHR">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<a href="forgotPassword.php" type="submit" class="btn btn-danger btn-sm">Forgot Password <i class="fas fa-key"></i></a>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>