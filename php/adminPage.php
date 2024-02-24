<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="adminPageStyle.css">
    <title>Admin Page</title>
    </head>
    <body>
        <div class="header">
            <p class="welcome-text">WELCOME ADMIN!</p>
            <button class="signout-btn" onclick="document.location ='login.php'"><b>Sign Out</b></button>
        </div>

        <div class="sidebar">
            <p>sidebar</p>
        </div>

        <div class="container">
            <div class="information-container" id ="database">
                <div class="icon-row">
                    <img class = "info-icon" src ="/databaseIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> User Database</p>
                </div>
            </div>

            <div class="information-container" id ="dataVisual">
                <div class="icon-row" >
                    <img class = "info-icon"  src ="/dataVisualisationIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Data Visualisation</p>
                </div>
            </div>

            <div class="information-container" id="settings">
                <div class="icon-row">
                    <img class = "info-icon"  src ="/settingIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Settings</p>
                </div>
            </div>

            <div class="information-container" id="register">
                <div class="icon-row">
                    <img class = "info-icon" src ="/registration.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Registration</p>
                </div>
            </div>
        </div>
    <body>

    <script>
        const database_div = document.getElementById("database");

        database_div.addEventListener('click', function() {
            console.log('database-div was clicked!');
        });

        const dataVisual_div = document.getElementById("dataVisual");

        dataVisual_div.addEventListener('click', function() {
            location.replace("./login.php");
            console.log('datavisual-div was clicked!');
        });

        const settings_div = document.getElementById("settings");

        settings_div.addEventListener('click', function() {
            console.log('settings-div was clicked!');
        });
        const register_div = document.getElementById("register");

        register_div.addEventListener('click', function() {
            console.log('register-div was clicked!');
        });
    </script>
</html>