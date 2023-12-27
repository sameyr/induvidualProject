<?php
    
    print_r($_POST["timestamp"]);
   if (empty($_POST["timestamp"])){
        die("Timestamp required");
   }

   $mysqli = require __DIR__ ."/database.php";

   $sql = sprintf("SELECT * FROM sampleinputdata 
                WHERE timestamp = '%s';", 
            $mysqli -> real_escape_string($_POST["timestamp"]));

   $result = $mysqli -> query($sql);

   $data = $result ->fetch_assoc();

   var_dump($data);

?>