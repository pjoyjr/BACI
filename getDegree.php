<?php 

require_once "db_connect.php";

$num = $_REQUEST["num"];

$stmt = $con->prepare("SELECT * FROM degree_tbl WHERE active = 1");
$stmt->execute(array());

$string = "";

$string = $string."<select id='degree'".$num." class='form-control' name='degree".$num."' required>";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$string = $string."<option value='" . $row['ID'] ."'>" . $row['type'] ."</option>";
}
$string = $string."</select>";

print($string);