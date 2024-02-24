<?php
    $mysqli = require __DIR__ ."/database.php";
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="userDatabase.css">
        <title>Admin</title>
    </head>
    <body>
        <header>
            <nav class ="navBar">
                <p class = "title"> <b>User Information</b> </p>
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

        <div class ="table-div">
            <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
            </tr>

            <?php
            $sql="Select * from userauthentication order by usernames ASC";
            $result = $mysqli -> query($sql);
            while($row=$result->fetch_assoc()){
            ?>
            
            <tr>
                <td><?php echo $row['ID'];?></td>
                <td><?php echo $row['First_Name'];?></td>
                <td><?php echo $row['Last_Name'];?></td>
                <td><?php echo $row['usernames'];?></td>
                <td><?php echo $row['Email'];?></td>
                <td><?php echo $row['Roles'];?></td>
            </tr>

            <?php
            }
            ?>
            <button class = "addUser" onclick="location = 'registrationPage.php'"><b>Add User</b></button>
        </div>
    </body>
    <script>
        function signout(){
            return location.replace("./login.php");
        }
    </script>
</html>