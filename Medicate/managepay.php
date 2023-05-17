<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE PAYMENTS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
 		<a href=advsearch.php>Advanced Search</a>
 		<a href=manageapp.php> Manage Appointments and Prescriptions</a>
  		<a href=managedoc.php>Manage Doctors</a>
 		<a href=managepat.php>Manage Patients</a>
		<a class = "active" href=managepay.php>Manage Payments</a>
		<a href=managecl.php>Manage Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<h3>VIEW ALL PAYMENTS</h3>
		<form method ="post">
		<button type="submit" name="viewPayment" value="View Payments" class="btn btn-primary"> View Payments </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['viewPayment'])){
		$query = "SELECT appointment.pat_id,patient.pat_insured,patient.pat_insurance_num,appointment.app_id,appointment.app_payment,appointment.app_date 
		FROM appointment INNER JOIN patient ON appointment.pat_id = patient.pat_id";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>AppointmentID</th><th>Payment</th><th>AppointmentDate</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['app_id']}</td><td>{$row['app_payment']}</td><td>{$row['app_date']}</td><tr>";
		}
		echo"</table>";
		}
		?>
		<h3>SEARCH PAYMENTS BY DATE</h3>
		<form method ="post">
		<label>Enter Starting Date:</label>
		<input type="date" name="st_date" placeholder="Start Date"/><br>
		<label>Enter Ending Date:</label>
		<input type="date" name="ed_date" placeholder="End Date"/><br>
		<button type="submit" name="searchPayments" value="Search Payments" class="btn btn-primary"> Search Payment </button>

	</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['st_date']) || isset($_POST['ed_date'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$st=validate($_POST['st_date']);
		$ed=validate($_POST['ed_date']);
	
		if(empty($st) && empty($ed)) {
						echo "<script>
            alert('Start and end date required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		if(!empty($st) && !empty($ed) && $ed == $st) {
			$query = "SELECT appointment.pat_id,patient.pat_insured,patient.pat_insurance_num,appointment.app_id,appointment.app_payment,appointment.app_date 
			FROM appointment INNER JOIN patient ON appointment.pat_id = patient.pat_id WHERE app_date = '$st'";
	}else{
		$query = "SELECT appointment.pat_id,patient.pat_insured,patient.pat_insurance_num,appointment.app_id,appointment.app_payment,appointment.app_date 
		FROM appointment INNER JOIN patient ON appointment.pat_id = patient.pat_id WHERE 1";
		if(!empty($st)) {
		$query.=" AND app_date>'$st'";
		}
		if(!empty($ed)) {
		$query.=" AND app_date<'$ed'";
		}
	    }
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  
						echo "<script>
            alert('Payments not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>AppointmentID</th><th>Payment</th><th>AppointmentDate</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['app_id']}</td><td>{$row['app_payment']}</td><td>{$row['app_date']}</td><tr>";
		}
		echo"</table>";
		}
		?>
		</div>
</body>
</html>	