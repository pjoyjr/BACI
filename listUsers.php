<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}?>

<section id="listUsers">
	<div class="container mt-2">
		<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
	</div>
	<div class="tableDiv mt-3">
		<div id="table" class="table-responsive"></div>
	</div>
</section>

<?php include 'footer.php'; ?>