<?php
session_start();
require_once "db_connect.php";

/*$mentorStmt = $con->prepare('SELECT lastName FROM user_tbl'); //Where mmStatus=1'
$mentorStmt->execute(array('lastName'=>$lastName));
$row = $mentorStmt->fetch(PDO::FETCH_OBJ);*/

$sql = "select * from user_tbl where userStatus = 1"; 
$a = $con->query($sql);

$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "")
{ 	
	$q=strtolower($q); 
	$len=strlen($q);

		foreach($a as $name){ 

			if (stristr($q, substr($name['lastName'],0,$len))){ //test if $q matches with the first few characters of the same length in the lastname
				if ($hint===""){ 
					$hint = '<option data-id="'.$name['ID'].'">'.$name['lastName'].', '.$name['firstName'].'</option>';
				}
				else{ 	
					$hint .= '<option data-id="'.$name['ID'].'">'.$name['lastName'].', '.$name['firstName'].'</option>';
				}
			}
		}
}


print $hint;
?>