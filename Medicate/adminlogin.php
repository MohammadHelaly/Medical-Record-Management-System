<?php

include "db_conn.php";
session_start();

if(isset($_POST['email']) && isset($_POST['password'])) {
	
	function validate($entry){
		$entry=trim($entry);
		$entry=stripslashes($entry);
		$entry=htmlspecialchars($entry);
		return $entry;
	}	
	
	$email=validate($_POST['email']);
	$password=validate($_POST['password']);
	$v1='@';
	$v2='.';	
	if(empty($email) && empty($password)) {
		echo "<script>
            alert('Enter Login Information');
            </script>";
			header("refresh:0; adminlog.php");
					exit();
	}

	else if(empty($email)) {
		echo "<script>
            alert('Please Enter Your Email Address');
            </script>";
			header("refresh:0; adminlog.php");
		exit();
	}
	
	else if(empty($password)) {
		echo "<script>
            alert('Please Enter Your Password');
            </script>";
			header("refresh:1; adminlog.php");
		exit();
	}
	
	else if(strpos($email,$v1) == false || strpos($email,$v2) == false) {
		echo "<script>
		alert('Email  is Incorrect Please Retry ');
		</script>";
		header("refresh:0; adminlog.php");
		exit();
	}
	
	else{
		$password = md5($password);
		$sql="SELECT * FROM admin WHERE admin_email='$email' AND admin_password='$password'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)!= 1){
			echo "<script>
            alert('Login Information Is Incorrect! Please Retry');
            </script>";
			header("refresh:0; adminlog.php");
		exit();
		}
		else if(mysqli_num_rows($result)== 1){
			//$row = mysqli_fetch_assoc($result);
			//$_SESSION['name'] = $row['system_admin_name'];    
			//echo 'Welcome, '.$_SESSION['name'].'.'; 
			//header("Location: adminlog.php?error=Email required.");
		header("Location: advsearch.php");
		exit();
		}	
	}
	
}

?>