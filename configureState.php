<?php 
require_once 'header.php';
require_once "db_connect.php";

//verify logged in as a admin
$user = $_SESSION['user'];
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$userPriv = $user->getUserPrivilege();
if($userPriv < 1 || $userPriv > 3){
	header('Location: dashboard.php');
}	
			
//initialize variable
$state = "";
$msgState = "";
$country="";

//show states for selected country to database
if(isset($_POST['show'])) {
	$msgState = "";
	$countryID = trim($_POST['countryIDShow']);
	$countryName = $con->query("select * from country_tbl");
	while($rowCountryName = $countryName->fetch(PDO::FETCH_ASSOC)) {
		if($rowCountryName['ID'] == $countryID)
			$country = $rowCountryName['name'];
	}
	$msgState = "The active states currently in ".$country." are : "."</br>";
	$resultShow = $con->query("select * from state_tbl WHERE active = 1 ORDER BY name ASC");
	while($rowShow = $resultShow->fetch(PDO::FETCH_ASSOC)) {
		if($rowShow['countryID'] == $countryID)
			$msgState = $msgState.$rowShow['name']."</br>";
	}
	$msgState = $msgState."</br>The inactive states currently in ".$country." are : "."</br>";
	$resultShow = $con->query("select * from state_tbl WHERE active = 0 ORDER BY name ASC");
	while($rowShow = $resultShow->fetch(PDO::FETCH_ASSOC)) {
		if($rowShow['countryID'] == $countryID)
			$msgState = $msgState.$rowShow['name']."</br>";
	}
}

//add to database
if(isset($_POST['add'])) {
	$newState = trim($_POST['addState']);
	$countryID = trim($_POST['countryID']);
	if($newState != ""){
		$stmt = $con->prepare('INSERT INTO state_tbl (ID, name, countryID, active) VALUES (Null, :state, :countryID, 1)');
		$stmt->execute(array('state' => $newState, 'countryID' => $countryID));
	}
}
//edit from database
if(isset($_POST['edit'])){
		$stateNum = trim($_POST['stateNameEdit']);
		$state = trim($_POST['editState']);
		if($state != ""){
			$stmt = $con->prepare('UPDATE state_tbl SET name = :name WHERE ID = :num');
			$stmt->execute(array('name' => $state, 'num' => $stateNum));
		}
	}	

//activate in database
if(isset($_POST['activate'])){
		$stmt = $con->prepare('UPDATE state_tbl SET active = 1 WHERE ID = :num');
		$stmt->execute(array('num' => $_POST["stateID"]));
	}

//deactivate from database
if(isset($_POST['deactivate'])){
		$stmt = $con->prepare('UPDATE state_tbl SET active = 0 WHERE ID = :num');
		$stmt->execute(array('num' => $_POST["stateID"]));
	}	
	
$result = $con->query("select * from state_tbl ORDER BY name ASC");
$resultCountry = $con->query("select name from country_tbl ORDER BY name ASC");
?>

<div class="container" id="configureState">
	<section id="blankHeader">
		<div class="row mt-4">
			<div class="col-sm-12">
				<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-sm-6 col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<!-- PRINT ALL STATES-->
				<h4>List of states in current database are:</h4>
				
				<!-- editing -->
				<form action="configureState.php" method="post">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="countryIDShow">Country: </label>
						</div>
						<select class="custom-select" name="countryIDShow">
							<?php
							$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
							while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
							}
							?>
						</select>
						<div class="input-group-append">
							<button type="submit" class="btn btn-outline-danger" name="show">Show States</button>
						</div>
					</div>
					<?php echo $msgState?>
				</form>

				
			</div>
			<div class="col-sm-6 col-md-8">
				<div class="row">
					<div class="col-sm-12">
					<!-- ADD STATES-->
						<h4>Add State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameEdit">State</label>
								</div>
								<input type="text" class="form-control" name="addState">
								<div class="input-group-prepend">
									<label class="input-group-text" for="countryID">Country</label>
								</div>
								<select class="custom-select" name="countryID">
									<?php
									$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="add">Add State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-sm-12">
					<!-- EDIT STATES-->
						<h4>Edit State Name</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameEdit">States</label>
								</div>
								<select class="custom-select" name="stateNameEdit">
									<?php
									$result1 = $con->query("select * from state_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										$stmtCountry = $con->prepare('SELECT * FROM country_tbl WHERE ID = :id');
										$stmtCountry->execute(array('id' => $row1["countryID"]));
										$rowCountry = $stmtCountry->fetch(PDO::FETCH_ASSOC);
										$country = $rowCountry["name"];
										echo "<option value = '".$row1['ID']."'>".$row1['name'].", ".$country."</option>";
									}
									?>
								</select>
								<input type="text" class="form-control" name="editState">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary" name="edit">Edit State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-sm-12">
					<!-- Activate STATES-->
						<h4>Activate State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameAct">States</label>
								</div>
								<select class="custom-select" name="stateID">
									<?php
									$result1 = $con->query("select * from state_tbl WHERE active = 0 ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										$stmtCountry = $con->prepare('SELECT * FROM country_tbl WHERE ID = :id');
										$stmtCountry->execute(array('id' => $row1["countryID"]));
										$rowCountry = $stmtCountry->fetch(PDO::FETCH_ASSOC);
										$country = $rowCountry["name"];
										echo "<option value = '".$row1['ID']."'>".$row1['name'].", ".$country."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="activate">Activate State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-sm-12">
					<!-- Deactivate STATES-->
						<h4>Dectivate State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameDeact">States</label>
								</div>
								<select class="custom-select" name="stateID">
									<?php
									$result1 = $con->query("select * from state_tbl WHERE active = 1 ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										$stmtCountry = $con->prepare('SELECT * FROM country_tbl WHERE ID = :id');
										$stmtCountry->execute(array('id' => $row1["countryID"]));
										$rowCountry = $stmtCountry->fetch(PDO::FETCH_ASSOC);
										$country = $rowCountry["name"];
										echo "<option value = '".$row1['ID']."'>".$row1['name'].", ".$country."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-danger" name="deactivate">Deactivate State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div>
