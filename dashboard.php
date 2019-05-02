<?php 
include 'header.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$address = $_SESSION['address'];

$firstName = $user->getFirstName();
$userPriv = $user->getUserPrivilege();
$userStatus = $user->getUserStatus();

function passwordToDots($password) {
    $len = strlen($password);
    $hiddenPSW = "";
    for($i = 0; $i < $len; $i++) {
    	$hiddenPSW = $hiddenPSW.'&#9679;';
    }
    return $hiddenPSW;
}
?>
<section id="dashboard">
	<div class="container">

		<?php if ($userPriv == 3) {?>
		<h3>Super-Admin Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add Admin</h5>
						<p class="card-text">Add a new Admin.</p>
						<a href="addUser.php" class="btn btn-danger">Add Admin</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Delete a Registered User/Coord/Admin</h5>
						<p class="card-text">Hides a User, Coordinator or Admin.</p>
						<a href="delUser.php" class="btn btn-danger">Delete</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Activate/Reactivate a User/Coord/Admin</h5>
						<p class="card-text">Activate/Reactive any deleted or inactive User/Coord/Admin.</p>
						<a href="reactAdmin.php" class="btn btn-danger">Activate/Reactivate</a>
					</div>
				</div>
			</div>
		</div>	
		<hr>
	<?php } ?>
	
	<?php if ($userPriv == 2 || $userPriv == 3) {?>
		<h3>Admin Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User List</h5>
						<p class="card-text">View all users/coordinators (not activated, activated, hidden) .</p>
						<a href="listUsers.php" class="btn btn-warning">View/Edit</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add User</h5>
						<p class="card-text">Add a User or Coordinator Manually</p>
						<a href="addUser.php" class="btn btn-warning">Add</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Download Tables</h5>
						<p class="card-text">Export the information within the database</p>
						<a href="downloadTables.php" class="btn btn-warning">Download Tables</a>
					</div>
				</div>
			</div>
		</div>
		<?php if($userPriv == 2){ ?>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Delete a Registered User/Coord</h5>
						<p class="card-text">Hides a User or a Coordinator.</p>
						<a href="delUser.php" class="btn btn-warning">Delete</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<hr>
	<?php } ?>

	<?php if ($userPriv == 1 || $userPriv == 2 || $userPriv == 3) {?>
		<h3>Coordinator Dashboard</h3>
		<div class="row mt-1">
		<?php if($userPriv == 1){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">View/Edit User List</h5>
						<p class="card-text">List of all the registered users in the database.</p>
						<a href="listUsers.php" class="btn btn-primary">User List</a>
					</div>
				</div>
			</div>
		<?php } ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Create New Pair</h5>
						<p class="card-text">Add a new mentor/mentee pair.</p>
						<a href="adminPair.php" class="btn btn-primary">New Pair</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Current Pairings</h5>
						<p class="card-text">View current mentor/mentee pairs.</p>
						<a href="listCurrent.php" class="btn btn-primary">Current Pairings</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Pending Pairings</h5>
						<p class="card-text">View pending mentor/mentee pairs.</p>
						<a href="listPending.php" class="btn btn-primary">Pending Pairings</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Ended/Denied Pairings</h5>
						<p class="card-text">View pending mentor/mentee pairs.</p>
						<a href="listEnded.php" class="btn btn-primary">Ended/Denied Pairings</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Country list</h5>
						<p class="card-text">Add, edit or delete a country from the database</p>
						<a href="configureCountry.php" class="btn btn-primary">Configure Country list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure State list</h5>
						<p class="card-text">Add, edit or delete a state from the database</p>
						<a href="configureState.php" class="btn btn-primary">Configure State list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Degree Level list</h5>
						<p class="card-text">Add, edit or delete an educational degree from the database</p>
						<a href="configureDegree.php" class="btn btn-primary">Configure Degree level list</a>
					</div>
				</div>
			</div>
		</div>
		<hr>
	<?php } ?>

		<h3>User Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User Profile</h5>
						<p class="card-text">View and Edit your public profile.</p>
						<a href="userProfile.php" class="btn btn-success">User Profile</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Upload Files</h5>
						<p class="card-text">Upload a picture or resume to your profile</p>
						<a href="fileUpload.php" class="btn btn-success">Upload Files</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User Pairing</h5>
						<p class="card-text">View Current Pairing Details.</p>
						<a href="userPairing.php" class="btn btn-success">User Pairing</a>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row mt-1">
			<?php if ($userStatus != "Mentor") {?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">View Mentors</h5>
						<p class="card-text">View registered mentors</p>
						<a href="listMentors.php" class="btn btn-success">View Mentors</a>
					</div>
				</div>
			</div>
		<?php } if ($userStatus != "Mentee"){ ?>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">View Mentees</h5>
						<p class="card-text">View registered mentees</p>
						<a href="listMentees.php" class="btn btn-success">View Mentees</a>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>


	</div>
</section>
<?php 
include 'footer.php'; ?>