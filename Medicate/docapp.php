<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE APPOINTMENTS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
 		<a class = "active" href=docapp.php> Manage Appointments</a>
  		<a href=docpre.php>Manage Prescriptions</a>
 		<a  href=docpat.php>Manage Patients</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<h3>VIEW YOUR APPOINTMENTS</h3>
		<form method ="post">
		<button type="submit" name="viewApp" value="View Appointments" class="btn btn-primary"> View Appointments </button>
		</form>
		<?php
		include "db_conn.php";
        session_start();
		if(isset($_POST['viewApp'])){
        $did=$_SESSION['dsid'];
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$did'";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>AppointmentID</th><th>AppointmentInfo</th><th>AppointmentDate</th><th>Payment</th><th>ClinicID</th><th>City</th><th>PatientID</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['app_id']}</td><td>{$row['app_desc']}</td><td>{$row['app_date']}</td><td>{$row['app_payment']}</td><td>{$row['clinic_id']}</td><td>{$row['pat_city']}</td><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>
		
		<h3>SEARCH YOUR APPOINTMENTS BY DATE</h3>
		<form method ="post">
		<label>Enter Starting Date:</label>
		<input type="date" name="st_dated" placeholder="Start Date"/> <br>
		<label>Enter Ending Date:</label>
		<input type="date" name="ed_dated" placeholder="End Date"/><br>
		<button type="submit" name="searchAppd" value="Search Appointments" class="btn btn-primary"> Search Appointments </button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['st_dated']) || isset($_POST['ed_dated'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
        $did=$_SESSION['dsid'];	
		$st=validate($_POST['st_dated']);
		$ed=validate($_POST['ed_dated']);
	
		if(empty($st) && empty($ed)) {
			echo "<script>
            alert('Start or end date required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if ($st == $ed){
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$did' AND appointment.app_date = '$st'";
		}
		else{
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id
		WHERE appointment.doc_id = '$did'";
		
		if(!empty($st)) {
		$query.=" AND appointment.app_date>'$st'";
		}

		if(!empty($ed)) {
		$query.=" AND appointment.appointment_date<'$ed'";
		}
	    }	
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  
									echo "<script>
            alert('Appointments not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>AppointmentID</th><th>AppointmentInfo</th><th>AppointmentDate</th><th>Payment</th><th>ClinicID</th><th>City</th><th>PatientID</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['app_id']}</td><td>{$row['app_desc']}</td><td>{$row['app_date']}</td><td>{$row['app_payment']}</td><td>{$row['clinic_id']}</td><td>{$row['pat_city']}</td><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>

		<h3>SEARCH YOUR APPOINTMENTS BY PATIENT/DATE</h3>
		<form method ="post">
		<label>Enter Patient ID:</label>
		<input type="text" name="pat_idc" placeholder="Patient ID"/> <br>
		<label>Enter Starting Date:</label>
		<input type="date" name="st_datec" placeholder="Start Date"/> <br>
		<label>Enter Ending Date:</label>
		<input type="date" name="ed_datec" placeholder="End Date"/><br>
		<button type="submit" name="searchAppc" value="Search Appointments" class="btn btn-primary"> Search Appointments </button>
		</form>
		<?php
		include "db_conn.php";
		if((isset($_POST['st_datec']) || isset($_POST['ed_datec'])) && isset($_POST['pat_idc'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
        $did=$_SESSION['dsid'];	
		$st=validate($_POST['st_datec']);
		$ed=validate($_POST['ed_datec']);
		$id=validate($_POST['pat_idc']);
	
		if(empty($st) && empty($ed) && empty($id)) {
									echo "<script>
            alert('Search information required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($id)) {
									echo "<script>
            alert('Patient ID required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(!empty($st) && !empty($ed) && $st == $ed ) {
			$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
			patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
			appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
			INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$did' AND appointment.pat_id = '$id' AND appointment.app_date = '$st'";
		}
		else{
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$did' AND appointment.pat_id = '$id'";
				
		if(!empty($st)) {
		$query.=" AND appointment.app_date>'$st'";
		}

		if(!empty($ed)) {
		$query.=" AND appointment.app_date<'$ed'";
		}
	    }	
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  
						echo "<script>
            alert('Appointments not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>AppointmentID</th><th>AppointmentInfo</th><th>AppointmentDate</th><th>Payment</th><th>ClinicID</th><th>City</th><th>PatientID</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['app_id']}</td><td>{$row['app_desc']}</td><td>{$row['app_date']}</td><td>{$row['app_payment']}</td><td>{$row['clinic_id']}</td><td>{$row['pat_city']}</td><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>

        <br><h3>CANCEL APPOINTMENTS</h3>
		<form method ="post">
		<label>Enter Appointment ID:</label>
		<input type="text" name="app_idd" placeholder="Appointment ID"/><br>
		<button type="submit" name="deleteApp" value="Delete Appointment" class="btn btn-primary"> Cancel Appointment </button>
		</form>
	</div>
	<?php
		include "db_conn.php";
		if(isset($_POST['app_idd'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
				
		$id=validate($_POST['app_idd']);
		$did=$_SESSION['dsid'];

	
		if(empty($id)) {
			echo "<script>
            alert('Appointment ID required.');
            </script>";
			header("Refresh:0");
			exit();
		}
		
		$sqle="SELECT * FROM appointment WHERE doc_id = '$did' AND app_id='$id'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)== 0){  
			echo "<script>
            alert('Appointment not found.');
            </script>";
			header("Refresh:0");
			exit();
	    }
		$rowe = mysqli_fetch_assoc($resulte);
		$adate = $rowe['app_date']; 
		//$currentDate = date('Y-m-d');
	    if($adate < date('Y-m-d')){
			echo '<script>
            alert("Can`t cancel past appointments.");
            </script>';
			header("Refresh:0");
			exit();
		}
		$sql="DELETE FROM appointment WHERE app_id='$id'";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM appointment WHERE app_id='$id'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 0){
			echo "<script>
            alert('Deletion Successful.');
            </script>";
			header("Refresh:0");
			exit();
	    }
		}
		?>
		
</body>
</html>	