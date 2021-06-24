<?php 

	session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php include "assets/links.php" ?>
<link rel="stylesheet" type="text/css" href="assets/css/register.css">
<title>Bootstrap Simple Registration Form</title>



</head>
<body>
<div class="signup-form">
    <form  method="post">
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="fname" placeholder="First Name" required="required"></div>
				<div class="col"><input type="text" class="form-control" name="lname" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
        <div class="form-group">
        	<input type="number" class="form-control" name="mobile" placeholder="mobile" required="required">
        </div>

        <div class="form-group">
        	<div class="form-control">
        		<select name="role">
	        		<option value="0">Manufacturer</option>
	        		<option value="1">Retailer</option>
	        		<option value="2">Consumer</option>
        		</select>
        	</div>
        </div>

		<div class="form-group">
            <input type="password" class="form-control" name="pword" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="cpword" placeholder="Confirm Password" required="required">
        </div>        
        <div class="form-group">
			<label class="form-check-label"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Register Now" name="submit">
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
</div>
</body>
</html>



<?php 
	
	include "connect.php";

	if(isset($_POST['submit']))
	{
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$role = $_POST['role'];
		$pword = $_POST['pword'];
		$cpword = $_POST['cpword'];
	


		$query = "SELECT * FROM userdetails WHERE fname = '{$fname}'";
		$result = mysqli_query($conn,$query);

		if(mysqli_num_rows($result)==1)
		{ ?>
			<script>alert("This Email Already Exists !")</script>
		<?php
		}else if($pword!=$cpword)
		{?>
			<script>alert("Passwords Dont Match !")</script>
		<?php
		}else
		{
			$pword = password_hash($pword,PASSWORD_BCRYPT);
			$token = bin2hex(random_bytes(15));
			$query= "INSERT INTO userdetails(fname,lname,email,mobile,role,password,token,status) VALUES('{$fname}','{$lname}','{$email}','{$mobile}','{$role}','{$pword}','{$token}','inactive')";

			$result = mysqli_query($conn,$query);
			if($result)
			{	
				$_SESSION['email']=$email;
				$_SESSION['fname']=$fname;
				$_SESSION['lname']=$lname;
          		$_SESSION['token']=$token;
				$_SESSION['msg']="Check your mail to verify account";
				?>
				<script>window.location.replace("sendActivationMail.php")</script>

			<?php

		}else
				echo "<h1>".mysqli_error($conn)."</h1>"; 


		}
	}

 ?>