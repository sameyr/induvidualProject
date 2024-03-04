    <?php
        $mysqli = require __DIR__ ."/database.php";
        if (isset($_POST['submit'])){
            if($_POST['userID'] == null){
                header('Location: userDatabase.php');
            }
            else{
                $selectedID= $_POST['userID'];
                $sql = sprintf("Select * From userauthentication Where ID = %s;", $mysqli->real_escape_string($selectedID));
                $result = $mysqli->query($sql);
                $row = $result -> fetch_assoc();
            }
        }
         
    ?>

    <!DOCTYPE HTML>
    <html>
    <head>
        <link rel="stylesheet" href="editUser.css">
        <title>Registration Page</title>
    <head>
    <body>
        <header>
            <nav class ="navBar">
                <p class = "title"> <b>Update User Information</b> </p>
                <div classs = "homebtn-div">

                    <button class = "home-btn" onClick="location = 'adminPage.php'" type="button"><b>Home</b></button>

                    <button class = "signout-btn" onClick="signout()" type="button"><b>Sign Out</b></button>
                </div>

            </nav>
        </header>

        <div class="registerForm">
            <form method="post" class="user" action="" autocomplete="on">
                <div>
                    <input type= "hidden" name="userID" value="<?php echo $row['ID']?>">
                </div>
                <select required name="userType">
                    <option value="">--Select User Type--</option>
                    <option value="Teacher" <?=  $row['Roles']=="Teacher" ? 'selected' : ''?> >Teacher</option>
                    <option value="Student" <?=  $row['Roles']=="Student" ? 'selected':'' ?>>Student</option>
                </select>                

                <br>

                <div class="form-group">
                    <input class="input" type="text" required name="fname" placeholder="First Name" value="<?php echo $row['First_Name']?>">
                </div>

                <div class="form-group">
                    <input class="input" type="text" required name="lname" placeholder="Last Name" value="<?php echo $row['Last_Name']?>">
                </div>

                <div class="form-group">
                    <input class="input" type="text" required name="uname" placeholder="Username" value="<?php echo $row['usernames']?>">
                </div>

                <div class="form-group">
                    <input class="input" type="email" required name="email" placeholder="Email" value="<?php echo $row['Email']?>">
                </div>

                <div class="form-group">
                    <input class="input" type="password" required name="Password" placeholder="Password">
                </div>

                <div class="form-group">
                    <button  class = "submit-btn" type="submit" name="submitChanges"><b>Submit</b></button>
                </div>
            </form>
        </div>
    <body>
    </html>

    <?php
    $mysqli = require __DIR__ ."/database.php";
    if(isset($_POST['submitChanges'])){
        $selectedID = $_POST['userID'];
        $userType = $_POST['userType'];
        $firstname= $_POST['fname'];
        $lastname = $_POST['lname'];
        $username = $_POST['uname'];
        $email	  = $_POST['email'];
        $Password = $_POST['Password'];

        $sqlCheckPassword = sprintf("SELECT passwords FROM userauthentication WHERE ID = %s", $mysqli->real_escape_string($selectedID));
        $resultCheckPassword = $mysqli->query($sqlCheckPassword);
        $rowCheckPassword = $resultCheckPassword->fetch_assoc();
                
        if($Password != $rowCheckPassword['passwords'] ){
            echo '<script type="text/javascript"> alert("Invalid Current Password") </script>';
        }
        else{
            // Update user information in the database
            $sqlUpdateUser = sprintf("UPDATE userauthentication
                                            SET usernames = '%s', Email = '%s', Roles = '%s', First_Name = '%s', Last_Name = '%s'
                                        WHERE ID = %s",
                $mysqli->real_escape_string($username),
                $mysqli->real_escape_string($email),
                $mysqli->real_escape_string($userType),
                $mysqli->real_escape_string($firstname),
                $mysqli->real_escape_string($lastname),
                $mysqli->real_escape_string($selectedID)
            );
            $resultUpdateUser = $mysqli->query($sqlUpdateUser);
            if($resultUpdateUser){
                echo '<script type="text/javascript"> alert("User Information Updated") </script>';   
                header('Location: userDatabase.php'); 
            }
        }
    } 
                
    ?>