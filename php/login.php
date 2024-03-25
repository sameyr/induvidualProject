<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="loginstyles.css">
    <title>Login Page</title>
    </head>
    <body>
        <form action="authorisationPage.php" method="post">
        <div class="login-box">   
        <h1 class = "title">BIG DATA VISUALISATION</h1>     
            <h2>Login</h2>
                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="Username"
                            name="username" value="" required>
                </div>
    
                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password"
                            name="password" value="" required>
                </div>
    
                <input class="button" type="submit"
                        name="login" value="Sign In">
                    
                <a href="forgetPass.php">Forget Your Password?</a>

                <?php 
                    $fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    if(strpos($fullUrl,"submit=invalidcredentials") == true){
                        echo "<p class='error'> Error, please try again.<br> Invalid Credentials. <p>";
                    }
                ?>
            </div>
        </form>


    </body>
</html>