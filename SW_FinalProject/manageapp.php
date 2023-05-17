<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE APPOINTMENTS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
 		<a href=advsearch.php>Advanced Search</a>
 		<a class = "active" href=manageapp.php> Manage Appointments and Prescriptions</a>
  		<a href=managedoc.php>Manage Doctors</a>
 		<a href=managepat.php>Manage Patients</a>
		<a href=managepay.php>Manage Payments</a>
		<a href=managecl.php>Manage Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<h3>VIEW ALL APPOINTMENTS</h3>
		<form method ="post">
		<button type="submit" name="viewApp" value="View Appointments" class="btn btn-primary"> View Appointments </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['viewApp'])){
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id";
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
		
		<h3>SEARCH APPOINTMENTS BY DATE</h3>
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
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.app_date = '$st'";
		}
		else{
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id
		WHERE 1";
		
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
		
		
		<br><h3>SEARCH APPOINTMENTS BY DOCTOR/DATE</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_idr" placeholder="Doctor ID"/> <br>
		<label>Enter Starting Date:</label>
		<input type="date" name="st_dater" placeholder="Start Date"/> <br>
		<label>Enter Ending Date:</label>
		<input type="date" name="ed_dater" placeholder="End Date"/><br>
		<button type="submit" name="searchAppr" value="Search Appointments" class="btn btn-primary"> Search Appointments </button>
		</form>
		<?php
		include "db_conn.php";
		if((isset($_POST['st_dater']) || isset($_POST['ed_dater'])) && isset($_POST['doc_idr'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$st=validate($_POST['st_dater']);
		$ed=validate($_POST['ed_dater']);
		$id=validate($_POST['doc_idr']);
	
		if(empty($st) && empty($ed) && empty($id)) {
									echo "<script>
            alert('Search information required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($id)) {
									echo "<script>
            alert('Doctor ID required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(!empty($st) && !empty($ed) && $st == $ed ) {
			$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
			patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
			appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
			INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$id' AND appointment.app_date = '$st'";
		}
		else{
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.doc_id = '$id'";
				
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

		<h3>SEARCH APPOINTMENTS BY PATIENT/DATE</h3>
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
			INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.pat_id = '$id' AND appointment.app_date = '$st'";
		}
		else{
		$query = "SELECT appointment.app_id,appointment.app_desc,appointment.app_date,appointment.app_payment,appointment.clinic_id,patient.pat_city,appointment.pat_id,
		patient.pat_name,patient.pat_email,patient.pat_phone,appointment.doc_id,doctor.doc_name,doctor.doc_email,doctor.doc_phone FROM 
		appointment INNER JOIN patient ON appointment.pat_id=patient.pat_id
		INNER JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE appointment.pat_id = '$id'";
				
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
		
		<br><h3>DELETE APPOINTMENTS</h3>
		<form method ="post">
		<label>Enter Appointment ID:</label>
		<input type="text" name="app_idd" placeholder="Appointment ID"/><br>
		<button type="submit" name="deleteApp" value="Delete Appointment" class="btn btn-primary"> Delete Appointment </button>
		</form>

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
	
		if(empty($id)) {
			echo "<script>
            alert('Appointment ID required.');
            </script>";
			header("Refresh:0");
			exit();
		}
		
		$sqle="SELECT * FROM appointment WHERE app_id='$id'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)== 0){  
			echo "<script>
            alert('Appointment not found.');
            </script>";
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
		
		<br><h3>VIEW ALL PRESCRIPTIONS</h3>
		<form method ="post">
		<button type="submit" name="viewPre" value="View Prescriptions" class="btn btn-primary"> View Prescriptions</button>
		</form>
		<?php
		include "db_conn.php";
		session_start();
		if(isset($_POST['viewPre'])){
		$query = "SELECT *
		FROM prescriptions INNER JOIN patient ON prescriptions.pat_id=patient.pat_id INNER JOIN doctor ON prescriptions.doc_id=doctor.doc_id";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>PateintID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>

<br><h3>SEARCH PRESCRIPTIONS BY PATIENT</h3>
		<form method ="post">
        <label>Enter Patient ID:</label>
		<input type="text" name="pat_idps" placeholder="Patient ID"/> <br>
		<button type="submit" name="serPrep" value="Ser Presp" class="btn btn-primary"> Search Prescriptions</button>
		</form>

		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['pat_idps'])){
			function validate($entry){
                $entry=trim($entry);
                $entry=stripslashes($entry);
                $entry=htmlspecialchars($entry);
                return $entry;
                }		
            $id=validate($_POST['pat_idps']);

            if(empty($id)) {
                echo "<script>
                alert('Patient id required.');
                </script>";
                            header("Refresh:0");
                            exit();
            }
            $query = "SELECT *
            FROM prescriptions INNER JOIN patient ON prescriptions.pat_id=patient.pat_id INNER JOIN doctor ON prescriptions.doc_id=doctor.doc_id WHERE prescriptions.pat_id = '$id'";
            $result= mysqli_query($conn, $query);
			if(mysqli_num_rows($result)== 0){  

				echo "<script>
	alert('Information not found.');
	</script>";
				header("Refresh:0");
				exit();
}
echo "<table border='1'>";
echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>PateintID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
while($row = mysqli_fetch_assoc($result))
{
   
   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
   
	
}
echo"</table>";
		}
		?>

		<br><h3>SEARCH PRESCRIPTIONS BY DOCTOR</h3>
		<form method ="post">
        <label>Enter Doctor ID:</label>
		<input type="text" name="doc_idps" placeholder="Doctor ID"/> <br>
		<button type="submit" name="serPred" value="Ser Presd" class="btn btn-primary"> Search Prescriptions</button>
		</form>

		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['doc_idps'])){
			function validate($entry){
                $entry=trim($entry);
                $entry=stripslashes($entry);
                $entry=htmlspecialchars($entry);
                return $entry;
                }		
            $id=validate($_POST['doc_idps']);

            if(empty($id)) {
                echo "<script>
                alert('Doctor id required.');
                </script>";
                            header("Refresh:0");
                            exit();
            }
            $query = "SELECT *
            FROM prescriptions INNER JOIN patient ON prescriptions.pat_id=patient.pat_id INNER JOIN doctor ON prescriptions.doc_id=doctor.doc_id WHERE prescriptions.doc_id = '$id'";
            $result= mysqli_query($conn, $query);
			if(mysqli_num_rows($result)== 0){  

				echo "<script>
	alert('Information not found.');
	</script>";
				header("Refresh:0");
				exit();
}
echo "<table border='1'>";
echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>PateintID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><tr>";
while($row = mysqli_fetch_assoc($result))
{
   
   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><tr>";
   
	
}
echo"</table>";
		}
		?>

<br><h3>DELETE A PRESCRIPTION</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_iddd" placeholder="Doctor ID"/> <br>			
		<label>Enter Patient ID:</label>
		<input type="text" name="pat_iddd" placeholder="Patient ID"/> <br>
		<label>Enter Prescription:</label>
		<input type="text" name="pre_infod" placeholder="Prescription"/><br>
		<label>Enter Prescription Date:</label>
		<input type="date" name="pre_dated" placeholder="Prescription Date"/><br>
		<button type="submit" name="delPre" value="Del Pre" class="btn btn-primary">Delete Prescription</button>
		</form>
	</div>
	<?php
		include "db_conn.php";
		if(isset($_POST['pre_infod'])  && isset($_POST['pat_iddd']) && isset($_POST['pre_dated'])&& isset($_POST['doc_iddd'])){ 
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		

		$info=validate($_POST['pre_infod']);
		$date=validate($_POST['pre_dated']);
		$id=validate($_POST['pat_iddd']);
		$did=validate($_POST['doc_iddd']);
		if(empty($info) && empty($id) && empty($date)&& empty($did)) {
			echo "<script>
            alert('Prescription Information Required.');
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

		if(empty($did)) {
			echo "<script>
            alert('Doctor ID required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($info)) {
			echo "<script>
            alert('Prescription required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($date)) {
			echo "<script>
            alert('Prescription date required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		$sqle="SELECT * FROM prescriptions WHERE pat_id = '$id' AND doc_id='$did' AND pres_date = '$date' AND prescription = '$info'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)== 0){  
			echo "<script>
            alert('Prescription not found.');
            </script>";
			header("Refresh:0");
			exit();
	    }

		$sql="DELETE FROM prescriptions WHERE pat_id = '$id' AND doc_id='$did' AND pres_date = '$date' AND prescription = '$info'";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM prescriptions WHERE pat_id = '$id' AND doc_id='$did' AND pres_date = '$date' AND prescription = '$info'";
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