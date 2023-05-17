<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE CLINICS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
        <div class="topnav">
 		<a href=advsearch.php>Advanced Search</a>
 		<a href=manageapp.php> Manage Appointments and Prescriptions</a>
  		<a href=managedoc.php>Manage Doctors</a>
 		<a href=managepat.php>Manage Patients</a>
		<a href=managepay.php>Manage Payments</a>
		<a class="active" href=managecl.php>Manage Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<h3>VIEW ALL CLINICS</h3>
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
		<input type="text" name="cl_ids" placeholder="Clinic ID"/> <br>
		<label>Enter Clinic City:</label>
		<input type="text" name="cl_citys" placeholder="Clinic City"/> <br>
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
		   echo "<tr><td>{$row['clinic_id']}</td><td>{$row['clinic_city']}</td><td>{$row['clinic_address']}</td><tr>";
		}
		echo"</table>";
		}
		?>
		
		<h3>ADD CLINICS</h3>
		<form method ="post">
		<label>Enter Clinic ID:</label>
		<input type="text" name="cl_ida" placeholder="Clinic ID"/> <br>
		<label>Enter Clinic City:</label>
		<input type="text" name="cl_citya" placeholder="Clinic City"/> <br>
		<label>Enter Clinic Address:</label>
		<input type="text" name="cl_adda" placeholder="Clinic Address"/> <br>
		<button type="submit" name="addNewClinic" value="Add New Clinic" class="btn btn-primary"> Add Clinic </button>
		</form>
		<?php

		include "db_conn.php";

		if(isset($_POST['cl_ida']) && isset($_POST['cl_citya']) && isset($_POST['cl_adda'])){	
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}				
	
		$id=validate($_POST['cl_ida']);
		$city=validate($_POST['cl_citya']);
		$add=validate($_POST['cl_adda']);
	
		if(empty($id) && empty($city) && empty($add)) {
						echo "<script>
            alert('Clinic Information Required.');
            </script>";
			header("Refresh:0");
			exit();	
		}

		if(empty($city)) {
						echo "<script>
            alert('Clinic City Required.');
            </script>";
						header("Refresh:0");
			exit();	
		}
		
		if(empty($id)) {
			echo "<script>
            alert('Clinic ID required.');
            </script>";
						header("Refresh:0");
			exit();	
		}

		if(empty($add)) {
			echo "<script>
            alert('Clinic Address Required.');
            </script>";
						header("Refresh:0");
			exit();	
		}
		
		$sql="INSERT INTO clinic(clinic_id,clinic_city,clinic_address) VALUES('$id','$city','$add')";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM clinic WHERE clinic_id='$id' AND clinic_city='$city' AND clinic_address = '$add'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 1){
			echo "<script>
            alert('Clinic Added Successfully.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		}
		?>
		
		<h3>DELETE CLINICS</h3>
		<form method ="post">
		<label>Enter Clinic ID:</label>
		<input type="text" name="cl_idd" placeholder="Clinic ID"/> <br>
		<button type="submit" name="deleteClinic" value="Delete Clinic" class="btn btn-primary"> Delete Clinic </button>
		</form>
		</div>
		<?php
		include "db_conn.php";
		if(isset($_POST['cl_idd'])){
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
				
	
		$id=validate($_POST['cl_idd']);
	
		if(empty($id)) {
			echo "<script>
            alert('Clinic ID required.');
            </script>";
						header("Refresh:0");
			exit();	
		}
		
		$sqle="SELECT * FROM clinic WHERE clinic_id='$id'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)== 0){
		echo "<script>
        alert('Clinic not found.');
        </script>";
					header("Refresh:0");
		exit();	
	    }
		$sql="DELETE FROM clinic WHERE clinic_id='$id'";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM clinic WHERE clinic_id='$id'";
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