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
    
    /*foreach ($dataFuelMainfold as $dataFuelMainfold) {
        echo $dataFuelMainfold['data_Fuel_manifold_Pressure'] . "<br>";
    }*/

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://d3js.org/d3.v4.js"></script>
</head>
<body>
    <script>
        // Assuming PHP echoes the data in JSON format
        var rawData = <?php echo json_encode($dataFuelMainfold); ?>;

        // Extracting the pressure values from the nested array
        var data_Fuel_manifold_Pressure = rawData.map(function(d) {
            return d.data_Fuel_manifold_Pressure;
        });

        var container = d3.select("body")
            .append("svg")
            .attr("height", 200)
            .attr("width", 700)
            .append("g")
            .attr("transform", "translate(100,100)");

        var xScale = d3.scaleLinear().domain([0, data_Fuel_manifold_Pressure.length - 1]).range([0, 500]);
        var yScale = d3.scaleLinear().domain([d3.min(data_Fuel_manifold_Pressure), d3.max(data_Fuel_manifold_Pressure)]).range([100, 0]);

        var line = container.selectAll("line")
            .data(data_Fuel_manifold_Pressure)
            .enter()
            .append("line")
            .attr("x1", function (d, i) { return xScale(i); })
            .attr("y1", function (d) { return yScale(d); })
            .attr("x2", function (d, i) { return xScale(i + 1); }) // Assuming each data point represents a unit of time
            .attr("y2", function (d) { return yScale(d); })
            .attr("stroke", "green");
    </script>
</body>
</html>

