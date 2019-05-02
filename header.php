<?php
include 'userClass.php';
include 'addressClass.php';
include 'pairClass.php';
session_start();
require_once 'inc/util.php';
require_once 'mail/mail.class.php';
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
	<title>BACI: 
	<?php
	if(basename($_SERVER['PHP_SELF'])=="index.php") print 'Homepage';		
			else if(basename($_SERVER['PHP_SELF'])=="activate.php") print 'Activation';
			else if(basename($_SERVER['PHP_SELF'])=="dashboard.php") print 'Dashboard';
			else if(basename($_SERVER['PHP_SELF'])=="login.php") print 'Login';
			else if(basename($_SERVER['PHP_SELF'])=="forgotPassword.php") print 'Forgot Password';
			else if(basename($_SERVER['PHP_SELF'])=="registration.php") print 'Registration';
			else if(basename($_SERVER['PHP_SELF'])=="deactUser.php") print 'Deactivate User';
			else if(basename($_SERVER['PHP_SELF'])=="listUsers.php") print 'All Users List';
			else if(basename($_SERVER['PHP_SELF'])=="addUser.php") print 'Create User';
			else if(basename($_SERVER['PHP_SELF'])=="downloadTables.php") print 'Download Tables';
			else if(basename($_SERVER['PHP_SELF'])=="configureCountry.php") print 'Configure Country list';
			else if(basename($_SERVER['PHP_SELF'])=="configureDegree.php") print 'Configure Degree list';
			else if(basename($_SERVER['PHP_SELF'])=="configureState.php") print 'Configure State list';
			else if(basename($_SERVER['PHP_SELF'])=="listMentors.php") print 'Mentors List';
			else if(basename($_SERVER['PHP_SELF'])=="listMentees.php") print 'Mentees List';
			else if(basename($_SERVER['PHP_SELF'])=="listPending.php") print 'Pending Pairings';
			else if(basename($_SERVER['PHP_SELF'])=="listCurrent.php") print 'Current Pairings';
			else if(basename($_SERVER['PHP_SELF'])=="adminPair.php") print 'Create Mentorship';
			else if(basename($_SERVER['PHP_SELF'])=="pairing.php") print 'Pairing';
			else if(basename($_SERVER['PHP_SELF'])=="userProfile.php") print 'User Profile';
			else if(basename($_SERVER['PHP_SELF'])=="fileUpload.php") print 'Upload Picture/Resume';
			else if(basename($_SERVER['PHP_SELF'])=="userPairing.php") print 'Mentor/Mentee Pairings';
	?>
	</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>

	<!-- <link rel="stylesheet" href="css/buttons.css"> -->

</head>
<body>
	
	<?php
	$navBackground = "";
	if (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'login.php')
		$navBackground = "transparent";
	else
		$navBackground = "bg-dark";
	?>
	<nav class="navbar navbar-expand-lg navbar-dark <?php echo($navBackground); ?>">
		<div class="container">
			<?php 
			if(isset($_SESSION['loggedin'])){
				if($_SESSION['loggedin'] == true){
				echo '<a href="userProfile.php" class="navbar-brand">';
				$user = $_SESSION['user'];
				$name = $user->getFirstName()." ".$user->getLastName();
				echo "Hello, ".$name;
				}
			}else{
				
				echo '<a href="index.php" class="navbar-brand">';
				echo "Baci Project" ;
			}?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { echo 'active';} ?>">
						<a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
					</li>
					<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
					<!--##### ADD LOGGED IN HEADER LINKS BELOW ##### -->
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') { echo 'active';} ?>">
						<a class="nav-link" href="dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'logout.php') { echo 'active';} ?>">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
					<?php } else { ?>
					<!--##### ADD NOT LOGGED IN HEADER LINKS BELOW ##### -->
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'registration.php') { echo 'active';} ?>">
						<a class="nav-link" href="registration.php">Register</a>
					</li>
					<li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'login.php') { echo 'active';} ?>">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- <ul class="nav justify-content-end">
		<li class="nav-item">
			<a class="nav-link active" href="#">Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Register</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Login</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled" href="#">Admin</a>
		</li>
	</ul> -->
	