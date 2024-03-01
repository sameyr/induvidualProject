<?php

        $mysqli = require __DIR__ ."/database.php";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql="SELECT * from userAuthentication where usernames = '$username' and passwords= '$password'"; 
        $result = $mysqli -> query($sql);
        $check = mysqli_fetch_array($result);

        if($check == NuLL){
            header("Location: ./login.php?submit=invalidcredentials");
            exit();
        }
        elseif($check[2]=="Student"){
            header("Location: ./dataSelectionPage.php");
        }
        elseif($check[2] == "Teacher"){
            header("Location: ./adminPage.php");
        }
        
?>