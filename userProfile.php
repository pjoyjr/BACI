<?php 
include 'header.php';
require_once 'db_connect.php';
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$user = new User();
$address = new Address();
$admin = false;
$adminCheck = $_SESSION['user'];
if ($adminCheck->getUserPrivilege() != 0) {
	$admin = true;
}
$boolUser = false;
$mmSelect ="";
if (isset($_REQUEST["userID"])) {
	$tempUser = $_SESSION['user'];
	$userID = $_REQUEST["userID"];
	if ($tempUser->getID() != $userID) {
		$boolUser = true;
		$profileStmt = $con->prepare('SELECT * FROM user_tbl WHERE ID = :ID');
		$profileStmt->execute(array('ID'=>$userID));
		$row = $profileStmt->fetch(PDO::FETCH_OBJ);
		if($profileStmt->rowCount() != 1) {
			$msg = "Profile Not Found";
		} else {
			$user = new User();
			$user->setID($row->ID);
			$user->setUserName($row->username);
			$user->setPassword($row->password);
			$user->setEmail($row->email);
			$user->setFirstName($row->firstName);
			$user->setLastName($row->lastName);
			$user->setPhoneNumber($row->phone);
			$user->setGender($row->gender);
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
		}
	} else {
		$user = $_SESSION['user'];
		$address = $_SESSION['address'];
	}

} else {
	$user = $_SESSION['user'];
	$address = $_SESSION['address'];
}
function passwordToDots($password) {
	$len = strlen($password);
	$hiddenPSW = "";
	for($i = 0; $i < $len; $i++) {
		$hiddenPSW = $hiddenPSW.'&#9679;';
	}
	return $hiddenPSW;
}
if (isset($_REQUEST["mmSelect"]) && isset($_REQUEST["userID"])) {
	//set PairClass
	$mmPair = new Pair();
	$pairer = $_SESSION['user'];
	
	if ($_REQUEST["mmSelect"] == 0){
		$mmPair->setMenteeID($pairer->getID());
		$mmPair->setMentorID($user->getID());
		$mmPair->setRequester(0);
		$_SESSION['mmPair'] = $mmPair;
		$mmSelect = "Mentor";
	} else if($_REQUEST["mmSelect"] == 1) {
		$mmPair->setMenteeID($user->getID());
		$mmPair->setMentorID($pairer->getID());
		$mmPair->setRequester(1);
		$_SESSION['mmPair'] = $mmPair;
		$mmSelect = "Mentee";
	}
}
?>
<section id="dashboard">
	<div class="container">
			<div class="row mt-4">
				<div class="col-md-4 col-sm-4">
					<a href="dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
				</div>
				<?php if ($mmSelect != "") { ?>
				<div class="col-md-4 col-sm-4">
					<a href="pairRequest.php?id=<?php echo $user->getID(); ?>" class="btn btn-success btn-sm">Select as <?php echo $mmSelect?></a> <!-- ADD THE LINK TO INSERT TO MMRELATION TABLE HERE -->
				</div>
				<?php } ?>
			</div>
			<div class="row mt-4">
				<div class="col-md-4 col-sm-4" style="padding-right:20px; border-right: 1px solid #ccc;">
					<h3>User Profile</h3>
					<div class="row mt-4">
						<img src="<?php echo($user->getImagePath());?>" alt="profile_pic" class="rounded-circle" width="75%" height="75%">
					</div>
					<?php if($boolUser == false) {?>
					<div class="row mt-4">
						<p class="lead"><a href="fileUpload.php">Edit Profile Picture</a></p>
					</div>
					<?php } ?>
					<?php if ($boolUser == false || $admin) {?>
					<div class="row">
						<p class="lead"><a href="<?php echo($user->getResumePath());?>" class="btn btn-info">Resume</a></p>
					</div>
					<?php } ?>
				</div>
				<div class="col-md-8 col-sm-12">
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<h4>User Information</h4>
						</div>
						<?php if ($boolUser == false || $admin) { ?>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="editUserInformation.php?id=<?php echo($user->getID()) ?>">Edit User Information</a></p>
						</div>
						<?php } ?>
					</div>
					<?php if($boolUser == false) {?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">UserName:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getUserName()); ?></p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Password:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo(passwordToDots($user->getPassword())); ?> <a href="changePassword.php">Change Password</a></p>
						</div>
					</div>
					<?php } ?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Email:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getEmail()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">First Name:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getFirstName()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Last Name:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getLastName()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Phone Number:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getPhoneNumber()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Gender:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getGender()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">User Status:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($user->getUserStatus()); ?></p>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<h4>Address Information</h4>
						</div>
						<?php if ($boolUser == false || $admin) { ?>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="editAddressInformation.php?id=<?php echo($user->getID()) ?>">Edit Address Information</a></p>
						</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Street 1:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getStreet1()); ?></p>
						</div>
					</div>
					<?php if($address->getStreet2() != "") {?>
						<div class="row">
							<div class="col-md-4 col-sm-8">
								<p class="lead">Street 2:</p>
							</div>
							<div class="col-md-8 col-sm-12">
								<p class="lead"><?php echo($address->getStreet2()); ?></p>
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">City:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getCity()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">State:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getState()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">ZipCode:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getZipCode()); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Country:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getCountry()); ?></p>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<h4>Education</h4>
						</div>
						<?php if ($boolUser == false) { ?>
						<div class="col-md-4 col-sm-12">
							<p class="lead"><a href="addEducation.php" class="btn btn-outline-primary btn-sm">Add Education</a></p>
						</div>
						<?php } ?>
					</div>
					<?php 
					$eduSTMT = $con->prepare('SELECT * FROM education_tbl WHERE userID = :ID');
					$eduSTMT->execute(array('ID'=>$user->getID()));
					$count = 1;
					while($eduRow = $eduSTMT->fetch(PDO::FETCH_OBJ)) {
						$degreeSTMT = $con->prepare('SELECT * FROM degree_tbl WHERE ID = :ID');
						$degreeSTMT->execute(array('ID'=>$eduRow->degreeType));
						$degreeRow = $degreeSTMT->fetch(PDO::FETCH_OBJ);
					?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<h4>Education <?php echo $count; ?></h4>
						</div>
						<?php if ($boolUser == false || $admin) { ?>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="editEducation.php?num=<?php echo $eduRow->ID; ?>&id=<?php echo($user->getID()) ?>">Edit Education <?php echo $count; ?></a></p>
						</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Degree Type:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo $degreeRow->type; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Major:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo $eduRow->major; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">School Name:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo $eduRow->schoolName; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Completion Year:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo $eduRow->completionYear; ?></p>
						</div>
					</div>
					<?php 
					$count++;
					} ?>
					<hr>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<h4>Additional Information</h4>
						</div>
						<?php if ($boolUser == false || $admin) { ?>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="editAdditionalInfo.php?id=<?php echo($user->getID()) ?>">Edit Additional Information</a></p>
						</div>
						<?php } ?>
					</div>
					<?php if ($user->getFbLink() != "") {?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Facebook Link</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="https://www.facebook.com/<?php echo($user->getFbLink()); ?>"><?php echo"facebook.com/".($user->getFbLink()); ?></a></p>
						</div>
					</div>
					<?php }
					if ($user->getTwLink() != "") { ?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Twitter Link</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="https://www.twitter.com/<?php echo($user->getTwLink()); ?>"><?php echo"twitter.com/".($user->getTwLink()); ?></a></p>
						</div>
					</div>
					<?php }
					if ($user->getLkLink() != "") { ?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">LinkedIn Link</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><a href="https://www.linkedIn.com/<?php echo($user->getLkLink()); ?>"><?php echo"linkedIn.com/".($user->getLkLink()); ?></a></p>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
	</div>
</section>

<?php include 'footer.php'; ?>