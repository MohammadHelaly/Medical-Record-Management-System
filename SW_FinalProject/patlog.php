<!DOCTYPE html>
<html>
	<head>
		<title>PATIENT LOGIN</title>
		<link rel="stylesheet" href="stylemed.css">
		
	</head>
	<script>
  function validateForm() {
    let x = document.forms["Login-Form"]["email"].value;
    let y = document.forms["Login-Form"]["password"].value;
	if (x == "" && y== "") {
      alert("Login Information Missing.");
      return false;
    }
	else if (x == "")
	{
		alert("Please Enter Your E-mail Address.");
      return false;
	}
	else if(y== "")
	{
		alert("Please Enter Your Password.");
      return false;
	}
    
  }
  </script>
<body>
<div class="topnav">
 		<a href=index.php>Back</a>
		</div>
	<div class="container">
		<form name="Login-Form" action="patlogin.php" onsubmit="return validateForm()" method="post">
		<h3>PATIENT LOGIN</h3>
		<label>Enter Email:</label>
		<input type="email" name="email" placeholder="Email"/><br>
		<br>
		<label>Enter Password:</label>
		<input type="password" name="password" placeholder="Password"/><br>
		<input type="submit" name="submit" value="LOGIN" class="btn-login"/><br>
		<div>
		<label>Not registered?</label>
		<a href=patsign.php>Sign Up</a>
		</div>

	</form>	
		</div>
</body>
</html>	