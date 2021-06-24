<?php include "connect.php" ?>

<?php 

	session_start();


	if(isset($_GET['token']))
	{
		$token = $_GET['token'];
		$query = "SELECT * FROM userdetails WHERE token = '{$token}'";

		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result)==1 && mysqli_fetch_assoc($result)['status']=="active")
		{
			session_destroy();
			session_start();
			$_SESSION['msg']="Already Activated";			
		}
		else if(mysqli_num_rows($result)==1)
		{
			$result = mysqli_fetch_assoc($result);
			
			$updatequery = "UPDATE userdetails SET status = 'active' WHERE token = '{$token}' ";
			mysqli_query($conn,$updatequery);

			session_destroy();
			session_start();
			$_SESSION['msg']="Activation Successfully!";
		}
		else
		{
			$_SESSION['msg'] = 'Cannot Verify Email !';
		}
		header("location:login.php");

	}
	else{
		session_destroy();
		header("location:login.php");
	}




 ?>