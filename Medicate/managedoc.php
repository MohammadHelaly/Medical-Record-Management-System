<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE DOCTORS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
	
<div class="topnav">
 		<a href=advsearch.php>Advanced Search</a>
 		<a href=manageapp.php> Manage Appointments and Prescriptions</a>
  		<a class = "active" href=managedoc.php>Manage Doctors</a>
 		<a href=managepat.php>Manage Patients</a>
		<a href=managepay.php>Manage Payments</a>
		<a href=managecl.php>Manage Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<h3>VIEW ALL DOCTORS</h3>
		<form method ="post">
		<button type="submit" name="viewDoc" value="View Doctors" class="btn btn-primary"> View Doctors</button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['viewDoc'])){
		$query = "SELECT * FROM doctor";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>DoctorID</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>City</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		  
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_password']}</td><td>{$row['doc_phone']}</td><td>{$row['doc_city']}</td><tr>";
		 
			
		}
		echo"</table>";
		}
		?>

<br><h3>SEARCH DOCTORS</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_ids" placeholder="Doctor ID"/> <br>
		<label>Enter Doctor Name:</label>
		<input type="text" name="doc_name" placeholder="Doctor Name"/> <br>
		<label>Enter Doctor Email:</label>
		<input type="text" name="doc_email" placeholder="Doctor Email"/> <br>
		<label>Enter Doctor Phone:</label>
		<input type="text" name="doc_phone" placeholder="Doctor Phone"/> <br>
		<label>Enter Doctor City:</label>
		<input type="text" name="doc_city" placeholder="Doctor City"/> <br>				
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
		echo "<tr><th>DoctorID</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>City</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		  
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_name']}</td><td>{$row['doc_email']}</td><td>{$row['doc_password']}</td><td>{$row['doc_phone']}</td><td>{$row['doc_city']}</td><tr>";
		 
			
		}
		echo"</table>";
		}
		?>
		
		<h3>ADD DOCTORS</h3>
		<form method ="post">
		<label>Enter Doctor Name:</label>
		<input type="text" name="doc_namea" placeholder="Doctor Name"/> <br>
		<label>Enter Doctor Email:</label>
		<input type="text" name="doc_emaila" placeholder="Doctor Email"/> <br>
		<label>Enter Doctor Password:</label>
		<input type="text" name="doc_passa" placeholder="Doctor Password"/> <br>
		<label>Enter Doctor Phone:</label>
		<input type="text" name="doc_phonea" placeholder="Doctor Phone"/> <br>
		<label>Enter Doctor City:</label>
		<input type="text" name="doc_citya" placeholder="Doctor City"/><br>				
		<button type="submit" name="addDoctor" value="Add Doctors"class="btn btn-primary"> Add Doctor </button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['doc_namea']) && isset($_POST['doc_emaila']) && isset($_POST['doc_passa']) && isset($_POST['doc_phonea']) && isset($_POST['doc_citya'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
			$name=validate($_POST['doc_namea']);
			$email=validate($_POST['doc_emaila']);
			$phone=validate($_POST['doc_phonea']);
			$city=validate($_POST['doc_citya']);
			$pass=validate($_POST['doc_passa']);
	
		if(empty($name) && empty($email) && empty($phone) && empty($city) && empty($pass)) {
						echo "<script>
            alert('Doctor information required.');
            </script>";
						header("Refresh:0");
						exit();
		}

		if(empty($name)) {
						echo "<script>
            alert('Doctor name required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($email)) {

					echo "<script>
            alert('Doctor Email required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($pass)) {

					echo "<script>
            alert('Doctor Password required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($phone)) {
						echo "<script>
            alert('Doctor phone required.');
            </script>";
						header("Refresh:0");
						exit();
		}
	
		if(empty($city)) {
					echo "<script>
            alert('Doctor city required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		$pass = md5($pass);
		$sql="INSERT INTO doctor(doc_name,doc_email,doc_password,doc_phone,doc_city) VALUES('$name','$email','$pass','$phone','$city')";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM doctor WHERE doc_name='$name' AND doc_email='$email' AND doc_password='$pass' AND doc_phone='$phone' AND doc_city='$city'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 1){
			echo "<script>
            alert('Doctor Added Successfully.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		}
		?>
		
		<br><h3>DELETE DOCTORS</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_idd" placeholder="Doctor ID"/> <br>
		<button type="submit" name="deleteDoctor" value="Delete Doctor" class="btn btn-primary"> Delete Doctor </button>
		</form>
		<?php
		include "db_conn.php";

		if(isset($_POST['doc_idd'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
				
	
		$id=validate($_POST['doc_idd']);
	
		if(empty($id)) {
						echo "<script>
            alert('Doctor ID required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		$sqle="SELECT * FROM doctor WHERE doc_id='$id'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)== 0){  
						echo "<script>
            alert('Doctor not found.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		
		$sql="DELETE FROM doctor WHERE doc_id='$id'";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM doctor WHERE doc_id='$id'";
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
		
		<br><h3>VIEW ALL DOCTOR STATUS UPDATES</h3>
		<form method ="post">
		<button type="submit" name="viewStatus" value="View Status" class="btn btn-primary"> View Status </button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['viewStatus'])){
		$query = "SELECT * FROM doctor_status";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>DocotorID</th><th>Status</th><th>StatusDate</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['doc_id']}</td><td>{$row['doc_status']}</td><td>{$row['doc_status_date']}</td><tr>";
		  
		}
		echo"</table>";	
		}
		?>
				<br><h3>UPDATE DOCTOR STATUS</h3>
		<form method ="post">
		<label>Enter Doctor ID:</label>
		<input type="text" name="doc_idu" placeholder="Doctor ID"/> <br>
		<label>Enter Doctor Status:</label>
		<input type="text" name="status" placeholder="Status"/> <br>
		<label>Enter Status Date:</label>
		<input type="date" name="st_date" placeholder="Status Date"/> <br>
		<button type="submit" name="updateStatus" value="Update Status" class="btn btn-primary">Update Status</button>
		</form>
		<?php
		include "db_conn.php";
		if(isset($_POST['status']) && isset($_POST['doc_idu']) && isset($_POST['st_date'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$id=validate($_POST['doc_idu']);
		$sd=validate($_POST['st_date']);
		$st=validate($_POST['status']);
		$v1="available";
		$v2="unavailable";
	
		if(empty($id)) {

						echo "<script>
            alert('Doctor ID required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		if(empty($st)) {
						echo "<script>
            alert('Status Information required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		else if(strcmp($st,$v1) != 0 && strcmp($st,$v2) != 0) {
					echo "<script>
            alert('Status Invalid.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		
		if(empty($sd)) {
						echo "<script>
            alert('Status Date required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		
		$query = "INSERT INTO doctor_status(doc_id,doc_status,doc_status_date) VALUES ('$id','$st','$sd');";
		$result= mysqli_query($conn, $query);
		//echo mysqli_num_rows($result);
		$sql2="SELECT * FROM doctor_status WHERE doc_id='$id' AND doc_status_date='$sd'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 1){
			echo "<script>
            alert('Status Updated Successfully.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		}
		?>
		
		<br><h3>SEARCH DOCTOR STATUS BY DOCTOR/DATE</h3>
		<form method ="post">
		<label>Enter  Doctor ID:</label>
		<input type="text" name="doc_idv" placeholder="Doctor ID"/> <br>
		<label>Enter Status Date:</label>
		<input type="date" name="date" placeholder="Status Date"/> <br>
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
		</div>
</body>
</html>	