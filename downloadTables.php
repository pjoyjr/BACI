<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}?>

<section id="downloadTables" class="container">
	<div class="container mt-2">
		<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
	</div>

    
    <h3 class="mt-4">Save Database Information</h3>

    <div class="row mt-4">
        <div class="col-4">
			<p class="lead">User Table</p>
            <p class="lead"><a href="saveTables.php?tag=1" class="btn btn-primary btn-sm">Download User Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Address Table</p>
            <p class="lead"><a href="saveTables.php?tag=2" class="btn btn-primary btn-sm">Download Address Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Country Table</p>
            <p class="lead"><a href="saveTables.php?tag=3" class="btn btn-primary btn-sm">Download Country Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">State Table</p>
            <p class="lead"><a href="saveTables.php?tag=4" class="btn btn-primary btn-sm">Download State Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Degree Table</p>
            <p class="lead"><a href="saveTables.php?tag=5" class="btn btn-primary btn-sm">Download Degree Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Education Table</p>
            <p class="lead"><a href="saveTables.php?tag=6" class="btn btn-primary btn-sm">Download Education Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Identity Table</p>
            <p class="lead"><a href="saveTables.php?tag=7" class="btn btn-primary btn-sm">Download Identity Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Relationship Table</p>
            <p class="lead"><a href="saveTables.php?tag=8" class="btn btn-primary btn-sm">Download Relationship Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Picture Table</p>
            <p class="lead"><a href="saveTables.php?tag=9" class="btn btn-primary btn-sm">Download Picture Table</a></p>
        </div>
        <div class="col-4">
			<p class="lead">Resume Table</p>
            <p class="lead"><a href="saveTables.php?tag=10" class="btn btn-primary btn-sm">Download Resume Table</a></p>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>