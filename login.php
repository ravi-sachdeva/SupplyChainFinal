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
		<p class="hint-text"><?php 
            if(isset($_SESSION['msg']))
            {
                echo $_SESSION['msg'];
                session_destroy();
            }

        ?></p>
        
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>

		<div class="form-group">
            <input type="password" class="form-control" name="pword" placeholder="Password" required="required">
        </div>
		       
        <div class="form-group">
			<label class="form-check-label"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Sign in" name="submit">
        </div>
        <div class="text-center">Dont have an account? <a href="register.php">Sign Up</a></div>
        <div class="text-center"> <a href="recoverAccount.php">Forgot Password?</a></div>
    </form>

</div>
</body>
</html>


<?php include "connect.php"; ?>
<?php 

    if(isset($_POST['submit']))
    {
        $email=$_POST['email'];
        $password=$_POST['pword'];

        $query = "SELECT * FROM userdetails where email = '{$email}'";
        $result = mysqli_query($conn,$query);



        if(mysqli_num_rows($result)==0){
            ?>
            <script>alert("Email not Registered!!")</script>
        <?php

        }else {
                $result =  mysqli_fetch_assoc($result);
                $dbpass = $result['password'];
                $isMatch = password_verify($password, $dbpass);
                if($isMatch && $result['status']=="active")
                {
                    $_SESSION['username'] = $result['fname']." ".$result['lname'];
                    $_SESSION['role'] = $result['role'];
                    header('location:home.php');
                }
                else if($isMatch)
                {
                    session_destroy();
                    session_start();
                    $_SESSION['msg']="Account not Activated"; ?>

                        <script>window.location.replace("login.php")</script>
                    <?php
                }
                else
                {
                        session_destroy();
                        session_start();
                        $_SESSION['msg']="Wrong Password";
                        ?>
                        <script>window.location.replace("login.php")</script>
                <?php        
                }
        }


    }

 ?>