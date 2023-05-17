<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE PATIENTS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
 		<a href=docapp.php> Manage Appointments</a>
  		<a href=docpre.php>Manage Prescriptions</a>
 		<a class = "active" href=docpat.php>Manage Patients</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<h3>VIEW ALL PATIENTS</h3>
		<form method ="post">
		<button type="submit" name="viewPatient" value="View Patients" class="btn btn-primary"> View Patients</button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['viewPatient'])){
		$query = "SELECT * FROM patient";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Insured</th><th>Insurance Number</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		  
		   echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}|</td><td>{$row['pat_phone']}</td><td>{$row['pat_city']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><tr>";
		 
			
		}
		echo"</table>";
		}
		?>
		
		<br><h3>SEARCH PATIENTS</h3>
		<form method ="post">
		<label>Enter Patient ID:</label>
		<input type="text" name="pat_ids" placeholder="Patient ID"/> <br>
		<label>Enter Patient Name:</label>
		<input type="text" name="pat_name" placeholder="Patient Name"/> <br>
		<label>Enter Patient Email:</label>
		<input type="text" name="pat_email" placeholder="Patient Email"/> <br>
		<label>Enter Patient Phone:</label>
		<input type="text" name="pat_phone" placeholder="Patient Phone"/> <br>
		<label>Enter Patient City:</label>
		<input type="text" name="pat_city" placeholder="Patient City"/> <br>
		<label>Enter Patient Insurance Number:</label>
		<input type="text" name="pat_inss" placeholder="Patient Insurance Number"/><br>				
		<button type="submit" name="searchPatient" value="Search Patients"class="btn btn-primary"> Search Patient </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['pat_ids']) || isset($_POST['pat_name']) || isset($_POST['pat_email']) || isset($_POST['pat_phone']) || isset($_POST['pat_city']) || isset($_POST['pat_inss'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$id=validate($_POST['pat_ids']);
		$name=validate($_POST['pat_name']);
		$email=validate($_POST['pat_email']);
		$phone=validate($_POST['pat_phone']);
		$city=validate($_POST['pat_city']);
		$ins=validate($_POST['pat_inss']);
	
		if(empty($id) && empty($name) && empty($email) && empty($phone) && empty($city) && empty($ins)) {
			echo "<script>
            alert('Patient Information Required');
            </script>";
			header("refresh:0");
						exit();
		}	
		$query = "SELECT * FROM patient WHERE 1";
		if(!empty($id)){
		$query.=" AND pat_id='$id'";
		}
		if(!empty($name)){
		$query.=" AND pat_name='$name'";
		}
		if(!empty($email)){
		$query.=" AND pat_email='$email'";
		}
		if(!empty($phone)){
		$query.=" AND pat_phone='$phone'";
	    }
		if(!empty($city)){
		$query.=" AND pat_city='$city'";
	    }
		if(!empty($ins)){
			$query.=" AND pat_insurance_num='$ins'";
		}		
		$result= mysqli_query($conn, $query);
		//echo mysqli_num_rows($result);
		if(mysqli_num_rows($result)== 0){  
			echo "<script>
            alert('Patient Not Found.');
            </script>";
			header("refresh:0");
			exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Insured</th><th>Insurance Number</th><tr>";		while($row = mysqli_fetch_assoc($result))
		{
		  
		   echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}|</td><td>{$row['pat_phone']}</td><td>{$row['pat_city']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><tr>";
		 
			
		}
		echo"</table>";
		}
		?>

<br><h3>VIEW PATIENT CONDITIONS</h3>
		<form method ="post">
        <label>Enter Patient ID:</label>
		<input type="text" name="pat_idc" placeholder="Patient ID"/> <br>
		<button type="submit" name="viewCon" value="View Conditions" class="btn btn-primary"> View Conditions</button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['pat_idc'])){
            function validate($entry){
                $entry=trim($entry);
                $entry=stripslashes($entry);
                $entry=htmlspecialchars($entry);
                return $entry;
                }		
        
        $id=validate($_POST['pat_idc']);
		//$sid=$_SESSION['ssid'];
		$query = "SELECT * FROM patient_conditions WHERE pat_id = '$id'";
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  
			echo "<script>
            alert('Information Not Found.');
            </script>";
			header("refresh:0");
			exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>Conditions</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_condition']}</td><tr>";	
		}
		echo"</table>";
		}
		?>


</body>
</html>	