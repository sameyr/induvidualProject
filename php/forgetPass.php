<!DOCTYPE HTML>
    <html>
    <head>
        <link rel="stylesheet" href="forgetPass.css">
        <title>Password Reset Page</title>
    <head>
    <body>
        <header>
            <nav class ="navBar">
                <p class = "title"> <b>Recover Your Password</b> </p>
                <div classs = "homebtn-div">

                    <button class = "signout-btn" onClick="location = 'login.php'" type="button"><b>Go Back</b></button>

                </div>
            </nav>
        <header>

        <div class="editForm">
            <form method="post" class="user" action="" autocomplete="on">
                <div class="findAcc">
                    <p >Find Your Account </p>
                </div>

                <div class="findAcc2">
                    <p>Please enter your email address to search for your account.</p>
                    <input class="input" type="text" name="email" placeholder="Enter Email Address" value="" required>
                </div>    

                <div class="btn-div">
                    <button class="button-cancel" onClick="location = 'login.php'">Cancel</button>
                    <button type="submit" class="button-search">Search</button>
                <div>
            </form>
        </div>
    <body>

    <?php

    $mysqli = require __DIR__ ."/database.php";

    if(isset($_POST['email'])){
        $email = $_POST['email'];

        $sqlCheckEmail = sprintf("SELECT Email FROM userauthentication WHERE Email = '%s'", $mysqli->real_escape_string($email));
        $result = $mysqli->query($sqlCheckEmail);
        
        if($result->num_rows == 0){
            echo '<script type="text/javascript"> alert("This user doesn\'t exist. Talk to your admin to add user.") </script>';   
        }
        else{
            echo '<script type="text/javascript"> alert("User exists but you wont be able to change your password. Talk to your admin to change your details.") </script>'; 
        }
    }
?>