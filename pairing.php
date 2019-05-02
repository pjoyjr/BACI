<?php 
include 'header.php';
require_once 'db_connect.php';
$msg = "";
$msgRq = "*";
$subject = "";
$body = "";
$mentor = ($_GET["mentor"]);
$mentee = ($_GET["mentee"]);
$change = ($_GET["change"]);
$date = date("Y-m-d");
$stmtMentor = $con->prepare("SELECT * FROM user_tbl WHERE ID=:mentor");
$stmtMentor -> execute(array('mentor' => $mentor));
$mentorRow = $stmtMentor->fetch(PDO::FETCH_OBJ);
$stmtMentee = $con->prepare("SELECT * FROM user_tbl WHERE ID=:mentee");
$stmtMentee -> execute(array('mentee' => $mentee));
$menteeRow = $stmtMentee->fetch(PDO::FETCH_OBJ);
//0 -> Pairing denied by coordinator
//1 -> Pairing approved by coordinator
//2 -> Current pairing ended by coordinator
//3 -> Current pairing ended by user
//4 -> Pairing denied by user
//5 -> Pairing approved by user
//6 -> Admin enter pairing and approve
//7 -> Admin rerequests a pairing
if($change == "0" or $change == "4"){
	$stmt = $con->prepare("UPDATE mmRelationship_tbl SET rejectDate=:date WHERE mentorID = :mentor AND menteeID = :mentee");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing denied.";
	$subject = "Pairing Denied";
	if($change == "0"){
		$body = "A pairing has been denied by a coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been denied.";
	} else if ($change == "4"){
		$body = "A pairing has been denied by a user. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been denied.";
	}
} else if ($change == "1" or $change == "5"){
	$stmt = $con->prepare("UPDATE mmRelationship_tbl SET startDate=:date WHERE mentorID = :mentor AND menteeID = :mentee");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing accepted.";
	$subject = "Pairing Accepted";
	if($change == "1"){
		$body = "A pairing has been started by a coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been activated.";
	} else if ($change == "5"){
		$body = "A pairing has been started by a user. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been activated.";
	}
	
} else if ($change == "2" or $change == "3") {
	$stmt = $con->prepare("UPDATE mmRelationship_tbl SET endDate=:date WHERE mentorID=:mentor AND menteeID=:mentee");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing ended.";
	$subject = "Pairing Ended";
	if($change == "2"){
		$body = "A pairing has been ended by a coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been ended.";
	} else if ($change == "3"){
		$body = "A pairing has been ended by a user. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been ended.";
	}
	
} else if ($change == "6") {
	$stmt = $con->prepare("INSERT INTO mmRelationship_tbl (mentorID, menteeID, requester, requestDate, startDate) VALUES (:mentor, :mentee , '2', :date, :date)");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing Started.";
	$subject = "Pairing Started by admin.";
	$body = "A pairing has been started by an admin. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been started by an administator.";
} else if ($change == 7) {
/* 	$stmt = $con->prepare("DELETE * FROM mmRelationship_tbl WHERE ID = 106");
	$stmt -> execute(array()); */
	//INSERT INTO `pjoyjr_db`.`mmRelationship_tbl` (`ID`, `mentorID`, `menteeID`, `requester`, `requestDate`, `rejectDate`, `startDate`, `endDate`) VALUES (NULL, '1', '98', '2', '2018-12-06', NULL, NULL, NULL);
	$msg = "Pairing Re-requested.";
	$subject = "Pairing re-requested by coordinator.";
	$body = "A pairing re-requested by coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been started by an administator.";
}else {
	$msg = "Error, change not recognized.";
	
}
$mailer = new Mail();
if(($mailer->sendMail($mentorRow->email, "USER", $subject, $body))){
	$msg1 = "Message 1 sent";
	$msgReq = "";
}
if(($mailer->sendMail($menteeRow->email, "USER", $subject, $body))){
	$msg1 = "Emails have been sent to both parties";
	$msgReq="";
}
?>

<section id="loginPage">
	
	<div id="login">
		<div id="loginForm">
			<h3><?php 
			if($msgReq == "")
				echo $msg."</br>".$msg1; 
			else
				echo $msg;
			?>
			</h3>
			<div class="form-row">
				<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
					<button type="submit" class="btn btn-light btn-sm"><a href="dashboard.php">Return to Dashboard</a></button>
				</div>
			</div>
		</div>
	</div>

</section>