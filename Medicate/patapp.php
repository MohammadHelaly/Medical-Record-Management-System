<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE APPOINTMENTS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
		<a href=patprof.php> My Profile</a>	
 		<a class = "active" href=patapp.php> Manage Appointments and Prescriptions</a>
		<a href=patdoc.php>Search Doctors and Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<br><h3>VIEW ALL PRESCRIPTIONS</h3>
		<form method ="post">
		<button type="submit" name="viewPre" value="View Prescriptions" class="btn btn-primary"> View Prescriptions</button>
		</form>
		<?php
		include "db_conn.php";
		session_start();
		if(isset($_POST['viewPre'])){

		$sid=$_SESSION['ssid'];
		$query = "SELECT prescriptions.prescription,prescriptions.pres_date,prescriptions.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone 
		FROM prescriptions INNER JOIN doctor ON prescriptions.doc_id=doctor.doc_id WHERE prescriptions.pat_id='$sid'";
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  

			echo "<script>
alert('Information not found.');
</script>";
			header("Refresh:0");
			exit();
}
		echo "<table border='1'>";
		echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>

		<br><h3>VIEW ALL APPOINTMENTS</h3>
		<form method ="post">
		<button type="submit" name="viewApp" value="View Appointments" class="btn btn-primary"> View Appointments</button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['viewApp'])){

		$sid=$_SESSION['ssid'];
		$query = "SELECT appointment.app_id,appointment.app_date,appointment.app_desc,
		appointment.app_payment,clinic.clinic_address,patient.pat_insured,patient.pat_insurance_num,appointment.clinic_id,patient.pat_city,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone 
		FROM appointment 
		INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id
		INNER JOIN clinic ON appointment.clinic_id = clinic.clinic_id WHERE appointment.pat_id='$sid'";
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  

			echo "<script>
alert('Information not found.');
</script>";
			header("Refresh:0");
			exit();
}
		echo "<table border='1'>";
		echo "<tr><th>AppointmentID</th><th>AppointmentDate</th><th>AppointmentInfo</th><th>Payment</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>ClinicID</th><th>ClinicAddress</th><th>City</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['app_id']}</td><td>{$row['app_date']}</td><td>{$row['app_desc']}</td><td>{$row['app_payment']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['clinic_id']}</td><td>{$row['clinic_address']}</td><td>{$row['pat_city']}|</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>


		
		<br><h3>REQUEST AN APPOINTMENT</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_id" placeholder="Doctor ID"/><br>
		<label>Enter Appointment Date:</label>
		<input type="date" name="app_date" placeholder="Appointment Date"/><br>
		<label>Enter Appointment Purpose:</label>
		<input type="text" name="app_info" placeholder="Appointment Purpose"/><br>
		<button type="submit" name="makeApp" value="Make Reservation" class="btn btn-primary"> Request Appointment</button>
		</form>
	<?php
		include "db_conn.php";
		if((isset($_POST['app_info']) && isset($_POST['app_date'])) && isset($_POST['doc_id'])){ 
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$date=validate($_POST['app_date']);
		$info=validate($_POST['app_info']);
		$id=validate($_POST['doc_id']);
		$sid=$_SESSION['ssid'];
		if(empty($date) && empty($info) && empty($id)) {
			echo "<script>
            alert('Appointment Information Required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($id)) {
			echo "<script>
            alert('Doctor id required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($info)) {
			echo "<script>
            alert('Appointment Purpose required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($date)) {
			echo "<script>
            alert('Appointment date required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		$qr = "SELECT * FROM patient WHERE patient.pat_id = '$sid' ";
		$res= mysqli_query($conn, $qr);
		$r = mysqli_fetch_assoc($res);
		$qre = "SELECT * FROM doctor WHERE doctor.doc_id = '$id' ";
		$resu= mysqli_query($conn, $qre);
		$re = mysqli_fetch_assoc($resu);
		if($r['pat_city'] != $re['doc_city']){  
			echo "<script>
            alert('Doctor not in your city.Please choose another doctor.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		
		$querye = "SELECT appointment.doc_id FROM appointment WHERE appointment.doc_id='$id' AND appointment.app_date = '$date'";
		$resulte= mysqli_query($conn, $querye);
		//echo mysqli_num_rows($resulte);
		if(mysqli_num_rows($resulte)!= 0){  
			echo "<script>
            alert('Doctor busy  on this day. Please choose another date or doctor.');
            </script>";
						header("Refresh:0");
						exit();
	    }

		$queryee = "SELECT * FROM appointment WHERE appointment.pat_id='$sid' AND appointment.app_date = '$date'";
		$resultee= mysqli_query($conn, $queryee);
		//echo mysqli_num_rows($resulte);
		if(mysqli_num_rows($resultee)!= 0){  
			echo "<script>
            alert('You already have an appointment on this date.');
            </script>";
						header("Refresh:0");
						exit();
	    }



		$currentDate = date('Y-m-d');
		$queryee = "SELECT * FROM appointment WHERE appointment.pat_id='$sid' AND appointment.doc_id = '$id' AND appointment.app_date > '$currentDate'";
		$resultee= mysqli_query($conn, $queryee);
		//echo mysqli_num_rows($resulte);
		if(mysqli_num_rows($resultee)!= 0){  
			echo "<script>
            alert('You already have an upcoming appointment with this doctor.');
            </script>";
						header("Refresh:0");
						exit();
	    }

		if($date < date('Y-m-d')){
			echo "<script>
            alert('Invalid Date.');
            </script>";
			header("Refresh:0");
			exit();
		}

		$querys = "SELECT * FROM doctor_status WHERE doc_id='$id' AND doc_status_date = '$date'";
		$results= mysqli_query($conn, $querys);
		if(mysqli_num_rows($results)!= 0){
			$rs = mysqli_fetch_assoc($results);
			if($rs['doc_status'] == "unavailable"){
			echo "<script>
            alert('Doctor unavalaible  on this day. Please choose another date or doctor.');
            </script>";
						header("Refresh:0");
						exit();
			}
	    }

		$qp="SELECT pat_insured FROM patient WHERE pat_id='$sid'";
		$resultp=mysqli_query($conn,$qp);
		if(mysqli_num_rows($resultp)== 1){
			$rowp = mysqli_fetch_assoc($resultp);
			$ins = $rowp['pat_insured'];  
	    }
		if($ins == "YES"){
			$payment = 150;
		}
		else if ($ins == "NO"){
			$payment = 1000;
		}
		$qo="SELECT clinic_id FROM clinic WHERE clinic_city IN (SELECT pat_city FROM patient WHERE pat_id='$sid')";
		$resulto=mysqli_query($conn,$qo);
		if(mysqli_num_rows($resulto)== 0){

			echo "<script>
            alert('No clinic in your city.');
            </script>";
						header("Refresh:0");
						exit();		
	    }
		else if(mysqli_num_rows($resulto)== 1){
			$rowo = mysqli_fetch_assoc($resulto);
			$cl = $rowo['clinic_id'];  
	    }
		$sql="INSERT INTO appointment(pat_id,doc_id,app_date,app_desc,clinic_id,app_payment)
		 VALUES ('$sid','$id','$date','$info','$cl','$payment')";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM appointment WHERE appointment.doc_id='$id' AND appointment.pat_id ='$sid' AND app_date='$date' 
		AND appointment.clinic_id='$cl' AND app_payment='$payment' AND app_desc='$info'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 1){

			$rowx =  mysqli_fetch_assoc($result2);

			echo '<script type="text/javascript">alert("Appointment Successful, your payment is '.$rowx['app_payment'].' $");</script>';
						header("Refresh:0");
						exit();
	    }
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
		$sid=$_SESSION['ssid'];

	
		if(empty($id)) {
			echo "<script>
            alert('Appointment ID required.');
            </script>";
			header("Refresh:0");
			exit();
		}
		
		$sqle="SELECT * FROM appointment WHERE pat_id = '$sid' AND app_id='$id'";
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