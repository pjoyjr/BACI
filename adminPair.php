<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
/*if (isset($_POST['pair'])){
		
	$mentor = trim($_POST['mentor']);
	$mentee = trim($_POST['mentee']);
	
	
	if ($name !== ""){		
		header('Location: pairing.php?mentor='.$mentor.'&mentee='.$mentee.'&change=1');
	}
}*/
?>

<!--use 1st table to save userID, and refresh to show 2nd table w/ userID tag in header. 2nd table saves 2nd userID
and refeshes w/ both tags in header. Make if statement for userID tags, if mentor&mentee=null show mentor table | 
if mentor!=null &mentee=null show mentee table| if mentor&mentee!=null pair and show they have been paired successfully |
else show error w/ button to dashboard?
-->

<html>
	<head>
		<script>
			var menteeID, mentorID;
			var mentees = [];
			var mentors = [];
			function showMentors(str)
			{
				var xmlhttp;
				if (str.length==0) { 
					document.getElementById("mentor").innerHTML="";
					return;}
				  
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();}
				  
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				  
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("mentor").innerHTML=xmlhttp.responseText;
					createMentorMap();
						if(mentors[str])
						{
							mentorID = mentors[str];
						}
					}
				 }
				xmlhttp.open("GET","mentorProcess.php?q="+str,true);
				xmlhttp.send();
			}
			function showMentees(str)
			{
				var xmlhttp;
				if (str.length==0) { 
					document.getElementById("mentee").innerHTML="";
					return;}
				  
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();}
				  
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				  
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("mentee").innerHTML=xmlhttp.responseText;
					createMenteeMap();
						if(mentees[str])
						{
							menteeID = mentees[str];
						}
					}
				 }
				xmlhttp.open("GET","menteeProcess.php?q="+str,true);
				xmlhttp.send();
			}
			function createMenteeMap()
			{
				$('#mentee option').each( function(index, value){
					var id = $(this).data('id');
					var name = this.innerHTML;
					if(name.length > 0)
					{
						if(!mentees[name])
						{
							mentees[name] = id;
						}
					}
				});
			}
			function createMentorMap()
			{
				$('#mentor option').each( function(index, value){
					var id = $(this).data('id');
					var name = this.innerHTML;
					if(name.length > 0)
					{
						if(!mentors[name])
						{
							mentors[name] = id;
						}
					}
				});
			}
			function submitPair()
			{
				if(!mentorID || !menteeID) 
					alert('please double check your selections');
					var paths = location.pathname.split('/')
					var url = '';
					for (i = 0; i < paths.length - 1; i++)
					{
						url += paths[i] + '/';
					}
					url += 'pairing.php?mentor=' + mentorID + '&mentee=' + menteeID + '&change=2';
				location.href = url;
			}
		</script>
	</head>
	<section id="adminPair" class="container">
	<div class="row mt-4">
		<div class="col-md-4 col-sm-4">
			<a href="dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
		</div>
		<h3>Create new Pair</h3>
	</div>
		<div class="row mt-4">
			<div class="col-md-4 col-sm-4">
				<div class="mentor">
					<form action="adminPair.php" method="post"> 
						Enter Mentor's Last Name: 
						<input type="text" list="mentor" name="mentor" value="" onkeyup="showMentors(this.value)" />
						<datalist id="mentor" >
						
						</datalist>
					</form>
				</div>
			</div>
			<div class="col-md-4 col-sm-4">
				<div class="mentee">
					<form action="adminPair.php" method="post"> 
						Enter Mentee's Last Name: 
						<input type="text" list="mentee" name="mentee" value="" onkeyup="showMentees(this.value)" />
						<datalist id="mentee" >
						
						</datalist>
					</form>
				</div>
			</div>
			<input name="pair" class="btn" type="submit" value="Pair" onclick="submitPair()"/>
		</div>
	</section>
</html>

<?php include 'footer.php'; ?>