<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="registrationPage.css">
    <title>Registration Page</title>
<head>
<body>
    <header>
        <nav class ="navBar">
            <p class = "title"> <b>Registration Form</b> </p>
            <div classs = "homebtn-div">

                <button class = "home-btn" onClick="location = 'adminPage.php'" type="button"><b>Home</b></button>

                <button class = "password-btn" onClick="" type="button"><b>Change Password</b></button>

                <button class = "signout-btn" onClick="signout()" type="button"><b>Sign Out</b></button>
            </div>
            <!--<a href="changepw.php"><button type="button">Change Password</button></a>
            <a href="addUser.php"><button type="button">Add User</button></a>
            <a href="removeUser.php"><button type="button">Remove User</button></a>-->
        </nav>
    </header>

    <div class="registerForm">
        <form method="post" class="user" action="" autocomplete="on">

                <select required name="userType">
                    <option value="">-Select User Type-</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Student">Student</option>
                </select>
             
            <br>
            
            <div class="form-group">
                <input class="input" type="text" required name="fname" placeholder="First Name">
            </div>

            <div class="form-group">
                <input class="input" type="text" required name="lname" placeholder="Last Name">
            </div>

            <div class="form-group">
                <input class="input" type="text" required name="uname" placeholder="Username">
            </div>

            <div class="form-group">
                <input class="input" type="email" required name="email" placeholder="Email">
            </div>

            <div class="form-group">
                <input class="input" type="password" required name="newPassword" placeholder="Password">
            </div>

            <div class="form-group">
                <input class="input" type="password" required name="conPassword" placeholder="Confirm Password">
            </div>

            <div class="form-group">
                <button  class = "submit-btn" type="submit" name="submit"><b>Submit</b></button>
            </div>
        </form>
    </div>
<body>
</html>

<?php
    $mysqli = require __DIR__ ."/database.php";
    if(isset($_POST['submit'])){
        $userType = $_POST['userType'];
        $firstname= trim($_POST['fname']);
        $lastname = trim($_POST['lname']);
        $username = trim($_POST['uname']);
        $email	  = trim($_POST['email']);
        $password = $_POST['newPassword'];
        $cpassword= $_POST['conPassword'];
        
        if($password!=$cpassword){
            echo'<script type="text/javascript"> alert("New password confirmation failed! Try Again") </script>';
        }else {
            $sql="Select * from userauthentication where Email='$email'";
            $rs = $mysqli -> query($sql);
            $num=$rs->num_rows;
            if($num>0){
                echo'<script type="text/javascript"> alert("Email Already Taken") </script>';
            }else{
                $sql2= "Select * from userauthentication where usernames='$username'";
                $rs2=  $mysqli -> query($sql2);
                $numb=$rs2->num_rows;
                if($numb>0){
                    echo'<script type="text/javascript"> alert("Username Already Taken") </script>';
                }
                else{
                    $sql="insert into userauthentication(usernames,passwords,Roles,Email,First_Name,Last_Name) values ('$username','$password','$userType','$email','$firstname','$lastname')";
                    $rs =$mysqli -> query($sql);
                    echo'<script type="text/javascript"> alert("New User added!") </script>';
                }
            }
        }
    }

?>