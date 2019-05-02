<?php 
require_once 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$mmPair = $_SESSION['mmPair'];
$requestDate = date("Y/m/d");

$requestedID = "";
$email = "";
$body = "";
$mailed = "";
$msg = "";

$mmRelationship = $con->prepare("INSERT INTO mmRelationship_tbl (`ID`, `mentorID`, `menteeID`, `requester`, `requestDate`) VALUES (NULL, :mentorID, :menteeID, :requester, :requestDate)");
$mmRelationship->execute(array('mentorID'=>$mmPair->getMentorID(), 'menteeID'=>$mmPair->getMenteeID(), 'requester'=>$mmPair->getRequester(), 'requestDate'=>$requestDate));

if($mmPair->getRequester()==1)
	{
	$requestedID = $mmPair->getMenteeID();
	$mailed = "mentee";
	}
else
	{
	$requestedID = $mmPair->getMentorID();
	$mailed = "mentor";
	}

$stmtEmail = $con->prepare("SELECT * FROM user_tbl WHERE ID = :requestedID");
$stmtEmail -> execute(array('requestedID' => $requestedID));
$row = $stmtEmail->fetch(PDO::FETCH_OBJ);

$body = "You have been requested to be a ".$mailed.". Please log in to review the request. http://corsair.cs.iupui.edu:23151/BaciProjectAlt/login.php";
$mailer = new Mail();
if(($mailer->sendMail($row->email, "User", "You have been requested in a pairing", $body))){
	$msg = "An email has been sent to their email.";
}


?>

<div class="container" id="mmRelationship">
	<h2>Mentor/Mentee Pairing Requested!</h2>
	<h2><?php echo $msg;?>
	MentorID: <?php echo $mmPair->getMentorID();?>
	</br></br>
	MenteeID: <?php echo $mmPair->getMenteeID();?>
	</br></br>
	Requester: 
	<?php 
	if($mmPair->getRequester()==0)
		echo "Mentee";
	if($mmPair->getRequester()==1)
		echo "Mentor";
	?>
	</br></br>
	Today's Date: <?php echo $requestDate?>
	
</div>

<?php include 'footer.php'; ?>