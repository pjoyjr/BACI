$(document).ready(function() {

	/*
	#############################
	###### DATA TABLE CODE ######
	#############################
	*/

	var xmlhttp;
	if (document.getElementById("table")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#table').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getUsers.php",true);
		xmlhttp.send();
	}
	if (document.getElementById("tableMentor")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableMentor').html(xmlhttp.responseText);
				$('#mentorList').DataTable();
			}
		}
		xmlhttp.open("GET","getMentors.php",true);
		xmlhttp.send();
	} 
	if(document.getElementById("tableMentee")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableMentee').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getMentees.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("tablePending")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tablePending').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getPending.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("tableEnded")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableEnded').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getEnded.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("tableCurrent")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableCurrent').html(xmlhttp.responseText);
				$('#currentList').DataTable();
			}
		}
		xmlhttp.open("GET","getCurrent.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("userPairing")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#userPairing').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getUserPairing.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("delUser")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#delUser').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","delUserList.php",true);
		xmlhttp.send();
	}
	if(document.getElementById("renewAdmin")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#renewAdmin').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","reactAdminList.php",true);
		xmlhttp.send();
	}
	/*
	##################################
	###### ADD/REMOVE EDUCATION ######
	##################################
	*/

	var num = 1;
	$("#removeEducation").hide();

	function addEducation() {
		$("#removeEducation").show();
		var field = document.getElementById('dynamicEducation');
		var div = document.createElement("div");
		div.setAttribute("id", "removeDiv" + num);
		div.innerHTML = `
		<div class="form-row">
			<div class="form-group col-md-3 col-sm-6">
				<label for="degree${num}">Degree</label>
				<div class="degree"></div>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="major">Major</label>
				<input type="text" class="form-control" class="major" name="major${num}" required>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="school">School</label>
				<input type="text" class="form-control" class="school" name="school${num}" required>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="yearCompleted${num}">Year Completed</label>
				<select id="yearCompleted${num}" class="form-control yearDropdown" name="yearCompleted${num}" required>			
				</select>
			</div>
		</div>
		`;
		field.appendChild(div);
		if(document.getElementsByClassName("degree")) {
			if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					$('.degree').html(xmlhttp.responseText);
				}
			}
			xmlhttp.open("GET","getDegree.php?num=" + num,true);
			xmlhttp.send();
		}

		$('.yearDropdown').each(function() {
			var time = new Date();
			var year = time.getYear();
			if (year < 1900) {
				year = year + 1900;
			}
			var date = year - 40;
			var future = year + 10;
			do {
				future--;
				if (future == (new Date()).getFullYear())
					$(this).append("<option value=\"" + future +"\" selected>" + future + "</option>");
				else
					$(this).append("<option value=\"" + future +"\">" + future + "</option>");
			}
			while (future > date);

		});
		num++;
	}

	function removeEducation() {
		$('#removeDiv'+ (num - 1)).remove();
		num--;
		if (num <= 1)
			$("#removeEducation").hide();
	}

	$('#addEducation').click(addEducation);
	$('#removeEducation').click(removeEducation);

	/*
	##################################
	###### BIRTH YEAR SELECTION ######
	##################################
	*/

	$('#birthYear').each(function() {
		var year = (new Date()).getFullYear();
		var current = year;
		for (var i = 0; i < 90; i++) {
			if ((year+i) == current)
				$(this).append('<option selected value="' + (year - i) + '">' + (year - i) + '</option>');
			else
				$(this).append('<option value="' + (year - i) + '">' + (year - i) + '</option>');
		}

	});

	$('.yearDropdown').each(function() {
		var time = new Date();
		var year = time.getYear();
		if (year < 1900) {
			year = year + 1900;
		}
		var date = year - 40;
		var future = year + 10;
		do {
			future--;
			if (future == (new Date()).getFullYear())
				$(this).append("<option value=\"" + future +"\" selected>" + future + "</option>");
			else
				$(this).append("<option value=\"" + future +"\">" + future + "</option>");
		}
		while (future > date);

	});

	/*
	################################
	###### IDENTITY SELECTION ######
	################################
	*/

	$(".workingProfessional").hide();
	$('#employment').change(function() {
    	var value = $(this).val();
    	if (value == "student") {
    		$(".workingProfessional").hide();
    	} else {
    		$(".workingProfessional").show();
    	}
	});

	/*
	##############################################
	###### COUNTRY/STATE DROPDOWN SELECTION ######
	##############################################
	*/
	$("#country").change(function(){
		var countryID = $("#country").val();
		$.ajax({
			url: 'data.php',
			method: 'post',
			data: 'country=' + countryID
		}).done(function(states){
			console.log(states);
			states = JSON.parse(states);
			$('#state').empty();
			states.forEach(function(state){
				$('#state').append('<option value="' + state.ID + '">' + state.name + '</option>')
			})
		})
	});

});

$(function() {

	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
		$(':file').on('fileselect', function(event, numFiles, label) {

			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
	});
});