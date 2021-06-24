<?php 

	session_start();

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "assets/links.php" ?>
<link rel="stylesheet" type="text/css" href="assets/css/register.css">
<title>Login !</title>



</head>
<body>
<div class="signup-form">
    <form  method="post">
		<h2>Login</h2>
		<p class="hint-text">Set new Password</p>
        

		<div class="form-group">
            <input type="password" class="form-control" name="pword" placeholder="New Password" required="required">
        </div>
		       
        <div class="form-group">
            <input type="password" class="form-control" name="cpword" placeholder="Confirm Password" required="required">
        </div>

		<div class="form-group">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Reset Password" name="submit">
        </div>
        
    </form>

</div>
</body>
</html>

<?php include 'connect.php'; ?>

<?php 
	
	if(isset($_POST['submit']))
	{
		$pword = $_POST['pword'];
		$cpword = $_POST['cpword'];

		$token = $_GET['token'];

		$query = "SELECT * FROM userdetails WHERE token = '{$token}' ";
		$result = mysqli_query($conn,$query);
		if($pword!=$cpword)
		{?>
			<script>alert("Passwords Dont Match")</script>

		<?php }
		else if(mysqli_num_rows($result)==1)
		{
			$result = mysqli_fetch_assoc($result);
			$pword = password_hash($pword,PASSWORD_BCRYPT);
			$query = "UPDATE userdetails SET password = '{$pword}' where token = '{$token}' ";
			$result = mysqli_query($conn,$query);
			if($result){
				session_destroy();
				session_start();
				$_SESSION['msg'] = "Password Changed Successfully";
				?> <script>window.location.replace("login.php")</script>
			<?php }
			else
			{ ?>
				<script>alert("Password Not Updated")</script>

			<?php }


		}
		else{?>
			<script>alert("Wrong Authentication Link")</script>

		<?php }


	}



 ?>
