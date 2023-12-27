<?php
    
   if (empty($_POST["timestamp"])){
        die("Timestamp required");
   }

   $mysqli = require __DIR__ ."/database.php";

   $sql = sprintf("SELECT data_Fuel_manifold_Pressure FROM sampleinputdata 
                WHERE timestamp = '%s';", 
            $mysqli -> real_escape_string($_POST["timestamp"]));

   $result = $mysqli -> query($sql);

   while($row = $result->fetch_assoc()) 
        { 
            echo "data_Fuel_manifold_Pressure: " . $row["data_Fuel_manifold_Pressure"] . "<br>";
        } 

?>