<?php 
require_once 'header.php';
require_once "db_connect.php"	;

$user = $_SESSION['user'];
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$userPriv = $user->getUserPrivilege();
if($userPriv < 2 || $userPriv > 3){
	header('Location: dashboard.php');
}	

$userID = ($_GET["userID"]);

$stmt = $con->prepare("UPDATE user_tbl SET active = 2 WHERE ID = :userID");
$stmt -> execute(array('userID' => $userID));
	header('Location: deactUser.php')
?>

<div class="container" id="hideUser">
	<section id="hideUser">
		<h2>Hide a user ID: <?php echo $userID ?></h2>
	</section>
	
</div>

<?php include 'footer.php'; ?>