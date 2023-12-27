<?php 
//connecting PHP to mysql server

$host = "localhost";
$username ="root";
$password = "Nottheend321";
$database = "try";

$mysqli = new mysqli(hostname: $host,   //'mysqli' module is the mysql client for php 
                    username: $username,
                    password: $password,
                    database: $database);

if ($mysqli -> connect_errno){  //checks if connection was sucessful
    die("Connection Error" . $mysqli->connect_error);
}    

return $mysqli;