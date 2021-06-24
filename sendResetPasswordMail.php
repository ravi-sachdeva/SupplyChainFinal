<?php 
	session_start();

	$to_email = $_SESSION['email'];
	$username = $_SESSION['username'];
	$subject = "Reset Password";
	$body = "Hi {$username} , click on the link to RESET PASSWORD your account \n
	http://localhost/OurProject/resetPassword.php?token=".$_SESSION['token'];

	$headers = "From : supplychaincallback@gmail.com";


	if(mail($to_email,$subject,$body,$headers)){
		echo "mail sent";
		$_SESSION['msg']="Reset Password Link sent to your E-Mail";
	}

	else{
		echo "mail not sent";
	}

	header("location:login.php");


 ?>