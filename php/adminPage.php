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
            <button class = "home-btn" onClick="location = 'adminPage.php'" type="button"><b>Home</b></button>
            <button class = "password-btn" onClick="" type="button"><b>Change Password</b></button>
            <button class="signout-btn" onclick="signout()"><b>Sign Out</b></button>
        </div>

        <div class="sidebar">
            
            <div class="div-dashIcon">
                <img class ="dashboard-icon" id="git" src="/icons/gitIcon.png">
                <img class ="dashboard-icon" id="linkedin" src="/icons/linkedInIcon.png">
            </div>
        </div>

        <div class="container">
            <div class="information-container" id ="database">
                <div class="icon-row">
                    <img class = "info-icon" src ="/icons/databaseIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> User Database</p>
                </div>
            </div>

            <div class="information-container" id ="dataVisual">
                <div class="icon-row" >
                    <img class = "info-icon"  src ="/icons/dataVisualisationIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Data Visualisation</p>
                </div>
            </div>

            <div class="information-container" id="settings">
                <div class="icon-row">
                    <img class = "info-icon"  src ="/icons/settingIcon.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Settings</p>
                </div>
            </div>

            <div class="information-container" id="register">
                <div class="icon-row">
                    <img class = "info-icon" src ="/icons/registration.png">
                </div>
                <div class ="infoTitleContainer">
                   <p class= "info-title"> Registration</p>
                </div>
            </div>
        </div>
    <body>

    <script>
        function signout(){
           return location.replace("./login.php");
        }

        const git = document.getElementById("git");
        git.addEventListener('click',()=>{
           window.location.href='https://github.com/sameyr'
        })

        const linkedin = document.getElementById("linkedin");
        linkedin.addEventListener('click',()=>{
           window.location.href='https://www.linkedin.com/in/samir-shrestha-7a65031bb/'
        })


        const database_div = document.getElementById("database");

        database_div.addEventListener('click', function() {
            location.replace("./userDatabase.php");
            console.log('database-div was clicked!');
        });

        const dataVisual_div = document.getElementById("dataVisual");

        dataVisual_div.addEventListener('click', function() {
            location.replace("./dataSelectionPage.php");
            console.log('datavisual-div was clicked!');
        });

        const settings_div = document.getElementById("settings");

        settings_div.addEventListener('click', function() {
            console.log('settings-div was clicked!');
        });
        const register_div = document.getElementById("register");

        register_div.addEventListener('click', function() {
            location.replace("./registrationPage.php");
            console.log('register-div was clicked!');
        });
    </script>
</html>