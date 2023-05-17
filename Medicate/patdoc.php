<!DOCTYPE html>
<html>
	<head>
		<title>SEARCH DOCTORS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
		<div class="topnav">
        <a href=patprof.php> My Profile</a>			
 		<a href=patapp.php> Manage Appointments and Prescriptions</a>
		<a class="active" href=patdoc.php>Search Doctors and Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<h3>VIEW ALL DOCTORS</h3>
		<form method ="post">
		<button type="submit" name="viewDoc" value="View Cars" class="btn btn-primary"> View Doctors </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['viewDoc'])){
		$query = "SELECT * FROM doctor";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>DoctorID</th><th>DoctorName</th><th>DoctorEmail</th><th>DoctorPhone</th><th>DocorCity</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><td>{$row['doc_city']}</td><tr>";
		  
		}
		echo"</table>";
		}
		?>
		
		 <br> <h3>SEARCH DOCTORS</h3>
		 <form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_ids" placeholder="Doctor ID"/><br>
		<label>Enter Doctor Name:</label>
		<input type="text" name="doc_name" placeholder="Doctor Name"/><br>
		<label>Enter Doctor Email:</label>
		<input type="text" name="doc_email" placeholder="Doctor Email"/><br>
		<label>Enter Doctor Phone:</label>
		<input type="text" name="doc_phone" placeholder="Doctor Phone"/><br>
		<label>Enter Doctor City:</label>
		<input type="text" name="doc_city" placeholder="Doctor City"/><br>			
		<button type="submit" name="searchDoctor" value="Search Doctors"class="btn btn-primary"> Search Doctor </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['doc_ids']) || isset($_POST['doc_name']) || isset($_POST['doc_email']) || isset($_POST['doc_phone']) || isset($_POST['doc_city'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$id=validate($_POST['doc_ids']);
		$name=validate($_POST['doc_name']);
		$email=validate($_POST['doc_email']);
		$phone=validate($_POST['doc_phone']);
		$city=validate($_POST['doc_city']);
	
		if(empty($id) && empty($name) && empty($email) && empty($phone) && empty($city)) {
			echo "<script>
            alert('Doctor Information Required');
            </script>";
			header("refresh:0");
						exit();
		}	
		$query = "SELECT * FROM doctor WHERE 1";
		if(!empty($id)){
		$query.=" AND doc_id='$id'";
		}
		if(!empty($name)){
		$query.=" AND doc_name='$name'";
		}
		if(!empty($email)){
		$query.=" AND doc_email='$email'";
		}
		if(!empty($phone)){
		$query.=" AND doc_phone='$phone'";
	    }
		if(!empty($city)){
		$query.=" AND doc_city='$city'";
	    }		
		$result= mysqli_query($conn, $query);
		//echo mysqli_num_rows($result);
		if(mysqli_num_rows($result)== 0){  
			echo "<script>
            alert('Doctor Not Found.');
            </script>";
			header("refresh:0");
			exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>DoctorID</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		  
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_phone']}</td><td>{$row['doc_city']}</td><tr>";
		 
			
		}
		echo"</table>";
		}
		?>

		<br><h3>SEARCH DOCTOR STATUS BY DOCTOR/DATE</h3>
		<form method ="post">
		<label>Enter  Doctor ID:</label>
		<input type="text" name="doc_idv" placeholder="Doctor ID"/><br>
		<label>Enter Status Date:</label>
		<input type="date" name="date" placeholder="Status Date"/><br>
		<button type="submit" name="searchStatus" value="Search Status" class="btn btn-primary"> Search Status </button>
		</form>
	<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['date']) || isset($_POST['doc_idv'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$id=validate($_POST['doc_idv']);
		$sd=validate($_POST['date']);
	
		if(empty($sd) && empty($id)) {
			echo "<script>
            alert('Status Information required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($sd) || empty($id)){
		$query = "SELECT * FROM doctor_status WHERE doc_status_date='$sd' OR doc_id='$id';";
		$result= mysqli_query($conn, $query);
		}
		else
		{
		$query = "SELECT * FROM doctor_status WHERE doc_status_date='$sd' AND doc_id='$id';";
		$result= mysqli_query($conn, $query);
		}
		if(mysqli_num_rows($result)== 0){  

						echo "<script>
            alert('Doctor status not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>DocotorID</th><th>Status</th><th>StatusDate</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_status']}</td><td>{$row['doc_status_date']}</td><tr>";
		  
		}
		echo"</table>";	
		}
		?>

<br><h3>VIEW ALL CLINICS</h3>
		<form method ="post">
		<button type="submit" name="viewClinic" value="View Clinics"class="btn btn-primary">View Clinics </button>
		</form>
		<?php

		include "db_conn.php";

		if(isset($_POST['viewClinic'])){
		$query = "SELECT * FROM clinic";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>ClinicID</th><th>ClinicCity</th><th>ClinicAddress</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   echo "<tr><td>{$row['clinic_id']}</td><td>{$row['clinic_city']}</td><td>{$row['clinic_address']}</td><tr>";
		}
		echo"</table>";
		}
		?>


<br><h3>SEARCH CLINICS</h3>
		<form method ="post">
		<label>Enter Clinic ID:</label>
		<input type="text" name="cl_ids" placeholder="Clinic ID"/><br>
		<label>Enter Clinic City:</label>
		<input type="text" name="cl_citys" placeholder="Clinic City"/><br>
		<button type="submit" name="searchClinic" value="Search Clinics"class="btn btn-primary">Search Clinic </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['cl_ids']) || isset($_POST['cl_citys'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$id=validate($_POST['cl_ids']);
		$city=validate($_POST['cl_citys']);
	
		if(empty($id) && empty($city)) {
			echo "<script>
            alert('Clinic ID or City required.');
            </script>";
						header("Refresh:0");
			exit();
		}	
		$query = "SELECT * FROM clinic WHERE 1";
		if(!empty($id)){
			$query.=" AND clinic_id='$id'";
		}
		if(!empty($city)){
			$query.=" AND clinic_city='$city'";
			}
		$result= mysqli_query($conn, $query);
		if(mysqli_num_rows($result)== 0){  
			echo "<script>
            alert('Clinic not found.');
            </script>";
						header("Refresh:0");
			exit();
				
			
	    }
		echo "<table border='1'>";
		echo "<tr><th>ClinicID</th><th>ClinicCity</th><th>ClinicAddress</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['clinic_id']}</td><td>{$row['clinic_city']}<td>{$row['clinic_address']}</td><tr>";
		  
			
		}
		echo"</table>";
		}
		?>
		</div>
</body>
</html>	