<?php 
    session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "assets/links.php" ?>
        <link rel="stylesheet" type="text/css" href="assets/css/register.css">
        <title>Recover Account </title>
    </head>
    <body>
        <div class="signup-form">
            <form  method="post">
                <h2>Recover </h2>
                <p class="hint-text">Enter Registered E-Mail ID</p>
                
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-lg btn-block" value="Send Mail" name="submit">
                </div>
                
            </form>
        </div>
    </body>
</html>

<?php include "connect.php"; ?>


<?php
    
    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $query = "SELECT * FROM userdetails WHERE email = '{$email}' ";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==1)
        {
            $result = mysqli_fetch_assoc($result);
            $_SESSION['email']=$result['email'];
            $_SESSION['username'] = $result['fname']." ".$result['lname'];
            $_SESSION['token'] = $result['token'];
            ?>
            <script>window.location.replace("sendResetPasswordMail.php")</script>
        
    <?php }
    else{ ?>
            <script >alert("Email Not registered with us")</script>
        <?php
        }
    }
?>