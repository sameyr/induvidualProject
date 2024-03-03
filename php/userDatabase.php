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
                <th>Select</th>
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
                <td><input class="check" type="checkbox"></td>
            </tr>

            <?php
            }
            ?>
            <button class ="deleteUser" id ="deleteUser"><b>Delete</b></button>
            <button class ="editUser" onclick="location='editPage.php'"><b>Edit</b></button>
            <button class = "addUser" onclick="location = 'registrationPage.php'"><b>Add User</b></button>
        </div>
    </body>
    <script>
        function signout(){
            return location.replace("./login.php");
        }
        const deleteButton = document.getElementById("deleteUser");
        deleteButton.addEventListener("click",()=>{
            const checkbox = document.querySelectorAll("input[type = 'checkbox']:checked");
            if (checkbox.length > 0){
                const confirmDelete=confirm("Are you sure, you want to delete the user?");
                if (confirmDelete){
                    const selectedRows = Array.from(checkbox).map(checkbox => {
                    const row = checkbox.closest("tr");
                    const idCell = row.querySelector("td:first-child");
                    return idCell.textContent.trim();
                    });

                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'selectedRows=' + JSON.stringify(selectedRows),
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Handle the response from the PHP script if needed
                        console.log(data);
                        // Reload the page or update UI as necessary
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }
            else{
                alert("No Rows Selected...");
            }
        })
    </script>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedRows'])) {
            $selectedRows = json_decode($_POST['selectedRows'], true);
        
            foreach ($selectedRows as $rowId) {
                $sql = sprintf("DELETE FROM userauthentication WHERE ID = %s", $mysqli->real_escape_string($rowId));
                $result = $mysqli->query($sql);
            }
        echo 'Row deleted sucessfully';
        }
    ?>
</html>