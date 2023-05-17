<!DOCTYPE html>
<html>
	<head>
		<title>DOCTOR LOGIN</title>
		<link rel="stylesheet" href="stylemed.css">
		
	</head>
	<script>
  function validateForm() {
    let x = document.forms["Login-Form"]["email"].value;
    let y = document.forms["Login-Form"]["password"].value;
	if (x == "" && y== "") {
      alert("all field must be filled out");
      return false;
    }
	else if (x == "")
	{
		alert("email field must be filled out");
      return false;
	}
	else if(y== "")
	{
		alert("password field must be filled out");
      return false;
	}
    
  }
  </script>
<body>
<div class="topnav">
 		<a href=index.php>Back</a>
		</div>  
<div class="container">
            

				<form name="Login-Form" action="doclogin.php" onsubmit="return validateForm()" method="post">
        <h3> DOCTOR LOGIN </h3>
                        <label>Enter Email:</label>
                        <input type="email" name = "email" placeholder="Email" class="form-control" required><br><br>
                        <label>Enter Password:</label>
                        <input type="password" name = "password" placeholder="Password" class="form-control" required> <br>
                        <input type="submit" name="submit" value="LOGIN" class="btn-login"/><br>
                    </form>
</body>
</html>	
