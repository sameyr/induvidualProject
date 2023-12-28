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
            $dataFuelMainfold[] = $row;
            //echo "data_Fuel_manifold_Pressure: " . $row["data_Fuel_manifold_Pressure"] . "<br>";
        } 
    
    foreach ($dataFuelMainfold as $dataFuelMainfold) {
        echo $dataFuelMainfold['data_Fuel_manifold_Pressure'] . "<br>";
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <script src ="http://d3js.org/d3.v4.js"></script>
    </head>
    <body>
        <script>
            var container = d3.select("body")
                                .append("svg")
                                .attr("height",700)
                                .attr("width",700)
                                .append("g")
                                .attr("transform","translate(100,100)");

            var line =container.selectALL("line")
                                .data(data_Fuel_manifold_Pressure)
                                .enter()
                                    .append("line")
                                    .attr("x1",0)
                                    .attr("y1",data_Fuel_manifold_Pressure[0])
                                    .attr("x2",59)
                                    .attr("y2",data_Fuel_manifold_Pressure[59])
                                    .attr("stroke","green");
        </script>
    </body>    
