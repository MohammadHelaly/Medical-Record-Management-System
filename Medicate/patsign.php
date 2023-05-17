<!DOCTYPE html>
<html>
	<head>
		<title>PATIENT SIGNUP</title>
		<link rel="stylesheet" href="stylemed.css">
	</head>
	<script>
 <script>
  function validateForm() {
    let x = document.forms["SignupForm"]["email"].value;
    let l = document.forms["SignupForm"]["name"].value;
    let y = document.forms["SignupForm"]["password"].value;
    let z = document.forms["SignupForm"]["confirmpassword"].value;
    let p = document.forms["SignupForm"]["phone"].value;
    let k = document.forms["SignupForm"]["city"].value;
    if (x == "" && y == "" && l =="" && z == "" && p == "" && k == ""){
      alert("Missing Information Please fill out the fields accordingly");
      return false;
    }
    else if (x == "" && y == ""  && z == "" && p == "" && k == ""){
      alert("Missing Information Please fill out the fields accordingly");
      return false;
    }
    else if ( y == ""  && z == "" && p == "" && k == ""){
      alert("Missing Information Please fill out the fields accordingly");
      return false;
    }
    else if ( z == "" && p == "" && k == ""){
      alert("Missing Information Please fill out the fields accordingly");
      return false;
    }
    else if (  p == "" && k == ""){
      alert("Missing Information Please fill out the fields accordingly");
      return false;
    }
    else if (x == "") {
      alert("E-mail field must be filled out.");
      return false;
    }
    else if(k == ""){
        alert("City field must be filled out.");
        return false;
    }
    else if(y == ""){
        alert("Password field must be filled out.");
        return false;
    }
    
    else if(z ==""){
        alert("Confirmation of password field must be filled out.");
         return false;
    }
    else if(l == ""){
        alert("Name must be filled out.");
        return false;
    }
    else if(p ==""){
        alert("Phone number field must be filled out.");
        return false;
    }
    
    else if(y != z)
    {
        alert("Passwords Do not match. Please try again!");
        return false;
    } 
    //else 
    //alert("Welcome!");
    
  }
  </script>
  </script>
<body>
<div class="topnav">
 		<a href=index.php>Back</a>
		</div>
  <div class="container">
	<form name="SignupForm" action="patsignup.php" onsubmit="return validateForm()" method="post">
		<h3>PATIENT SIGNUP</h3>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Enter Name:</label>
		<input type="text" name="name" placeholder="Name" name="name"/><br>
    <br>
		<label>Enter Email:</label>
		<input type="email" name="email" placeholder="Email" name="email"/><br>
    <br>
    <label>Phone:</label>
    <input type="text" name="phone" placeholder="Phone" name="Phone"/><br>
    <br>
    <label>City:</label>
		<input type="text" name="city" placeholder="City" name="City"/><br>
    <br>
    <label>Are You Insured?:</label>
		<input type="text" name="ins" placeholder="YES or NO" name="ins"/><br>
    <br>
    <label>Insurance Number:</label>
		<input type="text" name="ins_num" placeholder="Insurance Number" name="ins_num"/><br>
    <br>
    <label>Enter Password:</label>
		<input type="password" name="password" placeholder="Password" name="password"/><br>
    <br>
    <label>Confirm Password:</label>
		<input type="password" name="confirmpassword" placeholder="Confirm Password" name="ConfirmPassword"/><br>
    <input type="submit" name="submit" value="SIGNUP" class="btn-signup"/><br>
	</form>
    </div>	
</body>
</html>	