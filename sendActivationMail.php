<?php 
	session_start();

	$to_email = $_SESSION['email'];
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$subject = "Activation Link";
	$body = "Hi {$fname} "."{$lname}"." , \nclick on the link to activate your account \n
	http://localhost/OurProject/verifyMail.php?token=".$_SESSION['token'];

	$headers = "From : supplychaincallback@gmail.com";


	if(mail($to_email,$subject,$body,$headers)){
		echo "mail sent";
	}

	else{
		echo "mail not sent";
	}

	header("location:login.php");


 ?>