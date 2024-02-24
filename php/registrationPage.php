<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="registrationPage.css">
    <title>Registration Page</title>
<head>
<body>
    <header>
        <nav class ="navBar">
            <p class = "title"> <b>Register Form</b> </p>
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

    <img src="../user-icn.png" style="width:100px;height:100px;align-content:center"><br>
    <form method="post" class="user" action="" autocomplete="on">
    <select required name="userType">
        <option value="">--Select User Type--</option>
        <option value="Administrator">Administrator</option>
        <option value="Teacher">Teacher</option>
        <option value="Student">Student</option>
    </select>
    <br>
      
    <div class="form-group">
        <input type="text" required name="name" placeholder="Name">
    </div>
    <div class="form-group">
        <input type="text" required name="contact" placeholder="Contact" maxlength="10" minlength="10">
    </div>
        <div class="form-group">
        <input type="email" required name="email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="password" required name="newPassword" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" required name="conPassword" placeholder="Confirm Password">
    </div>
    <div class="form-group">
        <input type="submit" value="Submit" name="submit">
    </div>
    </form>
<body>
</html>