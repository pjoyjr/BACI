<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$userPage = "";
if (isset($_REQUEST['id']))
	$userPage = $_REQUEST['id'];


$user = $_SESSION['user'];
$address = $_SESSION['address'];

$userPriv = $user->getUserPrivilege();
$userID = $user->getID();
$addressID = $address->getID();

if ($userID != $userPage && $userPriv == 0)
	header('Location: dashboard.php'); 

if ($userID != $userPage) {
	$profileStmt = $con->prepare('SELECT * FROM user_tbl WHERE ID = :ID');
	$profileStmt->execute(array('ID'=>$userPage));
	$row = $profileStmt->fetch(PDO::FETCH_OBJ);
	if($profileStmt->rowCount() != 1) {
		$msg = "Profile Not Found";
	} else {
		$user = new User();
		$address = new Address();
		$user->setID($row->ID);
		$user->setAddressID($row->addressID);
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
		$userID = $user->getID();

		$addressID = $address->getID();
	}
}

$street1 = "";
$street2 = "";
$city = "";
$state = "";
$zipCode = "";
$country = "";


$success = "";

if (isset($_POST['update'])) {

	$street1 = trim($_POST['street1']);
	$street2 = trim($_POST['street2']);
	$city = trim($_POST['city']);
	$zipCode = trim($_POST['zipCode']);
	$state = trim($_POST['state']);
	$country = trim($_POST['country']);
	
	$updateAddressInfo = $con->prepare("UPDATE address_tbl SET street1 = '$street1', street2 = '$street2', city = '$city', stateID = '$state', zipCode = '$zipCode' WHERE ID = '$addressID'");
	$updateAddressInfo->execute(array());
	$address->setStreet1($street1);
	$address->setStreet2($street2);
	$address->setCity($city);

	$stateSTMT = $con->prepare('SELECT * FROM state_tbl WHERE ID = :ID');
	$stateSTMT->execute(array('ID'=>$state));
	$stateRow = $stateSTMT->fetch(PDO::FETCH_OBJ);
	$address->setState($stateRow->name);

	$address->setZipCode($zipCode);

	$countrySTMT = $con->prepare('SELECT * FROM country_tbl WHERE ID = :ID');
	$countrySTMT->execute(array('ID'=>$country));
	$countryRow = $countrySTMT->fetch(PDO::FETCH_OBJ);
	$address->setCountry($countryRow->name);

	$success = "Update Successful";

}
?>

<section id="editAddressInfo">
	<div id="userAddressCell">
		<div class="container">
			<div class="row mt-4">
				<div class="col-md-4 col-sm-8">
					<h4>Edit Address Information</h4>
				</div>
				<div class="col-md-8 col-sm-12">
					<p class="lead">Click the information you wish to edit</p>
				</div>
			</div>
			<form action="editAddressInformation.php?id=<?php echo $user->getID(); ?>" method="post">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Street 1:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="street1" name="street1" value="<?php echo($address->getStreet1()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Street 2:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="street2" name="street2" value="<?php echo($address->getStreet2()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">City:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="city" name="city" value="<?php echo($address->getCity()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Zip Code:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="zipCode" name="zipCode" value="<?php echo($address->getZipCode()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">State:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="state" class="form-control" name="state">
							<option selected="" disabled="">Select Country</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Country:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="country" class="form-control" name="country">
							<option selected="" disabled="">Countries</option>
							<?php 
							require_once 'data.php';
							$countries = loadCountries($con);
							foreach ($countries as $country) {
								echo "<option value='".$country['ID']."'>".$country['name']."</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<a href="userProfile.php?userID=<?php echo $userID; ?>" class="btn btn-secondary btn-sm">Back to User Profile <i class="fas fa-undo-alt"></i></a>
					</div>
					<div class="form-group col-sm-12 col-md-8">
						<button type="submit" class="btn btn-dark btn-sm" name="update">Update <i class="fas fa-cloud-upload-alt"></i></button>
						<?php echo $success; ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php 
include 'footer.php';
?>