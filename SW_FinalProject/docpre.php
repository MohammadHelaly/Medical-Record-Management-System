<!DOCTYPE html>
<html>
	<head>
		<title>MANAGE PRESCRIPTIONS</title>
		<link rel="stylesheet" href="stylemed2.css">
	</head>
<body>
<div class="topnav">
 		<a href=docapp.php> Manage Appointments</a>
  		<a class = "active" href=docpre.php>Manage Prescriptions</a>
 		<a href=docpat.php>Manage Patients</a>
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
		$did=$_SESSION['dsid'];
		$query = "SELECT prescriptions.prescription,prescriptions.pres_date,prescriptions.pat_id,patient.pat_name,patient.pat_email,patient.pat_phone,patient.pat_insured,patient.pat_insurance_num 
		FROM prescriptions INNER JOIN patient ON prescriptions.pat_id=patient.pat_id WHERE prescriptions.doc_id='$did'";
		$result= mysqli_query($conn, $query);
		echo "<table border='1'>";
		echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>PateintID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><tr>";
		while($row = mysqli_fetch_assoc($result))
		{
		   
		   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><tr>";
		   
			
		}
		echo"</table>";
		}
		?>

		<br><h3>SEARCH YOUR PRESCRIPTIONS BY PATIENT</h3>
		<form method ="post">
        <label>Enter Patient ID:</label>
		<input type="text" name="pat_id" placeholder="Patient ID"/> <br>
		<button type="submit" name="serPre" value="View Appointments" class="btn btn-primary"> Search Prescriptions</button>
		</form>
		<?php
		include "db_conn.php";
		//session_start();
		if(isset($_POST['pat_id'])){
			function validate($entry){
                $entry=trim($entry);
                $entry=stripslashes($entry);
                $entry=htmlspecialchars($entry);
                return $entry;
                }		
            $id=validate($_POST['pat_id']);
            $did=$_SESSION['dsid'];

            if(empty($id)) {
                echo "<script>
                alert('Patient id required.');
                </script>";
                            header("Refresh:0");
                            exit();
            }
            $query = "SELECT prescriptions.prescription,prescriptions.pres_date,prescriptions.pat_id,patient.pat_name,patient.pat_email,patient.pat_phone,patient.pat_insured,patient.pat_insurance_num 
            FROM prescriptions INNER JOIN patient ON prescriptions.pat_id=patient.pat_id WHERE prescriptions.doc_id='$did' AND prescriptions.pat_id = '$id'";
            $result= mysqli_query($conn, $query);
			if(mysqli_num_rows($result)== 0){  

				echo "<script>
	alert('Information not found.');
	</script>";
				header("Refresh:0");
				exit();
}
echo "<table border='1'>";
echo "<tr><th>Prescription</th><th>PrescriptionDate</th><th>PateintID</th><th>PatientInsured</th><th>PatientInsuranceNumber</th><th>PatientName</th><th>PatientEmail</th><th>PatientPhone</th><tr>";
while($row = mysqli_fetch_assoc($result))
{
   
   echo "<tr><td>{$row['prescription']}</td><td>{$row['pres_date']}</td><td>{$row['pat_id']}</td><td>{$row['pat_insured']}</td><td>{$row['pat_insurance_num']}</td><td>{$row['pat_name']}</td><td>{$row['pat_email']}</td><td>{$row['pat_phone']}</td><tr>";
   
	
}
echo"</table>";
		}
		?>

		<br><h3>ISSUE A PRESCRIPTION</h3>
		<form method ="post">
		<label>Enter Patient ID:</label>
		<input type="text" name="pat_idp" placeholder="Patient ID"/> <br>
		<label>Enter Prescription:</label>
		<input type="text" name="pre_info" placeholder="Prescription"/><br>
		<button type="submit" name="makePre" value="Make Pre" class="btn btn-primary">Issue Prescription</button>
		</form>
	<?php
		include "db_conn.php";
		if(isset($_POST['pre_info'])  && isset($_POST['pat_idp'])){ 
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		

		$info=validate($_POST['pre_info']);
		$id=validate($_POST['pat_idp']);
		$did=$_SESSION['dsid'];
		if(empty($info) && empty($id)) {
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
		
		if(empty($info)) {
			echo "<script>
            alert('Prescription required.');
            </script>";
						header("Refresh:0");
						exit();
		}
		$date = date('Y-m-d');
		$sql="INSERT INTO prescriptions(pat_id,doc_id,prescription,pres_date)
		 VALUES ('$id','$did','$info','$date')";
		$result=mysqli_query($conn,$sql);
		$sql2="SELECT * FROM prescriptions WHERE doc_id='$did' AND pat_id ='$id' AND prescription='$info'";
		$result2=mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)!= 0){
			echo "<script>
            alert('Prescription Issued.');
            </script>";
						header("Refresh:0");
						exit();
	    }
		}
		?>

<br><h3>DELETE A PRESCRIPTION</h3>
		<form method ="post">
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
		if(isset($_POST['pre_infod'])  && isset($_POST['pat_iddd']) && isset($_POST['pre_dated'])){ 
			function validate($entry){
			$entry=trim($entry);
			$entry=stripslashes($entry);
			$entry=htmlspecialchars($entry);
			return $entry;
			}		

		$info=validate($_POST['pre_infod']);
		$date=validate($_POST['pre_dated']);
		$id=validate($_POST['pat_iddd']);
		$did=$_SESSION['dsid'];
		if(empty($info) && empty($id) && empty($date)) {
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