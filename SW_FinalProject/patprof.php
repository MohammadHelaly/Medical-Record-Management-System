<!DOCTYPE html>
<html>
	<head>
		<title>PATIENT PROFILE</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
        <a class = "active" href=patprof.php> My Profile</a>
 		<a href=patapp.php> Manage Appointments and Prescriptions</a>
		<a href=patdoc.php>Search Doctors and Clinics</a>
		<a class="logout" href=index.php>logout</a>
		</div>
		<div class="container">
		<?php if (isset($_GET['error'])) { ?>
		<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
        <h2>Welcome,
        <?php
        include "db_conn.php";
        session_start();
        $sid = $_SESSION['ssid'];
        $queryn = "SELECT * FROM patient WHERE pat_id='$sid'";
        $resultn = mysqli_query($conn, $queryn);
        if ($resultn && mysqli_num_rows($resultn) > 0) {
        $rown = mysqli_fetch_assoc($resultn);
        $name = $rown['pat_name'];
        echo $name;
        }
        ?>
        .</h2>
		<br><h3>YOUR INFORMATION</h3>
		<?php
		include "db_conn.php";
		//session_start();

		$sid=$_SESSION['ssid'];
		$query = "SELECT *FROM patient WHERE pat_id='$sid'";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>PatientID</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><th>PatientCity</th><th>Insured</th><th>PatientInsuranceNumber</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
            echo "<tr><td>{$row['pat_id']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}|</td><td>{$row['pat_phone']}</td><td>{$row['pat_city']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><tr>";
		}
		echo"</table>";
		?>

		<br><h3>VIEW ALL YOUR CONDITIONS</h3>
		<form method ="post">
		<button type="submit" name="viewCon" value="View Conditions" class="btn btn-primary"> View Conditions</button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['viewCon'])){
		$sid=$_SESSION['ssid'];
		$query = "SELECT *FROM patient_conditions WHERE pat_id='$sid'";
		$result= mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)== 0){  

					echo "<script>
		alert('Information not found.');
		</script>";
					header("Refresh:0");
					exit();
	    }
		echo "<table border='1'>";
		echo "<tr><th>Conditions</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   echo "<tr><td>{$row['pat_condition']}</td><tr>";	
		}
		echo"</table>";
		}
		?>
		
		<br><h3>DO YOU HAVE ANY CONDITIONS TO RECORD?</h3>
		<form method ="post">
		<label>Enter Condition Information:</label>
		<input type="text" name="con_info" placeholder="Condition Information"/><br>
		<button type="submit" name="recCon" value="Record Condition" class="btn btn-primary"> Record Condition</button>
		</form>
	</div>
	<?php
		include "db_conn.php";
		if(isset($_POST['con_info'])){ 
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		
	
		$info=validate($_POST['con_info']);
		$sid=$_SESSION['ssid'];
		if(empty($info)) {
			echo "<script>
            alert('Condition Information Required.');
            </script>";
						header("Refresh:0");
						exit();
		}
        $sqle="SELECT * FROM patient_conditions WHERE pat_id='$sid' AND pat_condition = '$info'";
		$resulte=mysqli_query($conn,$sqle);
		if(mysqli_num_rows($resulte)!= 0){
			echo "<script>alert('Condition Already Recorded.');</script>";
						header("Refresh:0");
						exit();
	    }
		
		$sql="INSERT INTO patient_conditions(pat_id,pat_condition)
		 VALUES ('$sid','$info')";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM patient_conditions WHERE pat_id='$sid' AND pat_condition = '$info'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)== 1){
			$rowx =  mysqli_fetch_assoc($result2);
			echo "<script>alert('Condition Recorded Successfully.');</script>";
						header("Refresh:0");
						exit();
	    }
		}
		?>
</body>
</html>	