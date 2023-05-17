	<!DOCTYPE html>
<html>
	<head>
		<title>ADVANCED SEARCH</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
	<script>
  function validateForm() {
    let x = document.forms["AdvForm"]["pat_idv"].value;
    let y = document.forms["AdvForm"]["pat_namev"].value;
	let z = document.forms["AdvForm"]["pat_emailv"].value;
	let a = document.forms["AdvForm"]["pat_phonev"].value;
	let b = document.forms["AdvForm"]["pat_cityv"].value;
	let c = document.forms["AdvForm"]["doc_idv"].value;
	let d = document.forms["AdvForm"]["doc_namev"].value;
	let e = document.forms["AdvForm"]["doc_emailv"].value;
	let f = document.forms["AdvForm"]["doc_phonev"].value;
	let g = document.forms["AdvForm"]["app_idv"].value;
	let h = document.forms["AdvForm"]["cl_idv"].value;
	let k = document.forms["AdvForm"]["app_payv"].value;
	let l = document.forms["AdvForm"]["app_datev"].value;
	let m = document.forms["AdvForm"]["app_descv"].value;
	let n = document.forms["AdvForm"]["pat_insv"].value;
	if (x == "" && y== "" && a == "" && b== "" && c== "" && d == "" && e== "" && f== "" && g=="" && h=="" && k=="" && l== "" && m=="" && n=="") {
      alert("Please fill out all required fields.");
      return false;
    }
    
  }
  </script>
<body>
<div class="topnav">
 		<a class = "active" href=advsearch.php>Advanced Search</a>
 		<a href=manageapp.php> Manage Appointments and Prescriptions</a>
  		<a href=managedoc.php>Manage Doctors</a>
 		<a href=managepat.php>Manage Patients</a>
		<a href=managepay.php>Manage Payments</a>
		<a href=managecl.php>Manage Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<h3>ADVANCED SEARCH</h3>
		<form name="AdvForm" onsubmit="return validateForm()" method ="post">
		<h4>Patient Information</h4>
		<label>Enter Patient ID:</label>
		<input type="text" name="pat_idv" placeholder="Patient ID"/></br>
		<label>Enter Patient Name:</label>
		<input type="text" name="pat_namev" placeholder="Patient Name"/></br>
		<label>Enter Patient Email:</label>
		<input type="email" name="pat_emailv" placeholder="Patient Email"/></br>
		<label>Enter Patient Phone:</label>
		<input type="text" name="pat_phonev" placeholder="Patient Phone"/></br>
		<label>Enter Patient City:</label>
		<input type="text" name="pat_cityv" placeholder="Patient City"/></br>
		<label>Enter Patient Insurance Number:</label>
		<input type="text" name="pat_insv" placeholder="Patient Insurance Number"/> <br>		
		<h4>Doctor Information</h4>
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_idv" placeholder="Doctor ID"/></br>
		<label>Enter Doctor Name:</label>
		<input type="text" name="doc_namev" placeholder="Doctor Name"/></br>
		<label>Enter Docotor Email:</label>
		<input type="email" name="doc_emailv" placeholder="Doctor Email"/><br>
		<label>Enter Doctor Phone:</label>
		<input type="text" name="doc_phonev" placeholder="Doctor Phone"/><br>
		<label>Enter Doctor City:</label>
		<input type="text" name="doc_cityv" placeholder="Doctor City"/><br>
		<h4>Appointment Information</h4>
		<label>Enter Appointment ID:</label>
		<input type="text" name="app_idv" placeholder="Appointment ID"/><br>
		<label>Enter Clinic ID:</label>
		<input type="text" name="cl_idv" placeholder="Clinic ID"/><br>
		<label>Enter Appointment Payment:</label>
		<input type="text" name="app_payv" placeholder="Appointment Payment"/><br>
		<label>Enter Appointment Date:</label>
		<input type="date" name="app_datev" placeholder="Appointment Date"/><br>
		<label>Enter Appointment Description:</label>
		<input type="text" name="app_desc" placeholder="Appointment Description"/><br>
		<button type="submit" name="searchv" value="Search" class="btn btn-primary"> Search </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['pat_idv'])    || isset($_POST['pat_namev']) 
		|| isset($_POST['pat_emailv']) || isset($_POST['pat_phonev']) 
		|| isset($_POST['pat_cityv'])  || isset($_POST['pat_insv']) || isset($_POST['doc_idv']) 
		|| isset($_POST['doc_namev'])  || isset($_POST['doc_emailv']) 
		|| isset($_POST['doc_phonev']) || isset($_POST['doc_cityv']) || isset($_POST['app_idv']) 
		|| isset($_POST['cl_idv'])     || isset($_POST['app_payv']) 
		|| isset($_POST['app_datev'])  || isset($_POST['app_desc'])){
		function validate($entry)
		{
		$entry=trim($entry);
		$entry=stripslashes($entry);
		$entry=htmlspecialchars($entry);
		return $entry;
		}		
		$pid=validate($_POST['pat_idv']);
		$pnm=validate($_POST['pat_namev']);
		$pem=validate($_POST['pat_emailv']);
		$pph=validate($_POST['pat_phonev']);
		$pct=validate($_POST['pat_cityv']);
		$pin=validate($_POST['pat_insv']);
		$did=validate($_POST['doc_idv']);
		$dnm=validate($_POST['doc_namev']);
		$dem=validate($_POST['doc_emailv']);
		$dph=validate($_POST['doc_phonev']);
		$dct=validate($_POST['doc_cityv']);
		$aid=validate($_POST['app_idv']);
		$cid=validate($_POST['cl_idv']);
		$apy=validate($_POST['app_payv']);
		$adt=validate($_POST['app_datev']);
	    $ads=validate($_POST['app_desc']);

		if(empty($pid) && empty($pnm) 
		&& empty($pem) && empty($pph) 
		&& empty($pct) && empty($did) 
		&& empty($dnm) && empty($dem)
		&& empty($dph) && empty($dct)
		&& empty($aid) && empty($cid) 
		&& empty($apy) && empty($adt) 
		&& empty($pin) && empty($ads)) 
		{
			echo "<script>
            alert('Please enter search information.');
            </script>";
			header("Refresh:0");
			exit();
		}
		
		$queryl = "(SELECT appointment.app_id,appointment.app_date,appointment.app_desc,
		appointment.app_payment,appointment.clinic_id,patient.pat_id,patient.pat_name,patient.pat_email,
		patient.pat_phone,patient.pat_city,patient.pat_insured,patient.pat_insurance_num,doctor.doc_id,
		doctor.doc_name,doctor.doc_email,doctor.doc_phone,doctor.doc_city FROM doctor
		LEFT JOIN appointment ON appointment.doc_id=doctor.doc_id
		LEFT JOIN patient ON appointment.pat_id=patient.pat_id WHERE 1" ;
		if(!empty($pid)){
		$queryl.=" AND patient.pat_id='$pid'";
		}
		if(!empty($pnm)){
		$queryl.=" AND patient.pat_name='$pnm'";
		}
		if(!empty($pem)){
		$queryl.=" AND patient.pat_email='$pem'";
		}
		if(!empty($pph)){
		$queryl.=" AND patient.pat_phone='$pph'";
	    }
		if(!empty($pct)){
		$queryl.=" AND patient.pat_city='$pct'";
		}
		if(!empty($pin)){
		$queryl.=" AND patient.pat_insurance_num='$pin'";
		}
		if(!empty($did)){
		$queryl.=" AND doctor.doc_id='$did'";
		}
		if(!empty($dnm)){
		$queryl.=" AND doctor.doc_name='$dnm'";
		}
		if(!empty($dem)){
		$queryl.=" AND doctor.doc_email='$dem'";
		}
		if(!empty($dph)){
		$queryl.=" AND doctor.doc_phone='$dph'";
		}
		if(!empty($dct)){
		$queryl.=" AND doctor.doc_city='$dct'";
		}
		if(!empty($aid)){
		$queryl.=" AND appointment.app_id='$aid'";
		}
		if(!empty($cid)){
		$queryl.=" AND appointment.clinic_id='$cid'";
		}
		if(!empty($apy)){
		$queryl.=" AND appointment.app_payment='$apy'";
	    }
		if(!empty($adt)){
		$queryl.=" AND appointment.app_date='$adt'";
		}
		if(!empty($ads)){
		$queryl.=" AND appointment.app_desc='$ads'";
		}
        
		$queryl.=")";
		
		$queryr = "(SELECT appointment.app_id,appointment.app_date,appointment.app_desc,
		appointment.app_payment,appointment.clinic_id,patient.pat_id,patient.pat_name,patient.pat_email,
		patient.pat_phone,patient.pat_city,patient.pat_insured,patient.pat_insurance_num,doctor.doc_id,
		doctor.doc_name,doctor.doc_email,doctor.doc_phone,doctor.doc_city FROM patient
		LEFT JOIN appointment ON appointment.pat_id=patient.pat_id
		LEFT JOIN doctor ON appointment.doc_id=doctor.doc_id WHERE 1" ;
		if(!empty($pid)){
		$queryr.=" AND patient.pat_id='$pid'";
		}
		if(!empty($pnm)){
		$queryr.=" AND patient.pat_name='$pnm'";
		}
		if(!empty($pem)){
		$queryr.=" AND patient.pat_email='$pem'";
		}
		if(!empty($pph)){
		$queryr.=" AND patient.pat_phone='$pph'";
	    }
		if(!empty($pct)){
		$queryr.=" AND patient.pat_city='$pct'";
		}
		if(!empty($pin)){
		$queryr.=" AND patient.pat_insurance_num='$pin'";
		}
		if(!empty($did)){
		$queryr.=" AND doctor.doc_id='$did'";
		}
		if(!empty($dnm)){
		$queryr.=" AND doctor.doc_name='$dnm'";
		}
		if(!empty($dem)){
		$queryr.=" AND doctor.doc_email='$dem'";
		}
		if(!empty($dph)){
		$queryr.=" AND doctor.doc_phone='$dph'";
		}
		if(!empty($dct)){
		$queryr.=" AND doctor.doc_city='$dct'";
		}
		if(!empty($aid)){
		$queryr.=" AND appointment.app_id='$aid'";
		}
		if(!empty($cid)){
		$queryr.=" AND appointment.clinic_id='$cid'";
		}
		if(!empty($apy)){
		$queryr.=" AND appointment.app_payment='$apy'";
	    }
		if(!empty($adt)){
		$queryr.=" AND appointment.app_date='$adt'";
		}
		if(!empty($ads)){
		$queryr.=" AND appointment.app_desc='$ads'";
		}
		
		$queryr.=")";
		
		$queryl.=" UNION ";
		$queryl.=$queryr;
		
		$result= mysqli_query($conn, $queryl);
		//echo mysqli_num_rows($result);
		if(mysqli_num_rows($result)== 0){  

			echo "<script>
            alert('Information not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>AppointmentID</th><th>AppointmentDate</th><th>Payment</th><th>ClinicID</th><th>InsuranceNumber</th><th>PatientID</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>PatientCity</th><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><th>DoctorCity</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['app_id']}</td><td>{$row['app_date']}</td><td>{$row['app_payment']}</td><td>{$row['clinic_id']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><td>{$row['pat_city']}</td><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><td>{$row['doc_city']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>	
		</div>
</body>
</html>	
		