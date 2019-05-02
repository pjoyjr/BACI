<?php 

if(isset($_POST['country'])) {
	/*** mysql hostname ***/
	$hostname = 'localhost';

	/*** mysql username ***/
	$username = 'pjoyjr';

	/*** mysql password ***/
	$password = 'Burmese4!';

	try {
		$con = new PDO("mysql:host=$hostname;dbname=pjoyjr_db", $username, $password);
		/*** echo a message saying we have connected ***/
		//echo 'Connected to database';
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	$stmt = $con->prepare("SELECT * FROM state_tbl WHERE active = 1 AND countryID = ".$_POST['country']);
	$stmt->execute();
	$states = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($states);
}

function loadCountries($con) {
	$stmt = $con->prepare("SELECT * FROM country_tbl WHERE active = 1");
	$stmt->execute();
	$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $countries;
}

 ?>